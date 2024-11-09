<?php

namespace App\Http\Controllers;

use App\Models\Product_attribute_set;
use App\Models\Product_attribute_wise_stock;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_attribute;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function getStock(string $id)
    {
        $attributeSets = Product_attribute_set::where('status', 'active')->get();
        $product_id = Product::where('id', $id)->where('status', 'active')->first();
        $stocks = Product_attribute_wise_stock::where('status', 1)->get();
        return view('backend.product.stock_page', compact('attributeSets', 'product_id', 'stocks'));
    }

    public function getAttribute(string $id)
    {
        $attributes = Product_attribute::where('attribute_set_id', $id)->get();
        //dd($attributes);
        return response()->json($attributes);
    }

    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('hello');
        $request->validate([
            'attribute_set' => 'required',
            'attribute' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            // 'status' => 1,
        ]);

        $check_attribute = Product_attribute_wise_stock::where('attribute_id', $request->attribute)->first();

        if (! $check_attribute) {
            $data = new Product_attribute_wise_stock();
            $data->product_id  = $request->product_id;
            $data->attribute_id = $request->attribute;
            $data->price = $request->price;
            $data->sale_price = $request->sale_price;
            $data->stock = $request->stock;
            $data->status = 1;
            $data->save();
            return response()->json(['success' => true, 'message' => 'Stock added successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Already Added This Attribute']);
        }
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
