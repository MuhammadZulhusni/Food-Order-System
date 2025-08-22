@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Revenue</span>
                                <h4 class="mb-3">
                                    $<span class="counter-value" data-target="865.2">0</span>k
                                </h4>
                            </div>

                            <div class="col-6">
                                <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+{{-- $20.9k --}}</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div></div></div><div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Orders</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="6258">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-danger-subtle text-danger">-{{-- 29 --}} Orders</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div></div></div><div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Restaurants</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="150">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+{{-- 10 --}}</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div></div></div><div class="col-xl-3 col-md-6">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Clients</span>
                                <h4 class="mb-3">
                                    <span class="counter-value" data-target="2500">0</span>
                                </h4>
                            </div>
                            <div class="col-6">
                                <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                            </div>
                        </div>
                        <div class="text-nowrap">
                            <span class="badge bg-success-subtle text-success">+{{-- 50 --}}</span>
                            <span class="ms-1 text-muted font-size-13">Since last week</span>
                        </div>
                    </div></div></div></div><div class="row">
            <div class="col-xl-5">
                <div class="card card-h-100">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center mb-4">
                            <h5 class="card-title me-2">Order Status Breakdown</h5>
                            <div class="ms-auto">
                                <div>
                                    <button type="button" class="btn btn-soft-primary btn-sm">
                                        Today
                                    </button>
                                    <button type="button" class="btn btn-soft-secondary btn-sm">
                                        This Month
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-sm">
                                <div id="wallet-balance" data-colors='["#777aca", "#5156be", "#a8aada"]' class="apex-charts"></div>
                            </div>
                            <div class="col-sm align-self-center">
                                <div class="mt-4 mt-sm-0">
                                    <div>
                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Delivered Orders</p>
                                        <h6>{{-- 150 --}} Orders</h6>
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Pending Orders</p>
                                        <h6>{{-- 50 --}} Orders</h6>
                                    </div>

                                    <div class="mt-4 pt-2">
                                        <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Confirmed Orders</p>
                                        <h6>{{-- 70 --}} Orders</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            <div class="col-xl-7">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center mb-4">
                                    <h5 class="card-title me-2">Overall Revenue</h5>
                                    <div class="ms-auto">
                                        <select class="form-select form-select-sm">
                                            <option value="MAY" selected="">May</option>
                                            <option value="AP">April</option>
                                            <option value="MA">March</option>
                                            <option value="FE">February</option>
                                            <option value="JA">January</option>
                                            <option value="DE">December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <div id="invested-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                    </div>
                                    <div class="col-sm align-self-center">
                                        <div class="mt-4 mt-sm-0">
                                            <p class="mb-1">Total Sales</p>
                                            <h4>$ {{-- 6134.39 --}}</h4>

                                            <p class="text-muted mb-4"> + {{-- 0.2 --}} % since last month<i class="mdi mdi-arrow-up ms-1 text-success"></i></p>

                                            <div class="row g-0">
                                                <div class="col-6">
                                                    <div>
                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Income</p>
                                                        <h5 class="fw-medium">$ {{-- 2632.46 --}}</h5>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div>
                                                        <p class="mb-2 text-muted text-uppercase font-size-11">Expenses</p>
                                                        <h5 class="fw-medium">-$ {{-- 924.38 --}}</h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <a href="{{ route('admin.all.reports') }}" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card bg-primary text-white shadow-primary card-h-100">
                            <div class="card-body p-0">
                                <div id="carouselExampleCaptions" class="carousel slide text-center widget-carousel" data-bs-ride="carousel">                                                   
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-store-outline widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-store"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Pending</b> Restaurants</h4>
                                                <p class="text-white-50 font-size-13">You have **{{-- 10 --}}** new restaurant applications waiting for your approval. Review them to grow your network.</p>
                                                <a href="{{ route('pending.restaurant') }}" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-food-outline widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-food"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Pending</b> Orders</h4>
                                                <p class="text-white-50 font-size-13">There are **{{-- 20 --}}** new orders that have been placed. Review and confirm them as soon as possible.</p>
                                                <a href="{{ route('pending.order') }}" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="text-center p-4">
                                                <i class="mdi mdi-star-box-outline widget-box-1-icon"></i>
                                                <div class="avatar-md m-auto">
                                                    <span class="avatar-title rounded-circle bg-light-subtle text-white font-size-24">
                                                        <i class="mdi mdi-star"></i>
                                                    </span>
                                                </div>
                                                <h4 class="mt-3 lh-base fw-normal text-white"><b>Pending</b> Reviews</h4>
                                                <p class="text-white-50 font-size-13">You have **{{-- 5 --}}** new client reviews waiting for your approval. Make sure they are appropriate to display.</p>
                                                <a href="{{ route('admin.pending.review') }}" class="btn btn-light btn-sm">View details <i class="mdi mdi-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="carousel-indicators carousel-indicators-rounded">
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                                            aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> </div>
    </div>
@endsection