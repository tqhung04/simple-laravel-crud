<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Role extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name'
    ];

    public function getData() {
        $roles = DB::table('roles')->get();
        return $roles;
    }

    public function getNameById ($roleId) {
        $role = DB::table('roles')->where('id', '=', $roleId)->get();
        return $role;
    }
}
