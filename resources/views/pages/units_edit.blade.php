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

    {{-- =========================
        UPDATE HOUSE
    ========================== --}}
    <form method="POST" action="{{ route('units.update', $house->id) }}">
        @csrf
        @method('PUT')

        <table cellpadding="8" cellspacing="0">
            <tr>
                <td><strong>Status</strong></td>
                <td>
                    <select name="is_active">
                        <option value="1" @selected(old('is_active', (int)$house->is_active) === 1)>Aktif</option>
                        <option value="0" @selected(old('is_active', (int)$house->is_active) === 0)>Tak Aktif</option>
                    </select>
                </td>
            </tr>

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

    {{-- =========================
        HOUSE IMAGES
    ========================== --}}
    <h3>House Images</h3>

    <div style="margin-bottom:10px;padding:10px;border:1px solid #ddd;background:#fafafa;color:#555;max-width:520px;">
        <strong>Upload Guide:</strong><br>
        Format dibenarkan: JPG, JPEG, PNG, WEBP<br>
        Saiz maksimum: 2MB bagi setiap gambar<br>
        Boleh pilih lebih daripada satu gambar sekali gus.
    </div>

    <form method="POST"
          action="{{ route('houses.images.store', $house->id) }}"
          enctype="multipart/form-data"
          style="margin-bottom:12px;">
        @csrf

        <input type="file" name="images[]" multiple accept="image/*">
        <button type="submit">Upload House Images</button>
    </form>

    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;">
        @forelse($house->images as $image)
            <div style="width:170px;border:1px solid #ddd;padding:8px;">
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     alt="House Image"
                     style="width:100%;height:120px;object-fit:cover;display:block;">

                @if(Route::has('houses.images.destroy'))
                    <form method="POST"
                          action="{{ route('houses.images.destroy', [$house->id, $image->id]) }}"
                          style="margin-top:8px;"
                          onsubmit="return confirm('Delete this house image?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                @endif
            </div>
        @empty
            <div style="color:#666;">No house images uploaded yet.</div>
        @endforelse
    </div>

    <hr style="margin:18px 0;">

    {{-- =========================
    OWNER AGREEMENTS
    ========================== --}}
    <div style="display:flex;align-items:center;">
        <h3 style="margin:0;">Owner Agreements</h3>

        <div style="margin-left:auto;">
            <a href="{{ route('owner-agreements.create', $house->id) }}">
                <button type="button">+ Create Agreement</button>
            </a>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0"
        style="width:100%;border-collapse:collapse;margin-top:10px;">

        <thead>
            <tr>
                <th style="width:60px;">No</th>
                <th>Agreement Period</th>
                <th style="width:140px;">Rent (RM)</th>
                <th style="width:140px;">Deposit</th>
                <th style="width:160px;">Template</th>
                <th style="width:140px;">Status</th>
                <th style="width:180px;">Owner Signed</th>
                <th style="width:180px;">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($house->ownerAgreements as $i => $agreement)
                <tr>
                    <td>{{ $i + 1 }}</td>

                    <td>
                        {{ optional($agreement->start_date)->format('d/m/Y') ?? '-' }}
                        -
                        {{ optional($agreement->end_date)->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        {{ number_format((float)($agreement->rent_price ?? 0), 2) }}
                    </td>

                    <td>
                        {{ number_format((float)($agreement->deposit_amount ?? 0), 2) }}
                    </td>

                    <td>
                        {{ $agreement->template->title ?? '-' }}
                    </td>

                    <td>
                        {{ $agreement->status ?? 'Draft' }}
                    </td>

                    <td>
                        {{ !empty($agreement->owner_signed_at) ? optional($agreement->owner_signed_at)->format('d/m/Y') : '-' }}
                    </td>

                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            <a href="{{ route('owner-agreements.edit', ['house' => $house->id, 'ownerAgreement' => $agreement->id]) }}">
                                <button type="button">Modify</button>
                            </a>

                            <a href="{{ route('owner-agreements.preview', ['house' => $house->id, 'ownerAgreement' => $agreement->id]) }}"
                            target="_blank">
                                <button type="button">Preview</button>
                            </a>
                            @if(!empty($agreement->sign_token))
                                <a href="{{ route('owner-agreements.sign-page', ['token' => $agreement->sign_token]) }}" target="_blank">
                                    <button type="button">Share Link</button>
                                </a>
                            @else
                                <button type="button" disabled>No Link</button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#666;">
                        No agreement created yet.
                        <br><br>

                        <a href="{{ route('owner-agreements.create', $house->id) }}">
                            <button type="button">Create First Agreement</button>
                        </a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr style="margin:18px 0;">

    {{-- =========================
        ROOMS LIST
    ========================== --}}
    <div style="display:flex;align-items:center;">
        <h3 style="margin:0;">Rooms List</h3>

        <div style="margin-left:auto;">
            <a href="{{ route('rooms.create', $house->id) }}">
                <button type="button">+ Create Room</button>
            </a>
        </div>
    </div>

    @forelse($house->rooms as $i => $room)
        <div style="border:1px solid #ccc;padding:12px;margin-top:12px;">

            {{-- UPDATE ROOM --}}
            <form method="POST" action="{{ route('rooms.update', ['house' => $house->id, 'room' => $room->id]) }}">
                @csrf
                @method('PUT')

                <table cellpadding="8" cellspacing="0" style="width:100%;">
                    <tr>
                        <td style="width:60px;"><strong>No</strong></td>
                        <td>{{ $i + 1 }}</td>
                    </tr>

                    <tr>
                        <td><strong>Room Name</strong></td>
                        <td>
                            <input type="text" name="name" value="{{ old('name', $room->name) }}" style="width:220px;">
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Room Type</strong></td>
                        <td>
                            @php $rt = old('room_type', $room->room_type); @endphp
                            <select name="room_type">
                                <option value="">-</option>
                                <option value="Single" @selected($rt==='Single')>Single</option>
                                <option value="Medium" @selected($rt==='Medium')>Medium</option>
                                <option value="Master" @selected($rt==='Master')>Master</option>
                                <option value="House" @selected($rt==='House')>House</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Rent Price (RM)</strong></td>
                        <td>
                            <input type="number" step="0.01" name="rent_price" value="{{ old('rent_price', $room->rent_price) }}" style="width:140px;">
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @php $st = old('status', $room->status); @endphp
                            <select name="status">
                                <option value="available" @selected($st==='available')>available</option>
                                <option value="occupied" @selected($st==='occupied')>occupied</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button type="submit">Update Room</button>
                        </td>
                    </tr>
                </table>
            </form>

            {{-- DELETE ROOM --}}
            <form method="POST"
                  action="{{ route('rooms.destroy', [$house->id, $room->id]) }}"
                  style="margin-top:8px;"
                  onsubmit="return confirm('Delete room {{ $room->name }}?');">
                @csrf
                @method('DELETE')
                <button type="submit">Delete Room</button>
            </form>

            <hr style="margin:16px 0;">

            {{-- ROOM IMAGES --}}
            <h4 style="margin:0 0 10px 0;">Room Images</h4>

            <div style="margin-bottom:10px;padding:10px;border:1px solid #ddd;background:#fafafa;color:#555;max-width:520px;">
                <strong>Upload Guide:</strong><br>
                Format dibenarkan: JPG, JPEG, PNG, WEBP<br>
                Saiz maksimum: 2MB bagi setiap gambar<br>
                Boleh pilih lebih daripada satu gambar sekali gus.
            </div>

            <form method="POST"
                  action="{{ route('rooms.images.store', ['house' => $house->id, 'room' => $room->id]) }}"
                  enctype="multipart/form-data"
                  style="margin-bottom:12px;">
                @csrf

                <input type="file" name="images[]" multiple accept="image/*">
                <button type="submit">Upload Room Images</button>
            </form>

            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                @forelse($room->images as $image)
                    <div style="width:160px;border:1px solid #ddd;padding:8px;">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="Room Image"
                             style="width:100%;height:110px;object-fit:cover;display:block;">

                        @if(Route::has('rooms.images.destroy'))
                            <form method="POST"
                                  action="{{ route('rooms.images.destroy', ['house' => $house->id, 'room' => $room->id, 'image' => $image->id]) }}"
                                  style="margin-top:8px;"
                                  onsubmit="return confirm('Delete this room image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div style="color:#666;">No room images uploaded yet.</div>
                @endforelse
            </div>
        </div>
    @empty
        <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;margin-top:10px;">
            <tr>
                <td>No rooms found.</td>
            </tr>
        </table>
    @endforelse
@endsection