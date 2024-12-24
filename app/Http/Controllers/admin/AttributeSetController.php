<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product_attribute_set;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeSetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attribute_sets = Product_attribute_set::where('status','active')->get();
        return view("backend.attributeset.all_attribute_set", compact("attribute_sets"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $inactive_attribute_set = Product_attribute_set::where('status','inactive')->get();
       return view("backend.attributeset.all_inactive_attribute_set",compact("inactive_attribute_set"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $AttributeSet = Product_attribute_set::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title), 
            'status' =>  'active',
        ]);

        return response()->json(['success' => true, 'message' => 'Attribute Set added successfully']);
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
        $AttributeSet = Product_attribute_set::find($id);

        if ($AttributeSet) {
            return response()->json([
                'set_id' => $AttributeSet->id ?? null,
                'title' => $AttributeSet->title ?? null,
                // 'status' => $AttributeSet->status ?? 'active',
            ]);
        } else {
            return response()->json(['error' => true, 'message' => 'Attribute Set not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $AttributeSet = Product_attribute_set::find($id);

        $request->validate([
          'edit_title' => 'required|string|max:255',
        ]);

        $AttributeSet->update([
            'title' => $request->edit_title,
            'slug' => Str::slug($request->edit_title), 
            // 'status' => $request->has('status') ? 'active' : 'inactive',
        ]);
        return response()->json(['success' => true, 'message' => 'Attribute Set updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $AttributeSet = Product_attribute_set::find($id);
        $AttributeSet->status = 'inactive'; // Mark as inactive or deleted

        // if (file_exists(public_path($category->logo)) && !empty($category->logo)) {
        //     unlink(public_path($category->logo));
        // }
        $AttributeSet->save();

        return response()->json([
            'success' => true,
            'message' => 'Attribute Set Successfully Deleted'
        ]);
    }

    public function attributesetChangeStatus(Request $request){

        $product_attribute_set = Product_attribute_set::findOrFail($request->inactive_attribute_set_id);
        
        if ($product_attribute_set->status == 'inactive'){
            $product_attribute_set->status = 'active';
            $product_attribute_set->save();
        }

        // Return updated status
        return response()->json(['success' => 'Status changed successfully']);
        // dd($category);

    }
}
