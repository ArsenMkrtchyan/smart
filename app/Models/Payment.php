<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'finance_id',
        'project_id',
        'amount',
        'description',
        'date'
    ];

    public function finance()
    {
        return $this->belongsTo(Finance::class);
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class);
    }
}
