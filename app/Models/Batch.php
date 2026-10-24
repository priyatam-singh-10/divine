<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'start_date',
        'end_date',
        'leacture_count',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'batch_id', 'user_id');
    }
    public function liveClasses()
    {
        return $this->hasMany(\App\Models\Live_class::class, 'batch_id');
    }
    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class, 'batch_id');
    }
}
