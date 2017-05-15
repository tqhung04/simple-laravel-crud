<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use DB;
use App\User;

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

    public function saveCategory ($category)
    {
        $category->save();
    }

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

    public function getData() {
        $currentUserId = Auth::user()->id;
        $currentRoleId = Auth::user()->roles_id;
        if ( $currentRoleId == 1 ) {
            $categories = DB::table('categories');
        } else {
            $categories = DB::table('categories')->where('users_id', '=', $currentUserId);
        }
        return $categories;
    }

    public function checkCreater($categoryId) {
        $currentUserId = Auth::user()->id;
        $product = DB::table('categories')
                        ->where('id', '=', $categoryId)
                        ->where('users_id', '=', $currentUserId)
                        ->get();
        if ( count($product) == 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public function getCreaterUsername($categoryId) {
        $username = DB::table('categories')
            ->join('users', 'categories.users_id', '=', 'users.id')
            ->where('categories.id', '=', $categoryId)
            ->select('users.username')
            ->get();
        return $username[0]->username;
    }
}
