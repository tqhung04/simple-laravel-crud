<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CategoryController extends Controller
{
    use ValidatesRequests;

    public function index() 
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('Admin.Category.index')->with('categories', $categories);
    }

    public function create()
    {
        return view('Admin.Category.create_update');
    }

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

    public function edit($id)
    {
        $category = Category::find($id);
        return view('Admin.Category.create_update')->with('category', $category);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        $category = Category::find($id);
        $category->name = Input::get('name');
        $category->status = Input::get('status');
        $category->save();

        return redirect()->action('Admin\CategoryController@index');
    }

    public function action (Request $request)
    {
        $checkedItems = $request->input('cb');

        if ( !empty($checkedItems) ) {

            $listOfId = array_keys($checkedItems);
            $status = $this->getStatus($request->input('active'));

            foreach ($listOfId as $id) {
                $category = Category::find($id);
                $category->status = $status;
                $category->save();
            }
        }

        return redirect()->action('Admin\CategoryController@index');
    }

    public function search (Request $request)
    {
        $this->validate($request, [
            'search' => 'required',
        ]);

        $query = Input::get('search');

        if ( $this->isSpaceString($query) === false ) {
            $categories = Category::where('name', 'LIKE', '%'.$query.'%')->paginate(10);
            return view('Admin.Category.index', compact('categories', 'query'));
        }
    }
}
