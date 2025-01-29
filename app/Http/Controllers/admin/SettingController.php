<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;

class SettingController extends Controller
{
    public function siteSetting(){
        $products = Product::where("status", 'active')->where("is_featured", '0')->orderBy("name", "asc")->get();
        $featured_products = Product::where("status", 'active')->where("is_featured", '1')->orderBy("name", "asc")->get();
        return view('backend.site_update',compact('products','featured_products'));
    }

    public function updateFeaturedProducts(Request $request){

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
    
        $featured = Product::findOrFail($request->product_id);
    
        if ($featured->is_featured == '0') {
            $featured->is_featured = '1'; // Use '=' instead of '=='
            $featured->save();
        }
    
        return redirect()->back()->with('success', 'Product updated successfully!');

    }
}
