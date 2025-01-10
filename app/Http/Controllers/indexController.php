<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_category_product;
use App\Models\Product_with_attribute;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {

        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists
        // dd($products);
        return view('frontend.index', compact('categories', 'brands', 'products', 'carts'));
    }

    public function categoryDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $category_product = Product_category::with('translations', 'hasChild', 'totalProducts')
            ->where('status', 'active')  // Filter by active status
            ->where('id', $id)           // Filter by the specific id
            ->first();

        $category_name = Product_category::findOrFail($id);
        // dd($category_product);
        return view('frontend.category_detail', compact('categories', 'brands', 'products', 'category_name', 'category_product', 'carts'));
    }

    public function brandDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $brand_product = Product::with('translations', 'brands', 'categories')
            ->where('status', 'active')->where('brand_id', $id)   // Filter by active status
            ->get();

        $brand_name = Brand::findOrFail($id);
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')
            ->where('status', 'active')->latest()->get();

        // dd($brand_product);
        return view('frontend.brand_detail', compact('categories', 'brands', 'products', 'brand_name', 'brand_product', 'carts'));
    }


    public function productDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $selected_product = Product::with('multi_images', 'attribute_set',)->findOrFail($id);
        $attributes = Product_with_attribute::where('product_id', $id)->first();

        $category_product = Product_category_product::with('products', 'category_detail')
            ->where('product_id', $id)           // Filter by the specific id
            ->first();

        $trending_products = Product::with('translations')
            ->where('status', 'active')
            ->where('id', '!=', $id) // Exclude the current product
            ->latest()
            ->get();

        $related_products = Product_category::with('totalProducts')
            ->where('status', 'active')
            ->where('id',  $category_product->category_id) // Exclude the current product
            ->first();

        //dd($attributes);

        return view('frontend.product_detail', compact('categories', 'brands', 'products', 'selected_product', 'category_product', 'trending_products', 'related_products', 'attributes', 'carts'));
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'area' => 'required',
            'payment-option' => 'required',
        ]);

        $carts = session()->get('cart');
        
        dd($carts);
    }

    public function productSearch(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:255',
        ]);

        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        // $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists

        $query = $request->input('search');
        // dd($query);

        // Check if query exists, else return with no results
    if (!$query) {
        return view('frontend.product_search', compact('categories', 'brands', 'carts'))->with('error', 'No search query provided.');
    }

    // Fetch products based on the search query
    $products = Product::with(['translations', 'inventory_stocks', 'brands', 'categories'])
        ->where('status', 'active')
        ->where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
        ->latest()
        ->get();

    // Return the view with the search results
    return view('frontend.product_search', compact('categories', 'brands', 'products', 'carts', 'query'));
    }
}
