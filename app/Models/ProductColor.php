<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['color_name', 'color', 'product_id', 'price_increase'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
