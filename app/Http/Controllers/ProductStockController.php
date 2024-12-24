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
        $product_id = Product::with('attribute_set')->where('id', $id)->where('status', 'active')->first();

        $variants = Product_with_attribute_set::where('product_id', $id)->get();
        //dd($product_id);
        return view('backend.product.stock_page', compact('attributeSets', 'product_id', 'variants'));
    }

    public function getAttribute(string $id)
    {
        $attributes = Product_attribute::where('attribute_set_id', $id)->get();
        //dd($attributes);
        return response()->json($attributes);
    }

    public function getEditAttribute(string $id)
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
        //dd($request->attribute_set);
        $request->validate([
            'attribute_set' => 'required',
        ]);

        $check_attributeSet = Product_with_attribute_set::where('attribute_set_id', $request->attribute_set)->first();

        if (!$check_attributeSet) {
            //     $data = new Product_attribute_wise_stock();
            //     $data->product_id  = $request->product_id;
            //     $data->attribute_id = $request->attribute;
            //     $data->price = $request->price;
            //     $data->sale_price = $request->sale_price;
            //     $data->stock = $request->stock;
            //     $data->status = 1;
            //     $data->save();
            // dd('hello');
            $data = new Product_with_attribute_set();
            $data->product_id = $request->product_id;
            $data->attribute_set_id  = $request->attribute_set;
            $data->save();

            return response()->json(['success' => true, 'message' => 'Attribute Set added successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Already Added This Attribute Set']);
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
                'edit_product_id' => $stock->product_id ?? null,


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
        // dd('Product ID: ', $id);
        $request->validate([
            'edit_attribute_set' => 'required',
            'edit_attribute' => 'required',
            'edit_price' => 'required',
            'edit_sale_price' => 'required',
            'edit_stock' => 'required',
        ]);

        $update_attribute = Product_attribute_wise_stock::where('product_id', $id)->first();
        //dd($update_attribute);

        if ($update_attribute) {

            $update_attribute->attribute_id = $request->edit_attribute;
            $update_attribute->price = $request->edit_price;
            $update_attribute->sale_price = $request->edit_sale_price;
            $update_attribute->stock = $request->edit_stock;
            // $update_attribute->status = 1;
            $update_attribute->save();


            $data = Product_with_attribute_set::where('product_id', $id)->first();
            //dd($data);
            $data->attribute_set_id = $request->edit_attribute_set;
            $data->save();

            // Product_with_attribute_set::updateOrCreate(
            //     ['product_id' => $update_attribute->product_id],
            //     ['attribute_set_id' => $update_attribute->id]
            // );
            return response()->json(['success' => true, 'message' => 'Stock Updated successfully']);
        } else {
            return response()->json(['error' => true, 'message' => 'Wrong Input']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock_product = Product_with_attribute_set::findOrFail($id);
        // Mark as inactive or deleted
        $stock_product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock Successfully Deleted'
        ]);
    }


    public function getStockAttribute(string $id)
    {
        //dd($id);

        $StockAttribute = Product_attribute::where('attribute_set_id', $id)->get();
        //dd(vars: $StockAttribute);
        return response()->json($StockAttribute);
    }


    public function addAttributeWiseStock(Request $request)
    {
        $request->validate([
            'quantity' => 'required',
        ]);

        $attributeIds = json_decode($request->input('attribute_ids'), true);
        $quantity = $request->input('quantity');

        // Perform the logic with the data
        // dd($request);
        $data = new Product_attribute_wise_stock();
        $data->product_id = $request->product_id;
        $data->stock = $request->quantity;
        $total_attributeIds = count($attributeIds);

        $attributeString = implode(',', $attributeIds);

        // Check if the attribute combination already exists
        $exist_attribute = Product_attribute_wise_stock::where('attribute_id', $attributeString)->first();
        if($exist_attribute)
        {
            $update_exist_attribute = Product_attribute_wise_stock::where('id', $exist_attribute->id)->first();

            $update_exist_attribute->stock = $request->quantity;
            $update_exist_attribute->save();
            return response()->json(['success' => true, 'message' => 'Product stock Updated successfully']);
        }

        if ($total_attributeIds != 0) {
            $attributeString = '';
            for ($i = 0; $i < $total_attributeIds; $i++) {
                $attributeString .= $attributeIds[$i] . ',';
            }
            $data->attribute_id = rtrim($attributeString, ',');  // Remove trailing comma
            $data->save();
            return response()->json(['success' => true, 'message' => 'Product stock added successfully']);
        }

        else{
            return response()->json(['success' => true, 'message' => 'Error']);
        }
    }
}
