<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class consultation_slots extends Model
{
    use HasFactory;
  // Table name (optional if matches plural form)
    protected $table = 'consultation_slots';

    // Primary key
    protected $primaryKey = 'id';

    // Fields that are mass assignable
    protected $fillable = [
        'service',
        'slot_date',
        'start_time',
        'end_time',
        'is_booked',
    ];

    // Casts for specific fields
    protected $casts = [
        'slot_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'is_booked' => 'boolean', // will auto-convert 0/1 to true/false, null stays null
    ];
}
