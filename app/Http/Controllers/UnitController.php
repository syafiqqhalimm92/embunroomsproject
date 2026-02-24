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
            'property_type' => 'nullable|in:Terrace,Service Apartment,Flat,Condo,Shop Lot,Semi-D,Apartment,Bungalow,Others',
            'owner_full_name' => 'nullable|string|max:255',
            'owner_ic_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',

            'address' => 'required|string',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'room_count' => 'nullable|integer|min:0',
            'house_rent_price' => 'nullable|numeric|min:0',
        ]);

        House::create($data);

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
            'address' => 'required|string',
            'property_type' => 'nullable|in:Terrace,Service Apartment,Flat,Condo,Shop Lot,Semi-D,Apartment,Bungalow,Others',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'room_count' => 'nullable|integer|min:0',
            'house_rent_price' => 'nullable|numeric|min:0',

            'owner_full_name' => 'nullable|string|max:255',
            'owner_ic_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        $house->rooms()->create($data);

        return redirect()->route('units.index')->with('success','Room created.');
    }

    public function edit(House $house)
    {
        $house->load('rooms'); // untuk rooms list
        return view('pages.units_edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'address' => 'required|string',
            'property_type' => 'nullable|in:Terrace,Service Apartment,Flat,Condo,Shop Lot,Semi-D,Apartment,Bungalow,Others',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'room_count' => 'nullable|integer|min:0',
            'house_rent_price' => 'nullable|numeric|min:0',

            'owner_full_name' => 'nullable|string|max:255',
            'owner_ic_no' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'bank_account_no' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        $house->update($data);

        return redirect()->route('units.index')->with('success', 'House updated.');
    }
}