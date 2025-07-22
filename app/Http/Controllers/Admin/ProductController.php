<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Guarantee;
use App\Models\ProductColor;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('dashboard.products.all' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::all();
        $attributeValues = AttributeValue::all();
        $brands = \App\Models\Brand::all();
        return view('dashboard.products.create',compact(['categories','attributes','attributeValues','brands']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selectedAttributes = $request->input('selected_attributes', []);
        $attributeValues = $request->input('attributeValues', []);
        $guarantees = $request->input('guarantees', []);
        $colors = $request->input('colors', []);
        // dd($colors, $guarantees, $selectedAttributes, $attributeValues);
        $request->validate([
            'title' => ['required','string','max:255','min:3'],
            'text' => ['required'],
            'categories' => ['required'],
            'price' => ['required','integer'],
            'amount' => ['required','integer'],
            'brand_id' => ['required','exists:brands,id'],
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) 
        {
           $image = $request->image;
           $path = time().$image->getClientOriginalName();
           $path = str_replace(' ','-',$path);
           $image->move('storage/products/',$path);
           $data['image'] = 'storage/products/'.$path;
        }
        $product = $request->user()->products()->create($data);

        //Add Attributes For Product
        $syncData = [];
        foreach ($attributeValues as $attributeId => $value) {
            
            $syncData[$attributeId] = ['value_id' => $value];
            
        }
        // dd($syncData);
        if (!empty($syncData)) {
            $product->attributes()->attach($syncData);
        }

        // ثبت رنگ‌ها (colors)
        if (!empty($colors)) {
            foreach ($colors as $color) {
                // اگر هیچ فیلدی پر نشده بود، این رنگ را ثبت نکن
                if (empty($color['color_name'])) {
                    continue;
                }
                $product->colors()->create([
                    'color_name' => $color['color_name'] ?? null,
                    'color' => $color['color'] ?? null,
                    'price_increase' => $color['price_increase'] ?? null
                ]);
            }
        }

        // ثبت گارانتی‌ها (guarantees)
        if (!empty($guarantees)) {
            foreach ($guarantees as $guarantee) {
                // اگر هیچ فیلدی پر نشده بود، این گارانتی را ثبت نکن
                if (empty($guarantee['name'])) {
                    continue;
                }
                $product->guarantees()->create([
                    'name' => $guarantee['name'] ?? null,
                    'price_increase' => $guarantee['price_increase'] ?? null
                ]);
            }
        }

        $product->categories()->attach(request('categories'));
        toast()->success('محصول جدید با موفقیت ثبت شد');
        return redirect(route('products.index'));
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = \App\Models\Brand::all();
        $attributes = Attribute::all();
        $attributeValues = AttributeValue::all();
        return view('dashboard.products.edit',compact(['product','categories','brands', 'attributes', 'attributeValues']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $selectedAttributes = $request->input('selected_attributes', []);
        $attributeValues = $request->input('attributeValues', []);

        $request->validate([
            'title' => ['required','string','max:255','min:3'],
            'text' => ['required'],
            'categories' => ['required'],
            'price' => ['required','integer'],
            'amount' => ['required','integer'],
            'brand_id' => ['required','exists:brands,id'],
        ]);

        $data = $request->all();
        // اگر کاربر عکس جدیدی فرستاد
        if ($request->hasFile('image')) {
            // ابتدا باید عکس قبلی را پاک کنیم
            if($product->image && file_exists(public_path($product->image))){
                unlink(public_path($product->image));
            }

            $image = $request->image;
            $path = time().$image->getClientOriginalName();
            $path = str_replace(' ','-',$path);
            $image->move('storage/products/',$path);
            $data['image'] = 'storage/products/'.$path;
        }
        $product->update($data);
        $product->categories()->sync(request('categories'));

        //edit Attributes For Product
        $syncData = [];
        foreach ($attributeValues as $attributeId => $value) {
            
            $syncData[$attributeId] = ['value_id' => $value];
            
        }
        // dd($syncData);
        if (!empty($syncData)) {
            $product->attributes()->sync($syncData);
        }

        // ویرایش رنگ‌ها (colors)
        try {
            DB::beginTransaction();
    
            $originalColorIds = $product->colors()->pluck('id')->all();
            $submittedColors = $request->input('colors', []);
            $submittedIds = [];
    
            foreach ($submittedColors as $colorData) {
                if(isset($colorData['color_name'])){
                // اگر رنگ ID داشت، یعنی یک رکورد موجود است -> آپدیت کن
                    if (isset($colorData['id'])) {
                        $product->colors()->where('id', $colorData['id'])->update([
                            'color_name' => $colorData['color_name'],
                            'color' => $colorData['color'],
                            'price_increase' => $colorData['price_increase'] ?? 0,
                        ]);
                        // آی‌دی‌های ارسال شده را نگه می‌داریم
                        $submittedIds[] = $colorData['id'];
                    }
                    // اگر ID نداشت، یعنی یک رنگ جدید است -> ایجاد کن
                    else {
                        $product->colors()->create([
                            'color_name' => $colorData['color_name'],
                            'color' => $colorData['color'],
                            'price_increase' => $colorData['price_increase'] ?? 0,
                        ]);
                    }
                }
            }
    
            // حذف رنگ‌هایی که در دیتابیس بودند ولی در فرم ارسالی جدید وجود ندارند
            $idsToDelete = array_diff($originalColorIds, $submittedIds);
            if (!empty($idsToDelete)) {
                $product->colors()->whereIn('id', $idsToDelete)->delete();
            }
    
            DB::commit();
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطایی در به‌روزرسانی رنگ‌ها رخ داد: ' . $e->getMessage());
        }

        // ویرایش گارانتی‌ها (guarantees)
        try {
            DB::beginTransaction();
    
            $originalGuaranteeIds = $product->guarantees()->pluck('id')->all();
            $submittedGuarantees = $request->input('guarantees', []);
            $submittedIds = [];
    
            foreach ($submittedGuarantees as $guaranteeData) {
                if(isset($guaranteeData['name'])){
                // اگر رنگ ID داشت، یعنی یک رکورد موجود است -> آپدیت کن
                    if (isset($guaranteeData['id'])) {
                        $product->guarantees()->where('id', $guaranteeData['id'])->update([
                            'name' => $guaranteeData['name'],
                            'price_increase' => $guaranteeData['price_increase'] ?? 0,
                        ]);
                        // آی‌دی‌های ارسال شده را نگه می‌داریم
                        $submittedIds[] = $guaranteeData['id'];
                    }
                    // اگر ID نداشت، یعنی یک رنگ جدید است -> ایجاد کن
                    else {
                        $product->guarantees()->create([
                            'name' => $guaranteeData['name'],
                            'price_increase' => $guaranteeData['price_increase'] ?? 0,
                        ]);
                    }
                }
            }
    
            // حذف رنگ‌هایی که در دیتابیس بودند ولی در فرم ارسالی جدید وجود ندارند
            $idsToDelete = array_diff($originalGuaranteeIds, $submittedIds);
            if (!empty($idsToDelete)) {
                $product->guarantees()->whereIn('id', $idsToDelete)->delete();
            }
    
            DB::commit();
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'خطایی در به‌روزرسانی گارانتی ها رخ داد: ' . $e->getMessage());
        }

        toast()->success('محصول با موفقیت ویرایش شد');
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // حذف عکس محصول از سرور
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        $product->delete();
        toast()->success('محصول با موفقیت حذف شد');
        return back();
    }
}
