@extends('admin.layout')
@section('title','Designations')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Designations @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') Designations @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Designation','Department','Action']
    ])
        @slot('table_id') designation-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Designation Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form  id="add_designation" method="POST" >
                    <div class="modal-body">
                        <input type="hidden" class="url" value="{{url('admin/designations')}}" >
                        <div class="form-group">
                            <label>Designation Name</label>
                            <input type="text" name="designation" class="form-control" placeholder="Enter Designation Name">
                        </div>
                        <div class="form-group ">
                            <label> Department </label>
                            <select name="department" class="form-control">
                                <option value="0" selected disabled>Select Department</option>    
                                @if(!empty($department))
                                    @foreach($department as $types)
                                        <option value="{{$types->department_id}}">{{$types->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Designation Edit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form  id="edit_designation" method="POST" >
                    <div class="modal-body">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="form-group">
                            <label>Designation Name</label>
                            <input type="hidden" class="u-url" value="{{url('admin/designations')}}" >
                            <input type="text" name="designation" class="form-control"  placeholder="Enter Designation Name">
                            <input type="hidden" name="id">
                        </div>
                        <div class="form-group ">
                            <label> Department </label>
                            <select name="department" class="form-control">
                                <option value="0" selected disabled>Select Department</option>    
                                @if(!empty($department))
                                    @foreach($department as $types)
                                        <option value="{{$types->department_id}}">{{$types->name}}</option>
                                    @endforeach
                                @endif 
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#designation-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "designations",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'department', name: 'department'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });
</script>

@stop