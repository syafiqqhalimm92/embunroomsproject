@extends('layouts.app')

@section('title', 'Create Admin')

@section('content')
    <h2>Create Admin</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.store') }}">
        @csrf

        <div>
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <br>

        <div>
            <label>Username (No IC)</label><br>
            <input type="text" name="ic_no" value="{{ old('ic_no') }}" required>
        </div>
        <br>

        <div>
            <label>No Phone</label><br>
            <input type="text" name="no_phone" value="{{ old('no_phone') }}">
        </div>
        <br>

        <div>
            <label>Email </label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <br>

        <div>
            <label>Role</label><br>
            <select name="role" required>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
            </select>
        </div>
        <br>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>
        <br>

        <button type="submit">Save</button>
        <a href="{{ route('admin.index') }}">Back</a>
    </form>
@endsection