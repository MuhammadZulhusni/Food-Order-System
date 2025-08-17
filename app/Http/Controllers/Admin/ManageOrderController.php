<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}