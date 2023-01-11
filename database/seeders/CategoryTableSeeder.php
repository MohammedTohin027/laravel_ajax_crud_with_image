<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['cat_name_en' => 'Electronics En', 'cat_name_bn' => 'Electronics Bn', 'cat_slug_en' => 'electronics-en', 'cat_slug_bn' => 'electronics-bn', 'discount' => 10, 'status' => 1],
            ['cat_name_en' => 'Clothing En', 'cat_name_bn' => 'Clothing Bn', 'cat_slug_en' => 'clothing-en', 'cat_slug_bn' => 'clothing-bn', 'discount' => 15, 'status' => 0],
        ];
        Category::insert($data);
    }
}
