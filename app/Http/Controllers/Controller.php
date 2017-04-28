<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Product;

class Controller extends BaseController
{
    protected $_model = '';
    protected $_message = '';
    protected $_pagination = 15;

    public function index(Request $request)
    {
        $sortBy = (isset($request['sortBy']) ? $request['sortBy'] : 'id');
        $order = (isset($request['order']) ? $request['order'] : 'desc');

        if ( $order == 'asc' ) {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        $model = 'App\\' . $this->_model;

        $datas = $model::orderBy($sortBy, $order)->paginate($this->_pagination);

        if ( isset($_GET['page']) && $_GET['page'] > $datas->total()/$this->_pagination + 1)
        {
            return view('errors.404');
        }
        return view('Admin.'. $this->_model .'.index')
                ->with('datas', $datas)
                ->with('order', $order);
    }

    public function create()
    {
        return view('Admin.'. $this->_model .'.create_update');
    }

    public function edit($id)
    {
        $data = $this->getObjectById($id);

        if ( $data ) {
            return view('Admin.'. $this->_model .'.create_update')->with('data', $data);
        } else {
            return view('errors.404');
        }
    }

    public function bulkAction (Request $request)
    {
        $checkedItems = $request->input('cb');

        if ( !empty($checkedItems) ) {

            $listOfId = array_keys($checkedItems);
            $status = $this->getStatus($request->input('active'));

            $model = 'App\\' . $this->_model;
            foreach ($listOfId as $id) {
                $data = $model::find($id);
                $data->status = $status;

                // Deactive Category
                if ( $this->_model == 'Category' ) {
                    if ( $data->status == 1 ) {
                        $category = new Category();
                        $haveProducts = $category->haveProducts($id);
                        if ( $haveProducts ) {
                            $data->status = 0;
                            return redirect()->back()->with('status_error', 'This category had product');
                        }
                    }
                }
                $data->save();
            }
            return redirect()->action('Admin\\'. $this->_model .'Controller@index');
        }
        else {
            return redirect()   ->back()->with('bulk_error', 'Ahihi');
        }
    }

    public function search (Request $request)
    {
        $sortBy = (isset($request['sortBy']) ? $request['sortBy'] : 'id');
        $order = (isset($request['order']) ? $request['order'] : 'asc');

        if ( $order == 'asc' ) {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        $column = $request->input('search_type');
        $model = 'App\\' . $this->_model;
        switch ($column) {
            case 'name':
            case 'username':
                $keyword = $request->input('name');
                if ( $this->isSpaceString($keyword) === true ) {
                    $datas = $model::orderBy($sortBy, $order)->where($column, "LIKE", "%$keyword%")->paginate($this->_pagination);
                } else {
                    return redirect()->back();
                }
                break;
            case 'price':
                $keyword = $request->input('price');
                if ($keyword == '<100000') {
                    $datas = $model::orderBy($sortBy, $order)->where($column, '<', 100000)->paginate($this->_pagination);
                } elseif ($keyword == '10000~500000') {
                    $datas = $model::orderBy($sortBy, $order)->whereBetween($column, [100000, 500000])->paginate($this->_pagination);
                } elseif ($keyword == '>500000') {
                    $datas = $model::orderBy($sortBy, $order)->where($column, '>', 500000)->paginate($this->_pagination);
                }
                break;
            case 'status':
                $keyword = $request->input('status');
                if ($keyword == 'active') {
                    $datas = $model::orderBy($sortBy, $order)->where($column, '=', 0)->paginate($this->_pagination);
                } elseif ($keyword == 'deactive') {
                    $datas = $model::orderBy($sortBy, $order)->where($column, '=', 1)->paginate($this->_pagination);
                }
                break;
        }
        $datas->appends(array_merge($request->all()));
        return view('Admin.'. $this->_model .'.index')
                ->with('datas', $datas)
                ->with('search_message', 'About '. $datas->total() .' results')
                ->with('order', $order);
    }

    public function getNameOfFileUpload ($model, $file)
    {
        if ( $file ) {
            if ($model->username) {
                $fileName = $model->username . '.' . $file->getClientOriginalExtension();
            } else {
                $fileName = $model->name . '.' . $file->getClientOriginalExtension();
            }
        } else if ( !$file && $model->image != 'default.jpg' ) {
            $fileName = $model->image;
        } else {
            $fileName = 'default.jpg';
        }

        return $fileName;
    }

    public function handleFileUpload ($file, $fileName)
    {
        if ( $file && $fileName != 'default.jpg') {

            switch ( $this->_model ) {
                case 'User':
                    $path = public_path('upload/user');
                    break;
                case 'Product':
                    $path = public_path('upload/product');
                    break;
            }

            $file->move($path, $fileName);
        }
    }

    public function getStatus ($status)
    {
        if ( $status == 'Active' )
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }

    public function isSpaceString ($string) {
        if ( $string )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjectById($id) {
        $model = 'App\\' . $this->_model;
        $data = $model::find($id);

        if ( $data ) {
            return $data;
        } else {
            return false;
        }
    }
}
