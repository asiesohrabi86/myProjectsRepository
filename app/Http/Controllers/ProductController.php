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
        $this->seo()
            ->setTitle($product->metaTitle)
            ->setDescription($product->metaDescription);
        $comments= $product->comments()->where('approved',1)->get();
        // افزایش مقدار بازدید
        $product->increment('view');
        return view('product-single',compact(['product','comments']));
    }
}
