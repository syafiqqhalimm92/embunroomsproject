@extends('layouts.app')

@section('title', 'Edit Admin')

@section('content')
    <h2>Edit Admin</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <br>

        <div>
            <label>Username (No IC)</label><br>
            <input type="text" name="ic_no" value="{{ old('ic_no', $user->ic_no) }}" required>
        </div>
        <br>

        <div>
            <label>Email </label><br>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <br>

        <div>
            <label>No Phone</label><br>
            <input type="text" name="no_phone" value="{{ old('no_phone', $user->no_phone) }}" required>
        </div>
        <br>

        <div>
            <label>Role</label><br>
            <select name="role" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="vendor" {{ old('role', $user->role) == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="tenant" {{ old('role', $user->role) == 'tenant' ? 'selected' : '' }}>Tenant</option>
                <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>
        <br>

        <div>
            <label>Status</label><br>
            <select name="status" required>
                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>
        <br>

        <button type="submit">Update</button>
        <a href="{{ route('admin.index') }}">Back</a>
    </form>
@endsection