@extends('layouts.app')

@section('title', 'Create Vendor')

@section('content')
    <h2>Create Vendor</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.store') }}">
        @csrf

        <div>
            <label>Name</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div><br>

        <div>
            <label>Username (No IC - 12 digit)</label><br>
            <input type="text" name="ic_no" value="{{ old('ic_no') }}" required>
        </div><br>

        <div>
            <label>Email (optional)</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div><br>

        <div>
            <label>No Phone (optional)</label><br>
            <input type="text" name="no_phone" value="{{ old('no_phone') }}">
        </div><br>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">Save</button>
        <a href="{{ route('vendor.index') }}">Back</a>
    </form>
@endsection