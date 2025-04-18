<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User List</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
     <div class="flex text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="mx-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <div class="ms-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <div class="mt-8 me-8 absolute fixed top-0 right-0 ">
                    <a href="/author/create"
                    title="Add Author"
                        class="text-white text-xl w-8 h-8 bg-blue-700 hover:bg-blue-800 shadow-lg rounded-full flex items-center justify-center opacity-75">
                            +
                    </a>
                </div>



                {{-- Judul Tabel --}}
                {{-- <a href="/author/create" class="bg-green-400 rounded-full m-2 p-2"> + </a> --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            Role
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
                    @foreach ($users as $user)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">

                            {{-- Judul Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $user->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                Roles</td>

                            @if (Auth::check() && Auth::user()->hasRole('Admin'))
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    {{-- Tombol Edit --}}
                                    <form action="/user/edit" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
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
                {{ $users->links() }}
            </div>
        </div>
        </div>
     </div>
</body>
</html>