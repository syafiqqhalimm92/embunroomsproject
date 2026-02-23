@extends('layouts.app')

@section('title','Edit Unit')

@section('content')
    <h2>Edit House</h2>

    {{-- Error validation --}}
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

    <form method="POST" action="{{ route('units.update', $house->id) }}">
        @csrf
        @method('PUT')

        <table cellpadding="8" cellspacing="0">
            <tr>
                <td><strong>Address</strong></td>
                <td>
                    <input type="text" name="address"
                           value="{{ old('address', $house->address) }}"
                           required style="width:300px;">
                </td>
            </tr>

            <tr>
                <td><strong>State</strong></td>
                <td>
                    <input type="text" name="state"
                           value="{{ old('state', $house->state) }}"
                           required>
                </td>
            </tr>

            <tr>
                <td><strong>City</strong></td>
                <td>
                    <input type="text" name="city"
                           value="{{ old('city', $house->city) }}"
                           required>
                </td>
            </tr>

            <tr>
                <td><strong>Total Rooms</strong></td>
                <td>
                    <input type="number" name="room_count"
                           value="{{ old('room_count', $house->room_count) }}"
                           min="0">
                </td>
            </tr>

            <tr>
                <td><strong>House Rent Price (RM)</strong></td>
                <td>
                    <input type="number" step="0.01" name="house_rent_price"
                           value="{{ old('house_rent_price', $house->house_rent_price) }}">
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit">Update House</button>
                    <a href="{{ route('units.index') }}">
                        <button type="button">Cancel</button>
                    </a>
                </td>
            </tr>
        </table>
    </form>

    <hr style="margin:20px 0;">

    <div style="display:flex;align-items:center;gap:10px;">
        <h3 style="margin:0;">Rooms List</h3>

        <a href="{{ route('rooms.create', $house->id) }}" style="margin-left:auto;">
            <button type="button">+ Create Room</button>
        </a>
    </div>

    @if($house->rooms->isEmpty())
        <p style="margin-top:10px;">Tiada room untuk house ini lagi.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;margin-top:10px;">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Room Name</th>
                    <th style="width:160px;">Room Type</th>
                    <th style="width:150px;">Rent Price (RM)</th>
                    <th style="width:140px;">Status</th>
                    <th style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($house->rooms as $i => $room)
                    <tr>
                        <form method="POST" action="{{ route('rooms.update', [$house->id, $room->id]) }}">
                            @csrf
                            @method('PUT')

                            <td>{{ $i + 1 }}</td>

                            <td>
                                <input type="text" name="name" value="{{ old('name', $room->name) }}" required>
                            </td>

                            <td>
                                <select name="room_type" required>
                                    <option value="Single" @selected($room->room_type==='Single')>Single</option>
                                    <option value="Medium" @selected($room->room_type==='Medium')>Medium</option>
                                    <option value="Master" @selected($room->room_type==='Master')>Master</option>
                                    <option value="House"  @selected($room->room_type==='House')>House</option>
                                </select>
                            </td>

                            <td style="text-align:right;">
                                <input type="number" step="0.01" name="rent_price"
                                    value="{{ old('rent_price', $room->rent_price) }}" required
                                    style="width:120px;text-align:right;">
                            </td>

                            <td>
                                <select name="status" required>
                                    <option value="available" @selected($room->status==='available')>available</option>
                                    <option value="occupied" @selected($room->status==='occupied')>occupied</option>
                                </select>
                            </td>

                            <td>
                                <button type="submit">Update</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection