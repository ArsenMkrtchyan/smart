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
        'ident_id',
        'kargavichak',
        'user_id',

        'worker_id',
        'project_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class); // Указывает, что hardware принадлежит пользователю
    }
    public function worker()
    {
        return $this->belongsTo(User::class,'worker_id');
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
