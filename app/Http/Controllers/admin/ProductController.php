<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\product_translation;
use App\Models\Product_category_product;
use App\Models\Multi_image;
use App\Models\Product_with_multi_image;
use App\Models\Videos;
use App\Models\Product_with_videos;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("backend.product.all_product", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where("status", 'active')->orderBy("name", "asc")->get();
        $categories = Product_category::where('status', 'active')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('backend.product.add_product', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd('hello');

        DB::beginTransaction();
        try {

            $request->validate([
                'product_name' => 'required|string|max:255',
                'product_name_bangla' => 'required|string|max:255',
                'brand_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'nullable',
                'quantity' => 'required|integer',
                'price' => 'required|numeric',
                'sale_price' => 'nullable|numeric',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'length' => 'nullable|numeric',
                'wide' => 'nullable|numeric',
                'height' => 'nullable|numeric',
                'weight' => 'nullable|numeric',
                'content' => 'nullable|string',
                'description' => 'required|string',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->file('thumbnail')) {
                $image = $request->file('thumbnail');
                $imageName = date("Y-m-d") . '_' . rand() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $directory = 'upload/product/';
                $image->move($directory, $imageName);
            }

            // $sku = $request->sku ?? $this->generateSku($request->product_name, $request->category_id);

            $product = Product::create([
                'name' => $request->product_name,
                'description' => $request->description,
                'content' => $request->short_content,
                'status' => 'active',
                'thumbnail' => $request->file('thumbnail') ? $directory . $imageName : null,
                // 'sku' => $sku,
                'quantity' => $request->quantity,
                'is_featured' => $request->has('is_featured') ? 0 : 1,
                'brand_id' => $request->brand_id,
                'is_variation' => $request->has('is_variation') ? 0 : 1,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'length' => $request->length,
                'wide' => $request->wide,
                'height' => $request->height,
                'weight' => $request->weight,
                'created_by_id' => Auth::User()->id,
            ]);

            product_translation::create([
                'name' => $request->product_name_bangla,
                'lang_code' => 'bn',
                'products_id' => $product->id,
            ]);
            // dd($request->all());

            // Handle sub_category_id
            if ($request->filled('sub_category_id')) {
                Product_category_product::create([
                    'category_id' => $request->sub_category_id,
                    'product_id' => $product->id,
                ]);
            } else {
                Product_category_product::create([
                    'category_id' => $request->category_id,
                    'product_id' => $product->id,
                ]);
            }

            if ($request->file('multi_img')) {
                $images = $request->file('multi_img');
                foreach ($images as $image) {
                    $data = new Multi_image();
                    $product_image = new Product_with_multi_image();
                    $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $image->getClientOriginalExtension();
                    $directory = 'upload/product/';
                    $image->move($directory, $photoName);
                    $data->image = $directory . $photoName;
                    $data->product_id = $product->id;
                    $data->save();
                    $multiImageId = $data->id;
                    $product_image->product_id = $product->id;
                    $product_image->multiImage_id = $multiImageId;
                    $product_image->save();
                }
            }


            if ($request->has('video_type') && $request->has('video_link')) {
                $videoTypes = $request->input('video_type');
                $videoLinks = $request->input('video_link');
                $count = count($videoTypes);
                for ($i = 0; $i < $count; $i++) {
                    $data = new Videos();
                    $product_video = new Product_with_videos();
                    $data->video_type = $videoTypes[$i];
                    $data->video_link = $videoLinks[$i];
                    $data->product_id = $product->id;
                    $data->save();
                    $product_video->product_id    = $product->id;
                    $product_video->video_id = $data->id;
                    $product_video->save();
                }
            }

            DB::commit();

            $notification = array(
                'message' => 'Product Successfully Added',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        } catch (\Exception $e) {

            DB::rollback();

            $notification = array(
                'message' => 'Failed to store product. Please try again.',
                'alert-type' => 'error',
            );

            return back()->with($notification);
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
        $product = Product::with('translations', 'categories', 'multi_images', 'videos')->find($id);
        // dd(vars: $product);
        $product->start_date = \Carbon\Carbon::parse($product->start_date)->format('Y-m-d');
        $product->end_date = \Carbon\Carbon::parse($product->end_date)->format('Y-m-d');

        $brands = Brand::where('status', 'active')->get();
       
        $categories = Product_category::where('status', 'active')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        // dd($product->brands);
        return view('backend.product.edit_product', compact('product', 'brands', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadMultiImg(Request $request)
    {
        $request->validate([
            'multi_img' => 'required|image|mimes:jpeg,png,jpg,gif|',
        ]);

        if ($request->file('multi_img')) {
            $image = $request->file('multi_img');
                $data = new Multi_image();
                $product_image = new Product_with_multi_image();
                $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $image->getClientOriginalExtension();
                $directory = 'upload/product/';
                $image->move($directory, $photoName);
                $data->image = $directory . $photoName;
                $data->product_id = $request->upload_product_id;
                $data->save();
                $multiImageId = $data->id;
                $product_image->product_id = $request->upload_product_id;
                $product_image->multiImage_id = $multiImageId;
                $product_image->save();

                $notification = array(
                    'message' => 'Product Successfully Added',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
        }

        $notification = array(
            'message' => 'Failed to store product. Please try again.',
            'alert-type' => 'error',
        );

        return back()->with($notification);
        
    }

    public function deleteMultiImg($id){

        // dd(vars: $id);

        $multiImage = Multi_image::findOrFail($id);
        unlink($multiImage->image);

        $multiImage->delete();

        // $product = Product_with_multi_image::where('multiImage_id','$id')->first();

        // $product->delete();

        $notification = array(
            'message' => 'Product MultiImage Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
   
}
