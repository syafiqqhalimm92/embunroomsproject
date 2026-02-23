@extends('layouts.app')

@section('title', 'Admin Users')

@section('content')
    <h2>Admin Users</h2>

    @if(session('success'))
        <div style="padding:10px; border:1px solid #0a0; color:#0a0; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex; gap:10px; align-items:center; margin-bottom:12px;">
        <form method="GET" action="{{ route('admin.index') }}">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search nama / IC / email / phone">
            <button type="submit">Search</button>
            <a href="{{ route('admin.index') }}">Clear</a>
        </form>

        <div style="margin-left:auto;">
            <a href="{{ route('admin.create') }}">
                <button type="button">Create Admin</button>
            </a>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Name</th>
                <th>Username (IC)</th>
                <th>Email</th>
                <th>No Phone</th>
                <th>Status</th>
                <th>Role</th>               
                <th width="160">Reset Password</th>
                <th width="120">Modify</th>
            </tr>
        </thead>

        <tbody>
        @forelse($admins as $i => $admin)
            <tr>
                <td>{{ $admins->firstItem() + $i }}</td> 
                <td>{{ $admin->name }}</td>
                <td>
                    {{ substr($admin->ic_no,0,6) . '-' .
                    substr($admin->ic_no,6,2) . '-' .
                    substr($admin->ic_no,8,4) }}
                </td>
                <td>{{ $admin->email ?? '-' }}</td>
                <td>{{ $admin->no_phone ?? '-' }}</td>
                <td>
                    @if($admin->status === 'active')
                        <span style="color:green;">Active</span>
                    @else
                        <span style="color:red;">Inactive</span>
                    @endif
                </td>
                <td>{{ $admin->role }}</td>

                <td>
                    <form method="POST"
                          action="{{ route('admin.resetPassword', $admin->id) }}"
                          onsubmit="return confirm('Reset password untuk user ini?');">
                        @csrf
                        <button type="submit">Reset</button>
                    </form>
                </td>

                <td>
                    <a href="{{ route('admin.edit', $admin->id) }}">
                        <button type="button">Edit</button>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Tiada admin dijumpai.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">
        {{ $admins->links() }}
    </div>
@endsection