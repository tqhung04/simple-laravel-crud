<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function isAdmin ($userId) {
        $user = DB::table('users')
                    ->where('id', '=', $userId)
                    ->where('roles_id', '=', '1')->get();
        if ( count($user) == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function getData() {
        $currentUserId = Auth::user()->id;

        if ( $currentUserId == 1 ) {
            $users = DB::table('users');
        } else {
            $users = DB::table('users')->where('id', '=', $currentUserId);
        }
        return $users;
    }
}
