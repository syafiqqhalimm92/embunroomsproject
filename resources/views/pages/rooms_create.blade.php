@extends('layouts.app')

@section('title','Create Room')

@section('content')
    <h2>Create Room</h2>

    <div style="margin-bottom:10px;">
        <a href="{{ route('units.index') }}"><button type="button">← Back</button></a>
    </div>

    <div style="padding:10px;border:1px solid #ddd;margin-bottom:12px;">
        <div><strong>House:</strong> {{ $house->address }}, {{ $house->city }}, {{ $house->state }}</div>
        <div>
            <strong>Rooms limit (room_count):</strong> {{ $house->room_count ?? 0 }} |
            <strong>Current rooms created:</strong> {{ $currentRooms }} |
            <strong>Remaining:</strong> {{ max(0, ($house->room_count ?? 0) - $currentRooms) }}
        </div>
    </div>

    @if(session('error'))
        <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:10px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:10px;">
            <strong>There were some errors:</strong>
            <ul style="margin:5px 0 0 15px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($canCreate)
        <form method="POST" action="{{ route('rooms.store', $house->id) }}">
            @csrf

            <table cellpadding="8" cellspacing="0">
                <tr>
                    <td><strong>Room Name</strong></td>
                    <td>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                        <small style="display:block;color:#666;">Contoh: Room A / Bilik 1</small>
                    </td>
                </tr>

                <tr>
                    <td><strong>Room Type</strong></td>
                    <td>
                        <select name="room_type" required>
                            <option value="">-- Select Room Type --</option>
                            <option value="Single" @selected(old('room_type')==='Single')>Single</option>
                            <option value="Medium" @selected(old('room_type')==='Medium')>Medium</option>
                            <option value="Master" @selected(old('room_type')==='Master')>Master</option>
                            <option value="House" @selected(old('room_type')==='House')>House</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><strong>Rent Price (RM)</strong></td>
                    <td>
                        <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price') }}" required>
                    </td>
                </tr>

                <tr>
                    <td><strong>Status</strong></td>
                    <td>
                        <select name="status">
                            <option value="available" @selected(old('status','available')==='available')>available</option>
                            <option value="occupied" @selected(old('status')==='occupied')>occupied</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button type="submit">Create Room</button>
                    </td>
                </tr>
            </table>
        </form>
    @else
        <div style="padding:10px;border:1px solid #a00;color:#a00;">
            Dah capai limit bilik untuk rumah ini. Tak boleh tambah room lagi.
        </div>
    @endif
@endsection