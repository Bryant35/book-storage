<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Role</title>

    {{-- Tailwind CSS --}}
    @vite('resources/css/app.css')

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="flex text-gray-900 min-h-screen">
        @include('sidebar')
        <div class="mx-3 my-3 flex-1 bg-white rounded-lg shadow-lg p-4">
            <form action="/role/add" method="POST">
                @csrf
                <h2 class="content-center"><span class="text-2xl font-bold uppercase">Add Role : </span><input
                        type="text" class="border border-1 border-gray-400 rounded-lg p-1 mb-1.5" name="role_name"
                        placeholder="Enter new role name..." required></h2>


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="permissions-table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Permission Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    View
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Edit
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Create
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($grouped as $feature => $perms)
                                <tr class="bg-white border-b hover:bg-gray-50" data-feature="{{ $feature }}">
                                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ ucfirst($feature) }}</th>

                                    @php
                                        $permissionsMap = [
                                            'view' => 'view ' . $feature,
                                            'edit' => 'edit ' . $feature,
                                            'create' => 'create ' . $feature,
                                        ];
                                    @endphp

                                    @foreach (['view', 'edit', 'create'] as $action)
                                        <td class="px-6 py-4 justify-items-center">
                                            <input type="checkbox" name="permissions[]" class="permission-checkbox"
                                                data-feature="{{ $feature }}" data-action="{{ $action }}"
                                                value="{{ $permissionsMap[$action] }}">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="m-2 mt-4 text-right">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>


    {{-- auto checkbox script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.getElementById('permissions-table');

            table.addEventListener('change', function(e) {
                if (e.target.classList.contains('permission-checkbox')) {
                    const feature = e.target.dataset.feature;
                    const action = e.target.dataset.action;
                    const checkboxes = document.querySelectorAll(`input[data-feature="${feature}"]`);

                    if (action === 'create' && e.target.checked) {
                        // When "create" is checked, check view and edit too
                        checkboxes.forEach(cb => cb.checked = true);
                    }

                    if (action === 'edit' && e.target.checked) {
                        // When "edit" is checked, check view too
                        checkboxes.forEach(cb => {
                            if (cb.dataset.action === 'view') cb.checked = true;
                        });
                    }else if (action === 'edit' && !e.target.checked) {
                        // When "edit" is unchecked, uncheck create too
                        checkboxes.forEach(cb => {
                            if (cb.dataset.action === 'create') cb.checked = false;
                        });
                    }

                    if (action === 'view' && !e.target.checked) {
                        // When "view" is unchecked, uncheck everything
                        checkboxes.forEach(cb => cb.checked = false);
                    }
                }
            });
        });
    </script>
</body>

</html>
