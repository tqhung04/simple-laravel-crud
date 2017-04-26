<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class ProductImages extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'id', 'name', 'products_id'
    ];

    public function createProductImage ($productImage)
    {
        $productImage->save();
    }

    public function getImagesOfProduct ($productId)
    {
        $result = DB::table('product_images')->select('name')->where('products_id', '=', $productId)->get();
        $images = json_decode(json_encode($result), true);
        // die(var_dump($images));
        if ($images) {
	        return $images;
        } else {
            return false;
        }
    }

    public function getTotalImagesOfProduct ($productId)
    {
        $total = DB::table('product_images')->where('products_id', '=', $productId)->count();
        return $total;
    }
}
