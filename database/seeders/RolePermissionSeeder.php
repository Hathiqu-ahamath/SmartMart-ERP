<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard', 'group' => 'dashboard'],

            ['name' => 'Create Products', 'slug' => 'create-products', 'group' => 'products'],
            ['name' => 'Edit Products', 'slug' => 'edit-products', 'group' => 'products'],
            ['name' => 'Delete Products', 'slug' => 'delete-products', 'group' => 'products'],
            ['name' => 'View Products', 'slug' => 'view-products', 'group' => 'products'],

            ['name' => 'Create Categories', 'slug' => 'create-categories', 'group' => 'categories'],
            ['name' => 'Edit Categories', 'slug' => 'edit-categories', 'group' => 'categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories', 'group' => 'categories'],
            ['name' => 'View Categories', 'slug' => 'view-categories', 'group' => 'categories'],

            ['name' => 'Create Suppliers', 'slug' => 'create-suppliers', 'group' => 'suppliers'],
            ['name' => 'Edit Suppliers', 'slug' => 'edit-suppliers', 'group' => 'suppliers'],
            ['name' => 'Delete Suppliers', 'slug' => 'delete-suppliers', 'group' => 'suppliers'],
            ['name' => 'View Suppliers', 'slug' => 'view-suppliers', 'group' => 'suppliers'],

            ['name' => 'Create Purchase Orders', 'slug' => 'create-purchase-orders', 'group' => 'purchases'],
            ['name' => 'Approve Purchase Orders', 'slug' => 'approve-purchase-orders', 'group' => 'purchases'],
            ['name' => 'View Purchase Orders', 'slug' => 'view-purchase-orders', 'group' => 'purchases'],
            ['name' => 'Cancel Purchase Orders', 'slug' => 'cancel-purchase-orders', 'group' => 'purchases'],

            ['name' => 'Create GRN', 'slug' => 'create-grn', 'group' => 'grn'],
            ['name' => 'View GRN', 'slug' => 'view-grn', 'group' => 'grn'],

            ['name' => 'View Inventory', 'slug' => 'view-inventory', 'group' => 'inventory'],
            ['name' => 'Adjust Stock', 'slug' => 'adjust-stock', 'group' => 'inventory'],

            ['name' => 'Create Sales', 'slug' => 'create-sales', 'group' => 'sales'],
            ['name' => 'View Sales', 'slug' => 'view-sales', 'group' => 'sales'],

            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'reports'],

            ['name' => 'Manage Users', 'slug' => 'manage-users', 'group' => 'users'],
            ['name' => 'Manage Roles', 'slug' => 'manage-roles', 'group' => 'roles'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Full system access']
        );
        $adminRole->permissions()->sync(Permission::all()->pluck('id'));

        $managerRole = Role::firstOrCreate(
            ['slug' => 'manager'],
            ['name' => 'Manager', 'slug' => 'manager', 'description' => 'Can view reports and approve orders']
        );
        $managerPermissions = Permission::whereIn('slug', [
            'view-dashboard', 'view-products', 'view-categories', 'view-suppliers',
            'view-purchase-orders', 'approve-purchase-orders', 'view-inventory',
            'view-sales', 'view-reports',
        ])->pluck('id');
        $managerRole->permissions()->sync($managerPermissions);

        $cashierRole = Role::firstOrCreate(
            ['slug' => 'cashier'],
            ['name' => 'Cashier', 'slug' => 'cashier', 'description' => 'POS billing and sales']
        );
        $cashierPermissions = Permission::whereIn('slug', [
            'view-dashboard', 'view-products', 'create-sales', 'view-sales',
        ])->pluck('id');
        $cashierRole->permissions()->sync($cashierPermissions);

        $storekeeperRole = Role::firstOrCreate(
            ['slug' => 'storekeeper'],
            ['name' => 'Storekeeper', 'slug' => 'storekeeper', 'description' => 'Inventory and goods receiving']
        );
        $storekeeperPermissions = Permission::whereIn('slug', [
            'view-dashboard', 'view-products', 'view-inventory', 'adjust-stock',
            'create-grn', 'view-grn', 'create-purchase-orders', 'view-purchase-orders',
        ])->pluck('id');
        $storekeeperRole->permissions()->sync($storekeeperPermissions);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartmart.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@smartmart.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'employee_code' => 'EMP-001',
                'phone' => '1234567890',
            ]
        );
    }
}
