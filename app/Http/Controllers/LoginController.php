<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

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

    protected function redirectTo()
    {
        return '/admin/user';
    }

    protected function redirectAfterLogout()
    {
        return 'login';
    }

    protected function redirectAfterLoginFailed()
    {
        return 'login';
    }

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

    public function authenticate(Request $request) {
        $remember = (Input::has('cbRemember')) ? true : false;

        $dataOfInput = Auth::attempt(
            [
                'username'  => strtolower(Input::get('username')),
                'password'  => Input::get('password')
            ], $remember
        );

        if ( $dataOfInput ) {
            return redirect()->intended($this->redirectTo());
        } else {
            return redirect()->route($this->redirectAfterLoginFailed())->with('message', 'User & password doesn\'t match.');
        }
    }

    public function logout () {
        Auth::logout();
        return redirect()->route($this->redirectAfterLogout());
    }
}
