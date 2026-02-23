@extends('layouts.app')

@section('title', 'Vendor Users')

@section('content')
    <h2>Vendor Users</h2>

    @if(session('success'))
        <div style="padding:10px; border:1px solid #0a0; color:#0a0; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex; gap:10px; align-items:center; margin-bottom:12px;">
        <form method="GET" action="{{ route('vendor.index') }}">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Search nama / IC / email / phone">
            <button type="submit">Search</button>
            <a href="{{ route('vendor.index') }}">Clear</a>
        </form>

        <div style="margin-left:auto;">
            <a href="{{ route('vendor.create') }}">
                <button type="button">Create Vendor</button>
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
                <th width="160">Reset Password</th>
                <th width="120">Modify</th>
            </tr>
        </thead>

        <tbody>
        @forelse($vendors as $i => $vendor)
            <tr>
                <td>{{ $vendors->firstItem() + $i }}</td>
                <td>{{ $vendor->name }}</td>
                <td>{{ $vendor->ic_formatted }}</td>
                <td>{{ $vendor->email ?? '-' }}</td>
                <td>{{ $vendor->no_phone ?? '-' }}</td>
                <td>{{ ucfirst($vendor->status) }}</td>

                <td>
                    <form method="POST"
                          action="{{ route('vendor.resetPassword', $vendor->id) }}"
                          onsubmit="return confirm('Reset password untuk user ini?');">
                        @csrf
                        <button type="submit">Reset</button>
                    </form>
                </td>

                <td>
                    <a href="{{ route('vendor.edit', $vendor->id) }}">
                        <button type="button">Edit</button>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Tiada vendor dijumpai.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">
        {{ $vendors->links() }}
    </div>
@endsection