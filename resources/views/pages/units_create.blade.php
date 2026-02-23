@extends('layouts.app')

@section('title', 'Create House')

@section('content')
    <h2>Create House</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('units.store') }}">
        @csrf

        <div>
            <label>Address</label><br>
            <textarea name="address" required>{{ old('address') }}</textarea>
        </div><br>

        <div>
            <label>State</label><br>
            <input type="text" name="state" value="{{ old('state') }}" required>
        </div><br>

        <div>
            <label>City</label><br>
            <input type="text" name="city" value="{{ old('city') }}" required>
        </div><br>

        <div>
            <label>Room Count</label><br>
            <input type="number" name="room_count" value="{{ old('room_count', 0) }}" min="0">
        </div><br>

        <div>
            <label>House Rent Price (RM)</label><br>
            <input type="number" step="0.01" name="house_rent_price" value="{{ old('house_rent_price', 0) }}">
        </div><br>

        <button type="submit">Save</button>
        <a href="{{ route('units.index') }}">Back</a>
    </form>
@endsection