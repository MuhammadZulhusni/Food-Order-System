@extends('admin.admin_dashboard') 
@section('admin') 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content"> 
    <div class="container-fluid"> 

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All City</h4> 

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{-- Button to trigger the "Add City" modal --}}
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">Add City</button>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Data table to display city information --}}
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>City Name</th>
                                    <th>City Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($city as $key => $item) {{-- Loop through each city item passed from the controller --}}
                                <tr>
                                    <td>{{ $key + 1 }}</td> {{-- Sequential numbering --}}
                                    <td>{{ $item->city_name }}</td> {{-- Display city name --}}
                                    <td>{{ $item->city_slug }}</td> {{-- Display city slug --}}
                                    <td>
                                        {{-- Button to trigger the "Edit City" modal --}}
                                        {{-- IMPORTANT: 'id' attribute of the button stores the city's ID for AJAX fetch --}}
                                        {{-- 'onclick="cityEdit(this.id)"' calls the JS function to fetch and populate data --}}
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myEdit" id="{{ $item->id }}" onclick="cityEdit(this.id)">Edit</button>

                                        {{-- Link to delete a city --}}
                                        {{-- IMPORTANT: Ensure 'delete.city' route is correctly defined in web.php and points to the right controller method --}}
                                        <a href="{{ route('delete.city',$item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> </div> </div> </div>

{{--  Add City Modal --}}
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Form for adding a new city --}}
                {{-- IMPORTANT: 'id="myForm"' is a duplicate. Consider renaming to 'id="addCityForm"' --}}
                <form id="myForm" action="{{ route('city.store') }}" method="post" enctype="multipart/form-data">
                    @csrf 

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-3">
                                <label for="city_name_add_input" class="form-label">City Name</label> {{-- Label for city name input --}}
                                {{-- Input field for city name. Consider adding a unique ID like 'city_name_add_input' --}}
                                <input class="form-control" type="text" name="city_name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>

        </div></div></div>{{-- Edit City Modal --}}

        <div id="myEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit City</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Form for editing an existing city --}}
                        {{-- IMPORTANT: 'id="myForm"' is a duplicate. Consider renaming to 'id="editCityForm"' --}}
                        {{-- IMPORTANT: 'action="{{ route('city.update') }}"' ensures the form submits to the update route --}}
                        <form id="myForm" action="{{ route('city.update') }}" method="post" enctype="multipart/form-data">
                            @csrf {{-- CSRF token for security --}}
                            {{-- Hidden input to store the ID of the city being edited --}}
                            {{-- IMPORTANT: 'name="cat_id"' should ideally be 'name="id"' to match common Laravel conventions for ID parameters --}}
                            {{-- IMPORTANT: 'id="cat_id"' is correctly targeted by JS --}}
                                <input type="hidden" name="cat_id" id="cat_id">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mb-3">
                                            <label for="city_name_edit_input" class="form-label">City Name</label> 
                                            {{-- Input field for city name --}}
                                            {{-- IMPORTANT: 'id="cat"' is correctly targeted by JS but is a generic ID. Consider renaming to 'id="city_name_edit_input"' --}}
                                            <input class="form-control" type="text" name="city_name" id="cat">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </div>
                        </form>
                    </div></div></div>


<script>
    function cityEdit(id){
        $.ajax({
            type: 'GET',
            url: '/admin/edit/city/' + id,
            dataType: 'json',
            success:function(data){
                $('#cat').val(data.city_name); // Populates the city name input
                $('#cat_id').val(data.id);     // Populates the hidden city ID input
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                console.log("Response Text:", xhr.responseText); 
            }
        });
    }
</script>

@endsection