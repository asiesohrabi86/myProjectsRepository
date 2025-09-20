<?php

namespace App\Models;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ActivationCode;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Permission;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Cart;
use App\Models\Basket;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_admin',
        'is_operator',
        'email',
        'password',
        'two_factor_type',
        'phone_number',
        'two_factor_code',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_type' => 'string',
    ];

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isOperator()
    {
        return $this->is_operator;
    }

    public function hasTwoFactorAuthenticationEnabled()
    {
        return $this->two_factor_type != 'off';
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function activationCode()
    {
        return $this->hasMany(ActivationCode::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'user_id','id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class,'user_id','id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name' , $permission->name) || $this->hasRole($permission->roles);
    }

    public function hasRole($roles)
    {
        return !! $roles->intersect($this->roles)->all();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactionss()
    {
        return $this->hasMany(Transaction::class);
    }
}
