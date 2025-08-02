<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the frontend index page.
     */
    public function Index()
    {
        return view('frontend.index');
    }

    /**
     * Store or update the user's profile information.
     */
    public function ProfileStore(Request $request){
        // Get the ID of the authenticated user
        $id = Auth::user()->id;
        // Find the user by their ID
        $data = User::find($id);

        // Update user's name, email, phone, and address
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 

        // Store the path of the existing photo for potential deletion
        $oldPhotoPath = $data->photo;

        // Check if a new photo has been uploaded
        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           // Generate a unique filename based on current time and original extension
           $filename = time().'.'.$file->getClientOriginalExtension();
           // Move the uploaded file to the public 'upload/user_images' directory
           $file->move(public_path('upload/user_images'),$filename);
           // Update the user's photo attribute with the new filename
           $data->photo = $filename;

           // If an old photo existed and is different from the new one, delete it
           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
             $this->deleteOldImage($oldPhotoPath);
           }
        }
        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
    
    /**
     * Delete an old user profile image from the server.
     */
    private function deleteOldImage(string $oldPhotoPath): void {
        // Construct the full path to the old image file
        $fullPath = public_path('upload/user_images/'.$oldPhotoPath);
        // Check if the file exists and delete it
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Log out the authenticated user.
     */
    public function UserLogout(){
        // Log out the user from the 'web' guard
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('success','Logout Successfully');
    }
}