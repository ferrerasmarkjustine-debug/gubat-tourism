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

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    private Resort $resort;
    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        // Build location tree
        $province = Province::create(['name' => 'Sorsogon']);
        $municipality = Municipality::create([
            'province_id' => $province->id,
            'name' => 'Gubat',
        ]);
        $barangay = Barangay::create([
            'municipality_id' => $municipality->id,
            'name' => 'Rizal',
        ]);

        // Find or create test resort
        $this->resort = Resort::create([
            'barangay_id' => $barangay->id,
            'name' => 'Test Gubat Bay Resort',
            'category' => 'luxury',
            'is_lgu_approved' => true,
        ]);

        // Create super admin
        $this->superAdmin = User::create([
            'email' => 'admin@gubat.gov.ph',
            'name' => 'LGU Super Admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);
    }

    public function test_guests_cannot_access_super_admin_portal(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));

        $response2 = $this->get(route('admin.resort-admins.index'));
        $response2->assertRedirect(route('login'));
    }

    public function test_tourist_users_cannot_access_super_admin_portal(): void
    {
        $tourist = User::factory()->create([
            'role' => 'tourist',
            'is_active' => true,
        ]);

        $response = $this->actingAs($tourist)->get(route('admin.dashboard'));
        $response->assertForbidden();

        $response2 = $this->actingAs($tourist)->get(route('admin.resort-admins.index'));
        $response2->assertForbidden();
    }

    public function test_super_admin_can_view_dashboard_and_resort_admins_list(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('LGU Super Admin Portal');

        $response2 = $this->actingAs($this->superAdmin)->get(route('admin.resort-admins.index'));
        $response2->assertOk();
        $response2->assertSee('Resort Administrators');
    }

    public function test_super_admin_can_create_resort_admin_assigned_to_resort(): void
    {
        $response = $this->actingAs($this->superAdmin)->post(route('admin.resort-admins.store'), [
            'name' => 'Juan Dela Cruz',
            'email' => 'juan.resort@example.com',
            'resort_id' => $this->resort->id,
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ]);

        $response->assertRedirect(route('admin.resort-admins.index'));
        $response->assertSessionHas('success');

        $createdAdmin = User::where('email', 'juan.resort@example.com')->first();
        $this->assertNotNull($createdAdmin);
        $this->assertEquals('Juan Dela Cruz', $createdAdmin->name);
        $this->assertEquals('resort_admin', $createdAdmin->role);
        $this->assertEquals($this->resort->id, $createdAdmin->resort_id);
        $this->assertTrue($createdAdmin->is_active);
        $this->assertTrue(Hash::check('secret12345', $createdAdmin->password));
    }

    public function test_resort_admin_can_access_their_resort_dashboard(): void
    {
        $resortAdmin = User::create([
            'name' => 'Maria Makiling',
            'email' => 'maria@example.com',
            'password' => Hash::make('password'),
            'role' => 'resort_admin',
            'resort_id' => $this->resort->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($resortAdmin)->get(route('resort.dashboard'));
        $response->assertOk();
        $response->assertSee('Resort Administrator Portal');
        $response->assertSee($this->resort->name);
    }

    public function test_resort_admin_cannot_access_super_admin_portal(): void
    {
        $resortAdmin = User::create([
            'name' => 'Resort Admin User',
            'email' => 'resortadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'resort_admin',
            'resort_id' => $this->resort->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($resortAdmin)->get(route('admin.dashboard'));
        $response->assertForbidden();

        $response2 = $this->actingAs($resortAdmin)->get(route('admin.resort-admins.index'));
        $response2->assertForbidden();

        $response3 = $this->actingAs($resortAdmin)->post(route('admin.resort-admins.store'), [
            'name' => 'Illegal Admin',
            'email' => 'illegal@example.com',
            'resort_id' => $this->resort->id,
            'password' => 'secret12345',
            'password_confirmation' => 'secret12345',
        ]);
        $response3->assertForbidden();
    }

    public function test_super_admin_can_toggle_resort_admin_status(): void
    {
        $resortAdmin = User::create([
            'name' => 'Toggle User',
            'email' => 'toggle@example.com',
            'password' => Hash::make('password'),
            'role' => 'resort_admin',
            'resort_id' => $this->resort->id,
            'is_active' => true,
        ]);

        // Toggle to deactivated
        $response = $this->actingAs($this->superAdmin)->patch(route('admin.resort-admins.toggle-status', $resortAdmin));
        $response->assertRedirect();
        $this->assertFalse($resortAdmin->fresh()->is_active);

        // Deactivated user cannot access resort portal
        $response2 = $this->actingAs($resortAdmin->fresh())->get(route('resort.dashboard'));
        $response2->assertRedirect(route('login'));

        // Toggle back to active
        $response3 = $this->actingAs($this->superAdmin)->patch(route('admin.resort-admins.toggle-status', $resortAdmin));
        $response3->assertRedirect();
        $this->assertTrue($resortAdmin->fresh()->is_active);
    }
}
