@extends('Admin.zlayouts.index')

@section('title', 'Category')

@section('breadline')
    <li><a href="{{ url('admin/category') }}">List Categories</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/category/search', 'method' => 'get')) }}

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! Form::text('search', null, array('required', 'class'=>'span11', 'placeholder'=>'Search for a category...')) !!}
        {!! Form::submit('Search', array('class'=>'btn btn-default')) !!}

    {{ Form::close() }}
@stop

@section('content')
    <div class="row-fluid">

        <div class="span12">

            <div class="head">
                <div class="isw-grid"></div>
                <h1>Category Management</h1>

                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                <a href="{{ url('admin/category/create') }}" class="btn btn-add">Add Category</a>
                {{ Form::open(array('url' => 'admin/category/bulkAction', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"/></th>
                            <th width="15%" class="sorting"><a href="#">ID</a></th>
                            <th width="35%" class="sorting"><a href="#">Name</a></th>
                            <th width="20%" class="sorting"><a href="#">Activate</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Created</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Updated</a></th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($datas as $indexKey => $category)
                        <tr>
                            <td><input type="checkbox" name="cb[{{ $category->id }}]"/></td>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            @if( $category->status == 0 )
                                <td><span class="text-success">Actived</span></td>
                            @else
                                <td><span class="text-error">Deactived</span></td>
                            @endif
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td><a href="{{ url('admin/category/' . $category->id . '/edit') }}" class="btn btn-info">Edit</a></td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <div class="bulk-action">
                        <input class="btn btn-success" type="submit" name="active" value="Active">
                        <input class="btn btn-danger" type="submit" name="deactive" value="Deactive">
                    </div><!-- /bulk-action-->
                {{ Form::close() }}
                </form>
                    {{ $datas->render() }}
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
        @if (session('status_error'))
            <div class="alert alert-danger" id="danger-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Deactive category failed! Category had product.</strong>
            </div>
        @endif
    </div>
@stop