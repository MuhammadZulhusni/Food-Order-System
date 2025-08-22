@extends('frontend.master')
@section('content')
<style>
    .modern-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    .modern-card-img-wrap {
        position: relative;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }
    .modern-card-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .modern-card:hover .modern-card-img {
        transform: scale(1.05);
    }
    .modern-card-content {
        padding: 20px;
        position: relative;
        z-index: 1;
        background-color: #fff;
    }
    .modern-card-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .modern-card-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }
    .modern-card-rating {
        display: flex;
        align-items: center;
        margin-bottom: 16px;
    }
    .modern-card-rating-badge {
        background-color: #2ecc71;
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
    }
    .modern-card-rating-text {
        color: #6c757d;
        font-size: 0.85rem;
        margin-left: 8px;
    }
    .modern-card-offer {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        padding: 8px 12px;
        background-color: #e9f5ee;
        border-radius: 8px;
        border: 1px solid #d4e9d5; /* Subtle border */
        margin-top: 15px;
    }
    .modern-card-offer small {
        color: #555;
    }
    .modern-card-offer b {
        color: #000;
    }
    .modern-card-promoted {
        background-color: #f39c12;
        color: #fff;
        font-size: 0.8rem;
        font-weight: bold;
        padding: 6px 10px;
        border-radius: 6px;
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }
    .modern-card-wishlist {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }
    .modern-card-wishlist a {
        background-color: rgba(0, 0, 0, 0.4);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }
    .modern-card-wishlist a:hover {
        background-color: rgba(0, 0, 0, 0.6);
    }
    .modern-card-wishlist i {
        color: #fff;
    }
    .no-offers-badge {
        background-color: #ccc;
        color: #666;
    }
</style>

<section class="section pt-5 pb-5 products-section">
    <div class="container">
       <div class="section-header text-center mb-5">
          <h2 class="font-weight-bold">Popular Restaurants</h2>
          <p class="text-secondary">Discover top-rated restaurants, cafes, and eateries near you!</p>
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
                    <div class="modern-card bg-white h-100">
                       <div class="modern-card-img-wrap">
                          @if ($coupons)
                             <div class="modern-card-promoted">
                                 <span>PROMOTED</span>
                             </div>
                          @endif
                          
                          <div class="modern-card-wishlist">
                             <a aria-label="Add to Wishlist" onclick="addWishList({{$client->id}})">
                                <i class="icofont-heart"></i>
                             </a>
                          </div>
                          
                          <a href="{{ route('res.details',$client->id) }}">
                             <img src="{{ asset('upload/client_images/' . $client->photo) }}" class="modern-card-img">
                          </a>
                       </div>

                       <div class="modern-card-content">
                          <div class="list-card-body">
                             <h6 class="modern-card-title">
                                <a href="{{ route('res.details',$client->id) }}" class="text-black">{{ $client->name }}</a>
                             </h6>
                             <p class="modern-card-subtitle">{{ $menuNamesString }}</p>
                             
                             <div class="modern-card-rating">
                                <span class="modern-card-rating-badge">
                                   <i class="icofont-star"></i> {{ number_format($avarage,1) }}
                                </span>
                                <span class="modern-card-rating-text">({{ count($reviewcount) }} Reviews)</span>
                             </div>
                          </div>

                          <div class="modern-card-offer">
                             @if ($coupons)
                                <span class="badge badge-success p-2" style="background-color: #2ecc71; color: #fff; border-radius: 4px;">
                                   <i class="icofont-sale-discount"></i>
                                </span> 
                                <small>
                                    {{ $coupons->discount }}% off | Use Coupon <b>{{ $coupons->coupon_name }}</b>
                                </small>
                             @else 
                                <span class="badge badge-secondary no-offers-badge p-2" style="border-radius: 4px;">
                                   <i class="icofont-info-circle"></i>
                                </span> 
                                <small>No active offers right now.</small>
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
