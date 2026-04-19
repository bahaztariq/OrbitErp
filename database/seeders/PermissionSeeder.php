<?php

namespace Database\Seeders;

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
            'payments', 'products', 'roles', 'suppliers', 'tasks'
        ];

        foreach ($resources as $resource) {
            $actions = ['view-any', 'view', 'create', 'update', 'delete', 'restore', 'force-delete'];
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    ['name' => "$action-$resource"],
                    ['description' => ucfirst(str_replace('-', ' ', $action)) . " " . str_replace('-', ' ', $resource)]
                );
            }
        }
    }
}
