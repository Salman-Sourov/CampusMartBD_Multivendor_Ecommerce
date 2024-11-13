<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){

        $categories = Product_category::with('translations','hasChild')->where('status','active')->get();
        $brands = Brand::with('translations')->where('status','active')->get();
        $products = Product::with('translations','inventory_stocks')->where('status','active')->latest()->get();
         //dd($categories);
        return view('frontend.index',compact('categories','brands','products'));
    }


}
