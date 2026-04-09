<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'companies', 'calender-events', 'categories', 'clients', 'conversations',
            'invitations', 'invoices', 'memberships', 'messages', 'orders',
            'payments', 'permissions', 'products', 'roles', 'suppliers', 'tasks'
        ];

        foreach ($resources as $resource) {
            $actions = ['view', 'create', 'update', 'delete', 'restore', 'force-delete'];
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "$action $resource",
                    'description' => ucfirst($action) . " " . str_replace('-', ' ', $resource),
                ]);
            }
        }

        // Add index permissions specifically if needed, or view Any
        foreach ($resources as $resource) {
            Permission::firstOrCreate([
                'name' => "view-any $resource",
                'description' => "View any " . str_replace('-', ' ', $resource),
            ]);
        }

    }
}
