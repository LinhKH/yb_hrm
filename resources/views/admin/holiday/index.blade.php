@extends('admin.layout')
@section('title','Holidays')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Holidays @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary">Add New</button> @endslot
        @slot('active') Holidays @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Date','Occasion','Action']
    ])
        @slot('table_id') holiday-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Holiday Add</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- form start -->
                <form  id="add_holiday" method="POST" >
                    <div class="modal-body">
                            @csrf
                        <input type="hidden" class="url" value="{{url('admin/holidays')}}" >
                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-group date" id="reservationdate_3"  data-target-input="nearest">
                                <div class="input-group-append" data-target="#reservationdate_3" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" name="holiday_date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Occasion</label>
                            <input type="text" name="occasion" class="form-control" placeholder="Enter Occasion Name">
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
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#holiday-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "holidays",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'date', name: 'date'},
            {data: 'occasion', name: 'occasion'},
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