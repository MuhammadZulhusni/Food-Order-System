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
        return view('admin.index');
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

    public function AdminProfile()
    {
        // Get authenticated admin's ID
        $id = Auth::guard('admin')->id();
        // Find admin data by ID
        $profileData = Admin::find($id);
        // Return view with profile data
        return view('admin.admin_profile',compact('profileData'));      
    }

    public function AdminProfileStore(Request $request){
        // Get authenticated admin's ID
        $id = Auth::guard('admin')->id();
        // Find admin data by ID
        $data = Admin::find($id);

        // Update basic profile fields
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 

        // Store old photo path for potential deletion
        $oldPhotoPath = $data->photo;

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           // Generate unique filename
           $filename = time().'.'.$file->getClientOriginalExtension();
           // Move new photo to public path
           $file->move(public_path('upload/admin_images'),$filename);
           // Update photo filename in database
           $data->photo = $filename;

           // Delete old photo if it exists and is different from the new one
           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
             $this->deleteOldImage($oldPhotoPath);
           }
        }
        // Save updated admin data
        $data->save();
        
        // Prepare success notification
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        
        // Redirect back with notification
        return redirect()->back()->with($notification);
    }
    
    // Deletes an old image file from the server
    private function deleteOldImage(string $oldPhotoPath): void {
        $fullPath = public_path('upload/admin_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function AdminChangePassword(){
        // Get authenticated admin's ID
        $id = Auth::guard('admin')->id();
        // Find admin data by ID
        $profileData = Admin::find($id);
        // Return view with profile data
        return view('admin.admin_change_password',compact('profileData'));
    }

    public function AdminPasswordUpdate(Request $request){
        // Get authenticated admin user
        $admin = Auth::guard('admin')->user();
        // Validate password change request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Check if old password matches current password
        if (!Hash::check($request->old_password,$admin->password)) {
            // Prepare error notification
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            // Redirect back with error notification
            return back()->with($notification);
        }
        /// Update the new password 
        // Hash and update admin's password
        Admin::whereId($admin->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Prepare success notification
        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        // Redirect back with success notification
        return back()->with($notification);
    }
}
