<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add new Author</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="flex text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="mx-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <h2 class="text-2xl font-bold uppercase">Add New Author</h2>
            <div class="flex justify-items-start p-8">
                <div class="w-full max-w-[550px]">
                    <form action="/author/save" method="post">
                        @csrf
                        <div class="mb-5">
                            <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                Author Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="New Author Name"
                                value=""
                                class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>

                        {{-- Button Delete and Save --}}
                        <div class="flex justify-between">
                            <div class=""></div>
                            <button type="submit" name="submit"
                                class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none" value="save">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
