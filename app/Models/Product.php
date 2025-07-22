<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;
use App\Models\ProductColor;
use App\Models\Cart;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'text',
        'price',
        'amount',
        'view',
        'image',
        'brand_id',
        // 'metaTitle',
        // 'metaDescription',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function guarantees(){
        return $this->hasMany(Guarantee::class);
    }

    public function colors() {
        return $this->hasMany(ProductColor::class);
    }
}
