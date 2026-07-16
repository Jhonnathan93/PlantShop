<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        $guides = [
            ['title' => 'How to choose the right plant', 'content' => 'Start with the light in your space. Observe whether it receives direct sun, bright indirect light or shade, then choose a plant whose care needs match that environment.', 'image' => '1.jpg'],
            ['title' => 'A simple watering routine', 'content' => 'Check the first two centimeters of soil before watering. Most houseplants prefer a thorough drink followed by time for the soil to dry slightly.', 'image' => 'guide4.jpg'],
            ['title' => 'Repotting without stress', 'content' => 'Choose a pot only one size larger, use fresh substrate and avoid compacting the roots. Repot during active growth whenever possible.', 'image' => 'guide5.jpg'],
            ['title' => 'Light for indoor plants', 'content' => 'A bright room is not always direct sunlight. Keep sensitive foliage away from harsh afternoon rays and rotate pots every few weeks for even growth.', 'image' => '1.jpg'],
            ['title' => 'Starting a kitchen herb garden', 'content' => 'Use a sunny window, breathable soil and pots with drainage. Basil, mint and rosemary offer a rewarding place to start.', 'image' => 'guide4.jpg'],
            ['title' => 'Caring for succulents', 'content' => 'Succulents need abundant light and infrequent watering. Let the soil dry completely between waterings to keep roots healthy.', 'image' => 'guide5.jpg'],
        ];

        foreach ($guides as $guideData) {
            $guide = new Guide();
            $guide->setTitle($guideData['title']);
            $guide->setContent($guideData['content']);
            $guide->setImage($guideData['image']);
            $guide->save();
        }
    }
}
