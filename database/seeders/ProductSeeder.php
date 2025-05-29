<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(
            [
                'title'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, aliquid.',
                'price'=>19.3,
                'quantity'=>3,
                'category_id'=>1,
                'brand_id'=>1,
                'description'=>' Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officiis soluta pariatur est vitae deserunt aut!',
            ]
        );
    }
}
