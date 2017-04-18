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
                'avatar' => 'admin.jpg',
                'status' => 0,
                'remember_token' => ''
            ],
            [
                'id' => 2,
                'username' => 'guest',
                'email' => 'guest@gmail.com',
                'password' => bcrypt('12345678'),
                'avatar' => 'guest.jpg',
                'status' => 0,
                'remember_token' => ''
            ],
        ];

        DB::table('users')->insert($users);
    }
}