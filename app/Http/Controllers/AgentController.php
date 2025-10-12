<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product_category;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\File;

class AgentController extends Controller
{
    public function AgentRegisterShow()
    {

        return view('frontend.agent_register');
    }

    public function AgentRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => [
                'required',
                'string',
                'max:14',
                'unique:users,phone',
                'regex:/^\+8801[3-9][0-9]{8}$/'
            ],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Please enter a phone number.',
            'phone.regex' => 'Please enter a valid Bangladeshi phone number (e.g., +8801XXXXXXXXX).',
            'phone.unique' => 'This phone number is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 6 characters long.',
            // 'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $verification_code = rand(100000, 999999);

        // Save user temporarily in session
        session([
            'temp_user' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'verification_code' => $verification_code,
                'role' => 'agent',
                'status' => 'inactive',
                'expires_at' => now()->addMinutes(10),
            ]
        ]);

        // Send OTP email using custom Mailable
        Mail::to($request->email)->queue(new VerifyEmailMail($verification_code));

        return redirect()->route('verify.email')->with('success', 'We sent an OTP to your email. Please verify.');
    }

    public function AgentDashboard()
    {
        return view('agent.index');
    }

    public function AgentLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Agent Successfully Logout',
            'alert-type' => 'success',
        ];

        return redirect('/')->with($notification);
    }

    public function AgentProfile()
    {
        $id = Auth::user()->id; //collect user data from database
        $profileData = User::find($id); //Laravel Eloquent
        // dd($profileData);
        return view('agent.agent_profile_view', compact('profileData'));
    } //End Method

    public function AgentProfileStore(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'roll' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = Auth::user()->id; //collect user data from database
        $data = User::find($id); //Laravel Eloquent
        $data->phone = $request->phone;
        $data->address = $request->address;
        // $data->university = $request->university;
        $data->roll = $request->roll;

        if ($request->file('photo')) {
            $file = $request->file('photo');

            // Folder path
            $destinationPath = public_path('upload/agent_images');

            // Check if folder exists, otherwise create
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Delete old image if exists
            if ($data->image && File::exists($destinationPath . '/' . $data->image)) {
                @unlink($destinationPath . '/' . $data->image);
            }

            // Save new file
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $data->image = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Agent Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function AgentChangePassword()
    {

        $id = Auth::user()->id; //collect user data from database
        $profileData = User::find($id); //Laravel Eloquent
        return view('agent.agent_change_password', compact('profileData'));
    }

    public function AgentUpdatePassword(Request $request)
    {

        //Validation
        $request->validate([
            // 'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        //Match The old password
        // if (!Hash::check($request->old_password, auth::user()->password)) {

        //     $notification = array(
        //         'message' => 'Old password does not match',
        //         'alert-type' => 'error'
        //     );

        //     return back()->with($notification);
        // };

        //update the password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Passord change successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function AgentVerification(Request $request)
    {
        
    }
}
