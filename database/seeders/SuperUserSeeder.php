<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = new User();
        $user->setName('Admin Garden');
        $user->setEmail('superusuario@gmail.com');
        $user->setPassword(Hash::make('123456789'));
        $user->setImage('user0.jpg');
        $user->setRole('admin');
        $user->setBalance(1000);
        $user->save();
    }
}
