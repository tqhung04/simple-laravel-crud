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
            ],
            [
                'id' => 2,
                'name' => 'Toshiba',
                'status' => 0,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
