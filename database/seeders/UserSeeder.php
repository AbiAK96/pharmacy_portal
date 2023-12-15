<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
                ['id' => '1', 
                'role_id' => '1',
                'name' => 'Admin',
                'contact_number' => '0752938243',
                'dob' => '1996-01-12',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                ]);
    }
}
