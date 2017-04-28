@extends('Admin.zlayouts.index')

@section('title', 'Category')

@section('breadline')
<li><a href="{{ url('admin/category') }}">List Categories</a> <span class="divider">></span></li>
<li class="active">
    @if(isset($data))
        Update
    @else
        Create
    @endif
</li>
@stop

@section('content')

<div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-grid"></div>
                    <h1>Categories Management</h1>

                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                    @if(isset($data->id))
                        {!! Form::open(['action' => ['Admin\CategoryController@update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                    @else
                        {!! Form::open(['action' => 'Admin\CategoryController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                    @endif
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Category name:</div>
                            <div class="span9">
                                <input type="text" name="name" placeholder="some text value" value="@if(isset($data->name)){{ $data->name }}@else{{ old('name') }}@endif" required="true"/>
                                @if( $errors->first('name') )
                                    <div class = "alert alert-danger">
                                        {!! $errors->first('name') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                @if ( isset($data->status) && $data->status == 0 ) 
                                   <select name="status" required="true">
                                        <option value="0">Active</option>
                                        <option value="1">Deactivate</option>
                                    </select>
                                @else
                                    <select name="status" required="true">
                                        <option value="1">Deactive</option>
                                        <option value="0">Active</option>
                                    </select>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">
                                <input type="submit" class="btn btn-success"/>
                            </div>
                            <div class="span9">
                                @if(Session::has('flash_message'))
                                    <div class="alert alert-error alert-{!! @Session::get('flash_level') !!}">
                                        {!! @Session::get('flash_message') !!}
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                    {!! Form::close() !!}
                    <div class="clear"></div>
                </div>
            </div>
</div>

@stop