<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\Plant;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            ['user' => 'sofia@example.com', 'address' => 'Calle 93 #12-45, Bogota', 'status' => 'Delivered', 'items' => [['Monstera Deliciosa', 1], ['Basil', 2]]],
            ['user' => 'daniel@example.com', 'address' => 'Carrera 7 #72-18, Bogota', 'status' => 'Sent', 'items' => [['Lavender', 2], ['Aloe Vera', 1]]],
            ['user' => 'valentina@example.com', 'address' => 'Calle 10 #38-22, Medellin', 'status' => 'Completed', 'items' => [['Snake Plant', 1], ['Echeveria', 3]]],
        ];

        foreach ($orders as $orderData) {
            $user = User::query()->where('email', $orderData['user'])->firstOrFail();
            $order = new Order();
            $order->setUserId($user->getId());
            $order->setAddress($orderData['address']);
            $order->setStatus($orderData['status']);
            $order->setTotal(0);
            $order->save();

            $total = 0;
            foreach ($orderData['items'] as [$plantName, $quantity]) {
                $plant = Plant::query()->where('name', $plantName)->firstOrFail();
                $item = new Item();
                $item->setQuantity($quantity);
                $item->setPrice($plant->getPrice());
                $item->setPlantId($plant->getId());
                $item->setOrderId($order->getId());
                $item->save();
                $total += $plant->getPrice() * $quantity;
            }

            $order->setTotal($total);
            $order->save();
        }
    }
}
