<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadPurchase extends Model
{
    protected $table = 'lead_purchases';
    protected $fillable = [
        'webinar_name',
        'user_name',
        'mobile',
        'city',
        'price',
        'payment_gateway',
        'payment_id',
        'order_id',
        'payment_status'
    ];
}
