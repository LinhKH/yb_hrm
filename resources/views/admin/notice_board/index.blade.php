@extends('admin.layout')
@section('title','Notice Board')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Notice Board @endslot
        @slot('add_btn') <a href="{{url('admin/notice_board/create')}}" type="button" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Notice Board @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Title','Status','Action']
    ])
        @slot('table_id') notice_board-list @endslot
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
    var table = $("#notice_board-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "notice_board",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'title', name: 'title'},
            {data: 'status', name: 'status',sWidth: '60px'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: true,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop