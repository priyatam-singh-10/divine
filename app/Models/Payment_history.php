<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_history extends Model
{
    use HasFactory;
    
      protected $table = 'payment_histories';
    public function users()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id', 'id');
}
}
