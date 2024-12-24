<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_category;
use App\Models\Product_category_transletion;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Product_category::with('translations')->where('status', 'active')->whereNull('parent_id')->get();

        $subcategories = Product_category::with(['translations', 'hasChild'])->where('status', 'active')
            ->whereNotNull('parent_id') // Filter categories that have child categories
            ->get();
        // dd($subcategories);
        return view("backend.subcategory.all_subcategory", compact("subcategories", "categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inactive_subcategory = Product_category::where('status', 'inactive')->whereNotNull('parent_id')->get();
        return view("backend.subcategory.all_inactive_subcategory", compact('inactive_subcategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validation
        $request->validate([
            'category_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'name_bangla' => 'required|string|max:255',
            // 'description' => 'required|string|max:255',

        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = date("Y-m-d") . '_' . rand() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $directory = 'upload/category/';
            $image->move($directory, $imageName);
        }

        $category = Product_category::create([
            'parent_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->file('image') ? $directory . $imageName : null,
            'is_featured' => $request->has('is_featured') ? 0 : 1,
            'enableSubcat' => 0,
            'status' => 'active',
            'level' => 2,
        ]);

        Product_category_transletion::create([
            'name' => $request->name_bangla,
            'lang_code' => 'bn',
            'categories_id' => $category->id,
        ]);
        // Return success response
        return response()->json(['success' => true, 'message' => 'Sub Category added successfully']);
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
        //dd('hello');
        //  $category = Product_category::with('translations')->whereNull('parent_id')->find($id);
        $sub_category = Product_category::find($id);
        // dd($sub_category);
        if ($sub_category) {
            return response()->json([

                'cat_id' => $sub_category->id ?? null,
                'edit_category_id' => $sub_category->parent_id ?? null,
                'name' => $sub_category->name ?? null,
                'name_bangla' => $sub_category->translations->name ?? null,
                'description' => $sub_category->description ?? null,

                'image' => $sub_category->image ?? null,
                'is_featured' => $sub_category->is_featured ?? null,
                'enableSubcat' => $sub_category->enableSubcat ?? null,
            ]);
        } else {

            return response()->json(['error' => true, 'message' => 'Category not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Fetch the category with its translations
        $category = Product_category::with('translations')->find($id);

        // Validate the incoming request
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_banglaInputText' => 'required|string|max:255',
            // 'edit_description' => 'required|string|max:255',
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        if ($request->file('edit_image')) {
            // Delete old image if it exists
            if (file_exists(public_path($category->image)) && !empty($category->image)) {
                unlink(public_path($category->image));
            }

            // Save new image
            $image = $request->file('edit_image');
            $photoName = date("Y-m-d") . '_' . time() . '.' . $image->getClientOriginalExtension();
            $directory = 'upload/category/';
            $image->move($directory, $photoName);
            $category->image = $directory . $photoName;
        }

        // Directly set 'is_featured' and 'enableSubcat' based on the request
        // $category->is_featured = $request->has('edit_is_featured') ? 1 : 0;


        // Update the category's basic details including the toggled fields
        $category->update([
            'name' => $request->edit_name,
            'parent_id' => $request->edit_category_id,
            'description' => $request->edit_description,
            // 'is_featured' => $category->is_featured, // Save the updated value of 'is_featured'
            // 'enableSubcat' => $category->enableSubcat // Save the updated value of 'enableSubcat'
        ]);

        // Update or create the translation for Bangla
        $category->translations()->updateOrCreate(
            ['lang_code' => 'bn', 'categories_id' => $category->id],
            ['name' => $request->edit_banglaInputText]
        );

        // Return success response
        return response()->json(['success' => true, 'message' => 'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Product_category::findOrFail($id);
        $category->status = 'inactive';

        // Check if the image file exists and delete it
        // if (file_exists(public_path($category->image)) && !empty($category->image)) {
        //     unlink(public_path($category->image)); // Delete the image from the server
        // }
        // $category->image = null;

        $category->save();
        return response()->json([
            'success' => true,
            'message' => 'Category Successfully Deleted'
        ]);
    }

    public function subcategoryChangeStatus(Request $request){

        $subcategory = Product_category::findOrFail($request->subcategory_id);
        
        if ($subcategory->status == 'inactive'){
            $subcategory->status = 'active';
            $subcategory->save();
        }

        // Return updated status
        return response()->json(['success' => 'Status changed successfully']);
        // dd($category);
    }
}
