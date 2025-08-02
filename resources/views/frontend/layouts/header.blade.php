<nav class="navbar navbar-expand-lg navbar-dark osahan-nav">
    <div class="container">
        {{-- Brand Logo and Home Link --}}
        <a class="navbar-brand" href="{{ route('index') }}"><img alt="logo" src="{{ asset('frontend/img/logo.png') }}"></a>
        {{-- Navbar Toggler for mobile --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- Navbar Collapse Content --}}
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                {{-- Home Navigation Item --}}
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                </li>
                {{-- Offers Navigation Item --}}
                <li class="nav-item">
                    <a class="nav-link" href="offers.html"><i class="icofont-sale-discount"></i> Offers <span class="badge badge-warning">New</span></a>
                </li>
                {{-- Restaurants Navigation Item (placeholder for future dropdown) --}}
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Restaurants
                    </a>
                </li>

                {{-- Conditional rendering based on user authentication --}}
                @auth
                    {{-- Retrieve authenticated user's profile data --}}
                    @php
                        $id = Auth::user()->id;
                        $profileData = App\Models\User::find($id);
                    @endphp 
                    {{-- My Account Dropdown for authenticated users --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{-- Display user's profile picture or a default image --}}
                            <img alt="Generic placeholder image" src="{{ (!empty($profileData->photo)) ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}" class="nav-osahan-pic rounded-pill"> My Account
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                            {{-- Link to user dashboard --}}
                            <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="icofont-food-cart"></i> Dashboard</a>
                            {{-- Link to logout --}}
                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i class="icofont-sale-discount"></i> Logout </a>
                        </div>
                    </li>
                @else
                    {{-- Login Link for unauthenticated users --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('login') }}" role="button" aria-haspopup="true" aria-expanded="false">
                            Login
                        </a> 
                    </li>
                    {{-- Register Link for unauthenticated users --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('register') }}" role="button" aria-haspopup="true" aria-expanded="false">
                            Register
                        </a> 
                    </li>
                @endauth

                {{-- Cart Dropdown --}}
                <li class="nav-item dropdown dropdown-cart">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-basket"></i> Cart
                        <span class="badge badge-success">5</span> {{-- Displays the number of items in the cart --}}
                    </a>
                    <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-sm border-0">
                        {{-- Cart Header --}}
                        <div class="dropdown-cart-top-header p-4">
                            <img class="img-fluid mr-3" alt="osahan" src="img/cart.jpg">
                            <h6 class="mb-0">Gus's World Famous Chicken</h6>
                            <p class="text-secondary mb-0">310 S Front St, Memphis, USA</p>
                            <small><a class="text-primary font-weight-bold" href="#">View Full Menu</a></small>
                        </div>
                        {{-- Cart Items --}}
                        <div class="dropdown-cart-top-body border-top p-4">
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1 <span class="float-right text-secondary">$314</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Corn & Peas Salad x 1 <span class="float-right text-secondary">$209</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-success food-item"></i> Veg Seekh Sub 6" (15 cm) x 1 <span class="float-right text-secondary">$133</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Chicken Tikka Sub 12" (30 cm) x 1 <span class="float-right text-secondary">$314</span></p>
                            <p class="mb-2"><i class="icofont-ui-press text-danger food-item"></i> Corn & Peas Salad x 1 <span class="float-right text-secondary">$209</span></p>
                        </div>
                        {{-- Cart Footer with Subtotal --}}
                        <div class="dropdown-cart-top-footer border-top p-4">
                            <p class="mb-0 font-weight-bold text-secondary">Sub Total <span class="float-right text-dark">$499</span></p>
                            <small class="text-info">Extra charges may apply</small>  
                        </div>
                        {{-- Checkout Button --}}
                        <div class="dropdown-cart-top-footer border-top p-2">
                            <a class="btn btn-success btn-block btn-lg" href="checkout.html"> Checkout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>