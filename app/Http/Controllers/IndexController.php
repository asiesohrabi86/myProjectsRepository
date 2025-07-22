<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use SweetAlert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function index()
    {
        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // auth()->user()->assignRole('writer');
        $this->seo()
            ->setTitle('لاراول لرن')
            ->setDescription('دوره آموزشی پروژه محور هیولای لاراول ...');
        $products = Product::latest()->get();
        $latestProducts = Product::latest()->get();
        $mostViewedProducts = Product::latest('view')->get();
        $mobileCategoryProducts = Category::first()->products()->get();
        $laptopCategoryProducts = Category::where('id', 2 )->first()->products()->get();
        $cameraCategoryProducts = Category::where('id', 3 )->first()->products()->get();
        $accessoriesCategoryProducts = Category::where('id', 4 )->first()->products()->get();
        $brands = Brand::latest()->get();
        alert()->success('متن تست','متن عنوان تست')->persistent('خیلی خوب');
        return view('index',compact('products','latestProducts','mostViewedProducts', 'mobileCategoryProducts', 'laptopCategoryProducts', 'cameraCategoryProducts', 'accessoriesCategoryProducts', 'brands'));
    }
}
