<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
       public function adminHome()
    {
        return view('admin.index');
    }

    public function AdminProfile()
    {
        $id = Auth::user()->id; //collect user data from database
        $profileData = User::find($id); //Laravel Eloquent
        return view('admin.admin_profile_view', compact('profileData'));
    } //End Method

    public function AdminProfileStore(Request $request)
    {
        $id = Auth::user()->id; //collect user data from database
        $data = User::find($id); //Laravel Eloquent
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AdminChangePassword()
    {

        $id = Auth::user()->id; //collect user data from database
        $profileData = User::find($id); //Laravel Eloquent
        return view('admin.admin_change_password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request)
    {

        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        //Match The old password
        if (!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
                'message' => 'Old password does not match',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        };

        //update the password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password change successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

}
