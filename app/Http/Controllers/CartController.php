<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Product_attribute_wise_stock;
use App\Models\Brand;
use App\Models\Product_category;

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
                        // "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                        "attributes" => implode(',', $attributeIds),
                    ];
                } else {
                    $cart[$product->id] = [
                        // "id" => $product->id,
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
                        // "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                    ];
                } else {
                    $cart[$product->id] = [
                        // "id" => $product->id,
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
    public function remove(string $id)
    {
        $cartId = $id;

        // Logic to remove the item from the session cart
        // Assuming you have a session cart array
        $carts = session()->get('cart');
        // dd($carts);

        if (isset($carts[$cartId])) {
            unset($carts[$cartId]);
            session()->put('cart', $carts);
        }

        $update_cart_quantity = count($carts);

        $total_price = 0;

        // Calculate total price for remaining items
        foreach ($carts as $cart) {
            $total_price += $cart['price'] * $cart['quantity'];
        }

        return response()->json([

            'update_cart_quantity' => $update_cart_quantity ?? 0,
            'total_price' => $total_price ?? 0,
        ]);

        //dd($carts);
    }



    public function checkout()
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');
        // dd($carts);

        return view('frontend.checkout', compact('categories', 'brands', 'products', 'carts'));
    }

    public function buyNow(Request $request)
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
                        // "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                        "attributes" => implode(',', $attributeIds),
                    ];
                } else {
                    $cart[$product->id] = [
                        // "id" => $product->id,
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
                        // "id" => $product->id,
                        "name" => $product->name,
                        "quantity" => $request->quantity,
                        "price" => $product->sale_price,
                        "image" => $product->thumbnail,
                    ];
                } else {
                    $cart[$product->id] = [
                        // "id" => $product->id,
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
}
