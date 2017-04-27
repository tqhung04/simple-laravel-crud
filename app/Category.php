<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class Category extends Authenticatable
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

    public function getActiveCategories()
    {
        $categories = Category::get()->where('status', '=', '0');
        $categoryList = [];

        foreach ($categories as $category) {
            $category = Category::where('name' , '=', $category['name'])->first();
            $categoryList[$category['id']] = $category['name'];
        }

        return $categoryList;
    }

    public function haveProducts($id)
    {
        $category = DB::table('categories')
            ->join('products', 'categories.id', '=', 'products.categories_id')
            ->where('products.categories_id', '=', $id)
            ->select('products.name')
            ->get();

        if ( count($category) == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function checkActiveCategoryById($categoryId) {
        $category = DB::table('categories')
                ->where([
                    ['id', '=', $categoryId],
                    ['status', '=', 0]
                ])->get();

        if ( count($category) == 0 ) {
            return false;
        } else {
            return true;
        }
    }
}
