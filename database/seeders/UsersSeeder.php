<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'username' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('admin12345')
        ]);

        $admin->assignRole('admin');
    }
}
