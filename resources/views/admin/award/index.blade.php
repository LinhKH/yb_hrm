@extends('admin.layout')
@section('title','Awards')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Awards @endslot
        @slot('add_btn') <a href="{{url('admin/awards/create')}}" type="button" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Awards @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Award Name','Employee Name','Cash Prize','Award Item','On Date','Action']
    ])
        @slot('table_id') awards-list @endslot
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
    var table = $("#awards-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "awards",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth:'40px'},
            {data: 'award_name', name: 'award_name'},
            {data: 'emp_name', name: 'emp_name'},
            {data: 'cash_price', name: 'cash_price'},
            {data: 'item', name: 'item'},
            {data: 'date', name: 'date'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                sWidth:'100px'
            }
        ]
    });
</script>
@stop