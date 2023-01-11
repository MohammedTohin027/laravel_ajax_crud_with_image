<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['brand_name_en' => 'Pakija En', 'brand_name_bn' => 'Pakija Bn', 'brand_image'=> '', 'status' => 1],
            ['brand_name_en' => 'Samsung En', 'brand_name_bn' => 'Samsung Bn', 'brand_image'=> '', 'status' => 0],
        ];

        Brand::insert($data);
    }
}
