<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'electronics',
            'slug' => Str::slug('electronics'),
        ]);

        Category::create([
            'name' => 'clothes',
            'slug' => Str::slug('clothes'),
        ]);
    }
}
