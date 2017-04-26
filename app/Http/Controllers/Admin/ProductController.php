<?php
namespace App\Http\Controllers\Admin;

use App;
use App\Product;
use App\ProductImages;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Collective\Html\HtmlFacade;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;

class ProductController extends Controller
{
    use ValidatesRequests;

    protected $_model = 'Product';

    public function create()
    {
        $category = new Category();
        $active_categories = $category->getActiveCategories();

        return view('Admin.Product.create_update')
            ->with('active_categories', $active_categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products',
            'price' => 'required|numeric|max:999999999',
            'category' => 'required',
        ]);

        // Create product
        $product = new Product;
        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('description');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');
        $product->createProduct($product);

        // Create images of product
        $files = $request->input('images');

        foreach ($files as $key => $value) {

            $product = new Product();
            $highestIdOfProduct = $product->getTheHighestId();

            $productImages = new ProductImages();
            $productImages->name = Input::get('name') . '_' . $key;
            $productImages->products_id = $highestIdOfProduct + 1;
            $productImages->createProductImage($productImages);

            $this->handleFileUpload($value, $productImages->name);
        }

        return redirect()->action('Admin\ProductController@index');
    }

    public function edit($id)
    {
        $product = Product::find($id);

        $categories = Category::get()->where('status', '=', '0');
        $current_category[$product->categories_id] = Category::get()->where('id', '=', $product->categories_id);
        $categoryList = [];

        foreach ($categories as $category) {
            $category = Category::where('name' , '=', $category['name'])->first();
            $categoryList[$category['id']] = $category['name'];
        }

        return view('Admin.Product.create_update')
            ->with('active_categories', $categoryList)
            ->with('current_category', $current_category[$product->categories_id])
            ->with('product', $product);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,' .$id,
            'price' => 'required|numeric|max:999999999',
            'category' => 'required',
        ]);

        $product = Product::find($id);
        $file = Input::file('image');

        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('description');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');
        $product->image = $this->getNameOfFileUpload($product, $file);
        $product->createProduct($product);

        $this->handleFileUpload($file, $product->image);

        return redirect()->action('Admin\ProductController@index');
    }
}
