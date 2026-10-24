<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $fillable = [
        'user_id',
        'course_id',
        'identifier',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
