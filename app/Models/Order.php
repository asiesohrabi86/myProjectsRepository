<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Basket;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','basket_id','status','price','delivery'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
