@extends('Admin.zlayouts.index')

@section('title', 'Category')

@section('breadline')
    <li><a href="{{ url('admin/category') }}">List Categories</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/category/search', 'method' => 'get')) }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="radio" id="search_name" name="search_type" value="name" checked="checked" onclick="generateName()"> Name
        <input type="radio" id="search_status" name="search_type" value="status" onclick="generateStatus()"> Status<br>
        <div id="form_generate">
            <div id="form_name">
                @if( isset($_GET['name']) )
                    {!! Form::text('name', $_GET['name'], array('required', 'class'=>'span11', 'placeholder'=>'Search by name of category...')) !!}
                @else
                    {!! Form::text('name', null, array('required', 'class'=>'span11', 'placeholder'=>'Search by name of category...')) !!}
                @endif
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
                <h1>Category Management</h1>

                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                <div class="row-fluid">
                    <div class="span3">
                        <a href="{{ url('admin/category/create') }}" class="btn btn-add">Add Category</a>
                    </div>
                    <div class="span9" style="text-align: left; padding-top: 15px">
                        @if(isset($search_message))
                             <span class="search_message">
                                ___{{ $search_message }}___
                            </span>
                        @endif
                    </div>
                </div>
                {{ Form::open(array('url' => 'admin/category/bulkAction', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table" id="tSortable_2">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select_all"/></th>
                            <th width="15%" class="sorting" id="id">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @endif
                            <th width="35%" class="sorting" id="name">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Name', array_merge(Request::all(), ['sortBy'=>'name', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Name', array_merge(Request::all(), ['sortBy'=>'name', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="20%" class="sorting" id="status">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="10%" class="sorting" id="created_at">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Time Created', array_merge(Request::all(), ['sortBy'=>'created_at', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Time Created', array_merge(Request::all(), ['sortBy'=>'created_at', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
                            <th width="10%" class="sorting" id="updated_at">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Time Updated', array_merge(Request::all(), ['sortBy'=>'updated_at', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Time Updated', array_merge(Request::all(), ['sortBy'=>'updated_at', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
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
                 @if(Session::has('flash_message'))
                    <div class="message alert alert-{!! @Session::get('flash_level') !!}">
                        {!! @Session::get('flash_message') !!}
                    </div>
                @endif
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