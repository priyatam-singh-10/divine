<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable implements MustVerifyEmail
{
    use  SoftDeletes , HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'full_address',
        'role',
        'status',
        'email_verified_at',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 👇 This automatically converts JSON <-> array
        'full_address' => 'array',
    ];

    // ✅ Keep formatted version separate (for display only)
    public function getFormattedAddressAttribute()
    {
        if (empty($this->attributes['full_address'])) {
            return '-';
        }

        $address = json_decode($this->attributes['full_address'], true);

        $streetAddress = $address['address'] ?? '';
        $cityName = isset($address['city'])
            ? DB::table('cities')->where('id', $address['city'])->value('name') ?? ''
            : '';
        $stateName = isset($address['state'])
            ? DB::table('states')->where('id', $address['state'])->value('name') ?? ''
            : '';
        $countryName = isset($address['country'])
            ? DB::table('countries')->where('id', $address['country'])->value('name') ?? ''
            : '';
        $zipcode = $address['zipcode'] ?? '';

        return trim("{$streetAddress}, {$cityName}, {$stateName}, {$countryName}, {$zipcode}", ', ');
    }
}
