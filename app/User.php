<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class User extends Authenticatable implements Presentable
{
    const ROLE_CUSTOMER = 0;
    const ROLE_DRIVER = 1;
    const ROLE_MANAGER = 2;
    const ROLE_ADMIN = 5;

    use Notifiable;
    use PresentableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'access_token', 'email_confirmed', 'confirmation_code',
        'avatar', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function getPermitAttribute()
    {
        switch($this->role)
        {
            case self::ROLE_DRIVER:
                return __('Driver');
                break;
            case self::ROLE_MANAGER:
                return __('Manager');
                break;
            case self::ROLE_ADMIN:
                return __('Admin');
                break;
            default:
                return __('Customer');
            break;
        }
    }

    public function generateAccessToken()
    {
        $this->access_token = bcrypt(time() . $this->email . $this->id) . md5(time());
    }

    public static function generateConfirmationCode()
    {
        return substr(str_shuffle("123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -6);
    }

    public function updatePassword($password)
    {
        $this->generateAccessToken();
        $this->password = \Hash::make($password);
        $this->save();
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    // Relationship
    public function orders()
    {
        return $this->hasMany(\App\Order::class);
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDriver()
    {
        return $this->role === self::ROLE_DRIVER;
    }

    public function scopeGetRoles()
    {
        return [
            self::ROLE_CUSTOMER => __('Customer'),
            self::ROLE_DRIVER => __('Driver'),
            self::ROLE_MANAGER => __('Manager'),
            self::ROLE_ADMIN => __('Admin'),
        ];
    }
}
