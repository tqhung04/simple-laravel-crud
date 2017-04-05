<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/user';
    protected $redirectAfterLogout = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function index () {
        return view("Admin.Auth.login");

    }
    public function authenticate(Request $request)
    {
        // $dataOfInput = [
        //     'username' = $request->username,
        //     'password' = $request->password,
        // ];
        $username = $request->username;
        $password = $request->password;
        
        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->intended('admin/user');
        } else {
            return redirect()->intended('back');
        }
    }

    public function logout () {
        Auth::logout();
        return redirect()->route('login');
    }
}
