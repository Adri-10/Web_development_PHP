<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate([
            'name' => 'Mobile Phone',
            'description' => 'Suspendisse potenti. Nulla id lectus at enim dignissim fringilla ut nec ante. Praesent pellentesque aliquam tellus sed mattis. Quisque feugiat ut justo sed egestas',
            'image' => 'website/assets/images/featured-categories/fetured-item-1.png',
        ]);

        Category::updateOrCreate([
            'name' => 'Computer',
            'description' => 'Suspendisse potenti. Nulla id lectus at enim dignissim fringilla ut nec ante. Praesent pellentesque aliquam tellus sed mattis. Quisque feugiat ut justo sed egestas',
            'image' => 'website/assets/images/featured-categories/fetured-item-1.png',
        ]);

        Category::updateOrCreate([
            'name' => 'Accessories',
            'description' => 'Suspendisse potenti. Nulla id lectus at enim dignissim fringilla ut nec ante. Praesent pellentesque aliquam tellus sed mattis. Quisque feugiat ut justo sed egestas',
            'image' => 'website/assets/images/featured-categories/fetured-item-1.png',
        ]);

        Category::updateOrCreate([
            'name' => 'T-Shirt',
            'description' => 'Suspendisse potenti. Nulla id lectus at enim dignissim fringilla ut nec ante. Praesent pellentesque aliquam tellus sed mattis. Quisque feugiat ut justo sed egestas',
            'image' => 'website/assets/images/featured-categories/fetured-item-1.png',
        ]);
    }
}
