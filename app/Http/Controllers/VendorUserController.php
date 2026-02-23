<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorUserController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $vendors = User::query()
            ->where('role', 'vendor')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('ic_no', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('no_phone', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('pages.vendor', compact('vendors', 'q'));
    }

    public function create()
    {
        return view('pages.vendor_create');
    }

    public function store(Request $request)
    {
        // normalize IC: simpan digits sahaja
        $request->merge(['ic_no' => preg_replace('/\D/', '', (string) $request->ic_no)]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|digits:12|unique:users,ic_no',
            'email' => 'nullable|email|max:255|unique:users,email',
            'no_phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'ic_no.digits' => 'IC mesti 12 digit nombor sahaja.',
        ]);

        User::create([
            'name' => $data['name'],
            'ic_no' => $data['ic_no'],
            'email' => $data['email'] ?? null,
            'no_phone' => $data['no_phone'] ?? null,
            'role' => 'vendor',          // ✅ auto vendor masa create
            'status' => 'active',
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('vendor.index')->with('success', 'Vendor berjaya dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'vendor') abort(404);
        return view('pages.vendor_edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'vendor') abort(404);

        $request->merge(['ic_no' => preg_replace('/\D/', '', (string) $request->ic_no)]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ic_no' => 'required|digits:12|unique:users,ic_no,' . $user->id,
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'no_phone' => 'nullable|string|max:20',

            // ✅ update baru boleh tukar role lain
            'role' => 'required|in:superadmin,admin,vendor,tenant',
            'status' => 'required|in:active,inactive',
        ], [
            'ic_no.digits' => 'IC mesti 12 digit nombor sahaja.',
        ]);

        $user->update($data);

        return redirect()->route('vendor.index')->with('success', 'Vendor berjaya dikemaskini.');
    }

    public function resetPassword(User $user)
    {
        if ($user->role !== 'vendor') abort(404);

        $defaultPassword = '12345678';
        $user->password = Hash::make($defaultPassword);
        $user->save();

        return back()->with('success', "Password vendor telah di-reset ke: {$defaultPassword}");
    }
}