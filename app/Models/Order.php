<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'user_id', 'book_id', 'product_id',
        'customer_name', 'phone', 'email',
        'quantity', 'total_price',
        'payment_method', 'status', 'note',
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
