<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;

    protected $table = 'hardwares';
    protected $fillable = [
        'name',
        'serial',
        'user_id',
        'project_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class); // Указывает, что hardware принадлежит пользователю
    }

}
