<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_category_product;
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

        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();

        $category_product = Product_category::with('translations', 'hasChild', 'totalProducts')
            ->where('status', 'active')  // Filter by active status
            ->where('id', $id)           // Filter by the specific id
            ->first();

        $category_name = Product_category::findOrFail($id);
        // dd($category_product);
        return view('frontend.category_detail', compact('categories', 'brands', 'products', 'category_name', 'category_product'));
    }

    public function brandDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();

        $brand_product = Product::with('translations', 'brands', 'categories')
            ->where('status', 'active')->where('brand_id', $id)   // Filter by active status
            ->get();

        $brand_name = Brand::findOrFail($id);
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')
            ->where('status', 'active')->latest()->get();

        // dd($brand_product);
        return view('frontend.brand_detail', compact('categories', 'brands', 'products', 'brand_name', 'brand_product'));
    }


    public function productDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();

        $selected_product = Product::with('multi_images')->findOrFail($id);

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

        // dd($selected_product);

        return view('frontend.product_detail', compact('categories', 'brands', 'products', 'selected_product', 'category_product', 'trending_products', 'related_products'));
    }
}
