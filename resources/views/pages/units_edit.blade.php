@extends('layouts.app')

@section('title','Edit House')

@section('content')
    <h2>Edit House</h2>

    <div style="margin-bottom:10px;">
        <a href="{{ route('units.index') }}"><button type="button">← Back</button></a>
    </div>

    @if(session('success'))
        <div style="padding:10px;border:1px solid #0a0;color:#0a0;margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding:10px;border:1px solid #a00;color:#a00;margin-bottom:12px;">
            <strong>There were some errors:</strong>
            <ul style="margin:6px 0 0 18px;">
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
                <td style="width:220px;"><strong>Jenis Kediaman</strong></td>
                <td>
                    <select name="property_type" style="width:320px;">
                        <option value="">-- Select --</option>
                        <option value="Terrace" @selected(old('property_type', $house->property_type)==='Terrace')>Rumah Teres (Terrace)</option>
                        <option value="Service Apartment" @selected(old('property_type', $house->property_type)==='Service Apartment')>Service Apartment</option>
                        <option value="Flat" @selected(old('property_type', $house->property_type)==='Flat')>Flat</option>
                        <option value="Condo" @selected(old('property_type', $house->property_type)==='Condo')>Condo</option>
                        <option value="Shop Lot" @selected(old('property_type', $house->property_type)==='Shop Lot')>Shop Lot</option>
                        <option value="Semi-D" @selected(old('property_type', $house->property_type)==='Semi-D')>Semi-D</option>
                        <option value="Apartment" @selected(old('property_type', $house->property_type)==='Apartment')>Apartment</option>
                        <option value="Bungalow" @selected(old('property_type', $house->property_type)==='Bungalow')>Bungalow</option>
                        <option value="Others" @selected(old('property_type', $house->property_type)==='Others')>Lain-lain (Others)</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><strong>Nama Penuh Owner</strong></td>
                <td>
                    <input type="text" name="owner_full_name" value="{{ old('owner_full_name', $house->owner_full_name) }}" style="width:420px;">
                </td>
            </tr>

            <tr>
                <td><strong>No Kad Pengenalan Owner</strong></td>
                <td>
                    <input type="text" name="owner_ic_no" value="{{ old('owner_ic_no', $house->owner_ic_no) }}" placeholder="contoh: 900101-01-1234" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Nama Bank</strong></td>
                <td>
                    <input type="text" name="bank_name" value="{{ old('bank_name', $house->bank_name) }}" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>No Account Bank</strong></td>
                <td>
                    <input type="text" name="bank_account_no" value="{{ old('bank_account_no', $house->bank_account_no) }}" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Remarks</strong></td>
                <td>
                    <textarea name="remarks" rows="3" style="width:520px;">{{ old('remarks', $house->remarks) }}</textarea>
                </td>
            </tr>

            <tr><td colspan="2"><hr></td></tr>

            <tr>
                <td><strong>Address</strong></td>
                <td>
                    <textarea name="address" rows="3" required style="width:520px;">{{ old('address', $house->address) }}</textarea>
                </td>
            </tr>

            <tr>
                <td><strong>State</strong></td>
                <td>
                    <input type="text" name="state" value="{{ old('state', $house->state) }}" required style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>City</strong></td>
                <td>
                    <input type="text" name="city" value="{{ old('city', $house->city) }}" required style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Total Rooms</strong></td>
                <td>
                    <input type="number" name="room_count" value="{{ old('room_count', $house->room_count) }}" min="0" style="width:120px;">
                </td>
            </tr>

            <tr>
                <td><strong>House Rent Price (RM)</strong></td>
                <td>
                    <input type="number" step="0.01" name="house_rent_price" value="{{ old('house_rent_price', $house->house_rent_price) }}" style="width:160px;">
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit">Update House</button>
                    <a href="{{ route('units.index') }}" style="margin-left:6px;">Cancel</a>
                </td>
            </tr>
        </table>
    </form>

    <hr style="margin:18px 0;">

    {{-- Rooms List (kekalkan yang awak dah buat) --}}
    <div style="display:flex;align-items:center;">
        <h3 style="margin:0;">Rooms List</h3>

        <div style="margin-left:auto;">
            <a href="{{ route('rooms.create', $house->id) }}"><button type="button">+ Create Room</button></a>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;margin-top:10px;">
        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th>Room Name</th>
                <th style="width:150px;">Room Type</th>
                <th style="width:140px;">Rent Price (RM)</th>
                <th style="width:140px;">Status</th>
                <th style="width:120px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($house->rooms as $i => $room)
                <tr>
                    <form method="POST" action="{{ route('rooms.update', ['house' => $house->id, 'room' => $room->id]) }}">
                        @csrf
                        @method('PUT')

                        <td>{{ $i + 1 }}</td>

                        <td>
                            <input type="text" name="name" value="{{ old('name', $room->name) }}" style="width:160px;">
                        </td>

                        <td>
                            <select name="room_type">
                                @php
                                    $rt = old('room_type', $room->room_type);
                                @endphp
                                <option value="">-</option>
                                <option value="Single" @selected($rt==='Single')>Single</option>
                                <option value="Medium" @selected($rt==='Medium')>Medium</option>
                                <option value="Master" @selected($rt==='Master')>Master</option>
                                <option value="House" @selected($rt==='House')>House</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price', $room->rent_price) }}" style="width:110px;">
                        </td>

                        <td>
                            @php $st = old('status', $room->status); @endphp
                            <select name="status">
                                <option value="available" @selected($st==='available')>available</option>
                                <option value="occupied" @selected($st==='occupied')>occupied</option>
                            </select>
                        </td>

                        <td>
                            <button type="submit">Update</button>
                        </td>
                    </form>
                </tr>
            @empty
                <tr><td colspan="6">No rooms found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection