<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class House extends Model
{
    protected $fillable = [
        'address',
        'property_type',
        'state',
        'city',
        'room_count',
        'house_rent_price',
        'owner_full_name',
        'owner_ic_no',
        'bank_name',
        'bank_account_no',
        'remarks',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // images
    public function images()
    {
        return $this->hasMany(HouseImage::class)->orderBy('sort_order');
    }

    
}