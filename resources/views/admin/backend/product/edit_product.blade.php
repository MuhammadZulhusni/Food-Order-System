@extends('admin.admin_dashboard')
@section('admin')

{{-- Import jQuery for form validation and image preview --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- ========================================================= -->
        <!-- Start Page Header -->
        <!-- ========================================================= -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Product</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- ========================================================= -->
        <!-- Main Form Section -->
        <!-- ========================================================= -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-4">
                        <form id="myForm" action="{{ route('admin.product.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="row">
                                {{-- Select dropdowns for product relationships --}}
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category_id" class="form-label">Category Name</label>
                                        <select name="category_id" class="form-select" id="category_id">
                                            <option>Select</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="menu_id" class="form-label">Menu Name</label>
                                        <select name="menu_id" class="form-select" id="menu_id">
                                            <option selected disabled>Select</option>
                                            @foreach ($menu as $men)
                                                <option value="{{ $men->id }}" {{ $men->id == $product->menu_id ? 'selected' : '' }}>{{ $men->menu_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city_id" class="form-label">City Name</label>
                                        <select name="city_id" class="form-select" id="city_id">
                                            <option>Select</option>
                                            @foreach ($city as $cit)
                                                <option value="{{ $cit->id }}" {{ $cit->id == $product->city_id ? 'selected' : '' }}>{{ $cit->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="client_id" class="form-label">Client Name</label>
                                        <select name="client_id" class="form-select" id="client_id">
                                            <option>Select</option>
                                            @foreach ($client as $clie)
                                                <option value="{{ $clie->id }}" {{ $clie->id == $product->client_id ? 'selected' : '' }}>{{ $clie->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Text inputs for product details --}}
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" name="name" id="name" value="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input class="form-control" type="text" name="price" id="price" value="{{ $product->price }}">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="discount_price" class="form-label">Discount Price</label>
                                        <input class="form-control" type="text" name="discount_price" id="discount_price" value="{{ $product->discount_price }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <input class="form-control" type="text" name="size" id="size" value="{{ $product->size }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="qty" class="form-label">Product QTY</label>
                                        <input class="form-control" type="text" name="qty" id="qty" value="{{ $product->qty }}">
                                    </div>
                                </div>

                                {{-- Image upload and preview --}}
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Product Image</label>
                                        <input class="form-control" name="image" type="file" id="image">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ asset($product->image) }}" alt="Product Image" class="rounded-circle p-1 bg-primary" width="110">
                                    </div>
                                </div>

                                {{-- Checkbox options --}}
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="best_seller" type="checkbox" id="best_seller_check" value="1" {{ $product->best_seller == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="best_seller_check">
                                        Best Seller
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" name="most_populer" type="checkbox" id="most_populer_check" value="1" {{ $product->most_populer == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="most_populer_check">
                                        Most Popular
                                    </label>
                                </div>

                                {{-- Form submission button --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>

<!-- ========================================================= -->
<!-- Custom Javascript -->
<!-- ========================================================= -->
<script type="text/javascript">
    $(document).ready(function(){
        // Image preview script
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(e.target.files['0']);
        });

        // Form validation script
        $('#myForm').validate({
            rules: {
                name: {
                    required: true,
                },
                menu_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please Enter Product Name',
                },
                menu_id: {
                    required: 'Please Select a Menu',
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection
