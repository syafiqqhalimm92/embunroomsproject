<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function create(House $house)
    {
        // optional: kira limit bilik
        $currentRooms = $house->rooms()->count();
        $remaining = max(0, (int)$house->room_count - $currentRooms);

        $canCreate = $remaining > 0;
        return view('pages.rooms_create', compact('house','currentRooms','remaining','canCreate'));
    }

    public function store(Request $request, House $house)
    {
        // kalau nak enforce limit room_count
        $currentRooms = $house->rooms()->count();
        if ($house->room_count !== null && $currentRooms >= (int)$house->room_count) {
            return back()->withErrors([
                'room_limit' => 'Rooms limit reached for this house.'
            ])->withInput();
        }

        // ✅ validation untuk ROOM sahaja (bukan address/state/city)
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'room_type'  => 'required|in:Single,Medium,Master,House',
            'rent_price' => 'required|numeric|min:0',
            'status'     => 'required|in:available,occupied',
        ]);

        $data['house_id'] = $house->id;

        Room::create($data);

        return redirect()
            ->route('units.edit', $house->id) // kalau page edit house kau memang route units.edit
            ->with('success', 'Room created.');
    }

    public function update(Request $request, House $house, Room $room)
    {
        // pastikan room tu memang bawah house ini
        if ($room->house_id !== $house->id) {
            abort(404);
        }

        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'room_type'  => 'required|in:Single,Medium,Master,House',
            'rent_price' => 'required|numeric|min:0',
            'status'     => 'required|in:available,occupied',
        ]);

        $room->update($data);

        return redirect()
            ->route('units.edit', $house->id)
            ->with('success', 'Room updated.');
    }

    public function destroy(House $house, Room $room)
    {
        // ensure room memang milik house ni
        if ($room->house_id !== $house->id) {
            abort(404);
        }

        $room->delete();

        return back()->with('success', 'Room deleted.');
    }
}