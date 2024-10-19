<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product_category;
use App\Models\Product_category_transletion;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Product_category::with('translations')->get();
        return view("backend.category.all_category", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'description' => 'required|string|max:255',
          
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = date("Y-m-d") . '_' . rand() . '_' . time() . '.' . $image->getClientOriginalExtension();
            $directory = 'upload/category/';
            $image->move($directory, $imageName);
        }

        $category = Product_category::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $request->file('image') ? $directory . $imageName : null,
            'is_featured' => $request->has('is_featured') ? 0 : 1,
            'enableSubcat' => $request->has('enableSubcat') ? 0 : 1,
            'status' => 'active',
            'level' => 1,
        ]);

        Product_category_transletion::create([
            'name' => $request->name_bangla,
            'lang_code' => 'bn',
            'categories_id' => $category->id,
        ]);
        // Return success response
        return response()->json(['success' => true, 'message' => 'Category added successfully']);
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
        $category = Product_category::with('translations')->find($id);

        if ($category) {
            return response()->json([
                'cat_id' => $category->id ?? null,
                'name' => $category->name ?? null,
                'name_bangla' => $category->translations->name ?? null,
                'description' => $category->description ?? null,
                
                'image' => $category->image ?? null,
                'is_featured' => $category->is_featured ?? null,
                'enableSubcat' => $category->enableSubcat ?? null,
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
          // Fetch the brand with its translations
          $category = Product_category::with('translations')->find($id);

          // Validate the incoming request
          $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_banglaInputText' => 'required|string|max:255',
            'edit_description' => 'required|string|max:255',
          ]);
  
          // Handle file upload
          if ($request->file('edit_image')) {
              // Delete old logo if it exists
              if (file_exists(public_path($category->image)) && !empty($category->image)) {
                  unlink(public_path($category->image));
              }
  
              // Save new logo
              $logo = $request->file('edit_image');
              $photoName = date("Y-m-d") . '_' . time() . '.' . $logo->getClientOriginalExtension();
              $directory = 'upload/category/';
              $logo->move($directory, $photoName);
              $category->image = $directory . $photoName;
          }
  
          // Update the brand's basic details
          $category->update([
              'name' => $request->edit_name,
              'description' => $request->edit_description,
              'is_featured' => $request->has('is_featured') ? 0 : 1,
              'enableSubcat' => $request->has('enableSubcat') ? 0 : 1,
          ]);
  
          // Update the translation for Bangla
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
        $category->status = 'inactive'; // Mark as inactive or deleted
        // if (file_exists(public_path($category->logo)) && !empty($category->logo)) {
        //     unlink(public_path($category->logo));
        // }
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category Successfully Deleted'
        ]);
    }

    public function getSubcategories($id)
    {
        $subcategories = Product_category::where('parent_id', $id)->get();
        return response()->json($subcategories);
    }
}
