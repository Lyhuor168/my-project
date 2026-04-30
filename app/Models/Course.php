<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'code',
        'category',
        'image',
        'price',
        'teacher',
        'description',
        'level',
        'start_date',
        'end_date',
        'duration',
        'max_students',
        'time_start',
        'time_end',
        'room',
        'days',
        'color',
        'icon',
    ];

    protected $casts = [
        'start_date'   => 'date',
        'end_date'     => 'date',
        'duration'     => 'integer',
        'max_students' => 'integer',
    ];

    public function getDaysArrayAttribute(): array
    {
        return $this->days ? explode(',', $this->days) : [];
    }

    public function getTimeRangeAttribute(): string
    {
        if ($this->time_start && $this->time_end) {
            return $this->time_start . ' – ' . $this->time_end;
        }
        return '—';
    }
}
