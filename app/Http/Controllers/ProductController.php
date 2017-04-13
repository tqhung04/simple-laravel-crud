<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Validator;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);

        return view('Admin.Product.index')
            ->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[] = $category['name'];
        }

        return view('Admin.Product.create')
            ->with('categoryList', $categoryList);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'price' => 'required|numeric',
            'category' => 'required|exists:categories,id',
        ]);

        $product = new Product;
        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('password');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');

        if ( Input::file('image') ) {
            $image = Input::file('image');
            $filename  = $product->name . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/productImages/');
            Input::file('image')->move($path, $filename);
            $product->image = $filename;
        }

        $product->save();

        return redirect()->action('UserController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        $categories = Category::get();
        $categoryList[0] = DB::table('categories')->where('id', $product->categories_id)->value('name');
        foreach ($categories as $category) {
            $categoryList[] = $category['name'];
        }

        return view('Admin.Product.edit')
            ->with('categoryList', $categoryList)
            ->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,id',
            'price' => 'required|numeric',
            'category' => 'required',
        ]);

        $product = Product::find($id);
        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('password');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');

        if ( Input::file('image') ) {
            $image = Input::file('image');
            $filename  = $product->name . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/productImages/');
            Input::file('image')->move($path, $filename);
            $product->image = $filename;
        }

        $product->save();

        return redirect()->action('UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            $product = Product::find($id);
            $product->status = $status;
            $product->save();
            // print_r($product);
        }

        return redirect()->action('ProductController@index');
    }

    public function search (Request $request) {
        $query = $request->input('search');
        $products = Product::where('name', 'LIKE', '%'.$query.'%')->paginate(10);
        return view('Admin.product.index', compact('products', 'query'));
    }
}
