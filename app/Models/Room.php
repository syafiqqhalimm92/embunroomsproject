<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'house_id','name','room_type','rent_price','status'
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function agreements()
    {
        return $this->morphMany(Agreement::class, 'agreeable');
    }

    // latest tenant agreement for this room
    public function latestTenantAgreement()
    {
        return $this->morphOne(Agreement::class, 'agreeable')
                    ->where('agreement_type', 'business_to_tenant_room')
                    ->latestOfMany('start_date');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}