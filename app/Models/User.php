<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function image(): Attribute
    {        
        return Attribute::make(
            get: fn ($value) => $value ? asset(config('const.USERIMAGEPATH')) . '/' . $value : asset(config('const.USERDEFAULTIMAGEPATH')) . '/'  . config('const.USERDEFAULTIMAGE'),
        );
    }
    /* Send Reset Password Notification */
    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', ['token' => $token, 'email' => $this->email]);

        $this->notify(new ResetPasswordNotification($url, $this->name));
    }

    
    /* Active User Status Scope */
    public function scopeActive($query)
    {
        $query->whereStatus(config('const.statusActiveInt'));
    }
    
    /* Inactive User Status Scope */
    public function scopeInactive($query)
    {
        $query->whereStatus(config('const.statusInActiveInt'));
    }

    
}
