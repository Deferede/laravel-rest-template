<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'sanctum'
            ],
            [
                'name' => 'user',
                'guard_name' => 'sanctum'
            ]
        ];

        foreach ($roles as $role) {
            try {
                Role::create($role);
                $this->command->info("Role: {$role['name']} successful created!");
            }
            catch (RoleAlreadyExists $error) {
                $this->command->error("Role: {$role['name']} already exists for this guard name!");
            }
        }
    }
}
