@extends('layouts.app')

@section('title', 'Create House')

@section('content')
    <h2>Create House</h2>

    <div style="margin-bottom:10px;">
        <a href="{{ route('units.index') }}"><button type="button">← Back</button></a>
    </div>

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

    <form method="POST" action="{{ route('units.store') }}">
        @csrf

        <table cellpadding="8" cellspacing="0">
            <tr>
                <td style="width:220px;"><strong>Jenis Kediaman</strong></td>
                <td>
                    <select name="property_type" style="width:320px;">
                        <option value="">-- Select --</option>
                        <option value="Terrace" @selected(old('property_type')==='Terrace')>Rumah Teres (Terrace)</option>
                        <option value="Service Apartment" @selected(old('property_type')==='Service Apartment')>Service Apartment</option>
                        <option value="Flat" @selected(old('property_type')==='Flat')>Flat</option>
                        <option value="Condo" @selected(old('property_type')==='Condo')>Condo</option>
                        <option value="Shop Lot" @selected(old('property_type')==='Shop Lot')>Shop Lot</option>
                        <option value="Semi-D" @selected(old('property_type')==='Semi-D')>Semi-D</option>
                        <option value="Apartment" @selected(old('property_type')==='Apartment')>Apartment</option>
                        <option value="Bungalow" @selected(old('property_type')==='Bungalow')>Bungalow</option>
                        <option value="Others" @selected(old('property_type')==='Others')>Lain-lain (Others)</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><strong>Nama Penuh Owner</strong></td>
                <td>
                    <input type="text" name="owner_full_name" value="{{ old('owner_full_name') }}" style="width:420px;">
                </td>
            </tr>

            <tr>
                <td><strong>No Kad Pengenalan Owner</strong></td>
                <td>
                    <input type="text" name="owner_ic_no" value="{{ old('owner_ic_no') }}" placeholder="contoh: 900101-01-1234" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Nama Bank</strong></td>
                <td>
                    <input type="text" name="bank_name" value="{{ old('bank_name') }}" placeholder="contoh: Maybank / CIMB" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>No Account Bank</strong></td>
                <td>
                    <input type="text" name="bank_account_no" value="{{ old('bank_account_no') }}" style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Remarks</strong></td>
                <td>
                    <textarea name="remarks" rows="3" style="width:520px;">{{ old('remarks') }}</textarea>
                </td>
            </tr>

            <tr><td colspan="2"><hr></td></tr>

            <tr>
                <td><strong>Address</strong></td>
                <td>
                    <textarea name="address" rows="3" required style="width:520px;">{{ old('address') }}</textarea>
                </td>
            </tr>

            <tr>
                <td><strong>State</strong></td>
                <td>
                    <input type="text" name="state" value="{{ old('state') }}" required style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>City</strong></td>
                <td>
                    <input type="text" name="city" value="{{ old('city') }}" required style="width:260px;">
                </td>
            </tr>

            <tr>
                <td><strong>Room Count</strong></td>
                <td>
                    <input type="number" name="room_count" value="{{ old('room_count', 0) }}" min="0" style="width:120px;">
                    <small style="margin-left:8px;color:#666;">(Max room yang dibenarkan)</small>
                </td>
            </tr>

            <tr>
                <td><strong>House Rent Price (RM)</strong></td>
                <td>
                    <input type="number" step="0.01" name="house_rent_price" value="{{ old('house_rent_price', 0) }}" style="width:160px;">
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit">Save</button>
                    <a href="{{ route('units.index') }}" style="margin-left:6px;">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
@endsection