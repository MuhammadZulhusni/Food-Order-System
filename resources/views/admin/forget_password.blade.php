<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Super Admin Forget Password | Your System Name</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Super Admin Password Reset for the Your System Name platform." name="description" />
        <meta content="Your Name" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('super-admin.png') }}">

        <!-- preloader css -->
        <link rel="stylesheet" href="{{ asset('backend/assets/css/preloader.min.css') }}" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

    <!-- Main Content Wrapper -->
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left Column: Password Reset Form -->
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex align-items-center p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <!-- Logo and Title -->
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="{{ route('admin.login') }}" class="d-block auth-logo">
                                    <img src="{{ asset('super-admin.png') }}" alt="" height="40">
                                </a>
                            </div>
                            
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Super Admin Password Reset</h5>
                                    <p class="text-muted mt-2">Enter your email to receive a password reset link.</p>
                                </div>

                                <!-- Error and success messages -->
                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (Session::has('error'))
                                    <div class="alert alert-danger mt-3">
                                        <ul class="mb-0">
                                            <li>{{ Session::get('error') }}</li>
                                        </ul>
                                    </div>
                                @endif
                                @if (Session::has('success'))
                                    <div class="alert alert-success mt-3">
                                        <ul class="mb-0">
                                            <li>{{ Session::get('success') }}</li>
                                        </ul>
                                    </div>
                                @endif  

                                <!-- Password Reset Form -->
                                <form class="mt-4 pt-2" action="{{ route('admin.password_submit') }}"  method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required>
                                    </div> 
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Send Reset Link</button>
                                    </div>
                                </form>
                                
                                <!-- Link to go back to login -->
                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">Remember your password? <a href="{{ route('admin.login') }}" class="text-primary fw-semibold">Log In</a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: System Overview Carousel -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <!-- Carousel Item 1: Security Tip -->
                                        <div class="carousel-item active">
                                            <div class="testi-contain text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“A strong password is your first line of defense. After resetting, choose a unique password that combines letters, numbers, and symbols.”
                                                </h4>
                                                <div class="mt-4 pt-3 pb-5">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="mdi mdi-lock-open-outline avatar-md img-fluid rounded-circle" style="font-size: 3rem;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3 mb-4">
                                                            <h5 class="font-size-18 text-white">Secure Your Account</h5>
                                                            <p class="mb-0 text-white-50">Choose a Strong Password</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Carousel Item 2: Email Check Tip -->
                                        <div class="carousel-item">
                                            <div class="testi-contain text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“If you don’t receive the password reset email in your inbox, please check your spam or junk folder. The link will expire after a short period.”</h4>
                                                <div class="mt-4 pt-3 pb-5">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0">
                                                            <i class="mdi mdi-email-check-outline avatar-md img-fluid rounded-circle" style="font-size: 3rem;"></i>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3 mb-4">
                                                            <h5 class="font-size-18 text-white">Check Your Email</h5>
                                                            <p class="mb-0 text-white-50">Look in Junk/Spam</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Carousel Item 3: Support Tip -->
                                        <div class="carousel-item">
                                            <div class="testi-contain text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“If you continue to experience issues or cannot reset your password, please contact system support for assistance. Do not share your credentials with anyone.”</h4>
                                                <div class="mt-4 pt-3 pb-5">
                                                    <div class="d-flex align-items-start">
                                                        <img src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}" class="avatar-md img-fluid rounded-circle" alt="...">
                                                        <div class="flex-1 ms-3 mb-4">
                                                            <h5 class="font-size-18 text-white">Contact Support</h5>
                                                            <p class="mb-0 text-white-50">Super Admin Help</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('backend/assets/libs/pace-js/pace.min.js') }}"></script>
        <!-- password addon init -->
        <script src="{{ asset('backend/assets/js/pages/pass-addon.init.js') }}"></script>

    </body>

</html>
