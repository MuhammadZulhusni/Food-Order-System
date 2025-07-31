<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Client;

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
        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success','Logout Success');
    }
}