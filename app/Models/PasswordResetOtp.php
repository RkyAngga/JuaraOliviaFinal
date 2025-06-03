<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at'];
    public $timestamps = true;
    protected $table = 'password_resets_otp';
    protected $dates = ['expires_at'];
} 