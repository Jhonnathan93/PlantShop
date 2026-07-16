<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        $plants = [
            ['name' => 'Rose', 'description' => 'A classic flowering plant with fragrant petals and a timeless garden presence.', 'price' => 21, 'stock' => 42, 'category' => 'Flowering', 'image' => 'rose.jpg'],
            ['name' => 'Sunflower', 'description' => 'A cheerful, sun-loving flower that brings height and color to outdoor spaces.', 'price' => 18, 'stock' => 35, 'category' => 'Flowering', 'image' => 'sunflower.jpg'],
            ['name' => 'Lavender', 'description' => 'Aromatic purple blooms with a calming fragrance, ideal for sunny spots.', 'price' => 16, 'stock' => 50, 'category' => 'Aromatic', 'image' => 'lavender.jpg'],
            ['name' => 'Basil', 'description' => 'A fresh culinary herb for sauces, salads and kitchen windowsills.', 'price' => 10, 'stock' => 70, 'category' => 'Aromatic', 'image' => 'basil.jpg'],
            ['name' => 'Snake Plant', 'description' => 'A resilient indoor plant known for its upright leaves and low-light tolerance.', 'price' => 24, 'stock' => 38, 'category' => 'Indoor', 'image' => 'snake_plant.jpg'],
            ['name' => 'Monstera Deliciosa', 'description' => 'A dramatic tropical plant with iconic split leaves for bright interiors.', 'price' => 38, 'stock' => 22, 'category' => 'Indoor', 'image' => '1.jpg'],
            ['name' => 'Peace Lily', 'description' => 'Glossy foliage and elegant white flowers for softly lit rooms.', 'price' => 26, 'stock' => 30, 'category' => 'Indoor', 'image' => '2.jpg'],
            ['name' => 'Fiddle Leaf Fig', 'description' => 'A sculptural statement plant with broad, violin-shaped leaves.', 'price' => 45, 'stock' => 16, 'category' => 'Ornamental', 'image' => '3.jpg'],
            ['name' => 'Rubber Plant', 'description' => 'Deep green leaves and a tidy form make it a versatile decorative choice.', 'price' => 29, 'stock' => 28, 'category' => 'Ornamental', 'image' => '4.jpg'],
            ['name' => 'Aloe Vera', 'description' => 'A practical succulent valued for its soothing gel and easy care.', 'price' => 14, 'stock' => 64, 'category' => 'Succulents', 'image' => '6.jpg'],
            ['name' => 'Echeveria', 'description' => 'A compact rosette succulent with soft colors and minimal water needs.', 'price' => 12, 'stock' => 55, 'category' => 'Succulents', 'image' => 'plant5.jpg'],
            ['name' => 'Jade Plant', 'description' => 'A long-lived succulent with thick leaves, often associated with good fortune.', 'price' => 17, 'stock' => 44, 'category' => 'Succulents', 'image' => '6.jpg'],
            ['name' => 'Fern', 'description' => 'Lush, feathery foliage that adds texture to shaded patios and humid rooms.', 'price' => 19, 'stock' => 32, 'category' => 'Ornamental', 'image' => '1.jpg'],
            ['name' => 'Mint', 'description' => 'A fast-growing aromatic herb with refreshing leaves for drinks and desserts.', 'price' => 9, 'stock' => 68, 'category' => 'Aromatic', 'image' => 'basil.jpg'],
            ['name' => 'Bougainvillea', 'description' => 'Vibrant bracts and climbing growth for warm, sunny outdoor walls.', 'price' => 33, 'stock' => 18, 'category' => 'Outdoor', 'image' => 'sunflower.jpg'],
            ['name' => 'Bird of Paradise', 'description' => 'An architectural tropical plant with bold leaves and spectacular blooms.', 'price' => 49, 'stock' => 14, 'category' => 'Outdoor', 'image' => '4.jpg'],
        ];

        foreach ($plants as $plantData) {
            $category = Category::query()->where('name', $plantData['category'])->firstOrFail();
            $plant = new Plant();
            $plant->setName($plantData['name']);
            $plant->setDescription($plantData['description']);
            $plant->setPrice($plantData['price']);
            $plant->setStock($plantData['stock']);
            $plant->setImage($plantData['image']);
            $plant->setCategoryId($category->getId());
            $plant->save();
        }
    }
}
