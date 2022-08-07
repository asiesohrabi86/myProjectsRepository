<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('products',compact('products'));
    }

    public function singleProduct(Product $product)
    {
        $comments= $product->comments()->where('approved',1)->get();
        return view('product-single',compact(['product','comments']));
    }
}
