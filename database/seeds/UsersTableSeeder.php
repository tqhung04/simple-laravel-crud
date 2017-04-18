<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends DatabaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = [
            [
                'id' => 1,
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'),
                'image' => 'admin.jpg',
                'status' => 0,
                'remember_token' => '',
                'created_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 2,
                'username' => 'guest',
                'email' => 'guest@gmail.com',
                'password' => bcrypt('12345678'),
                'image' => 'guest.jpg',
                'status' => 0,
                'remember_token' => '',
                'created_at' => date("Y-m-d H:i:s")
            ],
        ];

        DB::table('users')->insert($users);
    }
}
