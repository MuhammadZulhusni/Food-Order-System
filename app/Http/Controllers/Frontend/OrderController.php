<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Admin;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Notifications\OrderComplete;
use Illuminate\Support\Facades\Notification; 

class OrderController extends Controller
{
    /**
     * Handles the cash on delivery order process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function CashOrder(Request $request)
    {
        // Fetch all admins to send a notification to each
        $admins = Admin::where('role', 'admin')->get();

        // Validate incoming request data
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        // Retrieve and calculate cart total
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        foreach ($cart as $car) {
            $totalAmount += ($car['price'] * $car['quantity']);
        }

        // Apply coupon discount if it exists in the session
        if (Session::has('coupon')) {
            $tt = Session::get('coupon')['discount_amount'];
        } else {
            $tt = $totalAmount;
        }

        // Create a new order and get its ID
        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_type' => 'Cash On Delivery',
            'payment_method' => 'Cash On Delivery',
            'currency' => 'USD',
            'amount' => $totalAmount,
            'total_amount' => $tt,
            'invoice_no' => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending',
            'created_at' => Carbon::now(),
        ]);

        // Insert each cart item into the order_items table
        $carts = session()->get('cart', []);
        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart['id'],
                'client_id' => $cart['client_id'],
                'qty' => $cart['quantity'],
                'price' => $cart['price'],
                'created_at' => Carbon::now(),
            ]);
        }

        // Clear the coupon and cart from the session after successful order
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('cart')) {
            Session::forget('cart');
        }

        // Send a notification to each admin
        foreach ($admins as $admin) {
            $admin->notify(new OrderComplete($request->name));
        }

        $notification = [
            'message' => 'Order Placed Successfully',
            'alert-type' => 'success'
        ];

        return view('frontend.checkout.thanks')->with($notification);
    }

    /**
     * Handles the Stripe payment process and saves the order to the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function StripeOrder(Request $request)
    {
        // Validate user input for required fields.
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        // Calculate the total amount from the cart session.
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        foreach ($cart as $car) {
            $totalAmount += ($car['price'] * $car['quantity']);
        }

        // Determine the final amount after applying any coupon.
        if (Session()->has('coupon')) {
            $tt = (Session()->get('coupon')['discount_amount']);
        } else {
            $tt = $totalAmount;
        }

        // Set the Stripe API key.
        \Stripe\Stripe::setApiKey('sk_test_51Oml5cGAwoXiNtjJZbPFBKav0pyrR8GSwzUaLHLhInsyeCa4HI8kKf2IcNeUXc8jc8XVzBJyqjKnDLX9MlRjohrL003UDGPZgQ');

        // Use the token from the form to create a charge on Stripe.
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => $totalAmount * 100, // Amount in cents
            'currency' => 'usd',
            'description' => 'EasyFood Delivery',
            'source' => $token,
            'metadata' => ['order_id' => '6735'] // Example metadata
        ]);

        // Insert a new order record into the database.
        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_type' => $charge->payment_method,
            'payment_method' => 'Stripe',
            'currency' => $charge->currency,
            'transaction_id' => $charge->balance_transaction,
            'amount' => $totalAmount,
            'total_amount' => $tt,
            'order_number' => $charge->metadata->order_id,
            'invoice_no' => 'easyshop' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending',
            'created_at' => Carbon::now(),
        ]);

        // Insert each item from the cart into the order_items table.
        $carts = session()->get('cart', []);
        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart['id'],
                'client_id' => $cart['client_id'],
                'qty' => $cart['quantity'],
                'price' => $cart['price'],
                'created_at' => Carbon::now(),
            ]);
        }

        // Clear the coupon and cart sessions.
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('cart')) {
            Session::forget('cart');
        }

        // Prepare a success notification and redirect to the thank you page.
        $notification = [
            'message' => 'Order Placed Successfully',
            'alert-type' => 'success'
        ];

        return view('frontend.checkout.thanks')->with($notification);
    }

    public function MarkAsRead(Request $request, $notificationId){
        $user = Auth::guard('admin')->user();
        $notification = $user->notifications()->where('id',$notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
        }
        return response()->json(['count' => $user->unreadNotifications()->count()]);
    }
}
