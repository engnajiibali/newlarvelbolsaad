<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
      protected $fillable = [
        'role_id',
        'username',
        'full_name',
        'phone',
        'photo',
        'email',
        'isDefault',
        'isAdmin',
        'email_verified_at',
        'password',
        'remember_token',
        'status',
        'two_factor_secret',
        'otp_code',
        'otp_expires_at',
    ];
                       public function roleName()
    {

        return $this->belongsTo(UserRole::class,'role_id')->withDefault([
            'Role' => 'Unknown Role'
        ]);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',          // hide OTP in JSON output
        'two_factor_secret', // hide 2FA secret
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'password' => 'hashed',
    ];

       public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
