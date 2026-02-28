<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'accounts';

    // Update the created_at column name to match the database column
    const CREATED_AT = 'registered';
    // Disable the updated_at column as it doesn't exist in the database
    const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'registered',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'registered' => 'datetime',
    ];
}
