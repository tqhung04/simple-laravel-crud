<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;

class Controller extends BaseController
{
    protected $_model = '';
    protected $_sortBy = '';
    static $_order = '';

    public function index(Request $request)
    {
        $sortBy = (isset($request['sortBy']) ? $request['sortBy'] : 'id');
        $order = (isset($request['order']) ? $request['order'] : 'desc');

        $model = 'App\\' . $this->_model;

        $datas = $model::orderBy($sortBy, $order)->paginate(10);

        return view('Admin.'. $this->_model .'.index')->with('datas', $datas);
    }

    public function create()
    {
        return view('Admin.'. $this->_model .'.create_update');
    }

    public function edit($id)
    {
        $model = 'App\\' . $this->_model;
        $data = $model::find($id);
        return view('Admin.'. $this->_model .'.create_update')->with('data', $data);
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
                $data->save();
            }
        }

        return redirect()->action('Admin\\'. $this->_model .'Controller@index');
    }

    public function search (Request $request)
    {
        $this->validate($request, [
            'search' => 'required',
        ]);

        $query = $request->input('search');

        if ( $this->isSpaceString($query) === false ) {
            $model = 'App\\' . $this->_model;
            $datas = $model::where('username', 'LIKE', '%'.$query.'%')->paginate(10);
            return view('Admin.'. $this->_model .'.index', compact('datas', 'query'));
        }
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

        if ( $model->image == NULL ) {
            $fileName = 'default.jpg';
        }

        return $fileName;
    }

    public function handleFileUpload ($file, $fileName)
    {
        if ( $file && $fileName != 'default.jpg') {
            $path = public_path('upload');
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
        if ( ctype_space($string) )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
