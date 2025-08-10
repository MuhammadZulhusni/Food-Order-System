<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Menu;
use App\Models\Gllery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 


class HomeController extends Controller
{
    /**
     * Display the details of a specific restaurant.
     *
     * @param  int  $id  The ID of the client (restaurant).
     * @return \Illuminate\View\View
     */
    public function RestaurantDetails($id){
     // Find the client (restaurant) by its ID
     $client = Client::find($id);

     // Get all menus for the client that contain at least one product
     $menus = Menu::where('client_id',$client->id)->get()->filter(function($menu){
        return $menu->products->isNotEmpty();
     });
     
     // Get all gallery images associated with the client
     $gallerys = Gllery::where('client_id',$id)->get();
     
     // Return the 'details_page' view, passing the client, menus, and gallerys data
     return view('frontend.details_page',compact('client','menus','gallerys'));
    }
}