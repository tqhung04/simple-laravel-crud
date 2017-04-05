<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index (Request $request)
    {
        $users = User::get();
        return view('Admin.User.index')->with('users', $users);
    }

    public function create (Request $request) {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $avatar = $request->input('avatar');

        if ( isset($request->createUser) ) {
            echo "<h1>Create User</h1>";
        }
        return view("Amin.User.create");
    }
}
