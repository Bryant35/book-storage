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
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                @if (Auth::check() && Auth::user()->hasRole('Admin'))
                    {{-- Tombol Tambah --}}
                    <div class="mt-8 me-8 absolute fixed top-0 right-0 ">
                        <a href="/user/create" title="Add Author"
                            class="text-white text-xl w-8 h-8 bg-blue-700 hover:bg-blue-800 shadow-lg rounded-full flex items-center justify-center opacity-75">
                            +
                        </a>
                    </div>
                @endif

                @php
                    $sort = request('sort');
                    $order = request('order', 'asc');
                @endphp

                {{-- Judul Tabel --}}
                {{-- <a href="/author/create" class="bg-green-400 rounded-full m-2 p-2"> + </a> --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            <a href="?sort=name&order={{ $sort === 'name' && $order === 'asc' ? 'desc' : 'asc' }}">
                                Name
                                @if ($sort === 'name')
                                    <i class="bi {{ $order === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            <a
                                href="?sort=username&order={{ $sort === 'username' && $order === 'asc' ? 'desc' : 'asc' }}">
                                Username
                                @if ($sort === 'username')
                                    <i class="bi {{ $order === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            {{-- <a href="?sort=role&order=asc">Role</a> --}}
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
                                {{ optional($user->roles)->pluck('name')->join(', ') }}
                            </td>
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

    {{-- pass OnSense 9We4bTlY --}}
    @if (session('random_password'))
        <!-- Modal -->
        <div class="fixed inset-0 bg-black opacity-50 z-40"></div>
        <div id="default-modal" tabindex="-1" aria-hidden="true"
            class="flex fixed inset-0 z-50 justify-center items-center w-full overflow-x-hidden overflow-y-auto">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            User Created
                        </h3>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <p class="text-base leading-relaxed text-gray-500">
                        <p><strong>Username:</strong> {{ session('new_user') }}</p>
                        </p>
                        <p class="text-base leading-relaxed text-gray-500">
                        <p><strong>Password:</strong> {{ session('random_password') }}</p>
                        </p>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                        <a href="{{session()->forget('random_password')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"> Finish </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</body>

</html>
