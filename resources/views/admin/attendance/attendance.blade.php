@extends('admin.layout')
@section('title','Attendance')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Attendance @endslot
        @slot('add_btn') @endslot
        @slot('active') Attendance @endslot
    @endcomponent
    <!-- /.content-header -->
    <div class="card">
        <div class="card-body">
            <form class="form-horizontal row">
                <div class="col-md-3 form-group">
                    <label for="">Employee Name</label>
                    <select class="form-control" id="attendance-employee">
                    <option value="all" selected>All</option>
                    @if(!empty($employees))
                            @foreach($employees as $emp)
                            <option value="{{$emp->id}}" >{{$emp->emp_name}}</td></option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="">Select Month</label>
                    <select class="form-control" id="attendance-month">
                        @php $cur_month = date('m'); @endphp
                        <option value="1" @php echo ($cur_month == '1')? 'selected' : ''; @endphp>Jan</option>
                        <option value="2" @php echo ($cur_month == '2')? 'selected' : ''; @endphp>Feb</option>
                        <option value="3" @php echo ($cur_month == '3')? 'selected' : ''; @endphp>March</option>
                        <option value="4" @php echo ($cur_month == '4')? 'selected' : ''; @endphp>April</option>
                        <option value="5" @php echo ($cur_month == '5')? 'selected' : ''; @endphp>May</option>
                        <option value="6" @php echo ($cur_month == '6')? 'selected' : ''; @endphp>June</option>
                        <option value="7" @php echo ($cur_month == '7')? 'selected' : ''; @endphp>July</option>
                        <option value="8" @php echo ($cur_month == '8')? 'selected' : ''; @endphp>Aug</option>
                        <option value="9" @php echo ($cur_month == '9')? 'selected' : ''; @endphp>Sep</option>
                        <option value="10" @php echo ($cur_month == '10')? 'selected' : ''; @endphp>Oct</option>
                        <option value="11" @php echo ($cur_month == '11')? 'selected' : ''; @endphp>Nov</option>
                        <option value="12" @php echo ($cur_month == '12')? 'selected' : ''; @endphp>Dec</option>
                    </select>
                </div>
                <div class="col-md-3 form-group" id="attendance-year">
                    <label for="">Select Year</label>
                    <select class="form-control">
                        <?php for($year = 2022;$year<=2050;$year++){ ?>
                            <option value="<?php echo $year; ?>" @php echo (date("Y") == $year)? 'selected' : ''; @endphp>{{$year}}</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 form-group mt-2 mb-0">
                    <label for=""></label>
                <button type="button" class="btn btn-success btn-block filter-attendance"">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive attendance-card">
            <table class="table" id="attendance-view">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/responsive.bootstrap4.min.js')}}"></script>

@stop