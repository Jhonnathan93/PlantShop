<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ornamental', 'description' => 'Colorful plants chosen to make indoor and outdoor spaces feel more welcoming.', 'image' => '1.jpg'],
            ['name' => 'Indoor', 'description' => 'Easy-care plants that thrive in bright rooms, offices and cozy corners.', 'image' => '2.jpg'],
            ['name' => 'Outdoor', 'description' => 'Resilient varieties for balconies, terraces and sunny gardens.', 'image' => '3.jpg'],
            ['name' => 'Aromatic', 'description' => 'Fragrant herbs and plants for cooking, tea and sensory gardens.', 'image' => '4.jpg'],
            ['name' => 'Succulents', 'description' => 'Low-maintenance plants with striking shapes and modest watering needs.', 'image' => '2.jpg'],
            ['name' => 'Flowering', 'description' => 'Seasonal blooms that add color and life to every collection.', 'image' => '1.jpg'],
        ];

        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData['name']);
            $category->setDescription($categoryData['description']);
            $category->setImage($categoryData['image']);
            $category->save();
        }
    }
}
