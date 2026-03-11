<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerAgreement extends Model
{
    protected $fillable = [
        'house_id',
        'agreement_template_id',
        'agreement_date',
        'owner_name',
        'owner_ic',
        'owner_phone',
        'bank_name',
        'bank_account_no',
        'premise_address',
        'start_date',
        'end_date',
        'tenancy_period_month',
        'rent_price',
        'deposit_amount',
        'utility_deposit',
        'owner_signature_path',
        'inventory',
        'emergency_contact',
        'sign_token',
        'status',
        'owner_signed_at',
    ];

    protected $casts = [
        'agreement_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'owner_signed_at' => 'datetime',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function template()
    {
        return $this->belongsTo(AgreementTemplate::class, 'agreement_template_id');
    }
}