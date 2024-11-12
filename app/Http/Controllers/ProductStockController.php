<?php

namespace App\Http\Controllers;

use App\Models\Product_attribute_set;
use App\Models\Product_attribute_wise_stock;
use App\Models\Product_with_attribute_set;
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
        $stocks = Product_attribute_wise_stock::all();
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

            $data = new Product_with_attribute_set();
            $data->product_id = $request->product_id;
            $data->attribute_set_id  = $request->attribute_set;
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
        $stock = Product_attribute_wise_stock::findOrFail($id);
        // dd($stock);
        $attribute_set = Product_attribute::where('id', $stock->attribute_id)->first();
       // dd($attribute_set->attribute_set_id);

        if ($stock) {
            return response()->json([
                'edit_attribute_set' => $attribute_set->attribute_set_id ?? null,
                'edit_attribute' => $stock->attribute_id  ?? null,
                'edit_price' => $stock->price ?? null,
                'edit_sale_price' => $stock->sale_price ?? null,
                'edit_stock' => $stock->stock ?? null,
            ]);
        } else {

            return response()->json(['error' => true, 'message' => 'Brand not found']);
        }
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
        $stock_product = Product_attribute_wise_stock::findOrFail($id);
        // Mark as inactive or deleted
        $stock_product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock Successfully Deleted'
        ]);
    }


    public function getStockAttribute(string $id){
            //dd($id);

            $StockAttribute = Product_attribute::where('attribute_set_id', $id)->get();
           //dd(vars: $StockAttribute);
            return response()->json($StockAttribute);
    }
}
