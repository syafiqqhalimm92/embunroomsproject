<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementTemplate extends Model
{
    protected $fillable = [
        'type',
        'title',
        'content',
        'is_active',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'to_owner' => 'To Owner',
            'to_tenants' => 'To Tenants',
            default => $this->type,
        };
    }
}

