<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        $product = Product::findOrFail($request->id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
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
        if ($request->id) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            return redirect()->back()->with('success', 'Product removed successfully!');
        }
    }
}
