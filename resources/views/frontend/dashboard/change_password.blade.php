@include('frontend.dashboard.header')

{{-- Include jQuery for dynamic functionalities --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- Include Toastr.js for notifications --}}
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

@php
    // Get the authenticated user's ID
    $id = Auth::user()->id;
    // Retrieve the user's profile data (though not directly used in this password change form, often included for consistent layout)
    $profileData = App\Models\User::find($id);
@endphp

<section class="section pt-4 pb-4 osahan-account-page">
    <div class="container">
        <div class="row">

            {{-- Include the dashboard sidebar --}}
            @include('frontend.dashboard.sidebar')

            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <h4 class="font-weight-bold mt-0 mb-4">Change Password</h4>

                            <div class="bg-white card mb-4 order-list shadow-sm">
                                <div class="gold-members p-4">

                                    {{-- Password Change Form --}}
                                    <form action="{{ route('user.password.update') }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <div class="mb-6">
                                                        <label for="old_password" class="form-label">Old Password</label>
                                                        {{-- Input field for old password with validation error display --}}
                                                        <input class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" id="old_password">
                                                        @error('old_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-6">
                                                        <label for="new_password" class="form-label">New Password</label>
                                                        {{-- Input field for new password with validation error display --}}
                                                        <input class="form-control @error('new_password') is-invalid @enderror" type="password" name="new_password" id="new_password">
                                                        @error('new_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-6">
                                                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                                        {{-- Input field for confirming new password --}}
                                                        <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation">
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- JavaScript for image preview functionality (though not directly used for password change, retained if shared layout) --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

{{-- Toastr.js script for displaying notifications --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}";
    switch(type){
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif
</script>

@include('frontend.dashboard.footer')