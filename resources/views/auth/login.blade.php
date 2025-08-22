<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Aesthetic Login Page">
      <meta name="author" content="Gemini">
      <title>User Login</title>
      <!-- Tailwind CSS CDN for modern styling -->
      <script src="https://cdn.tailwindcss.com"></script>
      <!-- Inter Font -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
      
      <style>
         body {
            font-family: 'Inter', sans-serif;
         }
         /* The background image for the left side of the page */
         .bg-image {
             background-image: url('https://framerusercontent.com/images/giAH6QzByvVLJdryNnbcMmx4.png');
             background-position: center center;
             background-size: cover;
             background-repeat: no-repeat;
         }
      </style>
   </head>
   <body class="bg-gray-50 flex items-center justify-center min-h-screen">
      <div class="w-full max-w-6xl mx-auto rounded-xl shadow-2xl overflow-hidden md:flex">
         <!-- Left side with a background image -->
         <div class="hidden md:block md:w-1/2 bg-image relative">
            <div class="absolute inset-0 bg-black opacity-40"></div>
         </div>
         
         <!-- Right side with the login form -->
         <div class="w-full md:w-1/2 bg-white flex items-center justify-center py-12 px-6 sm:px-12">
            <div class="max-w-md w-full">
               <div class="text-center">
                  <!-- Link to homepage -->
                  <a href="/" class="text-indigo-600 hover:text-indigo-500 font-medium text-sm mb-4 inline-block">← Back to Homepage</a>
                  <h3 class="text-3xl font-bold text-gray-900 mb-2">Welcome back!</h3>
                  <p class="text-gray-500">Sign in to your account</p>
               </div>

               <!-- Displaying validation and session messages -->
               @if ($errors->any())
               <div class="mt-4 bg-red-100 text-red-700 p-3 rounded-lg text-sm">
                   <ul class="list-none m-0 p-0">
                       @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                       @endforeach
                   </ul>
               </div>
               @endif
               
               @if (Session::has('error'))
               <div class="mt-4 bg-red-100 text-red-700 p-3 rounded-lg text-sm">
                   <li>{{ Session::get('error') }}</li>
               </div>
               @endif
               @if (Session::has('success'))
               <div class="mt-4 bg-green-100 text-green-700 p-3 rounded-lg text-sm">
                   <li>{{ Session::get('success') }}</li>
               </div>
               @endif

               <!-- Login Form -->
               <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                  @csrf
                  <div class="relative">
                     <input type="email" name="email" id="inputEmail" class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="Email address" required>
                     <label for="inputEmail" class="absolute left-4 -top-2 text-xs text-gray-600 bg-white px-1 transition-all">Email address</label>
                  </div>
                  <div class="relative mt-4">
                     <input type="password" name="password" id="inputPassword" class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="Password" required>
                     <label for="inputPassword" class="absolute left-4 -top-2 text-xs text-gray-600 bg-white px-1 transition-all">Password</label>
                  </div>
                  <div class="flex items-center justify-between mt-4">
                     <div class="flex items-center">
                     </div>
                     <a href="{{ route('password.request') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                  </div>
                  <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                     Sign in
                  </button>
               </form>
               
               <!-- Sign-up link section -->
               <div class="text-center pt-6 text-sm text-gray-500">
                  Don’t have an account? 
                  <a class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('register')}}">Sign Up</a>
               </div>
            </div>
         </div>
      </div>
   </body>
</html>
