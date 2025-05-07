<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#90a6e6]">
    <!-- component -->
<div class="min-h-screen flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Forget Password</h2>
    
    <form class="space-y-4" action="/validate/forget-password" method="POST">
        @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input 
          type="email" 
          name="email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
          placeholder="Enter your Email"
          value="{{ old('email') }}"
        />
      </div>

      {{-- <div class="flex items-center justify-between">
        <div class=""> </div>
        <a href="/login" class="text-sm text-indigo-600 hover:text-indigo-500">Back to Login</a>
      </div> --}}

      <input type="submit" name="login" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors" value="Send Reset Link">

    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      {{-- Don't have an account?  --}}
      <a href="/login" class="text-indigo-600 hover:text-indigo-500 font-medium">Back to Login</a>
    </div>
  </div>
</div>

</body>
</html>