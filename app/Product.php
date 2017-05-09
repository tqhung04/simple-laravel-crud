<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

class Product extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'id', 'name', 'price', 'description', 'image', 'categories_id'
    ];

    public function createProduct ($product)
    {
        $product->save();
    }

    public function categories() {
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function getTheHighestId() {
        $product = DB::table('products')->max('id');
        return $product;
    }

    public function getData() {
        $currentUserId = Auth::user()->id;
        $currentRoleId = Auth::user()->roles_id;
        if ( $currentRoleId == 1 ) {
            $product = DB::table('products');
        } else {
            $product = DB::table('products')->where('users_id', '=', $currentUserId);
        }
        return $product;
    }

    public function checkCreater($productId) {
        $currentUserId = Auth::user()->id;
        $product = DB::table('products')
                        ->where('id', '=', $productId)
                        ->where('users_id', '=', $currentUserId)
                        ->get();
        if ( count($product) == 0 ) {
            return false;
        } else {
            return true;
        }
    }
}
