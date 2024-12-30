<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_attribute_wise_stock;

class CartController extends Controller
{
    // Display cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add product to cart
    public function add(Request $request)
    {
        $attributeIds = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'attribute_set_') === 0) {
                // Convert the value to an integer and add it to the array
                $attributeIds[] = (int) $value;
            }
        }

        // dd($attributeIds);
        if ($attributeIds) {

            sort($attributeIds);

            $stocks = Product_attribute_wise_stock::where('product_id', $request->product_id)->whereIn('attribute_id', $attributeIds)->get();
            //dd($stocks);

            $check_stock = 0;
            foreach ($stocks as $stock) {
                $check_attribute = explode(',', $stock->attribute_id);

                sort($check_attribute);

                //dd($attributeIds);
                if ($check_attribute == $attributeIds) {
                    $check_stock = $stock->stock;
                }
            }

            if ($request->quantity > $check_stock) {
                return response()->json(['error' => true, 'message' => 'Big Quantity']);
            } else {
                $product = Product::findOrFail($request->product_id);
                $cart = session()->get('cart', []);
                if (isset($cart[$product->id])) {
                    $cart[$product->id] = [
                        "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                        "attributes" => implode(',', $attributeIds),
                    ];
                } else {
                    $cart[$product->id] = [
                        "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                        "attributes" => implode(',', $attributeIds),
                    ];
                }
                session()->put('cart', $cart);
                // dd($cart);
                return response()->json(['success' => true, 'message' => 'Succcesfully add to cart']);
            }
        } else {
            $product = Product::where('id', $request->product_id)->first();
            $check_stock = $product->quantity;
            // dd($check_stock);
            if ($request->quantity > $check_stock) {
                return response()->json(['error' => true, 'message' => 'Big Quantity']);
            } else {
                $cart = session()->get('cart', []);
                if (isset($cart[$product->id])) {
                    $cart[$product->id] = [
                        "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                    ];
                } else {
                    $cart[$product->id] = [
                        "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                    ];
                }
                session()->put('cart', $cart);
                //    dd($cart);
                return response()->json(['success' => true, 'message' => 'Successfully added to cart']);
            }
        }

    }

    // Update cart
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }
    }

    // Remove item from cart
    public function remove(Request $request)
    {
        $cartId = $request->input('id');

        // Logic to remove the item from the session cart
        // Assuming you have a session cart array
        $carts = session()->get('carts', []);

        if (isset($carts[$cartId])) {
            unset($carts[$cartId]);
            session()->put('carts', $carts);

            return response()->json(['success' => true, 'message' => 'Item removed from cart.']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart.']);
    }
}
