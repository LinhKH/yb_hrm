@extends('admin.layout')
@section('title','Leave Types')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Leave Types @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary">Add New</button> @endslot
        @slot('active') Leave Types @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Leave Type','Number of Leaves','Action']
    ])
        @slot('table_id') leave-list @endslot
    @endcomponent
        
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Leaves Type Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="add_leave" method="POST" >
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" class="url" value="{{url('admin/leave_type')}}" >
                            <div class="form-group">
                                <label>Leave Type</label>
                                <input type="text" name="leave_type" class="form-control" placeholder="Enter Leave Type Name">
                            </div>
                            <div class="form-group ">
                                <label> Number Of Leave</label>
                                <input type="number" name="number_leave" class="form-control" placeholder="Enter Number Of Leave">
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
                        <h4 class="modal-title">Leaves Type Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="edit_leave" method="POST" >
                        <div class="modal-body">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label>Leave Type Name</label>
                                <input type="hidden" class="u-url" value="{{url('admin/leave_type')}}" >
                                <input type="text" name="leave_type" class="form-control"  placeholder="Enter Leaves Type Name">
                                <input type="hidden" name="id">
                            </div>
                            <div class="form-group ">
                                <label> Number Of Leave</label>
                                <input type="number" name="number_leave" class="form-control" placeholder="Enter Number Of Leave">
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
    var table = $("#leave-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "leave_type",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth:'40px'},
            {data: 'leave_type', name: 'leave_type'},
            {data: 'number_of_type', name: 'number_of_type'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop