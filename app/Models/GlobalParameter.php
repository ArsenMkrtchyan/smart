<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalParameter extends Model
{
    protected $table = 'globalparameters';

    protected $fillable = [
        'example1',
        'example2',
        'keyword_id',
    ];
}
