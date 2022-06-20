<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Course;
use App\Models\Slider;
use App\Models\calendar;

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
        'superuser',
        'email',
        'password',
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


    public function superuser()
    {
        return $this->superuser;
    }

    public function course()
    {
        $this->hasMany(Course::class,'user_id','id');
    }

    public function slider()
    {
        return $this->hasMany(Slider::class,'user_id','id');
    }

    public function master()
    {
        return $this->hasMany(Master::class,'user_id','id');
    }

    public function calendar()
    {
        return $this->hasMany(Calendar::class,'user_id','id');
    }

}
