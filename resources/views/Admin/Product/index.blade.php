@extends('Admin.zlayouts.index')

@section('title', 'Product')

@section('breadline')
<li><a href="{{ url('admin/product') }}">List Products</a> <span class="divider"></span></li>
@endsection

@section('search')
    {{ Form::open(array('url' => 'admin/product/search', 'method' => 'get')) }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        @if( isset($_GET['search']) )
            {!! Form::text('search', $_GET['search'], array('required', 'class'=>'span11', 'placeholder'=>'Search for a user...')) !!}
        @else
            {!! Form::text('search', null, array('required', 'class'=>'span11', 'placeholder'=>'Search for a user...')) !!}
        @endif
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
                <a href="{{ url('admin/product/create') }}" class="btn btn-add">Add Product</a>
                {{ Form::open(array('url' => 'admin/product/action', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all" name="select_all"/></th>
                            <th width="10%" class="sorting"><a href="#">No</a></th>
                            <th width="30%" class="sorting"><a href="#">Product Name</a></th>
                            <th width="15%" class="sorting"><a href="#">Price</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Created</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Updated</a></th>
                            <th width="10%" class="sorting"><a href="#">Active</a></th>
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
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            @if( $product->status == 0 )
                                <td><span class="text-success">Actived</span></td>
                            @else
                                <td><span class="text-error">Deactived</span></td>
                            @endif
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