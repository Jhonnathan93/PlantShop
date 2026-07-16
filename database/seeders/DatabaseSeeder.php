<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Guide;
use App\Models\Item;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([Item::class, Review::class, Order::class, Plant::class, Guide::class, Category::class, User::class] as $model) {
            $model::truncate();
        }

        Schema::enableForeignKeyConstraints();

        $this->call([
            CategorySeeder::class,
            PlantSeeder::class,
            GuideSeeder::class,
            SuperUserSeeder::class,
            CustomerSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
