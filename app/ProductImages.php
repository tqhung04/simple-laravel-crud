<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
