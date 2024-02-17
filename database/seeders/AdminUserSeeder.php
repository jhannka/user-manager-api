<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sianexussas.com',
            'phone_number' => 3008871405,
            'identification_card' => '1111111111',
            'birth_date' => '1990/08/11',
            'city_code' => 0001,
            'password' => Hash::make('123456789'),
        ]);
    }
}
