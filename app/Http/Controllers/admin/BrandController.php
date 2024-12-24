<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Brand;
use App\Models\Brand_translation;
use Illuminate\Support\Facades\File;
use Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::where("status",'active')->get();
        return view("backend.brand.all_brand", compact("brands"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inactive_brands = Brand::where('status', 'inactive')->get();
        return view("backend.brand.all_inactive_brand", compact('inactive_brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'name_bangla' => 'required|string|max:255',

        ]);

        if ($request->file('image')) {
            $logo = $request->file('image');
            $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $logo->getClientOriginalExtension();
            $directory = 'upload/brand/';
            $logo->move($directory, $photoName);
        }


        // Store brand data in the database
        if ($request->file('image')) {
            $brand = Brand::create([
                'name' => $request->name,
                'description' => $request->description,
                'website' => $request->website,
                'logo' => $directory . $photoName,
                'status' => 'active',
            ]);
        } else {
            $brand = Brand::create([
                'name' => $request->name,
                'description' => $request->description,
                'website' => $request->website,
                'status' => 'active',

            ]);
        }

        $brand = Brand_translation::create([
            'name' => $request->name_bangla,
            'lang_code' => 'bn',
            'brand_id' => $brand->id,
        ]);

        // Flash message for success
        $notification = array(
            'message' => 'Brand Created Successfully', // The message you want to display
            'alert-type' => 'success' // Success notification type
        );

        // Redirect back to the list page with the notification
        // return redirect()->back()->with($notification);
        // Return success response
        return response()->json(['success' => true, 'message' => 'Brand added successfully']);
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
        $brand = Brand::with('translations')->find($id);

        if ($brand) {
            return response()->json([
                'brand_id' => $brand->id ?? null,
                'brand_name' => $brand->name ?? null,
                'name_bangla' => $brand->translations->name ?? null,
                'description' => $brand->description ?? null,
                'website' => $brand->website ?? null,
                'logo' => $brand->logo ?? null,
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
        // Fetch the brand with its translations
        $brand = Brand::with('translations')->find($id);

        // Validate the incoming request
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_banglaInputText' => 'required|string|max:255',
            'edit_description' => 'required|string|max:255',
            // 'edit_website' => 'required|string|max:255',
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        if ($request->file('edit_image')) {
            // Delete old logo if it exists
            if (file_exists(public_path($brand->logo)) && !empty($brand->logo)) {
                unlink(public_path($brand->logo));
            }

            // Save new logo
            $logo = $request->file('edit_image');
            $photoName = date("Y-m-d") . '_' . time() . '.' . $logo->getClientOriginalExtension();
            $directory = 'upload/brand/';
            $logo->move($directory, $photoName);
            $brand->logo = $directory . $photoName;
        }

        // Update the brand's basic details
        $brand->update([
            'name' => $request->edit_name,
            'description' => $request->edit_description,
            'website' => $request->edit_website,
        ]);

        // Update the translation for Bangla
        $brand->translations()->updateOrCreate(
            ['lang_code' => 'bn', 'brand_id' => $brand->id],
            ['name' => $request->edit_banglaInputText]
        );

        // Return success response
        return response()->json(['success' => true, 'message' => 'Brand updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = 'inactive'; // Mark as inactive or deleted
        // if (file_exists(public_path($brand->logo)) && !empty($brand->logo)) {
        //     unlink(public_path($brand->logo));
        // }
        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand Successfully Deleted'
        ]);
    }

    public function brandChangeStatus(Request $request)
    {
        $brand = Brand::find($request->brand_id);
        
        if ($brand->status == 'inactive'){
            $brand->status = 'active';
            $brand->save();
        }

        // Return updated status
        return response()->json(['success' => 'Status changed successfully']);
        
    } // End Method

}
