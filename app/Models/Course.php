<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Course extends Model
{
    protected $fillable=[
        'user_id',
        'course',
        'master',
        'time',
        'description',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
