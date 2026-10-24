<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'book_id',
        'quantity',
        'total_price',
        'status',
        'payment_status',
        'payment_type',
        'gateway_order_id',
        'gateway_payment_id',
        'shipping_address',
        'shipping_contact',
        'shipping_status',
        'shipping_name' ,
        'shipping_email' 
    ];

    // Relationship: Each order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   // Relationship: Each order belongs to a book
    public function book()
    {
         return $this->belongsTo(Book::class, 'book_id');
    }
    
        public function cartItems()
    {
        return $this->hasMany(ShopCart::class, 'user_id', 'user_id');
    }
    
    protected $casts = [
        'full_shippingaddress' => 'array', // Automatically decode JSON to array
    ];
}
