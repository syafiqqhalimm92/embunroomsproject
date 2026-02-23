<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'agreeable_type','agreeable_id','agreement_type',
        'owner_name','owner_ic','owner_phone',
        'tenant_user_id','start_date','end_date','status'
    ];

    public function agreeable()
    {
        return $this->morphTo();
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_user_id');
    }

    // scopes
    public function scopeActive($q)
    {
        return $q->where('status','active');
    }
}