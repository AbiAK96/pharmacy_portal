<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(
        //     ['id' => '1', 'type' => 'admin'],
        //     ['id' => '2', 'type' => 'user' ]);

            $createMultipleRoles = [
                ['id' => '1', 'type' => 'admin'],
                ['id' => '2', 'type' => 'user' ]
            ];
            Role::insert($createMultipleRoles);
    }
}
