<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Auth;
use App\UserStatus;
use App\UserType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create([
            'name'=> 'zaibi(developer)',
            'email'=> 'zaibi@gmail.com',
            'username'=>'zaibi',
            'password'=>Hash::make('1234567'),
            'type'=>UserType::SuperAdmin,
            'status'=> UserStatus::Active,
            'bio'=> 'I am a developer zaibi'

        ]);
    }
}
