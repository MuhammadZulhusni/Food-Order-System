<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use App\Models\Product;
use Illuminate\Support\Facades\Session; 

class CartController extends Controller
{
    /**
     * Add a product to the shopping cart stored in the session.
     *
     * @param int $id The ID of the product to add.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AddToCart($id){

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
}