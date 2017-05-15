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

    public function edit($id)
    {
        $category = Category::find($id);

        if ( $category ) {
            $checkCreater = $category->checkCreater($id);
            if ( $checkCreater || $this->isAdmin() ) {
                return view('Admin.Category.create_update')
                        ->with('data', $category)
                        ->with('isAdmin', $this->isAdmin())
                        ->with('creater', $category->getCreaterUsername($id));
            } else {
                return view('errors.permission');
            }
        } else {
            return view('errors.404');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        $category = new Category;
        $category->name = Input::get('name');
        $category->status = Input::get('status');
        $category->users_id = Auth::user()->id;
        $category->saveCategory($category);

        return redirect()->action('Admin\CategoryController@index')->with(['flash_level'=>'success','flash_message' => 'Create Category Success']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:categories,name,' . $id,
        ])->validate();

        $category = Category::find($id);
        $category->name = Input::get('name');
        $category->status = Input::get('status');

        // Deactive Category
        if ( $category->status == 1 ) {
            $haveProducts = $category->haveProducts($id);
            if ( $haveProducts ) {
                $category->status = 0;
                return redirect()->back()->with(['flash_level'=>'failed','flash_message' => 'This category had product']);
            }
        }

        $category->saveCategory($category);

        return redirect()->action('Admin\CategoryController@index');
    }


}
