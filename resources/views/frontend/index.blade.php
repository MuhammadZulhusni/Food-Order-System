@extends('frontend.master')
@section('content')
<section class="section pt-5 pb-5 products-section">
    <div class="container">
       <div class="section-header text-center">
          <h2>Popular Restaurants</h2>
          <p>Discover top-rated restaurants, cafes, and eateries near you!</p>
          <span class="line"></span>
       </div>
       <div class="row">

   @php
      // Retrieve all active clients (restaurants)
      $clients = App\Models\Client::latest()->where('status','1')->get();
   @endphp      

 @foreach ($clients as $client) 

  @php
     // Get a maximum of 3 products for the current client
     $products = App\Models\Product::where('client_id',$client->id)->limit(3)->get();
     // Extract menu names from the products and join them into a string
     $menuNames = $products->map(function($product){
      return $product->menu->menu_name;
     })->toArray();
     $menuNamesString = implode(' . ',$menuNames);
     // Check for an active coupon for the current client
     $coupons = App\Models\Coupon::where('client_id',$client->id)->where('status','1')->first();
  @endphp

     @php
        // Count total approved reviews and calculate average rating
        $reviewcount = App\Models\Review::where('client_id',$client->id)->where('status',1)->latest()->get();
        $avarage = App\Models\Review::where('client_id',$client->id)->where('status',1)->avg('rating');
     @endphp

   <div class="col-md-4 mb-4">  
         <div class="list-card bg-white rounded overflow-hidden position-relative shadow-sm h-100">
            <!-- Restaurant Image and Overlays -->
            <div class="list-card-image position-relative">
               <!-- Promoted Badge -->
               @if ($coupons)
                  <div class="member-plan position-absolute p-2" style="background-color: #f7a522; color: #fff; top: 10px; left: 10px; border-radius: 5px;">
                      <span class="font-weight-bold">PROMOTED</span>
                  </div>
               @endif
               
               <!-- Wishlist Heart -->
               <div class="favourite-heart text-danger position-absolute" style="top: 10px; right: 10px;">
                  <a aria-label="Add to Wishlist" onclick="addWishList({{$client->id}})" style="color: #fff; background-color: rgba(0,0,0,0.5); padding: 8px; border-radius: 50%;">
                     <i class="icofont-heart"></i>
                  </a>
               </div>
               
               <a href="{{ route('res.details',$client->id) }}">
                  <img src="{{ asset('upload/client_images/' . $client->photo) }}" class="img-fluid item-img" style="width: 100%; height:200px; object-fit: cover;">
               </a>
            </div>

            <!-- Restaurant Details Section -->
            <div class="p-3 position-relative">
               <div class="list-card-body">
                  <h6 class="mb-1">
                     <a href="{{ route('res.details',$client->id) }}" class="text-black">{{ $client->name }}</a>
                  </h6>
                  <p class="text-gray mb-2" style="font-size: 0.9rem;">{{ $menuNamesString }}</p>
                  
                  <!-- Rating and Review Count -->
                  <div class="d-flex align-items-center mb-2">
                     <span class="badge badge-success p-2" style="background-color: #28a745; color: #fff;">
                        <i class="icofont-star"></i> {{ number_format($avarage,1) }}
                     </span>
                     <span class="text-gray ml-2" style="font-size: 0.8rem;">({{ count($reviewcount) }} Reviews)</span>
                  </div>
               </div>

               <!-- Offer/Coupon Banner -->
               <div class="list-card-badge mt-2">
                  @if ($coupons)
                     <span class="badge badge-success p-2" style="background-color: #28a745; color: #fff;">
                        <i class="icofont-sale-discount"></i> OFFER
                     </span> 
                     <small style="color: #888;">{{ $coupons->discount }}% off | Use Coupon <b style="color: #000;">{{ $coupons->coupon_name }}</b></small>
                  @else 
                     <span class="badge badge-secondary p-2" style="background-color: #6c757d; color: #fff;">
                        NO OFFERS
                     </span> 
                     <small style="color: #888;">No active coupons right now.</small>
                  @endif
               </div>
            </div>
         </div>  
   </div> 
   @endforeach
   {{-- // end col md-4 --}}
       </div>
    </div>
 </section>

 @endsection
