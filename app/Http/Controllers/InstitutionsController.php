<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;

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
    public function store(Request $request) {
        //  dd($request->all());

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
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
                'logo' => $directory . $photoName,
                'status' => 'active',
            ]);
        } else {
            $institutions = Institution::create([
                'name' => $request->name,
                'status' => 'active',
            ]);
        }

        // Flash message for success
        $notification = array(
            'message' => 'Institutions Created Successfully', // The message you want to display
            'alert-type' => 'success' // Success notification type
        );

        // Redirect back to the list page with the notification
        // return redirect()->back()->with($notification);
        // Return success response
        return response()->json(['success' => true, 'message' => 'Institutions added successfully']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
