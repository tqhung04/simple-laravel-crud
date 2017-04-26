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
        $products = [];

        for($i = 1; $i<25; $i++) {

            $products[$i] = [
                'id' => $i,
                'name' => 'Tivi'. $i,
                'price' => 20000,
                'description' => 'This is description of tivi' . $i,
                'categories_id' => 2,
                'image' => 'default.jpg',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
        }

        DB::table('products')->insert($products);
    }
}
