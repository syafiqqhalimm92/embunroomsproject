<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HouseImageController extends Controller
{
    public function store(Request $request, House $house)
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        foreach ($request->file('images', []) as $file) {

            $path = $file->store('houses', 'public');

            HouseImage::create([
                'house_id' => $house->id,
                'image_path' => $path
            ]);
        }

        return back()->with('success', 'House images uploaded.');
    }
    public function destroy(House $house, HouseImage $image)
    {
        if ($image->house_id != $house->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'House image deleted successfully.');
    }
}