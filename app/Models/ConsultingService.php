<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingService extends Model
{
     protected $fillable = [
        'name', 'email', 'phone', 'service', 'page', 'additional_details', 'date', 'slot_id','start_time','end_time','status'
    ];
      public function slot()
{
    return $this->belongsTo(consultation_slots::class, 'slot_id');
}

// Accessor for formatted time slot
    // public function getTimeSlotAttribute()
    // {
    //     if ($this->slot) {
    //         $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
    //         $end = \Carbon\Carbon::parse($this->end_time)->format('H:i');
    //         return \Carbon\Carbon::parse($this->date)->format('Y-m-d') . " $start - $end";
    //     }
    //     return 'N/A';
    // }
    
      public function getTimeSlotAttribute()
{
    if ($this->start_time && $this->end_time && $this->date) {
        $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
        $end = \Carbon\Carbon::parse($this->end_time)->format('H:i');
        return \Carbon\Carbon::parse($this->date)->format('Y-m-d') . " $start - $end";
    }
    return 'N/A';
}
    
     // Accessor for formatted status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'confirmed' => 'success',
            'cancelled' => 'danger',
            default => 'warning',
        };
    }
}
