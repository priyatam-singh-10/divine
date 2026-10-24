<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Book extends Model
{
    use SoftDeletes,HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'slug',
        'author',
        'author_desc',
        'user_id',
        'description',
        'price',
        'image',
        'stock',
        'language',
        'pricing_type',
        'cover_image',
        'video',
        'video_url',
        'discount_percentage',
        'status'
    ];

    // Relationship: One book can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
