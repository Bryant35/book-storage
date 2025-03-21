<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite('resources/css/app.css')
</head>
<body>
    <!-- component -->
<div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 h-[calc(100vh-2rem)] w-full max-w-[20rem] p-4 shadow-xl shadow-blue-gray-900/5">
  <div class="mb-2 p-4">
    <h5 class="block antialiased tracking-normal font-sans text-xl font-semibold leading-snug text-gray-900">Hello</h5>
  </div>
  @include('sidebar')
</div>
    <div class="">
        <h1>Welcome to Book Preview</h1>
        <p>Book Preview is a platform that allows you to preview books before you buy them. You can read the first few pages of a book before you decide to buy it. This way, you can make an informed decision before you spend your money.</p>
        <p>Click on the "Books" link in the navigation bar to view the list of books available for preview.</p>
    </div>
</body>
</html>