<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('dashboard.brands.all' , compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255','min:3'],
            // 'metaTitle'=>'nullable',
            // 'metaDescription'=>'nullable',
        ]);

        // dd($request->image);
        // Image
        if ($request->hasFile('image')) 
        {
           $image = $request->image;
           $path = time().$image->getClientOriginalName();
           $path = str_replace(' ','-',$path);
           $image->move('storage/brands/',$path);
           $path = 'storage/brands/'.$path;
        }

        $brand = $request->user()->brands()->create($request->all());

        // پر کردن فیلد عکس برای برند به دو روش
        // $brand->image = $path;
        $brand->update([
            'image' => $path,
        ]); 
        toast()->success('برند جدید با موفقیت ثبت شد');
        return redirect(route('brands.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(brand $brand)
    {
        return view('dashboard.brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, brand $brand)
    {
        $request->validate([
            'name' => ['required','string','max:255','min:3'],
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            // حذف عکس قبلی اگر وجود داشته باشد
            if ($brand->image && file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image));
            }
            $image = $request->image;
            $path = time().$image->getClientOriginalName();
            $path = str_replace(' ','-',$path);
            $image->move('storage/brands/',$path);
            $data['image'] = 'storage/brands/'.$path;
        }
        $brand->update($data);
        toast()->success('برند با موفقیت ویرایش شد');
        return redirect(route('brands.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(brand $brand)
    {
        if ($brand->image && file_exists(public_path($brand->image))) {
            unlink(public_path($brand->image));
        }
        $brand->delete();
        toast()->success('برند با موفقیت حذف شد');
        return back();
    }
}
