<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Validator;
use Hash;
use DB; 

class UserController extends Controller {

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('Admin.User.index')->with('users', $users);
    }

    public function create() {
        return view('Admin.User.create');
    }

    public function store(Request $request) {

        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|unique:users',
        ]);

        $user = new User;
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->status = Input::get('status');

        if ( Input::file('avatar') ) {
            $image = Input::file('avatar');
            $filename  = $user->username . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/userImages');
            Input::file('avatar')->move($path, $filename);
            $user->avatar = $filename;
        } else {
            $user->avatar = 'user_default.jpg';
        }

        $user->save();

        return redirect()->action('UserController@index');
    }

    public function show($id) {

    }

    public function edit($id) {
        $user = User::find($id);
        return view('Admin.User.edit')->with('user', $user);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'username' => 'required|unique:users,username,'. $id,
            'email' => 'required|unique:users,email,' . $id,
        ]);

        $user = User::find($id);

        $user->avatar = $this->getInputFileName($user);

        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->status = Input::get('status');
        $user->save();

        return redirect()->action('UserController@index');

    }

    public function destroy($id) {
        //
    }

    public function action (Request $request)
    {
        $checkedItems = $request->input('cb');
        $listOfId = array_keys($checkedItems);

        if ($request->input('active')) {
            $status = 0;
        } else {
            $status = 1;
        }

        foreach ($listOfId as $id) {
            $user = User::find($id);
            $user->status = $status;
            $user->save();
        }

        return redirect()->action('UserController@index');
    }

    public function search (Request $request) {
        $query = $request->input('search');
        $users = User::where('username', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('Admin.User.index', compact('users', 'query'));
    }

    public function getInputFileName ($user) {
        if ( Input::file('avatar') ) {
            $image = Input::file('avatar');
            $filename  = $user->username . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/userImages');
            Input::file('avatar')->move($path, $filename);
            return $filename;
        }
    }
}

