<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Account</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="flex text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="mx-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            @guest
            <h2 class="text-2xl font-bold uppercase">Create Account</h2>
            <div class="flex justify-items-start p-8">
                <div class="w-full max-w-[550px]">
                    <form action="/user/guest/save" method="post">
                        @csrf
                        <div class="mb-5">
                            <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                Full Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="Enter Full Name"
                                value="{{ old('name') }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div class="mb-5">
                            <label for="username" class="mb-3 block text-base font-medium text-[#07074D]">
                                Username
                            </label>
                            <input type="text" name="username" id="username" placeholder="Add Username Name"
                                value="{{ old('username') }}"
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        <div class="mb-5">
                            <label for="password" class="mb-3 block text-base font-medium text-[#07074D]">
                                Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="Add Password"
                                value=""
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- Button Delete and Save --}}
                        <div class="flex justify-between">
                            <div class=""></div>
                            <input type="hidden" name="role" id="role" value="Guest">
                            <button type="submit" name="submit"
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none"
                                value="save">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
                <div class="flex justify-center items-center h-full">
                    <h1 class="text-2xl font-bold text-gray-800">You already login to an account.</h1>
                </div>
            @endguest
        </div>
    </div>
</body>

</html>
