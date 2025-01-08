<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patasxanatu extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'number',
    ];

    /**
     * Связь с проектом.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
