<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="Askbootstrap">
   <meta name="author" content="Askbootstrap">
   <title>User Dashboard - Online Food Ordering Website</title>

   <!-- Favicon Icon -->
   <link rel="icon" type="image/png" href="{{ asset('frontend/img/favicon.png') }}">

   <!-- Bootstrap core CSS -->
   <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

   <!-- Font Awesome -->
   <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">

   <!-- IcoFont -->
   <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">

   <!-- Select2 CSS -->
   <link href="{{ asset('frontend/vendor/select2/css/select2.min.css') }}" rel="stylesheet">

   <!-- Custom styles -->
   <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet">

   <!-- Owl Carousel -->
   <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
   <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">

   <!-- Toastr CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body>

@include('frontend.dashboard.header')
@yield('dashboard')
@include('frontend.dashboard.footer')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/owl-carousel/owl.carousel.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('frontend/js/custom.js') }}"></script>

<!-- Toastr Notification -->
<script>
@if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
@endif
</script>

</body>
</html>
