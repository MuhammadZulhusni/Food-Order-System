<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Mail\Websitemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // Show admin login page
    public function AdminLogin()
    {
        return view('admin.login');
    }

    // Show admin dashboard after login
    public function AdminDashboard()
    {
        return view('admin.admin_dasboard');
    }

    // Handle admin login form submission
    public function AdminLoginSubmit(Request $request)
    {
        // Validate email and password input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],        
        ];

        // Attempt to log in using the 'admin' guard
        if (Auth::guard('admin')->attempt($data)) 
        {
            return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
        } 
        else
        {
            return redirect()->route('admin.login')->with('error', 'Invalid Credentials');
        }
    }    

    // Handle admin logout
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully');
    }

    // Show forget password form
    public function AdminForgetPassword()
    {
        return view('admin.forget_password');
    }

    // Handle forget password form submission and send reset link
    public function AdminPasswordSubmit(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $admin_data = Admin::where('email', $email)->first();

        // If email not found in database
        if (!$admin_data) {
            return redirect()->back()->with('error', 'Email Not Found');
        }

        // Generate a secure token and save to admin record
        $token = hash('sha256', time());
        $admin_data->token = $token;
        $admin_data->save();

        // Create reset password link
        $reset_link = url('admin/reset-password/' . $token . '/' . $email);
        $subject = "Reset Password";

        // Compose reset email
        $message = "Please click on the link below to reset your password:<br>";
        $message .= "<a href='" . $reset_link . "'>Click Here</a>";

        // Send email with HTML content
        Mail::html($message, function ($mail) use ($email, $subject) {
            $mail->to($email)->subject($subject);
        });

        return redirect()->back()->with('success', 'Reset password link sent to your email');
    }

    // Show reset password form if token and email are valid
    public function AdminResetPassword($token, $email)
    {
        // Check if token and email match in the database
        $admin_data = Admin::where('email', $email)->where('token', $token)->first();

        // Redirect back to login if not found
        if(!$admin_data){
            return redirect()->route('admin.login')->with('error', 'Invalid Token or Email');
        }

        // Show the reset password view
        return view('admin.reset_password', compact('token','email'));
    }

    // Handle reset password form submission
    public function AdminResetPasswordSubmit(Request $request)
    {
        // Validate input
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        // Find the admin user by email and token
        $admin_data = Admin::where('email', $request->email)->where('token', $request->token)->first();

        // Update password and clear token
        $admin_data->password = Hash::make($request->password);
        $admin_data->token = "";
        $admin_data->update();

        // Redirect back to login with success message
        return redirect()->route('admin.login')->with('success', 'Password reset successfully');
    }
}
