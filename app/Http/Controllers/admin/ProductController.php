<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("backend.product.all_product", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where("status", 'active')->orderBy("name", "asc")->get();
        $categories = Product_category::where('status', 'active')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('backend.product.add_product', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd('hello');
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_name_bangla' => 'required|string|max:255',
            'brand_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'length' => 'nullable|numeric',
            'wide' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'content' => 'nullable|string',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->file('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = date("Y-m-d") . '_' . rand() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $directory = 'upload/product/';
            $image->move($directory, $imageName);
        }

        // $sku = $request->sku ?? $this->generateSku($request->product_name, $request->category_id);

        $product = Product::create([
            'name' => $request->product_name,
            'description' => $request->description,
            'content' => $request->short_content,
            'status' => 'active',
            'thumbnail' => $request->file('thumbnail') ? $directory . $imageName : null,
            // 'sku' => $sku,
            'quantity' => $request->quantity,
            'is_featured' => $request->has('is_featured') ? 0 : 1,
            'brand_id' => $request->brand_id,
            'is_variation' => $request->has('is_variation') ? 0 : 1,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'length' => $request->length,
            'wide' => $request->wide,
            'height' => $request->height,
            'weight' => $request->weight,
            'created_by_id' => Auth::User()->id,
        ]);

        $notification = array(
            'message' => 'Product Successfully Added',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
