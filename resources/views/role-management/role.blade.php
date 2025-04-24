<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roles Management</title>

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
                @can('create role')
                    {{-- Tombol Tambah --}}
                    <div class="mt-8 me-8 absolute fixed top-0 right-0 ">
                        <a href="/role/create" title="Add Role"
                            class="text-white text-xl w-8 h-8 bg-blue-700 hover:bg-blue-800 shadow-lg rounded-full flex items-center justify-center opacity-75">
                            +
                        </a>
                    </div>
                @endcan

                @php
                    $sort = request('sort');
                    $order = request('order', 'asc');
                @endphp

                {{-- Judul Tabel --}}
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            <a href="?sort=id&order={{ $sort === 'id' && $order === 'asc' ? 'desc' : 'asc' }}">
                                No
                                @if ($sort === 'id')
                                    <i class="bi {{ $order === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                            <a href="?sort=name&order={{ $sort === 'name' && $order === 'asc' ? 'desc' : 'asc' }}">
                                Role Name
                                @if ($sort === 'name')
                                    <i class="bi {{ $order === 'asc' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                @endif
                            </a>
                        </th>
                        @can('edit role')
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                                Action
                            </th>
                        @endcan
                    </tr>
                </thead>

                {{-- Isi Tabel --}}
                <tbody class="divide-y divide-gray-200">
                    @foreach ($roles as $role)
                        <tr class="bg-white border-b border-gray-200 hover:bg-gray-50">
                            {{-- Judul Buku --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $role->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                {{ $role->name }}</td>
                            @can('edit role')
                                {{-- Judul Buku --}}
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    {{-- Tombol Edit --}}
                                    <form action="/role/edit" method="GET">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $role->id }}">
                                        <input type="submit" name="edit"
                                            class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none"
                                            value="Edit">
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{-- Pagination --}}
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</body>
</html>