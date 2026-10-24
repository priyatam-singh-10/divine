<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseReservation extends Model
{
    use HasFactory;

    protected $table = 'course_reservations';

    protected $fillable = [
        'student_name',
        'father_name',
        'mobile_no',
        'city',
        'student_email',
        'target_exam',
        'type',
        'reservation_token',
        'payment_status',
        'payment_amount',
        'payment_method',
        'payment_order_id',
        'payment_transaction_id',
        'payment_response',
    ];
}
