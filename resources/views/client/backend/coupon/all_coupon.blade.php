@extends('client.client_dashboard')

@section('client')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Coupons</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{-- Button to add a new coupon --}}
                            <a href="{{ route('add.coupon') }}" class="btn btn-primary waves-effect waves-light">Add Coupon</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Data table for displaying all coupons --}}
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Coupon Name</th>
                                    <th>Coupon Desc</th>
                                    <th>Discount</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupon as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->coupon_name }}</td>
                                        {{-- Use Str::limit for a cleaner display of the description --}}
                                        <td>{{ Str::limit($item->coupon_desc, 20) }}</td>
                                        <td>{{ $item->discount }}</td>
                                        {{-- Format the date for better readability --}}
                                        <td>{{ Carbon\Carbon::parse($item->validity)->format('D, d F Y') }}</td>
                                        <td>
                                            {{-- Check coupon validity based on the current date --}}
                                            @if ($item->validity >= Carbon\Carbon::now()->format('Y-m-d'))
                                                <span class="badge rounded-pill bg-success">Valid</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Invalid</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Action buttons for editing and deleting coupons --}}
                                            <a href="{{ route('edit.coupon', $item->id) }}" class="btn btn-info waves-effect waves-light">Edit</a>
                                            <a href="{{ route('delete.coupon', $item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> </div> </div> </div>

@endsection