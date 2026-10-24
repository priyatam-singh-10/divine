<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'batch_id',
        'enrollment_type',
        'enroll_by_admin',
        'entry_date',
        'expiry_date',
    ];

      public function users()
{
    // user_id is the correct foreign key column in the enrollments table
    return $this->belongsTo(User::class, 'user_id', 'id');
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id', 'id');
}

public function admin()
{
    // enroll_by_admin is the admin user_id
    return $this->belongsTo(User::class, 'enroll_by_admin', 'id');
}
  public function batch()
{
    return $this->belongsTo(Batch::class, 'batch_id');
}
}
