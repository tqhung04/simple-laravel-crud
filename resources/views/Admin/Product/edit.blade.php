@extends('zlayouts.master')

@section('title', 'Create Product')

@section('breadline')
<li><a href="{{ url('admin/product') }}">List Products</a> <span class="divider">></span></li>
<li class="active">Add</li>
@stop

@section('content')

<div class="row-fluid">
            <div class="span12">
                <div class="head">
                    <div class="isw-grid"></div>
                    <h1>Users Management</h1>

                    <div class="clear"></div>
                </div>
                <div class="block-fluid">
                {!! Form::open(['action' => ['ProductController@update', $product->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row-form">
                            <div class="span3">Product Name:</div>
                            <div class="span9">
                                {{ Form::text('name', $product->name, array('placeholder'=>'some text value...')) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Price:</div>
                            <div class="span9">{{ Form::text('price', $product->price, array('placeholder'=>'some text value...')) }}</div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Description:</div>
                            <div class="span9">{{ Form::textarea('description', $product->description, array('placeholder'=>'some text value...')) }}</div>
                            <div class="clear"></div>
                        </div>
                        <div class="row-form">
                            <div class="span3">Category:</div>
                            <div class="span9">
                                {{ Form::select('category', $categoryList) }}
                            </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Upload Image:</div>
                            <div class="span9">
                                @if($product->image)
                                    <img src="{{ asset("upload/$product->image") }}" alt="{{ $product->image }}" width="50px" height="50px">
                                @endif
                                {{ Form::file('image', null) }}
                                </div>
                            <div class="clear"></div>
                        </div> 
                        <div class="row-form">
                            <div class="span3">Activate:</div>
                            <div class="span9">
                                {{ Form::select('status', ['0' => 'Active', '1' => 'Deactivate']) }}
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