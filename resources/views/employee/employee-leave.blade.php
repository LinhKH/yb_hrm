@extends('employee/layout') 
@section('title','My Leaves')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5">
   <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            @include('employee.components.sidebar')
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-server mr-1"></i>My Leave Applications</h3>
                            <button type="button" data-toggle="modal" data-target="#modal-default" class="float-right btn btn-sm btn-default">Add New</button> 
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="leave-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Date</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Date</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Apply Leave</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- form start -->
                                    <form  id="add_EmpLeave">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" class="url" value="{{url('employee/employee-leave')}}" >
                                            <div class="form-group">
                                                <label>Date:</label>
                                                <div class="input-group date" id="reservationdate_4" data-target-input="nearest">
                                                    <div class="input-group-append" data-target="#reservationdate_4" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                    <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label> Leave Type </label>
                                                <select name="leave" class="form-control">
                                                <option value="0" selected disabled>Select Leave Type</option>
                                                    @if(!empty($LeaveType))
                                                    @foreach($LeaveType as $types)
                                                        <option value="{{$types->id}}">{{$types->leave_type}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Reason</label>
                                                <input type="text" class="form-control" name="reason" placeholder="Enter Reason">
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
                        <div class="modal fade" id="view-application">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Leaves Application View</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" > 
                                        <span id="id"></span>
                                        <strong>Date :</strong>
                                        <span id="date"></span>
                                        <hr>
                                        <strong>Leave Type:</strong>
                                        <span id="leave_type"></span>
                                        <hr>
                                        <strong>Reason:</strong>
                                        <span id="reason"></span>
                                        <hr>
                                        <strong>Status:</strong>
                                        <span id="status"></span>
                                        <hr>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->    
                    </div>
                    <!-- /.card -->
                    <!--  Upcoming Holidays -->
                    <div class="card card-info">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-paper-plane mr-1"></i>Leaves Left</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            
                        @if(!empty($LeaveType))
                            @foreach($LeaveType as $types)
                                @if(count($employee_leaves) == 0)
                                    @php $remaining = $types->number_of_type @endphp
                                @else
                                    @foreach($employee_leaves as $leave)
                                        @if($leave->leave_type == $types->id)
                                            @php $remaining = $types->number_of_type - $leave->count @endphp
                                        @else
                                            @php $remaining = $types->number_of_type @endphp
                                        @endif
                                    @endforeach
                                @endif
                            <b>{{$types->leave_type}}</b> <a class="float-right">{{$remaining}}</a> 
                            <hr> 
                            @endforeach
                        @endif 
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>
<!-- /.row -->
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap4.min.js')}}"></script>

<script type="text/javascript">
     var table = $("#leave-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "my-leaves",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'date', name: 'date'},
            {data: 'leave_type', name: 'leave_type'},
            {data: 'reason', name: 'reason'},
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