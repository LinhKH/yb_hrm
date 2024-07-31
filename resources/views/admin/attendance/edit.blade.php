@extends('admin.layout')
@section('title','Edit Attendance')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Attendance'=>'admin/attendance']])
    @slot('title') Mark Attendance @endslot
    @slot('add_btn') @endslot
    @slot('active') Mark Attendance @endslot
    @endcomponent
    <!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h4 class="m-0 d-inline-block float-left">Date : {{date('d M, Y',strtotime($date))}}</h4>
            <form id="editAttendance" action="{{url('admin/attendance')}}"></form>
            <input class="form-control d-inline-block w-auto float-right date-attendance" type="date"
                value="@php echo date('Y-m-d',strtotime($date)) @endphp">
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table id="attendanceAjax" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Attendance</th>
                        <th>Clock In / Clock Out</th>
                        <th>Save</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Attendance</th>
                        <th>Clock In / Clock Out</th>
                        <th>Save</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-footer text-center">
            <button class="btn btn-info save-all-attendance" data-url="{{url('admin/attendance/'.$date)}}">Save All <i
                    class="fa fa-check"></i></button>
        </div>
    </div>
    <!-- /.card -->
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#attendanceAjax").DataTable({
        scrollY: "640px",
        processing: true,
        serverSide: true,
        bPaginate: false,
        bInfo : false,
        ajax: {
          url: "{{url('admin/attendance/attendance-ajax')}}",
          data: function (d) {
                d.date = $('.date-attendance').val();
            }
        },
        columns: [
            {data: 'employeeId', name: 'employeeId',sWidth: '250px'},
            {data: 'status', name: 'status'},
            {data: 'attendance', name: 'attendance',sWidth: '80px'},
            {data: 'clock-in', name: 'clock-in',sWidth: '300px',orderable: false,searchable: false,},
            {
                data: 'save',
                name: 'save',
                orderable: false,
                searchable: false,
                sWidth: '20px'
            }
        ]
    });
</script>
@stop