<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Project extends Model
{
    use HasFactory;

    protected $fillable = [

         'building_id',
        'check_time',
        'brand_name',
        'firm_name',
        'firm_type',
        'type_id',
        'hvhh',
        'i_marz_id',
        'i_address',
        'w_marz_id',
        'w_address',
        'ceo_name',
        'ceo_phone',
        'ceo_role',
        'fin_contact',
        'andznagir',
        'soc',
        'id',
        'firm_email',
        'firm_bank',
        'firm_bank_hh',
        'price_id',
        'paymanagir_time',
        'paymanagir_start',
        'signed',
        'status',
        'user_id',
        'worker_id',
        'x_gps',
        'y_gps',
        'nkar',
        'their_hardware',
        'patasxanatu_id',
        'connection_type',
        'indent_number',
        'ident_id',
        'end_dimum',
        'paymanagir_end',
        'paymanagir_received',
        'status_edit',
        'object_check',
'ceorole_id',
        'tech_check',
        'id_card',
        'choosed_type',
        'start_act'
    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function object_type()
    {
        return $this->belongsTo(Object_type::class,'type_id');
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
    public function simlists()
    {
        return $this->hasMany(Simlist::class);
    }
    public function hardwares()
    {
        return $this->hasMany(Hardware::class);
    }

    public function patasxanatus()
    {
        return $this->hasMany(Patasxanatu::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
