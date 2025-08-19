<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\Product; 
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    /**
     * Stores a new review submitted by a user.
     *
     * @param \Illuminate\Http\Request $request The request object containing review data.
     */
    public function StoreReview(Request $request){
        // Get the ID of the client being reviewed.
        $client = $request->client_id;

        // Validate that a comment is present.
        $request->validate([
            'comment' => 'required'
        ]);

        // Create a new review record in the database.
        Review::insert([
            'client_id' => $client,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => Carbon::now(), 
        ]);

        // Prepare a success notification.
        $notification = array(
            'message' => 'Review Will Approlve By Admin',
            'alert-type' => 'success'
        );

        // Redirect the user back to the previous page's review section with a success message.
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' : route('res.details', ['id' => $client]) . '#pills-reviews';
        return redirect()->to($redirectUrl)->with($notification);
    }
}