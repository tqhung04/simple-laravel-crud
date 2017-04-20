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
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ];

        for($i = 2; $i<25; $i++) {

            $users[$i] = [
                'id' => $i,
                'username' => 'guest' . $i,
                'email' => 'guest' . $i . '@gmail.com',
                'password' => bcrypt('12345678'),
                'image' => 'guest.jpg',
                'status' => 0,
                'remember_token' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }

        DB::table('users')->insert($users);
    }
}
