@extends('Admin.zlayouts.index')

@section('title', 'User')

@section('breadline')
    <li><a href="{{ url('admin/user') }}">List Users</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/user/search', 'method' => 'get')) }}
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <div class="row-fluid search_form">
            <div class="span4">
                <input type="radio" id="search_name" name="search_type" value="username" checked="checked" onclick="generateName()"> Name
                <div id="form_name">
                    @if( isset($_GET['name']) )
                        {!! Form::text('name', $_GET['name'], array('required', 'class'=>'span11', 'placeholder'=>'Search by name of user...')) !!}
                    @else
                        {!! Form::text('name', null, array('required', 'class'=>'span11', 'placeholder'=>'Search by name of user...')) !!}
                    @endif
                </div>
            </div>
            <div class="span4">
                <div id="form_status">
                    <input type="radio" id="search_status" name="search_type" value="status" onclick="generateStatus()"> Status<br>
                    <select name='status' id="status_select" onchange="setSelectedStatus()">
                        <option value='active'>Active</option>
                        <option value='deactive'>Deactive</option>
                    </select>
                </div>
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
                <h1>Users Management</h1>
                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                    <div class="row-fluid">
                        @if( isset($isAdmin) && $isAdmin == 1 )
                            <div class="span3">
                                <a href="{{ url('admin/user/create') }}" class="btn btn-add">Add User</a>
                            </div>
                        @endif
                        <div class="span9" style="text-align: left; padding-top: 15px">
                            @if(isset($search_message))
                                 <span class="search_message">
                                    ___{{ $search_message }}___
                                </span>
                            @endif
                        </div>
                    </div>
                    @if(Session::has('flash_message'))
                         <div class="message alert alert-{!! @Session::get('flash_level') !!}">
                            {!! @Session::get('flash_message') !!}
                        </div>
                    @endif
                {{ Form::open(array('url' => 'admin/user/bulkAction', 'method' => 'POST' )) }}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover" id="myTable">
                        <tr>
                            <th><input type="checkbox" id="select_all"/></th>
                            <th width="15%" class="sorting" id="id">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'ID', array_merge(Request::all(), ['sortBy'=>'id', 'order'=>$order])) !!}</th>
                            @endif
                            <th width="35%" class="sorting" id="username" onclick="sortTable(1)">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Username', array_merge(Request::all(), ['sortBy'=>'username', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Username', array_merge(Request::all(), ['sortBy'=>'username', 'order'=>$order])) !!}</th>
                            @endif
                            </th>
                            <th width="20%" class="sorting" id="status">
                            @if(isset($_GET['search_type']))
                                {!! link_to_route('user.search', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @else
                                {!! link_to_route('user.index', 'Status', array_merge(Request::all(), ['sortBy'=>'status', 'order'=>$order])) !!}</th>
                            @endif
                            </a></th>
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
                        @foreach ($datas as $indexKey => $user)
                        <tr>
                            <td><input type="checkbox" name="cb[{{ $user->id }}]"/></td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            @if( $user->status == 0 )
                                <td><span class="text-success">Actived</span></td>
                            @else
                                <td><span class="text-error">Deactived</span></td>
                            @endif
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td><a href="{{ url('admin/user/' . $user->id . '/edit') }}" class="btn btn-info">Edit</a></td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="bulk-action">
                        <input class="btn btn-success" type="submit" name="active" value="Active">
                        <input class="btn btn-danger" type="submit" name="deactive" value="Deactive">
                    </div><!-- /bulk-action-->
                {{ Form::close() }}
                </form>
                {{ $datas->appends(['search'])->links() }}
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
@stop
