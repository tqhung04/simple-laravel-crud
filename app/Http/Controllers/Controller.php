<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
}
