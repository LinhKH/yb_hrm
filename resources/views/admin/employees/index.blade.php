@extends('admin.layout')
@section('title','Employees')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Employees @endslot
        @slot('add_btn') <a href="{{url('admin/employees/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Employees @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['Employee Id','Image','Name','Department','Designation','At Work','Status','Action']
    ])
        @slot('table_id') employees-list @endslot
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
    var table = $("#employees-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "employees",
        columns: [
            {data: 'employeeId', name: 'DT_RowIndex'},
            {data: 'image', name: 'image'},
            {data: 'emp_name', name: 'name'},
            {data: 'department_name', name: 'department'},
            {data: 'designation_name', name: 'designation'},
            {data: 'at_work', name: 'at_work'},
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