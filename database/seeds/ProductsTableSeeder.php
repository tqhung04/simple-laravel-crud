<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProductsTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        $products = [
            [
                'id' => 1,
                'name' => 'Iphone 1',
                'price' => 12000,
                'description' => 'This is description of iphone 1',
                'categories_id' => 1,
                'image' => 'Iphone 1.jpg',
                'status' => 0,
            ],
            [
                'id' => 2,
                'name' => 'Tivi 1',
                'price' => 20000,
                'description' => 'This is description of tivi 1',
                'categories_id' => 2,
                'image' => 'Tivi 1.jpg',
                'status' => 0,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
