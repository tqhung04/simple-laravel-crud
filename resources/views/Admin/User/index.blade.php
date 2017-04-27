@extends('Admin.zlayouts.index')

@section('title', 'User')

@section('breadline')
    <li><a href="{{ url('admin/user') }}">List Users</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/user/search', 'method' => 'get')) }}
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
                <h1>Users Management</h1>
                <div class="clear"></div>
            </div>

            <div class="block-fluid table-sorting">
                    <div class="row-fluid">
                        <div class="span3">
                            <a href="{{ url('admin/user/create') }}" class="btn btn-add">Add User</a>
                        </div>
                        <div class="span9" style="text-align: left; padding-top: 15px">
                            @if(isset($search_message))
                                 <span class="">
                                    ___{{ $search_message }}___
                                </span>
                            @endif
                        </div>
                    </div>
                {{ Form::open(array('url' => 'admin/user/bulkAction', 'method' => 'POST' )) }}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover" id="myTable">
                        <tr>
                            <th><input type="checkbox" id="select_all"/></th>
                            <th width="15%" class="sorting"><a href="{{ url('admin/user') }}">ID</a></th>
                            <th width="35%" class="sorting" id="username" onclick="sortTable(1)">Username</th>
                            <th width="20%" class="sorting" id="active"><a href="#">Activate</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Created</a></th>
                            <th width="10%" class="sorting"><a href="#">Time Updated</a></th>
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
                        @if (session('bulk_error'))
                            <div class="alert alert-danger" id="danger-alert">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <strong>No row selected</strong>
                            </div>
                        @endif
                    </div><!-- /bulk-action-->
                {{ Form::close() }}
                </form>
                {{-- {{ $datas->render() }} --}}
                {{ $datas->appends(['search'])->links() }}
                {{-- {{ $datas->fragment('search')->links() }} --}}
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
@stop