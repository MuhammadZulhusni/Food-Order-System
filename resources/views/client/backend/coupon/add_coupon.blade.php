@extends('client.client_dashboard')

@section('client')

{{-- Include jQuery and jQuery Validation plugin for form handling --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Add Coupon</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Coupon</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-4">

                        {{-- Form to add a new coupon --}}
                        <form id="myForm" action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                {{-- Coupon Name Input --}}
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="coupon_name_input" class="form-label">Coupon Name</label>
                                        <input class="form-control" type="text" name="coupon_name" id="coupon_name_input">
                                    </div>
                                </div>

                                {{-- Coupon Description Input --}}
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="coupon_desc_input" class="form-label">Coupon Dsc</label>
                                        <input class="form-control" type="text" name="coupon_desc" id="coupon_desc_input">
                                    </div>
                                </div>

                                {{-- Coupon Discount Input --}}
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="discount_input" class="form-label">Coupon Discount</label>
                                        <input class="form-control" type="text" name="discount" id="discount_input">
                                    </div>
                                </div>

                                {{-- Coupon Validity Date Input --}}
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="validity_input" class="form-label">Coupon Validity</label>
                                        <input class="form-control" type="date" name="validity" id="validity_input" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div> </div>

{{-- JavaScript for Form Validation --}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                coupon_name: {
                    required : true,
                },
                coupon_desc: {
                    required : true,
                },
                discount: {
                    required : true,
                },
                validity: {
                    required : true,
                },
            },
            messages :{
                coupon_name: {
                    required : 'Please Enter Coupon Name',
                },
                coupon_desc: {
                    required : 'Please Enter Coupon Description',
                },
                discount: {
                    required : 'Please Enter Discount Amount',
                },
                validity: {
                    required : 'Please Select a Validity Date',
                },
            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>

@endsection