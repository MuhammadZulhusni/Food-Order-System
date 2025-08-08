<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 

class ClientController extends Controller
{
    public function ClientLogin()
    {
        // Display the client login form
        return view('client.client_login');
    }

    public function ClientRegister()
    {
        // Display the client registration form
        return view('client.client_register');
    }

    public function ClientRegisterSubmit(Request $request){
        // Validate registration input
        $request->validate([
            'name' => ['required','string','max:200'],
            'email' => ['required','string','unique:clients']
        ]);

        // Create a new client record in the database
        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password), // Hash the password
            'role' => 'client', // Assign 'client' role
            'status' => '0', // Set initial status
        ]);

        // Prepare success notification
        $notification = array(
            'message' => 'Client Register Successfully',
            'alert-type' => 'success'
        );
        // Redirect to login page with success message
        return redirect()->route('client.login')->with($notification);
    }

    public function ClientLoginSubmit(Request $request){
        // Validate login input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the client
        $check = $request->all();
        $data = [
            'email' => $check['email'],
            'password' => $check['password'],
        ];

        if (Auth::guard('client')->attempt($data)) {
            // Redirect to dashboard on successful login
            return redirect()->route('client.dashboard')->with('success','Login Successfully');
        } else {
            // Redirect back to login with error on failure
            return redirect()->route('client.login')->with('error','Invalid Creadentials');
        }
    }

    public function ClientDashboard(){
        // Display the client dashboard
        return view('client.index');
    }

    public function ClientLogout(){
        // Logs out the authenticated client
        Auth::guard('client')->logout();
        // Redirects to the client login page with a success message
        return redirect()->route('client.login')->with('success','Logout Success');
    }

    public function ClientProfile(){
        $city = City::latest()->get();
        // Gets the ID of the authenticated client
        $id = Auth::guard('client')->id();
        // Finds the client's profile data
        $profileData = Client::find($id);
        // Returns the client profile view with the profile data
        return view('client.client_profile',compact('profileData','city'));
     }

    public function ClientProfileStore(Request $request){
        // Gets the ID of the authenticated client
        $id = Auth::guard('client')->id();
        // Finds the client's data
        $data = Client::find($id);

        // Updates the client's name, email, phone, and address
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info; 

        // Stores the old photo path for potential deletion
        $oldPhotoPath = $data->photo;

        // Checks if a new photo has been uploaded
        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           // Generates a unique filename for the new photo
           $filename = time().'.'.$file->getClientOriginalExtension();
           // Moves the new photo to the public directory
           $file->move(public_path('upload/client_images'),$filename);
           // Updates the photo filename in the database
           $data->photo = $filename;

           // Deletes the old photo if it exists and is different from the new one
           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
             $this->deleteOldImage($oldPhotoPath);
           }

        }

        if ($request->hasFile('cover_photo')) {
            $file1 = $request->file('cover_photo');
            $filename1 = time().'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('upload/client_images'),$filename1);
            $data->cover_photo = $filename1; 
         }
         
        // Saves the updated client data
        $data->save();

        // Prepares a success notification
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        // Redirects back to the previous page with the notification
        return redirect()->back()->with($notification);
    }

     private function deleteOldImage(string $oldPhotoPath): void {
        // Constructs the full path to the old image
        $fullPath = public_path('upload/client_images/'.$oldPhotoPath);
        // Checks if the file exists and deletes it
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
     }

    public function ClientChangePassword(){
        // Gets the ID of the authenticated client
        $id = Auth::guard('client')->id();
        // Finds the client's profile data
        $profileData = Client::find($id);
        // Returns the client change password view with profile data
        return view('client.client_change_password',compact('profileData'));
     }


    public function ClientPasswordUpdate(Request $request){
        // Gets the authenticated client user
        $client = Auth::guard('client')->user();
        // Validates the password change request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Checks if the old password matches the current password
        if (!Hash::check($request->old_password,$client->password)) {
            // Prepares an error notification if passwords don't match
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            // Redirects back with the error notification
            return back()->with($notification);
        }
        /// Update the new password 
        // Updates the client's password with the new hashed password
        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Prepares a success notification
        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        // Redirects back with the success notification
        return back()->with($notification);
     }
}