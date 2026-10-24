<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_category_id','name','slug','description','price','sale_price','stock','sku','image','status'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }
}
