<?php

    namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // កំណត់ឈ្មោះ Table (ស្របតាម migration)
    protected $table = 'news';

    // ១. អនុញ្ញាតឱ្យបញ្ចូលទិន្នន័យក្នុង column ទាំងនេះ
    protected $fillable = [
        'title_en', 
        'title_km', 
        'slug', 
        'content_en', 
        'content_km', 
        'image', 
        'category', 
        'is_published', 
        'user_id'
    ];

    // ២. បង្កើតទំនាក់ទំនងជាមួយ User (Admin ជាអ្នកផុស)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ៣. បង្កើត Accessor ដើម្បីបង្ហាញចំណងជើងតាម Locale (en ឬ km)
    // ពេលប្រើក្នុង Blade: {{ $item->title }}
    public function getTitleAttribute()
    {
        return app()->getLocale() == 'km' ? $this->title_km : $this->title_en;
    }

    // បង្កើត Accessor ដើម្បីបង្ហាញខ្លឹមសារតាម Locale
    // ពេលប្រើក្នុង Blade: {!! $item->content !!}
    public function getContentAttribute()
    {
        return app()->getLocale() == 'km' ? $this->content_km : $this->content_en;
    }
}