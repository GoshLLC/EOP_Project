<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    // Update the created_at column name to match the database column
    const CREATED_AT = 'registered';
    // Disable the updated_at column as it doesn't exist in the database
    const UPDATED_AT = null;

    // The table name
    protected $table = 'accounts';

    // The fields that are required for registration
    protected $fillable = [
        'username', 'email', 'password', 'role'
    ];

    // The fields that are hidden from the user (password and remember_token)
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Use 'username' for authentication
    public function getAuthIdentifierName()
    {
        return 'username';
    }
}
?>