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
        // Define features and actions
        $features = ['book', 'author', 'category', 'user', 'role', 'audit'];
        $actions = ['view', 'edit', 'create'];

        // 1. Create all permissions
        foreach ($features as $feature) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "$action $feature"]);
            }
        }

        // 2. Create roles
        $admin  = Role::firstOrCreate(['name' => 'Admin']);
        $editor = Role::firstOrCreate(['name' => 'Editor']);
        $reader = Role::firstOrCreate(['name' => 'Reader']);

        // 3. Define permissions per role

        // Admin Permissions
        $adminPermissions = [
            'create book', 'create author', 'create category', 'create user',
            'edit role', 'edit user', 'edit book', 'edit author', 'edit category',
            'view audit', 'view user', 'view role', 'view book', 'view author', 'view category',
        ];

        // Editor Permissions
        $editorPermissions = [
            'create book', 'create author', 'create category',
            'edit book', 'edit author', 'edit category',
            'view user', 'view role', 'view audit',
        ];

        // Reader Permissions
        $readerPermissions = [
            'view book', 'view author', 'view category',
        ];

        // 4. Assign permissions to roles
        $admin->syncPermissions($adminPermissions);
        $editor->syncPermissions($editorPermissions);
        $reader->syncPermissions($readerPermissions);
    }
}
