@extends('Admin.zlayouts.index')

@section('title', 'User')

@section('breadline')
    <li><a href="{{ url('admin/user') }}">List Users</a></li>
@stop

@section('search')
    {{ Form::open(array('url' => 'admin/user/search', 'method' => 'get')) }}

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! Form::text('search', null, array('required', 'class'=>'span11', 'placeholder'=>'Search for a user...')) !!}
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
                <a href="{{ url('admin/user/create') }}" class="btn btn-add">Add User</a>
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
                    </div><!-- /bulk-action-->
                {{ Form::close() }}
                </form>
                    {{ $datas->render() }}
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <script>
        function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("myTable");
          switching = true;
          //Set the sorting direction to ascending:
          dir = "asc"; 
          /*Make a loop that will continue until
          no switching has been done:*/
          while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("tr");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
              //start by saying there should be no switching:
              shouldSwitch = false;
              /*Get the two elements you want to compare,
              one from current row and one from the next:*/
              x = rows[i].getElementsByTagName("td")[n];
              y = rows[i + 1].getElementsByTagName("td")[n];
              /*check if the two rows should switch place,
              based on the direction, asc or desc:*/
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  //if so, mark as a switch and break the loop:
                  shouldSwitch= true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  //if so, mark as a switch and break the loop:
                  shouldSwitch= true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              /*If a switch has been marked, make the switch
              and mark that a switch has been done:*/
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              //Each time a switch is done, increase this count by 1:
              switchcount ++; 
            } else {
              /*If no switching has been done AND the direction is "asc",
              set the direction to "desc" and run the while loop again.*/
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
              }
            }
          }
        }
        </script>
@stop