<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category - List</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="flex bg-gray-100 text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="ms-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                @if (Auth::check() && Auth::user()->hasRole('Admin'))
                    <div class="mt-8 me-8 absolute fixed top-0 right-0 ">
                        <a href="/category/create" title="Add Category"
                            class="text-white text-xl w-8 h-8 bg-blue-700 hover:bg-blue-800 shadow-lg rounded-full flex items-center justify-center opacity-75">
                            +
                        </a>
                    </div>
                @endif
                {{-- Judul Tabel --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            View Book Titles
                        </th>
                        @if (Auth::check() && Auth::user()->hasRole('Admin'))
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        @endif
                    </tr>
                </thead>

                {{-- Isi Tabel --}}
                <tbody class="divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                            {{-- Judul Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $category->name }}</td>

                            {{-- Kategori Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <form action="/category/book" method="GET">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $category->category_id }}">
                                    <input type="submit" name="view"
                                        class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                        value="View Book">
                                </form>
                            </td>
                            @if (Auth::check() && Auth::user()->hasRole('Admin'))
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    {{-- Tombol Edit Kategori --}}
                                    <form action="/category/edit" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $category->category_id }}">
                                        <input type="submit" name="edit"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                            value="Edit">
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{-- Pagination --}}
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</body>

</html>
