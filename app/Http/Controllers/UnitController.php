<?php
namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Agreement;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->get('q',''));

        $houses = House::query()
        ->with(['latestOwnerAgreement'])
        ->withCount([
            'rooms as available_rooms_count' => function ($q) {
                $q->where('status', 'available');
            }
        ])
        ->withSum('rooms as potential_rental_income', 'rent_price')
        
        ->when($q !== '', function($query) use ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('address','like', "%{$q}%")
                    ->orWhere('state','like', "%{$q}%")
                    ->orWhere('city','like', "%{$q}%");
            });
        })
        ->orderBy('id','desc')
        ->paginate(10)
        ->withQueryString();

        return view('pages.units', compact('houses','q'));
    }

    public function create()
    {
        return view('pages.units_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|in:Single,Medium,Master,House',
            'rent_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        $house = House::create($data);

        return redirect()->route('units.index')->with('success','House created.');
    }

    // room creation example
    public function createRoom(House $house)
    {
        $currentRooms = $house->rooms()->count();
        $limit = (int) ($house->room_count ?? 0);

        $canCreate = $currentRooms < $limit;

        return view('pages.rooms_create', compact('house', 'currentRooms', 'canCreate'));
    }

    public function storeRoom(Request $request, House $house)
    {
        $currentRooms = $house->rooms()->count();
        $limit = (int) ($house->room_count ?? 0);

        if ($currentRooms >= $limit) {
            return redirect()
                ->route('rooms.create', $house->id)
                ->with('error', 'Dah capai limit bilik (room_count). Tak boleh tambah room lagi.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'nullable|string|max:255',
            'rent_price' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied',
        ]);

        $house->rooms()->create($data);

        return redirect()->route('units.index')->with('success','Room created.');
    }

    public function edit(House $house)
    {
        $house->load(['rooms' => function($q){
            $q->orderBy('id','desc');
        }]);

        return view('pages.units_edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'room_count' => 'nullable|integer|min:0',
            'house_rent_price' => 'nullable|numeric',
        ]);

        $house->update($data);

        return redirect()->route('units.index')->with('success', 'House updated.');
    }
}