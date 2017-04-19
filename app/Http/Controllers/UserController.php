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

    public function create()
    {
        return view('Admin.User.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
        ]);

        $file = Input::file('image');

        $user = new User;
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->status = Input::get('status');
        $user->image = $this->getNameOfFileUpload($user, $file);
        $user->save();

        $this->handleFileUpload($file, $user->image);

        return redirect()->action('UserController@index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('Admin.User.edit')->with('user', $user);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'username' => 'required|unique:users,username,'. $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $file = Input::file('image');

        $user = User::find($id);
        $user->image = $this->getNameOfFileUpload($user, $file);
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->status = Input::get('status');
        $user->save();

        $this->handleFileUpload($file, $user->image);

        return redirect()->action('UserController@index');
    }

    public function action (Request $request)
    {
        $checkedItems = $request->input('cb');

        if ( !empty($checkedItems) ) {

            $listOfId = array_keys($checkedItems);
            $status = $this->getStatus($request->input('active'));

            foreach ($listOfId as $id) {
                $user = User::find($id);
                $user->status = $status;
                $user->save();
            }
        }

        return redirect()->action('UserController@index');
    }

    public function search (Request $request) {
        $query = $request->input('search');
        $users = User::where('username', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('Admin.User.index', compact('users', 'query'));
    }
}

