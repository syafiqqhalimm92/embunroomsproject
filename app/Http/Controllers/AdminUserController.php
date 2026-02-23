<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $admins = User::query()
            ->where('role', ['admin', 'superadmin']) // pastikan hanya admin/superadmin
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('ic_no', 'like', "%{$q}%") // Username (No IC)
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin', compact('admins', 'q'));
    }

    public function create()
    {
        return view('pages.admin_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|digits:12|unique:users,ic_no',
            'email' => 'nullable|email|max:255|unique:users,email',
            'no_phone' => 'nullable|string|max:20',
            'role' => 'required|in:superadmin,admin,vendor,tenant',
            'password' => 'required|string|min:6',
        ], [
            'ic_no.digits' => 'IC mesti 12 digit nombor sahaja.',
        ]);

        User::create([
            'name' => $data['name'],
            'ic_no' => $data['ic_no'],
            'email' => $data['email'] ?? null,
            'no_phone' => $data['no_phone'] ?? null,
            'role' => $data['role'], // ikut dropdown
            'status' => 'active', // ← tambah ni
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berjaya dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        return view('pages.admin_edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|digits:12|unique:users,ic_no,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_phone' => 'required|string|max:20',
            'role' => 'required|in:superadmin,admin,vendor,tenant',
            'status' => 'required|in:active,inactive', 
        ]);

        $user->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin berjaya dikemaskini.');
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        // default password (simple dulu)
        $defaultPassword = '12345678';

        $user->password = Hash::make($defaultPassword);
        $user->save();

        return back()->with('success', "Password admin telah di-reset ke: {$defaultPassword}");
    }
}