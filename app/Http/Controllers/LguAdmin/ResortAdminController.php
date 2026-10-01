<?php

namespace App\Http\Controllers\LguAdmin;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ResortAdminController extends Controller
{
    /**
     * Display a listing of Resort Admins.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'resort_admin')->with('resort');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('resort', function ($resortQuery) use ($search) {
                      $resortQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $resortAdmins = $query->latest()->paginate(10)->withQueryString();

        return view('super-admin.resort-admins.index', compact('resortAdmins'));
    }

    /**
     * Show the form for creating a new Resort Admin.
     */
    public function create(): View
    {
        $resorts = Resort::orderBy('name')->get();

        return view('super-admin.resort-admins.create', compact('resorts'));
    }

    /**
     * Store a newly created Resort Admin in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'resort_id' => ['required', 'exists:resorts,id'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'resort_admin',
            'resort_id' => $validated['resort_id'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.resort-admins.index')
            ->with('success', 'Resort Admin account created successfully.');
    }

    /**
     * Show the form for editing the specified Resort Admin.
     */
    public function edit(User $user): View
    {
        if (!$user->isResortAdmin()) {
            abort(404, 'User is not a Resort Admin.');
        }

        $resorts = Resort::orderBy('name')->get();

        return view('super-admin.resort-admins.edit', compact('user', 'resorts'));
    }

    /**
     * Update the specified Resort Admin in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if (!$user->isResortAdmin()) {
            abort(404, 'User is not a Resort Admin.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'resort_id' => ['required', 'exists:resorts,id'],
            'is_active' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->resort_id = $validated['resort_id'];
        $user->is_active = (bool) $validated['is_active'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.resort-admins.index')
            ->with('success', 'Resort Admin account updated successfully.');
    }

    /**
     * Toggle active/deactive status for the specified Resort Admin.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if (!$user->isResortAdmin()) {
            abort(404, 'User is not a Resort Admin.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Resort Admin {$user->name} has been {$statusText}.");
    }
}
