<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Basket;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','product_id','quantity','basket_id','color_id','guarantee_id','price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
