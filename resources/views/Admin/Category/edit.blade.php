@extends('zlayouts.master')

@section('title', 'Category')

@section('breadline')
<li><a href="{{ url('admin/category') }}">List Categories</a> <span class="divider">></span></li>
<li class="active">Update</li>
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
                    {!! Form::open(['action' => ['CategoryController@update', $category->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Category name:</div>
                            <div class="span9">
                                {{ Form::text('name', $category->name, array()) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                @if ( $category->status == 0 ) 
                                    {{ Form::select('status', ['0' => 'Active', '1' => 'Deactivate']) }}
                                @else
                                    {{ Form::select('status', ['1' => 'Deactive', '0' => 'Activate']) }}
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">{!! Form::submit('Update', array('class'=>'btn btn-success')) !!}</div>
                            <div class="span9">
                                @if (count($errors) > 0)
                                    <div class = "alert alert-danger">
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
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