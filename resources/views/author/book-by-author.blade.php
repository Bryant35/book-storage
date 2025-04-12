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
            <h1 class="text-2xl font-bold mb-4">Buku oleh {{ $author->name }}</h1>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                {{-- Judul Tabel --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Category
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
                    @foreach ($books as $book)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                            {{-- Judul Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $book->title }}</td>

                            {{-- Kategori Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $book->category->name }}</td>
                            @if (Auth::check() && Auth::user()->hasRole('Admin'))
                                {{-- Tombol Edit --}}
                                <form action="/book/edit" method="GET">
                                    @csrf
                                    <input type="hidden" name="page" value="book-by-author">
                                    <input type="hidden" name="author_id" value="{{ $author->author_id }}">
                                    <input type="hidden" name="id" value="{{ $book->book_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                        <input type="submit" name="edit"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                            value="Edit">
                                </form>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</body>
</html>
