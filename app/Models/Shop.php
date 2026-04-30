<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shop extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'description',
        'address', 'phone', 'email',
        'logo', 'cover', 'category', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($shop) {
            if (empty($shop->slug)) {
                $shop->slug = Str::slug($shop->name) . '-' . rand(100, 999);
            }
        });
    }

    // Relationships
    public function owner()    { return $this->belongsTo(User::class, 'user_id'); }
    public function products() { return $this->hasMany(Product::class); }
    public function orders()   { return $this->hasMany(Order::class); }

    // Helpers
    public function activeProducts() {
        return $this->products()->where('is_active', true);
    }
    public function totalRevenue() {
        return $this->orders()->where('status', 'delivered')->sum('total');
    }
}