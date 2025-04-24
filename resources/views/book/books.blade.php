<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Book Lists</title>

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
                @can('create book')
                    {{-- Tombol Tambah --}}
                    <div class="mt-8 me-8 absolute fixed top-0 right-0 ">
                        <a href="/book/create" title="Add Book"
                            class="text-white text-xl w-8 h-8 bg-blue-700 hover:bg-blue-800 shadow-lg rounded-full flex items-center justify-center opacity-75">
                            +
                        </a>
                    </div>
                @endcan

                @can('view book')
                    
                {{-- Judul Tabel --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Category
                        </th>
                        @can('edit book')
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        @endcan
                    </tr>
                </thead>

                {{-- Isi Tabel --}}
                <tbody class="divide-y divide-gray-200">
                    @foreach ($books as $book)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                            {{-- Judul Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $book->title }}</td>

                            {{-- Isi nama array penulis --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                @foreach ($book->authors as $author)
                                    {{ $author }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>

                            {{-- Kategori Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $book->category_name }}</td>
                            @can('edit book')
                                {{-- Tombol Edit --}}
                                <form action="/book/edit" method="GET">
                                    @csrf
                                    <input type="hidden" name="page" value="books">
                                    <input type="hidden" name="id" value="{{ $book->book_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <input type="submit" name="edit"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                            value="Edit">
                                </form>
                            @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $books->links() }}
            </div>
            @endcan
            @cannot('view book')
                <div class="flex justify-center items-center h-full">
                    <h1 class="text-2xl font-bold text-gray-800">You do not have permission to view this page.</h1>
                </div>
            @endcannot
        </div>
    </div>

    {{-- flowbite js --}}
    <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
</body>

</html>
