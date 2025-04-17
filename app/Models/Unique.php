<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Unique extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','paymanagir_hamar','paymanagir_date',
        'matucman_date','carayutyan_anun','gumar','export_date',
    ];

    protected $casts = [
        'paymanagir_date' => 'date',
        'matucman_date'   => 'date',
        'export_date'     => 'date',
    ];

    /* ─── Флаг «можно ли экспортировать» ───
       • startOfDay() ― сравниваем только дату
       • addDay(‑1) убран: теперь включительно сам день export_date  */
    public function getCanExportAttribute(): bool
    {
        return $this->export_date &&
            $this->export_date->startOfDay()
                ->lte(now()->startOfDay());   // <= сегодняшней даты
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
