<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::firstOrCreate(
            ['email' => 'admin@refugio.com'],
            [
                'name' => 'Admin',
                'cedula' => '1234567890',
                'rol' => 'admin',
                'password' => Hash::make('123456'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'encargado@refugio.com'],
            [
                'name' => 'Encargado',
                'cedula' => '987654321',
                'rol' => 'encargado',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
