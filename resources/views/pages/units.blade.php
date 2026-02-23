@extends('layouts.app')

@section('title','Units')

@section('content')
    <h2>Units (Rumah)</h2>

    @if(session('success'))
        <div style="padding:10px;border:1px solid #0a0;color:#0a0;margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex;gap:10px;margin-bottom:12px;align-items:center;">
        <form method="GET" action="{{ route('units.index') }}">
            <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari alamat / negeri / bandar">
            <button type="submit">Search</button>
            <a href="{{ route('units.index') }}">Clear</a>
        </form>

        <div style="margin-left:auto;">
            <a href="{{ route('units.create') }}"><button>Create House</button></a>
        </div>
    </div>

    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Address</th>
                <th>State</th>
                <th>City</th>
                <th>Total Rooms</th>
                <th>Available Rooms</th>
                <th>House Rent (RM)</th>
                <th>Current Rental Income</th>
                <th>Potential Rental Income</th>
                <th>Agreement Start</th>
                <th>Agreement End</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($houses as $i => $house)
            <tr>
                <td>{{ $houses->firstItem() + $i }}</td>
                <td>{{ $house->address }}</td>
                <td>{{ $house->state }}</td>
                <td>{{ $house->city }}</td>
                <td>{{ $house->room_count }}</td>
                <td>{{ $house->available_rooms_count }}</td>
                <td style="text-align:right">{{ number_format($house->house_rent_price,2) }}</td>
                <td></td>
                <td style="text-align:right">
                    {{ number_format($house->potential_rental_income ?? 0, 2) }}
                </td>
                <td>
                    @if($house->latestOwnerAgreement)
                        {{ $house->latestOwnerAgreement->start_date->format('Y-m-d') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($house->latestOwnerAgreement)
                        {{ $house->latestOwnerAgreement->end_date->format('Y-m-d') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="{{ route('units.edit', $house->id) }}"><button>Edit</button></a>
                    <a href="{{ route('rooms.create', $house->id) }}"><button>Create Room</button></a>
                </td>
            </tr>
        @empty
            <tr><td colspan="11">Tiada rumah ditemui.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">
        {{ $houses->links() }}
    </div>
@endsection