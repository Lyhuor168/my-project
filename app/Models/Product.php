<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id', 'name', 'description',
        'price', 'sale_price', 'stock',
        'image', 'category', 'is_active',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function shop() { return $this->belongsTo(Shop::class); }

    public function getCurrentPriceAttribute() {
        return $this->sale_price ?? $this->price;
    }

    public function getIsOnSaleAttribute() {
        return !is_null($this->sale_price) && $this->sale_price < $this->price;
    }
}

