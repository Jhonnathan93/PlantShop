<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            ['user' => 'sofia@example.com', 'plant' => 'Monstera Deliciosa', 'stars' => 5, 'content' => 'The plant arrived healthy and looks beautiful in my living room.'],
            ['user' => 'daniel@example.com', 'plant' => 'Lavender', 'stars' => 5, 'content' => 'Wonderful fragrance and clear care instructions.'],
            ['user' => 'valentina@example.com', 'plant' => 'Snake Plant', 'stars' => 4, 'content' => 'A great beginner plant. It adapted quickly to my office.'],
            ['user' => 'mateo@example.com', 'plant' => 'Aloe Vera', 'stars' => 5, 'content' => 'Compact, healthy and exactly as described.'],
            ['user' => 'sofia@example.com', 'plant' => 'Basil', 'stars' => 4, 'content' => 'Fresh leaves and perfect for my kitchen window.'],
            ['user' => 'daniel@example.com', 'plant' => 'Bird of Paradise', 'stars' => 5, 'content' => 'A standout plant that made the patio feel alive.'],
        ];

        foreach ($reviews as $reviewData) {
            $user = User::query()->where('email', $reviewData['user'])->firstOrFail();
            $plant = Plant::query()->where('name', $reviewData['plant'])->firstOrFail();
            $review = new Review();
            $review->setContent($reviewData['content']);
            $review->setStars($reviewData['stars']);
            $review->setStatus('approved');
            $review->setPlantId($plant->getId());
            $review->setUserId($user->getId());
            $review->save();
        }
    }
}
