<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCart extends Model
{
    //
     protected $table = 'shop_cart'; // table name

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity'
    ];

    // If you want relation with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // If you want relation with Item model (assuming you have it)
     public function book()
    {
        return $this->belongsTo(Book::class, 'item_id');
    }
}
