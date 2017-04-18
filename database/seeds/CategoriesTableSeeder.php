<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriesTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        $categories = [
            [
                'id' => 1,
                'name' => 'Apple',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 2,
                'name' => 'Toshiba',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s")
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
