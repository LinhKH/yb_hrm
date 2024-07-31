@extends('admin.layout')
@section('title','Expenses')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Expenses @endslot
        @slot('add_btn') <a href="{{url('admin/expenses/create')}}" type="button" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Expenses @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Title','Date','Invoice','Amount','Action']
    ])
        @slot('table_id') expenses-list @endslot
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
    var table = $("#expenses-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "expenses",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'item_name', name: 'item_name'},
            {data: 'purchase_date', name: 'purchase_date'},
            {data: 'price_bill', name: 'price_bill',sWidth: '80px'},
            {data: 'amount', name: 'amount',sWidth: '80px'},
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