<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index()
    {
        $q = request()->query('q');
        $role = request()->query('role');
        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $like = '%' . $q . '%';
                $query->where(function ($w) use ($like) {
                    $w->where('name', 'like', $like)->orWhere('email', 'like', $like);
                });
            })
            ->when(in_array($role, ['user', 'admin', 'superadmin']), function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(request()->query());
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $role = $request->input('role');

        // Validation behavior: Email is nullable only for admins/superadmins
        $emailRule = ($role === 'admin' || $role === 'superadmin')
            ? 'nullable|email|unique:users,email'
            : 'required|email|unique:users,email';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => 'required|string|min:4|confirmed', // Lowered min length for convenience as requested
            'role' => 'required|in:user,admin,superadmin',
        ]);

        // Auto-generate email for admins if missing
        if (empty($validated['email']) && ($role === 'admin' || $role === 'superadmin')) {
            $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $validated['name']));
            $validated['email'] = $cleanName . '@lcr.com';

            // Should ensure uniqueness (simple check)
            if (User::where('email', $validated['email'])->exists()) {
                $validated['email'] = $cleanName . rand(100, 999) . '@lcr.com';
            }
        }

        // Only superadmin can create superadmin
        if ($validated['role'] === 'superadmin' && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only superadmin can create superadmin users.');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Auto verify admins

        $user = User::create($validated);
        $note = '';
        if ($user->role === 'admin' && !empty($user->email)) {
            try {
                Mail::to($user->email)->send(new \App\Mail\AdminRoleAssignedMail($user));
                $note = ' Notification sent to ' . $user->email . '.';
            } catch (\Throwable $e) {
                $note = ' Email notification failed.';
            }
        }
        return redirect()->route('admin.users.index')->with('success', 'User created successfully! (Email: ' . ($validated['email'] ?? $user->email) . ')' . $note);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:user,admin,superadmin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Only superadmin can modify superadmin
        if (($user->isSuperAdmin() || $validated['role'] === 'superadmin') && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only superadmin can modify superadmin users.');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $previousRole = $user->role;
        $user->update($validated);
        $note = '';
        if ($validated['role'] === 'admin' && !empty($user->email) && $previousRole !== 'admin') {
            try {
                Mail::to($user->email)->send(new \App\Mail\AdminRoleAssignedMail($user));
                $note = ' Notification sent to ' . $user->email . '.';
            } catch (\Throwable $e) {
                $note = ' Email notification failed.';
            }
        }
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!' . $note);
    }

    public function destroy(User $user)
    {
        // Prevent deleting superadmin unless you are superadmin
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only superadmin can delete superadmin users.');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
