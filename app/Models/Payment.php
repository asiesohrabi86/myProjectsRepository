<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    protected $fillable = [
        'resnumber',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
