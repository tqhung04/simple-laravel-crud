<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Validator;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('Admin.Category.index')->with('categories', $categories);
    }

    public function create()
    {
        return view('Admin.Category.create');
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

        return redirect()->action('CategoryController@index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('Admin.Category.edit')->with('category', $category);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,' .$id,
        ]);

        $user = Category::find($id);
        $user->name = Input::get('name');
        $user->save();

        return redirect()->action('CategoryController@index');
    }

    public function action (Request $request)
    {
        $checkedItems = $request->input('cb');
        $listOfId = array_keys($checkedItems);

        if ($request->input('active')) {
            $status = 0;
        } else {
            $status = 1;
        }

        foreach ($listOfId as $id) {
            $user = Category::find($id);
            $user->status = $status;
            $user->save();
        }

        return redirect()->action('CategoryController@index');
    }

    public function search (Request $request)
    {
        $query = $request->input('search');
        $categories = Category::where('name', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('Admin.Category.index', compact('categories', 'query'));
    }
}
