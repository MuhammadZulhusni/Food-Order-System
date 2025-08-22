@extends('client.client_dashboard')

@section('client')

@php
    $id = Auth::guard('client')->id();
    $client = App\Models\Client::find($id);
    $status = $client->status;
@endphp


<div class="page-content">
    <div class="container-fluid">

        @if ($status === '1')
            <h4>Restaurant Account is <span class="text-success">Active</span> </h4>
            @else   
            <h4>Restaurant Account is <span class="text-danger">InActive</span> </h4> 
            <p class="text-danger"><b>Please wait for an admin to approve your account.</b> </p> 
        @endif
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Orders</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="1258">0</span>
                                </h4>
                            </div>

                            <div class="col-6">
                                <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+15%</span>
                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Revenue</span>
                                <h4 class="mb-3">
                                    $<span class="counter-value" data-target="86520">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+$10.5k</span>
                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col-->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">New Customers</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="432">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+35%</span>
                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->

            <div class="col-xl-3 col-md-6">
                <!-- card -->
                <div class="card card-h-100">
                    <!-- card body -->
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Average Order Value</span>
                                <h4 class="mb-3">
                                    $<span class="counter-value" data-target="68.50">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-danger-subtle text-danger">-5%</span>
                            <span class="ms-1 text-muted font-size-13">Since last month</span>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->    
        </div><!-- end row-->

        <div class="row">
            <!-- end col -->
            <div class="col-xl-7">
                <div class="row">
                    <div class="col-xl-8">
                        <!-- card -->
                        <div class="card card-h-100">
                            <!-- card body -->
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <h5 class="card-title me-2">Monthly Sales Overview</h5>
                                    <div class="ms-auto">
                                        <select class="form-select form-select-sm">
                                            <option value="JUL" selected="">July</option>
                                            <option value="JUN">June</option>
                                            <option value="MAY">May</option>
                                            <option value="AP">April</option>
                                            <option value="MA">March</option>
                                            <option value="FE">February</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <div id="monthly-sales-chart" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                    </div>
                                    <div class="col-sm align-self-center">
                                        <div class="mt-4 mt-sm-0">
                                            <p class="mb-1">Total Sales</p>
                                            <h4>$ 15,250.39</h4>

                                            <p class="text-muted mb-4"> + 5.2% from last month <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>

                                            <div class="row g-0">
                                                <div class="col-6">
                                                    <div>
                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Online Orders</p>
                                                        <h5 class="fw-medium">950</h5>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div>
                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Dine-in Orders</p>
                                                        <h5 class="fw-medium">308</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <a href="#" class="btn btn-primary btn-sm">View full report <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4">
                        <!-- card -->
                        <div class="card bg-primary text-white shadow-primary card-h-100">
                            <!-- card body -->
                            <div class="card-body p-0">
                                <div id="carouselExampleCaptions" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">                                                   
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-chef-hat widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-silverware-fork-knife"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white">Menu<b> Tips</b></h4>
                                                <p class="text-white-50 font-size-13">Update your menu regularly to keep it fresh and exciting for your customers. Add seasonal specials to attract new diners.</p>
                                                <button type="button" class="btn btn-light btn-sm">Manage Menu <i class="mdi mdi-arrow-right ms-1"></i></button>
                                            </div>
                                        </div>
                                        <!-- end carousel-item -->
                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-star-circle widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-chart-line"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white">Business <b>Insights</b></h4>
                                                <p class="text-white-50 font-size-13">Analyze your sales reports to identify your most popular dishes and peak hours. Use this data to optimize your staff and inventory.</p>
                                                <button type="button" class="btn btn-light btn-sm">View Reports <i class="mdi mdi-arrow-right ms-1"></i></button>
                                            </div>
                                        </div>
                                        <!-- end carousel-item -->
                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-account-group widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-account-heart"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white">Customer<b> Reviews</b></h4>
                                                <p class="text-white-50 font-size-13">Engage with your customers by responding to their reviews. Positive feedback can be leveraged for marketing, and negative feedback helps you improve.</p>
                                                <button type="button" class="btn btn-light btn-sm">Manage Reviews <i class="mdi mdi-arrow-right ms-1"></i></button>
                                            </div>
                                        </div>
                                        <!-- end carousel-item -->
                                    </div>
                                    <!-- end carousel-inner -->
                                    
                                    <div class="carousel-indicators carousel-indicators-rounded">
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <!-- end carousel-indicators -->
                                </div>
                                <!-- end carousel -->
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->
        </div> <!-- end row-->
    </div>
    <!-- container-fluid -->
</div>
@endsection
