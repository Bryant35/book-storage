<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-[#90a6e6]">
    <!-- component -->
<div class="min-h-screen flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sign In</h2>
    
    <form class="space-y-4" action="/validate/login" method="POST">
        @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input 
          type="text" 
          name="username"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
          placeholder="Enter your username"
          value="{{ old('username') }}"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input 
          type="password" 
          name="password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
          placeholder="••••••••"
        />
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <input type="checkbox" name="rememberMe" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"/>
          <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
      </div>

      <input type="submit" name="login" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-lg transition-colors" value="Sign In">
        {{-- Sign In --}}
    {{-- </input> --}}
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      Don't have an account? 
      <a href="/user/guest/create" class="text-indigo-600 hover:text-indigo-500 font-medium">Sign up</a>
    </div>
  </div>
</div>

</body>
</html>