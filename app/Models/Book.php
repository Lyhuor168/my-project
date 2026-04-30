<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $fillable = [
        'title', 'author', 'category',
        'language', 'description',
        'price', 'stock', 'image',
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
