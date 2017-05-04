<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Hash;
use DB; 

class UserController extends Controller
{
    use ValidatesRequests;

    protected $_model = 'User';

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

        return redirect()->action('Admin\UserController@index')->with(['flash_level'=>'success','flash_message' => 'Create User Success']);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'username' => 'required|unique:users,username,'. $id,
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $file = Input::file('image');

        $user = User::find($id);
        $user->image = $this->getNameOfFileUpload($user, $file);
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->status = Input::get('status');
        $user->save();

        $this->handleFileUpload($file, $user->image);

        return redirect()->action('Admin\UserController@index')->with(['flash_level'=>'success','flash_message' => 'Update User Success']);
    }

    public function edit($id)
    {
        $currentUserid = Auth::id();
        $user = new User();
        $isAdmin = $user->isAdmin($currentUserid);

        $data = $this->getObjectById($id);

        if ( $data ) {
            if ( $id == $currentUserid || $isAdmin == true ) {
                return view('Admin.'. $this->_model .'.create_update')
                    ->with('data', $data);
            } else {
                return view('errors.permission');
            }
        } else {
            return view('errors.404');
        }
    }
}

