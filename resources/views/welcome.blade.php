<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#90a6e6]">
    @include('nav')
    <div class="bg-white rounded-lg shadow-lg mx-8 my-4 p-4 mt-20">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                {{-- Judul Tabel --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Judul
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Penulis
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Aksi
                        </th>
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
                            <form action="/book/edit" method="GET">
                                <input type="hidden" name="id" value="{{ $book->book_id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <input type="submit" name="edit"
                                        class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                        value="Edit">
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
