<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'sim_info',
        'number',
        'sim_id',
        'price',
        'mb',
        'worker_id',
        'project_id',
        'user_id',
        'ident_id'



        ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function worker()
    {
        return $this->belongsTo(User::class, );
    }
}
