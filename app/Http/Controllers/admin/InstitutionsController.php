<?php

namespace App\Http\Controllers\Admin;

use App\Models\Institution;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstitutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $institutions = Institution::where("status", 'active')->get();
        return view("backend.institutions.all_institutions", compact("institutions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inactive_institutions = Institution::where('status', 'inactive')->get();
        return view("backend.institutions.all_inactive_institutions", compact('inactive_institutions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->file('image')) {
            $logo = $request->file('image');
            $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $logo->getClientOriginalExtension();
            $directory = 'upload/institutions/';
            $logo->move($directory, $photoName);
        }

        if ($request->file('image')) {
            $institutions = Institution::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'logo' => $directory . $photoName,
                'status' => 'active',
            ]);
        } else {
            $institutions = Institution::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace('', '-', $request->name)),
                'status' => 'active',
            ]);
        }

        // Flash message for success
        $notification = array(
            'message' => 'Institutions Created Successfully', // The message you want to display
            'alert-type' => 'success' // Success notification type
        );

        // Return success response
        // return response()->json(['success' => true, 'message' => 'Institutions added successfully']);
        return response()->json([
            'success' => true,
            'message' => 'Institutions added successfully',
            'institution' => $institutions
        ]);
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
        $institution = Institution::findOrFail($id);

        if ($institution) {
            return response()->json([
                'institution_id' => $institution->id ?? null,
                'institution_name' => $institution->name ?? null,
                'logo' => $institution->logo ?? null,
            ]);
        } else {

            return response()->json(['error' => true, 'message' => 'Institution not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $institution = Institution::findOrFail($id);

        // Validate the incoming request
        $request->validate([
            'edit_name' => 'required|string|max:255',
            'edit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $institution->name = $request->edit_name;
        $institution->slug = Str::slug($request->edit_name);

        if ($request->file('edit_image')) {
            if (!empty($institution->logo) && file_exists(public_path($institution->logo))) {
                unlink(public_path($institution->logo));
            }

            $logo = $request->file('edit_image');
            $photoName = date("Y-m-d") . '_' . time() . '.' . $logo->getClientOriginalExtension();
            $directory = 'upload/institutions/';
            $logo->move(public_path($directory), $photoName);
            $institution->logo = $directory . $photoName;
        }

        $institution->save();

        // return response()->json(['success' => true, 'message' => 'Institution updated successfully']);
        return response()->json([
            'success' => true,
            'message' => 'Institution updated successfully',
            'updated_logo' => $institution->logo ? asset($institution->logo) : null
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $institution = Institution::findOrFail($id);

        $institution->status = 'inactive'; // Mark as inactive or deleted
        $institution->save();

        return response()->json([
            'success' => true,
            'message' => 'Institution Successfully Deleted'
        ]);
    }

    // Change Status
    public function institutionsChangeStatus(Request $request)
    {
        $institution = Institution::find($request->institution_id);

        if ($institution->status === 'active') {
            $institution->status = 'inactive';
        } else {
            $institution->status = 'active';
        }

        $institution->save();

        return response()->json([
            'success' => true,
            'status' => $institution->status,
            'message' => 'Status updated successfully!',
        ]);
    }

    public function institutionsDelete(Request $request, $id)
    {
        $institution = Institution::findOrFail($id);

        if ($institution) {
            // Check if logo exists and delete the file
            if (file_exists(public_path($institution->logo)) && !empty($institution->logo)) {
                unlink(public_path($institution->logo)); // Delete logo file
            }

            // Delete the institution record
            $institution->delete();

            return response()->json([
                'success' => true,
                'message' => 'Institution deleted successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Institution not found.'
        ]);
    }
}
