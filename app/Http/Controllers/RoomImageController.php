<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    public function store(Request $request, House $house, Room $room)
    {
        if ($room->house_id != $house->id) {
            abort(403);
        }

        $request->validate([
            'images' => ['required','array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        foreach ($request->file('images', []) as $file) {

            $path = $file->store('rooms', 'public');

            RoomImage::create([
                'room_id' => $room->id,
                'image_path' => $path
            ]);
        }

        return back()->with('success','Room images uploaded.');
    }

    public function destroy(House $house, Room $room, RoomImage $image)
    {
        if ($room->house_id != $house->id || $image->room_id != $room->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Room image deleted successfully.');
    }
}