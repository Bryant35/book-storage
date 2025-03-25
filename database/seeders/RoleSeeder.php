<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds Role and Permission.
     *
     * @return void
     */
    public function run()
    {
        // Create Permissions
        $createBooksPermission = Permission::firstOrCreate(['name' => 'create books']);
        $editBooksPermission = Permission::firstOrCreate(['name' => 'edit books']);
        $deleteBooksPermission = Permission::firstOrCreate(['name' => 'delete books']);
        $viewBooksPermission = Permission::firstOrCreate(['name' => 'view books']);

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        $readerRole = Role::firstOrCreate(['name' => 'Reader']);

        // Assign Permissions to Roles
        $adminRole->givePermissionTo([
            $createBooksPermission,
            $editBooksPermission,
            $deleteBooksPermission,
            $viewBooksPermission
        ]);

        $editorRole->givePermissionTo([
            $editBooksPermission,
            $createBooksPermission,
            $viewBooksPermission
        ]);

        $readerRole->givePermissionTo([
            $viewBooksPermission
        ]);
    }
}
