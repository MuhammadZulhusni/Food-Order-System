<?php

namespace App\Http\Controllers\Client;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display all coupons for the authenticated client.
     */
    public function AllCoupon(){
        $coupon = Coupon::latest()->get();
        return view('client.backend.coupon.all_coupon', compact('coupon'));
    } 

    /**
     * Show the form for creating a new coupon.
     */
    public function AddCoupon(){
        return view('client.backend.coupon.add_coupon' );
    } 

    /**
     * Store a newly created coupon in the database.
     */
    public function StoreCoupon(Request $request){ 
       
        Coupon::create([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc, 
            'discount' => $request->discount,
            'validity' => $request->validity,
            'client_id' => Auth::guard('client')->id(),
            'created_at' => Carbon::now(),
        ]); 
         
        $notification = array(
            'message' => 'Coupon Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function EditCoupon($id){
        $coupon = Coupon::find($id);
        return view('client.backend.coupon.edit_coupon', compact('coupon'));
    }

    /**
     * Update the specified coupon in the database.
     */
    public function UpdateCoupon(Request $request){ 
        $cop_id = $request->id;

        Coupon::find($cop_id)->update([
            'coupon_name' => strtoupper($request->coupon_name),
            'coupon_desc' => $request->coupon_desc, 
            'discount' => $request->discount,
            'validity' => $request->validity, 
            'updated_at' => Carbon::now(), // Use 'updated_at' for updates
        ]); 
         
        $notification = array(
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    /**
     * Remove the specified coupon from the database.
     */
    public function DeleteCoupon($id){
        Coupon::find($id)->delete();
        $notification = array(
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}