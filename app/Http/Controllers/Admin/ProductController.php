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
            'price' => 'required|numeric|max:999999999|min:0',
            'category' => 'required',
        ]);

        // Create product
        $product = new Product;
        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('description');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');

        $category = new Category();
        $checkActiveCategoryById = $category->checkActiveCategoryById($product->categories_id);

        if ($checkActiveCategoryById) {
            $product->createProduct($product);
            $this->createImagesOfProduct($request);
        } else {
            return redirect()->back()->with(['flash_level'=>'failed','flash_message' => 'Category has been removed']);
        }

        return redirect()->action('Admin\ProductController@index')->with(['flash_level'=>'success','flash_message' => 'Create Product Success']);;
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if ( $product ) {
            // Get Images of Product
            $images = $this->getImagesOfProduct($id);
            

            $product = Product::find($id);

            $categories = Category::get()->where('status', '=', '0');
            $current_category[$product->categories_id] = Category::get()->where('id', '=', $product->categories_id);
            $categoryList = [];

            foreach ($categories as $category) {
                $category = Category::where('name' , '=', $category['name'])->first();
                $categoryList[$category['id']] = $category['name'];
            }

            return view('Admin.Product.create_update')
                ->with('images', $images)
                ->with('active_categories', $categoryList)
                ->with('current_category', $current_category[$product->categories_id])
                ->with('product', $product);
        } else {
            return view('errors.404');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,' . $id,
            'price' => 'required|numeric|max:999999999',
            'category' => 'required',
            'images[]' => 'mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $product = Product::find($id);

        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->description = Input::get('description');
        $product->categories_id = Input::get('category');
        $product->status = Input::get('status');

        $category = new Category();
        $checkActiveCategoryById = $category->checkActiveCategoryById($product->categories_id);

        if ($checkActiveCategoryById) {
            $product->createProduct($product);
            $this->createImagesOfProduct($request, $id);
        } else {
            return redirect()->back()->with(['flash_level'=>'failed','flash_message' => 'Category has been removed']);
        }

        return redirect()->action('Admin\ProductController@index')->with(['flash_level'=>'success','flash_message' => 'Update Product Success']);;
    }

    public function createImagesOfProduct($request, $id = null)
    {
        // Create images of product
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach($files as $key => $file){
                $product = new Product();
                $highestIdOfProduct = $product->getTheHighestId();

                $productImages = new ProductImages();
                // Create
                if ( $id == null ) {
                    $productImages->name = Input::get('name') . '_' . $key . '.jpg';
                    $productImages->products_id = $highestIdOfProduct;
                // Update
                } else {
                    $totalImagesOfProduct = $productImages->getTotalImagesOfProduct($id);
                    $productImages->name = Input::get('name') . '_' . $totalImagesOfProduct . '.jpg';
                    $productImages->products_id = $id;
                }
                $productImages->createProductImage($productImages);

                $this->handleFileUpload($file, $productImages->name);
            }
        }
    }

    public function getImagesOfProduct($productId)
    {
        $productImages = new ProductImages();
        $data = $productImages->getImagesOfProduct($productId);
        $images = [];
        if ($data) {
            foreach ($data as $key => $value) {
                $images[] = $value['name'];
            }
        }
        return $images;
    }

    public function search(Request $request)
    {
        $column = $request->input('search_type');
        $model = 'App\\' . $this->_model;
        switch ($column) {
            case 'name':
                $keyword = $request->input('name');

                if ( $this->isSpaceString($keyword) === false ) {
                    $datas = $model::where($column, "LIKE", "%$keyword%")->paginate($this->_pagination);
                }
                $datas->appends(['search_type'=>$_GET['search_type'], 'name' => $_GET['name']]);
                break;
            case 'price':
                $keyword = $request->input('price');
                if ($keyword == '<100000') {
                    $datas = $model::where($column, '<', 100000)->paginate($this->_pagination);
                } elseif ($keyword == '10000~500000') {
                    $datas = $model::whereBetween($column, [100000, 500000])->paginate(2);
                } elseif ($keyword == '>500000') {
                    $datas = $model::where($column, '>', 500000)->paginate($this->_pagination);
                }
                $datas->appends(['search_type'=>$_GET['search_type'], 'price' => $_GET['price']]);
                break;
        }
        return view('Admin.'. $this->_model .'.index')
                ->with('datas', $datas)
                ->with('search_message', 'About '. $datas->total() .' results');
    }
}
