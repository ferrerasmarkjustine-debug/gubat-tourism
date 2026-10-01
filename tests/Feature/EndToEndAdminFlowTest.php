<?php

namespace Tests\Feature;

use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Resort;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EndToEndAdminFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_complete_admin_management_flow(): void
    {
        // Setup resort data
        $province = Province::create(['name' => 'Sorsogon']);
        $municipality = Municipality::create([
            'province_id' => $province->id,
            'name' => 'Gubat',
        ]);
        $barangay = Barangay::create([
            'municipality_id' => $municipality->id,
            'name' => 'Pinontingan',
        ]);
        $targetResort = Resort::create([
            'barangay_id' => $barangay->id,
            'name' => 'Gubat Bay Beach Resort',
            'category' => 'luxury',
            'is_lgu_approved' => true,
        ]);

        // 1. Login as LGU Super Admin
        $superAdmin = User::create([
            'email' => 'admin@gubat.gov.ph',
            'name' => 'LGU Super Admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $loginResponse = $this->post('/login', [
            'email' => 'admin@gubat.gov.ph',
            'password' => 'password',
        ]);
        $this->assertAuthenticatedAs($superAdmin);
        $loginResponse->assertRedirect(route('admin.dashboard'));

        // 2. Open Resort Admin management
        $indexResponse = $this->actingAs($superAdmin)->get(route('admin.resort-admins.index'));
        $indexResponse->assertOk();
        $indexResponse->assertSee('Resort Administrators');

        // Open creation form
        $createFormResponse = $this->actingAs($superAdmin)->get(route('admin.resort-admins.create'));
        $createFormResponse->assertOk();
        $createFormResponse->assertSee('Create Resort Admin Account');

        // Pick an existing resort from database
        $targetResort = Resort::first();
        $this->assertNotNull($targetResort, 'A resort must exist in the database');
        $createFormResponse->assertSee($targetResort->name);

        // 3. Create a Resort Admin & 4. Assign the Resort Admin to a resort
        $newAdminEmail = 'e2e.admin@gubat.gov.ph';
        User::where('email', $newAdminEmail)->delete();

        $storeResponse = $this->actingAs($superAdmin)->post(route('admin.resort-admins.store'), [
            'name' => 'E2E Test Resort Manager',
            'email' => $newAdminEmail,
            'resort_id' => $targetResort->id,
            'password' => 'ResortPass2026!',
            'password_confirmation' => 'ResortPass2026!',
        ]);
        $storeResponse->assertRedirect(route('admin.resort-admins.index'));
        $storeResponse->assertSessionHas('success');

        // Verify account in database
        $resortAdmin = User::where('email', $newAdminEmail)->first();
        $this->assertNotNull($resortAdmin);
        $this->assertEquals('resort_admin', $resortAdmin->role);
        $this->assertEquals($targetResort->id, $resortAdmin->resort_id);
        $this->assertTrue($resortAdmin->is_active);
        $this->assertTrue(Hash::check('ResortPass2026!', $resortAdmin->password));

        // 5. Login as the Resort Admin
        $this->post('/logout');
        $this->assertGuest();

        $resortAdminLoginResponse = $this->post('/login', [
            'email' => $newAdminEmail,
            'password' => 'ResortPass2026!',
        ]);
        $this->assertAuthenticatedAs($resortAdmin);
        $resortAdminLoginResponse->assertRedirect(route('resort.dashboard'));

        // 6. Verify that they can only access their assigned resort
        $dashboardResponse = $this->actingAs($resortAdmin)->get(route('resort.dashboard'));
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Resort Administrator Portal');
        $dashboardResponse->assertSee($targetResort->name);

        // 7. Verify that they cannot access Super Admin functions
        $unauthorizedAdminDashboard = $this->actingAs($resortAdmin)->get(route('admin.dashboard'));
        $unauthorizedAdminDashboard->assertForbidden();

        $unauthorizedResortAdminList = $this->actingAs($resortAdmin)->get(route('admin.resort-admins.index'));
        $unauthorizedResortAdminList->assertForbidden();

        $unauthorizedCreate = $this->actingAs($resortAdmin)->post(route('admin.resort-admins.store'), [
            'name' => 'Hacker Admin',
            'email' => 'hack@example.com',
            'resort_id' => $targetResort->id,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $unauthorizedCreate->assertForbidden();

        // 8. Verify edit and deactivation
        $editResponse = $this->actingAs($superAdmin)->get(route('admin.resort-admins.edit', $resortAdmin));
        $editResponse->assertOk();
        $editResponse->assertSee('Edit Resort Admin');

        // Deactivate resort admin
        $toggleResponse = $this->actingAs($superAdmin)->patch(route('admin.resort-admins.toggle-status', $resortAdmin));
        $toggleResponse->assertRedirect();
        $this->assertFalse($resortAdmin->fresh()->is_active);

        // Verify deactivated admin cannot log in
        $this->post('/logout');
        $blockedLoginResponse = $this->post('/login', [
            'email' => $newAdminEmail,
            'password' => 'ResortPass2026!',
        ]);
        $blockedLoginResponse->assertSessionHasErrors('email');
        $this->assertGuest();

        // Clean up created e2e admin
        $resortAdmin->delete();
    }
}
