@extends('admin.layout')
@section('title','Leave Applications')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Leave Applications @endslot
        @slot('add_btn') @endslot
        @slot('active') Leave Applications @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Name','Date','Leave Type','Reason','Applied On','Status','Action']
    ])
        @slot('table_id') leave-list @endslot
    @endcomponent
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
        ajax: "leave_application",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'emp_name', name: 'Name'},
            {data: 'date', name: 'date'},
            {data: 'leave_type', name: 'leave_type'},
            {data: 'reason', name: 'reason'},
            {data: 'created_at', name: 'Applied On'},
            {data: 'status', name: 'status'},
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