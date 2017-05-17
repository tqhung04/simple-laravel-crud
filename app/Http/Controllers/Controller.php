<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Product;

class Controller extends BaseController
{
    protected $_model = '';
    protected $_message = '';
    protected $_pagination = 10;

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

        switch ($this->_model) {
            case 'Product':
                $product = new Product();
                $datas = $product->getData()->orderBy($sortBy, $order)->paginate($this->_pagination);
                break;
            case 'Category':
                $category = new Category();
                $datas = $category->getData()->orderBy($sortBy, $order)->paginate($this->_pagination);
                break;
            default:
                $user = new User();
                $datas = $user->getData()->orderBy($sortBy, $order)->paginate($this->_pagination);
                break;
        }

        if ( isset($_GET['page']) && $_GET['page'] >= $datas->total()/$this->_pagination + 1 || isset($_GET['page']) && $_GET['page'] < 0 )
        {
            return view('errors.404');
        }

        // Check admin
        $currentUserid = Auth::id();
        $user = new User();
        $isAdmin = $user->isAdmin($currentUserid);

        return view('Admin.'. $this->_model .'.index')
                ->with('datas', $datas)
                ->with('order', $order)
                ->with('isAdmin', $isAdmin);
    }

    public function create()
    {
        return view('Admin.'. $this->_model .'.create_update');
    }

    public function edit($id)
    {
        $currentUserid = Auth::id();
        $user = new User();
        $isAdmin = $user->isAdmin($currentUserid);

        $data = $this->getObjectById($id);

        if ( $data ) {
            if ( $id == $currentUserid || $isAdmin == true ) {
                return view('Admin.'. $this->_model .'.create_update')
                    ->with('data', $data);
            } else {
                return view('errors.permission');
            }
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
            $status_name = $request->input('active') ? $request->input('active') : $request->input('deactive');

            $model = 'App\\' . $this->_model;
            $check = 0;
            foreach ($listOfId as $id) {
                $data = $model::find($id);
                $data->status = $status;

                // Deactive Category
                if ( $this->_model == 'Category' ) {
                    if ( $data->status == 1 ) {
                        $category = new Category();
                        $haveProducts = $category->haveProducts($id);
                        if ( $haveProducts ) {
                            $check += 1;
                            $data->status = 0;
                            return redirect()->back()->with(['flash_level'=>'error','flash_message' => $data->name . ' had product']);
                        }
                    }
                }

                if ( $this->_model == 'User' ) {
                    // Can not deactive superadmin
                    if ( $data->isSuperAdmin($id) && $data->status == 1) {
                        $data->status = 0;
                        return redirect()->back()->with(['flash_level'=>'error','flash_message' => 'Can not deactive superadmin']);
                    }
                }
            }

            if ( $check == 0 ) {
                foreach ($listOfId as $id) {
                    $data = $model::find($id);
                    $data->status = $status;
                    $data->save();
                }
            }

                $data->save();
            }

            return redirect()->back()->with(['flash_level'=>'success','flash_message' => $status_name . ' success!']);
        }
        else {
            return redirect()->back()->with(['flash_level'=>'error','flash_message' => 'No row selected']);
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
        $model = new $model();

        switch ($column) {
            case 'name':
            case 'username':
                $keyword = $request->input('name');
                if ( $this->isSpaceString($keyword) === true ) {
                    $datas = $model->getData()->orderBy($sortBy, $order)->where($column, "LIKE", "%$keyword%")->paginate($this->_pagination);
                } else {
                    return redirect()->back();
                }
                break;
            case 'price':
                $keyword = $request->input('price');
                if ($keyword == '<100000') {
                    $datas = $model->getData()->orderBy($sortBy, $order)->where($column, '<', 100000)->paginate($this->_pagination);
                } elseif ($keyword == '10000~500000') {
                    $datas = $model->getData()->orderBy($sortBy, $order)->whereBetween($column, [100000, 500000])->paginate($this->_pagination);
                } elseif ($keyword == '>500000') {
                    $datas = $model->getData()->orderBy($sortBy, $order)->where($column, '>', 500000)->paginate($this->_pagination);
                }
                break;
            case 'status':
                $keyword = $request->input('status');
                if ($keyword == 'active') {
                    $datas = $model->getData()->orderBy($sortBy, $order)->where($column, '=', 0)->paginate($this->_pagination);
                } elseif ($keyword == 'deactive') {
                    $datas = $model->getData()->orderBy($sortBy, $order)->where($column, '=', 1)->paginate($this->_pagination);
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
        } else if ( !$file && $model->image && $model->image != 'default.jpg' ) {
            if ($model->username) {
                $fileName = $model->username . '.jpg';
            } else {
                $fileName = $model->name . '.jpg';
            }
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

    public function isSpaceString ($string)
    {
        if ( $string )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getObjectById($id)
    {
        $model = 'App\\' . $this->_model;
        $data = $model::find($id);

        if ( $data ) {
            return $data;
        } else {
            return false;
        }
    }

    public function updateImageByName($oldImage, $newImage)
    {
        $dirOld = public_path() . '/upload/user/' . $oldImage;
        $dirNew = public_path() . '/upload/user/' . $newImage;
        $check = file_exists($dirOld);
        if ( $check ) {
            if ( $oldImage == 'default.jpg' ) {
                copy($dirOld, $dirNew);
            } else {
                rename($dirOld, $dirNew);
            }
        }
    }

    public function show() {
        return view('errors.404');
    }

    public function isAdmin() {
        // Check admin
        $currentUserid = Auth::id();
        $user = new User();
        $isAdmin = $user->isAdmin($currentUserid);
        return $isAdmin;
    }
}
