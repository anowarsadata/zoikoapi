<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'lokesh.kumar.wh@gmail.com',
            'role_id' => 1,
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => Hash::make('loke*123#'),
        ]);
    }
}
