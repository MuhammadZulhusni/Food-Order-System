@extends('frontend.dashboard.dashboard')

@section('dashboard')

@php
    // Get the authenticated user's ID and profile data
    $id = Auth::user()->id;
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
                        {{-- Active tab for changing password --}}
                        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <h4 class="font-weight-bold mt-0 mb-4">Change Password</h4>
                            
                            <div class="bg-white card mb-4 order-list shadow-sm">
                                <div class="gold-members p-4">
                                    {{-- Password update form --}}
                                    <form action="{{ route('user.password.update') }}" method="post">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div>
                                                    <div class="mb-3">
                                                        <label for="old_password" class="form-label">Old Password</label>
                                                        <input class="form-control @error('old_password') is-invalid @enderror" type="password" name="old_password" id="old_password">
                                                        @error('old_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="mb-3">
                                                        <label for="new_password" class="form-label">New Password</label>
                                                        <input class="form-control @error('new_password') is-invalid @enderror" type="password" name="new_password" id="new_password">
                                                        @error('new_password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                        
                                                    <div class="mb-3">
                                                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                                        <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation">
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                                                    </div>
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

{{--  not relevant to this page and can be removed  --}}
{{--
<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })
</script>
--}}

@endsection