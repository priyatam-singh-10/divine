<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiWealthWhatsappLog extends Model
{
    protected $fillable = [
        'inquiry_id',
        'template_key',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
