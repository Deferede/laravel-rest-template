<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'admin'
            ],
            [
                'name' => 'user'
            ]
        ];

        // Add there other permissions from other Modules

        //

        foreach ($permissions as $permission) {
            try {
                $model = Permission::create($permission);
                Role::findByName('admin')->givePermissionTo($model);
                $this->command->info("Permission: {$permission['name']} successful created!");
            }
            catch (PermissionAlreadyExists $error) {
                $this->command->error("Permission: {$permission['name']} already exists for this guard name!");
            }
        }
    }
}
