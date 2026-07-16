<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Sofia Martinez', 'email' => 'sofia@example.com', 'balance' => 280],
            ['name' => 'Daniel Torres', 'email' => 'daniel@example.com', 'balance' => 195],
            ['name' => 'Valentina Ruiz', 'email' => 'valentina@example.com', 'balance' => 340],
            ['name' => 'Mateo Gomez', 'email' => 'mateo@example.com', 'balance' => 160],
        ] as $customerData) {
            $customer = new User();
            $customer->setName($customerData['name']);
            $customer->setEmail($customerData['email']);
            $customer->setPassword(Hash::make('password'));
            $customer->setImage('user0.jpg');
            $customer->setRole('client');
            $customer->setBalance($customerData['balance']);
            $customer->save();
        }
    }
}
