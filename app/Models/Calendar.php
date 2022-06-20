<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Calendar extends Model
{
    protected $fillable=[
       'user_id',
        'course',
        'teacher',
        'time',
        'capacity',
        'cost',
        'startingtime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
