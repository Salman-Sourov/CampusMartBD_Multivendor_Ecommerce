<?php

namespace App\Http\Controllers;

use App\Models\Institution;
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
use App\Models\AgentVerification;
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
        $id = Auth::user()->id;
        $verification = AgentVerification::where('agent_id', $id)->first();
        $agentId = Auth::user(); // or User::find($id)

        return view('agent.index', compact('id', 'verification', 'agentId'));
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
        $institutions =  Institution::where('status', 'active')->get();
        // dd( $profileData);
        return view('agent.agent_profile_view', compact('profileData',  'institutions'));
    } //End Method

    public function AgentProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $rules = [
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($rules);

        // Save data
        $data->phone = $request->phone;
        $data->address = $request->address;

        // Image upload
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $destinationPath = public_path('upload/agent_images');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            if ($data->image && File::exists($destinationPath . '/' . $data->image)) {
                @unlink($destinationPath . '/' . $data->image);
            }

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $data->image = $filename;
        }

        $data->save();

        $notification = [
            'message' => 'Agent Profile Updated Successfully',
            'alert-type' => 'success',
        ];

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
        $id = Auth::user()->id;

        $uploadPath = public_path('upload/agent_ver_images');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        // Use firstOrCreate to ensure record exists
        $verification = AgentVerification::firstOrCreate(['agent_id' => $id]);

        // Only update NID if file is uploaded
        if ($request->hasFile('nid')) {
            $nidFile = $request->file('nid');
            $nidName = time() . '_nid.' . $nidFile->getClientOriginalExtension();
            $nidFile->move($uploadPath, $nidName);
            $verification->nid = $nidName;
        }

        // Only update Student ID if file is uploaded
        if ($request->hasFile('student_id')) {
            $studentFile = $request->file('student_id');
            $studentName = time() . '_student.' . $studentFile->getClientOriginalExtension();
            $studentFile->move($uploadPath, $studentName);
            $verification->student_id = $studentName;
        }

        // Only update institution/roll if they are provided (first time)
        if ($request->filled('institution_id')) {
            $verification->institution = $request->input('institution_id');
        }
        if ($request->filled('roll')) {
            $verification->roll = $request->input('roll');
        }

        $verification->verification_date = now();
        $verification->save();

        $user = User::find($id);
        if ($user) {
            $user->status = 'pending';
            $user->save();
        }

        $notification = [
            'message' => 'Verification documents uploaded successfully!',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
