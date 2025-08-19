<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Client;
use App\Models\Gllery;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 


class HomeController extends Controller
{
    /**
     * Display the details of a specific restaurant.
     *
     * @param  int  $id The ID of the client (restaurant).
     * @return \Illuminate\View\View
     */
    public function RestaurantDetails($id){
        // Find the client (restaurant) by its ID.
        $client = Client::find($id);

        // Get all menus for the client that contain at least one product.
        $menus = Menu::where('client_id', $client->id)->get()->filter(function($menu){
            return $menu->products->isNotEmpty();
        });
        
        // Get all gallery images associated with the client.
        $gallerys = Gllery::where('client_id', $id)->get();
        
        // Get all reviews for the client.
        $reviews = Review::where('client_id',$client->id)->where('status',1)->get();
        
        // Calculate total reviews, average rating, and rating counts.
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $totalReviews > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);
        
        // Count the number of reviews for each rating level (1-5).
        $ratingCounts = [
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count(),
        ];
        
        // Calculate the percentage of reviews for each rating level.
        $ratingPercentages = array_map(function ($count) use ($totalReviews){
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);

        // Return the view with all the prepared data.
        return view('frontend.details_page', compact('client', 'menus', 'gallerys', 'reviews', 'roundedAverageRating', 'totalReviews', 'ratingCounts', 'ratingPercentages'));
    }

    /**
     * Add a restaurant to the user's wishlist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  The ID of the client (restaurant) to be added.
     * @return \Illuminate\Http\JsonResponse
     */
    public function AddWishList(Request $request, $id){
        // Check if a user is currently authenticated
        if (Auth::check()) {
            // Check if the restaurant is already in the user's wishlist
            $exists = Wishlist::where('user_id', Auth::id())->where('client_id', $id)->first();
            
            // If the item doesn't exist in the wishlist, add it
            if (!$exists) {
                Wishlist::insert([
                    'user_id' => Auth::id(),
                    'client_id' => $id,
                    'created_at' => Carbon::now(),
                ]);
                // Return a JSON success response
                return response()->json(['success' => 'Your Wishlist Added Successfully']);
            } else {
                // Return a JSON error response if the item already exists
                return response()->json(['error' => 'This product is already on your wishlist']);
            }
        } else {
            return response()->json(['error' => 'First Login to Your Account']);
        }
    }

    /**
     * Display all wishlist items for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function AllWishlist(){
        // Fetch all wishlist items where the user_id matches the authenticated user's ID
        $wishlist = Wishlist::where('user_id',Auth::id())->get();
        return view('frontend.dashboard.all_wishlist',compact('wishlist'));
    }

    /**
     * Remove a specific item from the user's wishlist.
     *
     * @param  int  $id  The ID of the wishlist item to be removed.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function RemoveWishlist($id){
        // Find and delete the wishlist item by its ID
        Wishlist::find($id)->delete();

        $notification = array(
            'message' => 'Wishlist Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


}