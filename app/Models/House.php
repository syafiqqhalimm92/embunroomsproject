<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class House extends Model
{
    protected $fillable = [
        'address',
        'property_type',       // NEW
        'state',
        'city',
        'room_count',
        'house_rent_price',

        'owner_full_name',     // NEW
        'owner_ic_no',         // NEW
        'bank_name',           // NEW
        'bank_account_no',     // NEW
        'remarks',             // NEW
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // polymorphic agreements
    public function agreements()
    {
        return $this->morphMany(Agreement::class, 'agreeable');
    }

    // latest owner agreement (owner_to_business)
    public function latestOwnerAgreement()
    {
        return $this->morphOne(Agreement::class, 'agreeable')
            ->where('agreement_type', 'owner_to_business')
            ->latestOfMany('start_date');
    }

    // images
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}