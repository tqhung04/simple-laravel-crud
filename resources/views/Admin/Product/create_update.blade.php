@extends('Admin.zlayouts.index')

@section('title', 'Product')

@section('breadline')
<li><a href="{{ url('admin/product') }}">List Products</a> <span class="divider">></span></li>
<li class="active">
    @if(isset($product))
        Update
    @else
        Create
    @endif
</li>
@endsection

@section('content')

<div class="row-fluid">
    <div class="span12">
        <div class="head">
            <div class="isw-grid"></div>
            <h1>Product Management</h1>
            <div class="clear"></div>
        </div>
        <div class="block-fluid">
            @if(isset($product->id))
                {!! Form::open(['action' => ['Admin\ProductController@update', $product->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
            @else
                {!! Form::open(['action' => 'Admin\ProductController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'files'=>true]) !!}
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row-form">
                    <div class="span3">Product Name:</div>
                    <div class="span9">
                        <input type="text" name="name" placeholder="some text value" value="@if(isset($product->name)){{ $product->name }}@endif" required="true"/>
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="row-form">
                    <div class="span3">Price:</div>
                    <div class="span9">
                        <input type="text" name="price" placeholder="some text value" value="@if(isset($product->price)){{ $product->price }}@endif" required="true"/>
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="row-form">
                    <div class="span3">Description:</div>
                    <div class="span9">
                        <textarea name="description" placeholder="some text value"/>@if(isset($product->description)){{ $product->description }}@endif</textarea>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="row-form">
                    <div class="span3">Category:</div>
                    <div class="span9">
                        <select name="category" required="true">
                            @if (isset($current_category))
                                @foreach($current_category as $key => $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            @endif
                            @foreach($active_categories as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="row-form">
                    <div class="span3">Upload Image:</div>
                    <div class="span9">
                        <div id="files">
                            <input type="file" name="images[]" id="upload_file" onchange="preview_image()" multiple="true"/>
                        </div>
                        <div id="image_preview">
                            @if(isset($images))
                                @foreach($images as $image)
                                    <img src="{{ asset("upload/product/$image") }}" alt="{{ $image }}" width="50px" height="50px">
                                @endforeach
                            @else
                                <img src="{{ asset("upload/product/default.jpg") }}" alt="default" width="50px" height="50px">
                            @endif
                        </div>
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="row-form">
                    <div class="span3">Activate:</div>
                    <div class="span9">
                        @if ( isset($product->status) && $product->status == 0 ) 
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
                        <input type="submit" class="btn btn-success">
                    </div>
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

@endsection