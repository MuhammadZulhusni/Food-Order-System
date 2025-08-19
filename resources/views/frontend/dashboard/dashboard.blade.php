<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>User Dashboard - Online Food Ordering Website</title>
      <link rel="icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}">
      <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.default.min.css') }}">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
      <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet">
      <script src="https://js.stripe.com/v3/"></script> 
   </head>
   <body>
      @include('frontend.dashboard.header')

      @yield('dashboard')

      @include('frontend.dashboard.footer')

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

      <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('frontend/vendor/select2/js/select2.min.js') }}"></script>
      <script src="{{ asset('frontend/vendor/owl-carousel/owl.carousel.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script src="{{ asset('frontend/js/custom.js') }}"></script>

      <script type="text/javascript">
         // Setup CSRF token for all AJAX requests
         $.ajaxSetup({
            headers:{
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
      </script>

      <script>
         // Toastr notifications from Laravel session
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

      {{-- //// Apply Coupon and Remove functions /////////////// --}}
    <script>
    function ApplyCoupon() {
        var coupon_name = $('#coupon_name').val();
        
        // Check if coupon name is not empty
        if (!coupon_name || coupon_name.trim() === '') {
            showToast('error', 'Please enter a coupon code');
            return;
        }

        // Show loading state (optional)
        $('#apply-coupon-btn').prop('disabled', true).text('Applying...');

        $.ajax({
            type: "POST",
            dataType: "json",
            data: {
                coupon_name: coupon_name,
                _token: $('meta[name="csrf-token"]').attr('content') // Explicit CSRF token
            },
            url: "/apply-coupon",
            success: function(data) {
                console.log('Apply coupon response:', data); // Debug log
                
                if (data.success) {
                    showToast('success', data.success);
                    // Optional: Update UI elements instead of full reload
                    setTimeout(() => location.reload(), 1000);
                } else if (data.error) {
                    showToast('error', data.error);
                } else {
                    showToast('error', 'Unexpected response from server');
                }
            },
            error: function(xhr, status, error) {
                console.error('Apply coupon error:', xhr.responseText); // Debug log
                
                let errorMessage = 'An error occurred while applying coupon';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMessage = 'Invalid coupon data provided';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again later';
                }
                
                showToast('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                $('#apply-coupon-btn').prop('disabled', false).text('Apply');
            }
        });
    }

    function couponRemove() {

        // Show loading state (optional)
        $('#remove-coupon-btn').prop('disabled', true).text('Removing...');

        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/remove-coupon",
            success: function(data) {
                console.log('Remove coupon response:', data); // Debug log
                
                if (data.success) {
                    showToast('success', data.success);
                    // Optional: Update UI elements instead of full reload
                    setTimeout(() => location.reload(), 1000);
                } else if (data.error) {
                    showToast('error', data.error);
                } else {
                    showToast('error', 'Unexpected response from server');
                }
            },
            error: function(xhr, status, error) {
                console.error('Remove coupon error:', xhr.responseText); // Debug log
                
                let errorMessage = 'An error occurred while removing coupon';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again later';
                }
                
                showToast('error', errorMessage);
            },
            complete: function() {
                // Reset button state
                $('#remove-coupon-btn').prop('disabled', false).text('Remove');
            }
        });
    }

    // Helper function for consistent toast notifications
    function showToast(type, message) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: type, // Use 'icon' instead of 'type' for newer SweetAlert2 versions
            title: message,
        });
    }

    // Alternative function using Toastr instead of SweetAlert2
    function showToastToastr(type, message) {
        switch(type) {
            case 'success':
                toastr.success(message);
                break;
            case 'error':
                toastr.error(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'info':
                toastr.info(message);
                break;
        }
    }
    </script>
   </body>
</html>