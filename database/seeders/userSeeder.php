<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        if(!DB::table('users')->where('email', 'admin@admin.com')->exists()) {
            // Buat 1 akun admin
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'usertype' => '1',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for($i = 1; $i <= 69; $i++){
            $email = $faker->unique()->safeEmail();
            
            // Cek apakah email sudah ada
            while(DB::table('users')->where('email', $email)->exists()) {
                $email = $faker->unique()->safeEmail();
            }

            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $email,
                'usertype' => '0',
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for($i = 1; $i <= 3; $i++) {
            if(!DB::table('users')->where('email', "factory{$i}@gmail.com")->exists()) {
                DB::table('users')->insert([
                    'name' => "Factory {$i}",
                    'email' => "factory{$i}@gmail.com",
                    'usertype' => '2',
                    'phone' => $faker->phoneNumber(),
                    'address' => $faker->address(),
                    'password' => Hash::make('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}