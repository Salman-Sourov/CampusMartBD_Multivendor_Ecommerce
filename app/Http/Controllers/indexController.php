<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {

        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        // dd($brands);
        return view('frontend.index', compact('categories', 'brands', 'products'));
    }

    public function categoryDetails($id)
    {
        $category_name = Product_category::findOrFail($id);
        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();

        // Use first() since you're querying by a specific category ID
        $category_product = Product_category::with('translations', 'hasChild', 'totalProducts')
            ->where('status', 'active')  // Filter by active status
            ->where('id', $id)           // Filter by the specific id
            ->first();

        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        // dd($category_product);
        return view('frontend.category_detail', compact('categories', 'brands', 'products', 'category_name', 'category_product'));
    }

    public function brandDetails($id)
    {
        $brand_name = Brand::findOrFail($id);
        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();

        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')
            ->where('status', 'active')
            ->where('brand_id', $id)
            ->first();

        // dd($products);
        return view('frontend.brand_detail', compact('categories', 'brands', 'products', 'brand_name'));
    }
}
