<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use Hash;
use DB;
use File;

class UserController extends Controller
{
    use ValidatesRequests;

    protected $_model = 'User';

    public function create()
    {
        $currentUserid = Auth::id();
        $user = new User();
        $isAdmin = $user->isAdmin($currentUserid);

        $roles_model = new Role();
        $roles = $roles_model->getData();
        $roleList = [];
        foreach ($roles as $role) {
            $roleList[$role->id] = $role->name;
        }

        if ( $isAdmin == true ) {
            return view('Admin.'. $this->_model .'.create_update')
                    ->with('roleList', $roleList)
                    ->with('isAdmin', $isAdmin);
        } else {
            return view('errors.permission');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:100||unique:users',
            'password' => 'required|max:100|min:8',
            'email' => 'required|max:100|email|unique:users',
            'role' => 'required',
        ]);

        $file = Input::file('image');

        $user = new User;
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->status = Input::get('status');
        $user->roles_id = Input::get('role');
        $user->image = $this->getNameOfFileUpload($user, $file);
        $user->save();

        $this->handleFileUpload($file, $user->image);

        return redirect()->action('Admin\UserController@index')->with(['flash_level'=>'success','flash_message' => 'Create User Success']);
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'username' => 'required|max:100|unique:users,username,'. $id,
            'email' => 'required|max:100|email|unique:users,email,' . $id,
        ]);

        $file = Input::file('image');
        $password = $request->input('password');
        $role = $request->input('role');

        $user = User::find($id);
        $oldImage = $user->image;
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->status = Input::get('status');
        if ( $user->isSuperAdmin($id) && $user->status == 1) {
            $user->status = 0;
            return redirect()->back()->with(['flash_level'=>'error','flash_message' => 'Can not deactive superadmin']);
        }
        $user->image = $this->getNameOfFileUpload($user, $file);

        if ( $role ) {
            $user->roles_id = Input::get('role');;
        }

        if( $password ) {
            $this->validate($request, [
                'password' => 'min:8',
            ]);
            $user->password = Hash::make(Input::get('password'));
        }

        $newImage = $user->username . '.jpg';

        $this->handleFileUpload($file, $user->image);
        $this->updateImageByName($oldImage, $newImage);

        $user->save();
        return redirect()->action('Admin\UserController@index')->with(['flash_level'=>'success','flash_message' => 'Update User Success']);
    }

    public function edit($id)
    {
        $data = $this->getObjectById($id);

        if ( $data ) {
            // Check admin
            $currentUserid = Auth::id();
            $user = new User();
            $isAdmin = $user->isAdmin($currentUserid);

            // Get Role
            $user = User::find($id);
            $roles_model = new Role();
            $current_role[$user->roles_id] = $roles_model->getNameById($user->roles_id);
            $roles = $roles_model->getData();
            $roleList = [];
            foreach ($roles as $role) {
                $roleList[$role->id] = $role->name;
            }

            if ( $id == $currentUserid || $isAdmin == true ) {
                return view('Admin.'. $this->_model .'.create_update')
                    ->with('data', $data)
                    ->with('isAdmin', $isAdmin)
                    ->with('current_role', $current_role[$user->roles_id])
                    ->with('roleList', $roleList);
            } else {
                return view('errors.permission');
            }
        } else {
            return view('errors.404');
        }
    }
}

