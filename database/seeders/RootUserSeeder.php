<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// created by running 
// php artisan make:seeder RootUserSeeder

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'tuanbk1908@gmail.com'],
            [
                'name' => 'Root User',
                'password' => Hash::make('Niteco@07'),
                'email_verified_at' => now(),
                'phone' => '0968576908',
                'address' => 'Hoang Liet ward, Hoang Mai district, Hanoi',
                'education_background' => 'bachelor',
                'user_type' => 'admin',
            ]
        );
    }
}
