<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function update(Request $request, House $house, Room $room)
    {
        // pastikan room tu memang bawah house ini
        if ($room->house_id !== $house->id) {
            abort(404);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|in:Single,Medium,Master,House',
            'rent_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        $room->update($data);

        return redirect()
            ->route('units.edit', $house->id)
            ->with('success', 'Room updated.');
    }
}