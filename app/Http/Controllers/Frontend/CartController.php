<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use App\Models\Product;
use Illuminate\Support\Facades\Session; 
use App\Models\Coupon;

class CartController extends Controller
{
    /**
     * Add a product to the shopping cart stored in the session.
     *
     * @param int $id The ID of the product to add.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AddToCart($id){

        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        $products = Product::find($id);

        // Retrieve the current cart from the session, or an empty array if it doesn't exist.
        $cart = session()->get('cart',[]);

        // Check if the product already exists in the cart.
        if (isset($cart[$id])) {
           // If it exists, increment the quantity.
           $cart[$id]['quantity']++;
        } else {
           // If it's a new product, add it to the cart with a quantity of 1.
           $priceToShow = isset($products->discount_price) ? $products->discount_price : $products->price;
           $cart[$id] = [
            'id' => $id,
            'name' => $products->name,
            'image' => $products->image,
            'price' => $priceToShow,
            'client_id' => $products->client_id,
            'quantity' => 1
           ];
        }

        // Store the updated cart back in the session.
        session()->put('cart',$cart);

        $notification = array(
            'message' => 'Add to Cart Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Update the quantity of a product in the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCartQuanity(Request $request){
        // Retrieve the current cart from the session.
        $cart = session()->get('cart',[]);

        // Check if the product exists and update its quantity.
        if (isset($cart[$request->id])) {
           $cart[$request->id]['quantity'] = $request->quantity;
           session()->put('cart',$cart);
        }

        // Return a JSON response to confirm the update.
        return response()->json([
            'message' => 'Quantity Updated',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove a product from the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function CartRemove(Request $request){
        // Retrieve the current cart from the session.
        $cart = session()->get('cart',[]);

        // Check if the product exists and remove it from the cart.
        if (isset($cart[$request->id])) {
           unset($cart[$request->id]);
           session()->put('cart',$cart);
        }

        // Return a JSON response to confirm the removal.
        return response()->json([
            'message' => 'Cart Remove Successfully',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Applies a coupon to the user's cart.
     *
     * This function validates a coupon, ensures it's valid for the products in the cart,
     * and then stores the coupon details in the session. It handles various error
     * conditions such as invalid coupons or coupons not applicable to the cart's items.
     *
     * @param Request $request The incoming HTTP request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function ApplyCoupon(Request $request){
        // 1. Validate the coupon
        $coupon = Coupon::where('coupon_name',$request->coupon_name)->where('validity','>=',Carbon::now()->format('Y-m-d'))->first();

        // 2. Get cart data and initialize variables
        $cart = session()->get('cart',[]);
        $totalAmount = 0;
        $clientIds = [];

        // 3. Loop through cart items to calculate total and get client IDs
        foreach($cart as $car){
            $totalAmount += ($car['price'] * $car['quantity']);
            $pd = Product::find($car['id']);
            $cdid = $pd->client_id;
            array_push($clientIds,$cdid);
        }

        // 4. Check if a valid coupon was found
        if ($coupon) {
        // 5. Check if all products in the cart are from a single client/restaurant
        if (count(array_unique($clientIds)) === 1) {
            $cvendorId = $coupon->client_id;

            // 6. Check if the coupon's client ID matches the cart's client ID
            if ($cvendorId == $clientIds[0]) {
                // 7. Store valid coupon details in the session
                Session::put('coupon',[
                    'coupon_name' => $coupon->coupon_name,
                    'discount' => $coupon->discount,
                    'discount_amount' => $totalAmount - ($totalAmount * $coupon->discount/100),
                ]);
                $couponData = Session()->get('coupon');

                // 8. Return a success response
                return response()->json(array(
                    'validity' => true,
                    'success' => 'Coupon Applied Successfully',
                    'couponData' => $couponData,
                ));
            }else{
                // 9. Return an error for a mismatch between coupon and restaurant
                return response()->json(['error' => 'This Coupon Not Valid for this Restrurant']);
            } 

        }else{
            // 10. Return an error if the cart contains products from multiple restaurants
            return response()->json(['error' => 'This Coupon for one of the selected Restrurant']);
        }
        }else {
            // 11. Return an error for an invalid coupon
            return response()->json(['error' => 'Invalid Coupon']);
        }
    }

    /**
     * Removes the active coupon from the user's session.
     *
     * This function simply clears the 'coupon' data from the session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function CouponRemove(){
        // 12. Remove the coupon from the session
        Session::forget('coupon');
        
        // 13. Return a success response
        return response()->json(['success' => 'Coupon Remove Successfully']);
    }

    /**
     * Redirects the user to the checkout page if they are authenticated and their cart is not empty.
     * Otherwise, it handles redirection and displays appropriate notifications.
     */
    public function ShopCheckout(){
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve cart items from the session
            $cart = session()->get('cart',[]);
            $totalAmount = 0;
            
            // Calculate the total amount of items in the cart
            foreach ($cart as $car) {
                $totalAmount += $car['price'];
            }

            // If the total amount is greater than zero, proceed to the checkout view
            if ($totalAmount > 0) {
            return view('frontend.checkout.view_checkout', compact('cart'));
            } else {
                // If the cart is empty, redirect to the homepage with an error notification
                $notification = array(
                    'message' => 'Shop at least one item',
                    'alert-type' => 'error'
                ); 
                return redirect()->to('/')->with($notification);
            } 
            
        } else {
            // If the user is not authenticated, redirect them to the login page with a notification
            $notification = array(
                'message' => 'Please Login First',
                'alert-type' => 'success'
            );

            return redirect()->route('login')->with($notification); 
        } 
    }
}