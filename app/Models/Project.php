<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Project extends Model
{
    use HasFactory;

    protected $fillable = [

    'brand_name',
        'firm_type',
        'hvhh',
        'i_marz_id',
        'i_address',
        'w_marz_id',
        'w_address',
        'ceo_name',
        'ceo_phone',
        'firm_email',
        'firm_bank',
        'firm_bank_hh',
        'price_id',
        'paymanagir_time',
        'paymanagir_start',
        'signed',
        'status',
        'user_id',
        'paymanagir_id_marz',
        'x_gps',
        'y_gps',
        'nkar',
        'their_hardware',
        'patasxanatu',
        'patasxanatu_phone',
        'patasxanatu_date',
        'building_type',
        'paymanagir_end',
        'paymanagir_received',
        'status_edit',
        'firm_name'

    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }


    public function iMarz()
    {
        return $this->belongsTo(State::class, 'i_marz_id');
    }

    public function wMarz()
    {
        return $this->belongsTo(State::class, 'w_marz_id');
    }

    public function finances()
    {
        return $this->hasMany(Finance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
