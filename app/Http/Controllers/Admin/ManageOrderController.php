<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageOrderController extends Controller
{
    /**
     * Display a list of all pending orders.
     */
    public function PendingOrder(){
        $allData = Order::where('status','Pending')->orderBy('id','desc')->get();
        return view('admin.backend.order.pending_order',compact('allData'));
    }

    /**
     * Display a list of all confirmed orders.
     */
    public function ConfirmOrder(){
        $allData = Order::where('status','confirm')->orderBy('id','desc')->get();
        return view('admin.backend.order.confirm_order',compact('allData'));
    }

    /**
     * Display a list of all processing orders.
     */
    public function ProcessingOrder(){
        $allData = Order::where('status','processing')->orderBy('id','desc')->get();
        return view('admin.backend.order.processing_order',compact('allData'));
    }

    /**
     * Display a list of all delivered orders.
     */
    public function DeliverdOrder(){
        $allData = Order::where('status','deliverd')->orderBy('id','desc')->get();
        return view('admin.backend.order.delivered_order',compact('allData'));
    }

    /**
     * Display the details of a specific order.
     */
    public function AdminOrderDetails($id){
        $order = Order::with('user')->where('id',$id)->first();
        $orderItem = OrderItem::with('product')->where('order_id',$id)->orderBy('id','desc')->get();

        $totalPrice = 0;
        foreach($orderItem as $item){
            $totalPrice += $item->price * $item->qty;
        }

        return view('admin.backend.order.admin_order_details',compact('order','orderItem','totalPrice'));
    } 

    /**
     * Update an order's status from 'Pending' to 'Confirm'.
     */
    public function PendingToConfirm($id){
        Order::find($id)->update(['status' => 'confirm']);
        $notification = array(
            'message' => 'Order Confirm Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('confirm.order')->with($notification);
    }

    /**
     * Update an order's status from 'Confirm' to 'Processing'.
     */
    public function ConfirmToProcessing($id){
        Order::find($id)->update(['status' => 'processing']);
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('processing.order')->with($notification);
    }

    /**
     * Update an order's status from 'Processing' to 'Delivered'.
     */
    public function ProcessingToDiliverd($id){
        Order::find($id)->update(['status' => 'deliverd']);
        $notification = array(
            'message' => 'Order Processing Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('deliverd.order')->with($notification);
    }

    /**
     * Displays all orders for the authenticated client.
     *
     * This function retrieves all order items associated with the logged-in client,
     * groups them by their order ID, and passes the grouped data to the view.
     */
    public function AllClientOrders(){
        // Get the authenticated client's ID.
        $clientId = Auth::guard('client')->id();

        // Retrieve order items, group them by order ID, and sort by descending order ID.
        $orderItemGroupData = OrderItem::with(['product','order'])
            ->where('client_id',$clientId)
            ->orderBy('order_id','desc')
            ->get()
            ->groupBy('order_id');
            
        return view('client.backend.order.all_orders',compact('orderItemGroupData'));
    }


    /**
     * Displays the details of a specific order for the client.
     *
     * This function retrieves the main order details and all associated order items
     * for a given order ID, calculates the total price, and passes the data to the view.
     */
    public function ClientOrderDetails($id){
        // Retrieve the order details along with the user information.
        $order = Order::with('user')->where('id',$id)->first();
        
        // Retrieve all order items for the given order ID.
        $orderItem = OrderItem::with('product')->where('order_id',$id)->orderBy('id','desc')->get();

        // Calculate the total price of all items in the order.
        $totalPrice = 0;
        foreach($orderItem as $item){
            $totalPrice += $item->price * $item->qty;
        }

        return view('client.backend.order.client_order_details',compact('order','orderItem','totalPrice'));
    }

    /**
     * Displays a list of all orders for the authenticated user.
     *
     * This function retrieves all orders associated with the logged-in user,
     * sorts them by ID in descending order, and passes the data to the view.
     */
    public function UserOrderList(){
        // Get the ID of the currently authenticated user.
        $userId = Auth::user()->id;
        
        // Retrieve all orders for the user, ordered by most recent.
        $allUserOrder = Order::where('user_id',$userId)->orderBy('id','desc')->get();
        
        return view('frontend.dashboard.order.order_list',compact('allUserOrder'));
    }

    /**
     * Displays the details of a specific order for the user.
     *
     * This function retrieves the main order details and all associated order items
     * for a given order ID, ensuring the order belongs to the authenticated user.
     * It also calculates the total price and passes the data to the view.
     */
    public function UserOrderDetails($id){
        // Retrieve the specific order, including user details, and ensure it belongs to the logged-in user.
        $order = Order::with('user')->where('id',$id)->where('user_id',Auth::id())->first();
        
        // Retrieve all items for the specific order.
        $orderItem = OrderItem::with('product')->where('order_id',$id)->orderBy('id','desc')->get();

        // Calculate the total price of all items in the order.
        $totalPrice = 0;
        foreach($orderItem as $item){
            $totalPrice += $item->price * $item->qty;
        }

        return view('frontend.dashboard.order.order_details',compact('order','orderItem','totalPrice'));
    }
}