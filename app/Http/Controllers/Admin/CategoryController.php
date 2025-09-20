<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.categories.all',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $parentCategories = Category::where('parent_id', null)->get();
        return view('dashboard.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // اعتبارسنجی داده‌های ارسالی
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'], // اختیاری، ولی باید معتبر باشه
        ]);

        // ذخیره دسته‌بندی جدید
        $category = Category::create([
            'name' => $validatedData['name'],
            'parent_id' => $validatedData['parent_id'] ?? null, // اگر parent_id نباشه، null می‌ذاریم
        ]);

        // ریدایرکت به صفحه لیست دسته‌بندی‌ها
        return redirect(route('categories.index'));
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
    public function edit(Category $category)
    {
        $parentCategories = Category::where('parent_id', null)->get();
        return view('dashboard.categories.edit', compact('parentCategories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // اعتبارسنجی داده‌های ارسالی
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'], // اختیاری، ولی باید معتبر باشه
        ]);

        // ذخیره دسته‌بندی جدید
        $category ->update([
            'name' => $validatedData['name'],
            'parent_id' => $validatedData['parent_id'] ?? null, // اگر parent_id نباشه، null می‌ذاریم
        ]);

        // ریدایرکت به صفحه لیست دسته‌بندی‌ها
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('categories.index'));
    }
}
