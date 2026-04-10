<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Admin' => ['all'],
            'Manager' => [
                'view-any companies', 'view companies', 'update companies',
                'view-any clients', 'view clients', 'create clients', 'update clients',
                'view-any products', 'view products', 'create products', 'update products',
                'view-any categories', 'view categories', 'create categories', 'update categories',
                'view-any suppliers', 'view suppliers', 'create suppliers', 'update suppliers',
                'view-any orders', 'view orders', 'create orders', 'update orders',
                'view-any invoices', 'view invoices', 'create invoices', 'update invoices',
                'view-any payments', 'view payments', 'create payments', 'update payments',
                'view-any tasks', 'view tasks', 'create tasks', 'update tasks',
                'view-any calender-events', 'view calender-events', 'create calender-events', 'update calender-events',
                'view-any messages', 'view messages', 'create messages',
                'view-any conversations', 'view conversations', 'create conversations',
                'view-any invitations', 'view invitations', 'create invitations',
                'view-any memberships', 'view memberships',
                'view-any trash', 'view trash', 'restore trash',
            ],
            'Sales' => [
                'view-any clients', 'view clients', 'create clients', 'update clients',
                'view-any products', 'view products', 'view-any categories', 'view categories',
                'view-any orders', 'view orders', 'create orders', 'update orders',
                'view-any invoices', 'view invoices', 'create invoices', 'update invoices',
                'view-any payments', 'view payments',
                'view-any tasks', 'view tasks', 'create tasks', 'update tasks',
            ],
            'Accountant' => [
                'view-any invoices', 'view invoices', 'update invoices',
                'view-any payments', 'view payments', 'create payments', 'update payments',
                'view-any orders', 'view orders',
                'view-any companies', 'view companies',
            ],
            'User' => [
                'view-any tasks', 'view tasks', 'create tasks', 'update tasks',
                'view-any calender-events', 'view calender-events', 'create calender-events', 'update calender-events',
                'view-any messages', 'view messages', 'create messages',
                'view-any conversations', 'view conversations',
            ],
        ];

        foreach ($roles as $roleName => $perms) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'slug' => Str::slug($roleName),
            ], [
                'description' => "Standard $roleName role",
            ]);

            if ($perms === ['all']) {
                $role->permissions()->sync(Permission::all());
            } else {
                $permissionIds = Permission::whereIn('name', $perms)->pluck('id');
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}
