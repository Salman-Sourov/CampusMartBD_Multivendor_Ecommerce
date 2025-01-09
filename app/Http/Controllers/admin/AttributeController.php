<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_attribute;
use App\Models\Product_attribute_set;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attribute_sets = Product_attribute_set::where('status', 'active')->get();
        $attributes = Product_attribute::where('status', 'active')->get();
        return view("backend.attribute.all_attribute", compact("attributes", "attribute_sets"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inactiveAttribute = Product_attribute::where('status', 'inactive')->get();
        return view('backend.attribute.all_inactive_attribute', compact('inactiveAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'attribute_set_id' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            // 'color' => 'nullable|string|max:255',
        ]);

        Product_attribute::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'attribute_set_id' => $request->attribute_set_id,
            // 'color' => $request->color,
            'status' => 'active',
        ]);

        return response()->json(['success' => true, 'message' => 'Attribute added successfully']);
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
        $Attribute = Product_attribute::findOrFail($id);
        //dd($Attribute);
        if ($Attribute) {
            return response()->json([
                'id' => $Attribute->id ?? null,
                'set_id' => $Attribute->attribute_set_id ?? null,
                'title' => $Attribute->title ?? null,
                // 'color' => $Attribute->color ?? null,
                'status' => $Attribute->status ?? null,
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
        $Attribute = Product_attribute::find($id);

        $request->validate([
            'edit_title' => 'required|string|max:255',
            //   'edit_color' => 'nullable|string|max:255',
            'edit_attribute_set_id' => 'required|string|max:255',
        ]);

        $Attribute->update([
            'title' => $request->edit_title,
            'slug' => Str::slug($request->edit_title),
            // 'color' => $request->edit_color,
            'attribute_set_id' => $request->edit_attribute_set_id,

            // 'status' => $request->has('status') ? 'active' : 'inactive',
        ]);
        return response()->json(['success' => true, 'message' => 'Attribute Set updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Attribute = Product_attribute::find($id);
        $Attribute->status = 'inactive'; // Mark as inactive or deleted

        // if (file_exists(public_path($category->logo)) && !empty($category->logo)) {
        //     unlink(public_path($category->logo));
        // }
        $Attribute->save();

        return response()->json([
            'success' => true,
            'message' => 'Attribute Set Successfully Deleted'
        ]);
    }


    public function attributeChangeStatus(Request $request)
    {

        $product_attribute = Product_attribute::findOrFail($request->inactive_attribute_id);

        if ($product_attribute->status == 'inactive') {
            $product_attribute->status = 'active';
            $product_attribute->save();
        }
        return response()->json(['success' => 'Status changed successfully']);
    }

    public function attributeDelete(Request $request, string $id)
    {
        $Attribute = Product_attribute::find($id);

        if ($Attribute) {

            $Attribute->delete();

            return response()->json([
                'success' => true,
                'message' => 'Attribute-Set deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Attribute-Set not found.'
        ]);
    }
}
