<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Product extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'id', 'name', 'price', 'description', 'image', 'categories_id'
    ];
}
