<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['Admin' , 'admin' , 'this role has all permissions' , true],
            ['User' , 'user' , 'this role has basic permissions' , true],
            ['Manager' , 'manager' , 'this role has manager permissions' , true],
            ['Employee' , 'employee' , 'this role has employee permissions' , true],
            ['Accountant' , 'accountant' , 'this role has accountant permissions' , true],
            ['HR' , 'hr' , 'this role has hr permissions' , true],
            ['Sales' , 'sales' , 'this role has sales permissions' , true],
            ['Marketing' , 'marketing' , 'this role has marketing permissions' , true],
            ['Support' , 'support' , 'this role has support permissions' , true],
            ['Developer' , 'developer' , 'this role has developer permissions' , true],
            ['Designer' , 'designer' , 'this role has designer permissions' , true],
            ['Editor' , 'editor' , 'this role has editor permissions' , true],
            ['Publisher' , 'publisher' , 'this role has publisher permissions' , true],
            ['Moderator' , 'moderator' , 'this role has moderator permissions' , true]
        ]);
    }
}
