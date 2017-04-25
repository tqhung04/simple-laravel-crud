<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;

class CategoryController extends Controller
{
    use ValidatesRequests;

    protected $_model = 'Category';
    protected $_message = [
        'status.error' => 'This category has product'
    ];

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $user = new Category;
        $user->name = Input::get('name');
        $user->status = Input::get('status');
        $user->save();

        return redirect()->action('Admin\CategoryController@index');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
        ])->validate();

        $category = Category::find($id);
        $category->name = Input::get('name');
        $category->status = Input::get('status');

        // Deactive Category
        if ( $category->status == 1 ) {
            $haveProducts = $category->haveProducts($id);
            if ( $haveProducts ) {
                $category->status = 0;
                return redirect()->back()->with('status_error', 'This category had product');
            }
        }

        $category->save();

        return redirect()->action('Admin\CategoryController@index');
    }


}
