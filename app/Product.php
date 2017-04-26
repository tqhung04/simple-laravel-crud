<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

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
}
