@extends('Admin.zlayouts.index')

@section('title', 'Product')

@section('breadline')
<li><a href="{{ url('admin/product') }}">List Products</a> <span class="divider"></span></li>
@endsection

@section('search')
    {{ Form::open(array('url' => 'admin/product/search', 'method' => 'get')) }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="radio" id="search_name" name="search_type" value="name" checked="checked" onclick="generateName()"> Name
        <input type="radio" id="search_price" name="search_type" value="price" onclick="generatePrice()"> Price
        <input type="radio" id="search_status" name="search_type" value="status" onclick="generateStatus()"> Status<br>
        <div id="form_generate">
            <div id="form_name">
                @if( isset($_GET['name']) )
                    {!! Form::text('name', $_GET['name'], array('required', 'class'=>'span11', 'placeholder'=>'Search by name of product...')) !!}
                @else
                    {!! Form::text('name', null, array('required', 'class'=>'span11', 'placeholder'=>'Search by name of product...')) !!}
                @endif
            </div>
            <div id="form_price">
                <select name='price' id="price_select" onchange="setSelectedPrice()">
                    <option value='<100000'>< 100000 VNĐ</option>
                    <option value='10000~500000'>10000~500000 VNĐ</option>
                    <option value='>500000'> > 500000 VNĐ</option>
                </select>
            </div>
            <div id="form_status">
                <select name='status' id="status_select" onchange="setSelectedStatus()">
                    <option value='active'>Active</option>
                    <option value='deactive'>Deactive</option>
                </select>
            </div>
        </div>
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}
        {{ Form::close() }}
@stop

@section('content')

    <div class="row-fluid">
        <div class="span12">

            <div class="head">
                <div class="isw-grid"></div>
                <h1>Product Management</h1>
                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                <div class="row-fluid">
                    <div class="span3">
                        <a href="{{ url('admin/product/create') }}" class="btn btn-add">Add Product</a>
                    </div>
                    <div class="span9" style="text-align: left; padding-top: 15px">
                        @if(isset($search_message))
                             <span class="search_message">
                                ___{{ $search_message }}___
                            </span>
                        @endif
                    </div>
                </div>
                {{ Form::open(array('url' => 'admin/product/action', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" name="select_all"/></th>
                            <th width="10%" class="sorting" id="id">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="30%" class="sorting" id="name">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'Name', array_merge(Request::all(), ['sortBy'=>'name', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'Name', array_merge(Request::all(), ['sortBy'=>'name', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="15%" class="sorting" id="price">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'Price', array_merge(Request::all(), ['sortBy'=>'price', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'Price', array_merge(Request::all(), ['sortBy'=>'price', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="20%" class="sorting" id="status">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
                            <th width="10%" class="sorting" id="created_at">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'Time Created', array_merge(Request::all(), ['sortBy'=>'created_at', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'Time Created', array_merge(Request::all(), ['sortBy'=>'created_at', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
                            <th width="10%" class="sorting" id="updated_at">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('product.search', 'Time Updated', array_merge(Request::all(), ['sortBy'=>'updated_at', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('product.index', 'Time Updated', array_merge(Request::all(), ['sortBy'=>'updated_at', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datas as $indexKey => $product)
                        <tr>
                            <td><input type="checkbox" name="cb[{{ $product->id }}]"/></td>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }} VNĐ</td>
                            @if( $product->status == 0 )
                                <td><span class="text-success">Actived</span></td>
                            @else
                                <td><span class="text-error">Deactived</span></td>
                            @endif
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td><a href="{{ url('admin/product/' . $product->id . '/edit') }}" class="btn btn-info">Edit</a></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="bulk-action">
                        <input class="btn btn-success" type="submit" name="active" value="Active">
                        <input class="btn btn-danger" type="submit" name="deactive" value="Deactive">
                    </div>
                {{ Form::close() }}
                </form>
                    {{ $datas->render() }}
                </div>
                    @if(Session::has('flash_message'))
                        <div class="message alert alert-{!! @Session::get('flash_level') !!}">
                            {!! @Session::get('flash_message') !!}
                        </div>
                    @endif
                <div class="clear"></div>
            </div>

        </div>
    </div>
@endsection