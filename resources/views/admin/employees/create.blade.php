@extends('admin.layout')
@section('title','Add New Employee')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Employees'=>'admin/employees']])
    @slot('title') Add Employees @endslot
    @slot('add_btn')  @endslot
    @slot('active') Add Employees @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="addEmployee"  method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @if(count($departments) == 0)
                    <div class="alert alert-danger">First Add Departments</div>
                    @else
                        @if(count($designations) == 0)
                        <div class="alert alert-danger">First Add Designations</div>
                        @endif
                    @endif
                </div>
                <!-- left column -->
                <div class="col-md-6">
                   <input type="hidden" class="url" value="{{url('admin/employees')}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Personal Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2">Image </label>
                                <div class="custom-file col-md-7">
                                    <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <div class="col-md-3 text-right">
                                    <img id="image" src="{{asset('employees/default.png')}}" alt=""  width="80px" height="80px">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Name <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="emp_name" placeholder="Name">
                            </div>
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Phone <small class="text-danger">*</small></label>
                                <div class="input-group" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gender </label>
                                <select class="form-control" name="gender"  style="width: 100%;">
                                    <option value="male" selected>Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth </label>
                                <div class="input-group">
                                    <input type="date" name="dob" class="form-control" value="<?php echo date('Y-m-d');  ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Local Address </label>
                                <textarea name="local_address" class="form-control" ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Permanent Address </label>
                                <textarea name="per_address" class="form-control" ></textarea>
                            </div>
                            <div class="form-group">
                                <label>Email address <small class="text-danger">*</small></label>
                                <input type="email" class="form-control" name="email" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label>Password <small class="text-danger">*</small></label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Documents</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label>Resume</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="resume">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Offer Letter</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="offer_letter">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Joining Letter</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="join_letter">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>ID proof</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="id_proof">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Company Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Employee ID <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="employeeId" placeholder="Employee ID">
                            </div>
                            <div class="form-group">
                                <label>Department Name <small class="text-danger">*</small></label>
                                <select class="form-control emp-department" name="department">
                                    <option disabled selected value="" >Select The Department</option>
                                     @if(!empty($departments))
                                        @foreach($departments as $types)
                                            <option value="{{$types->department_id}}">{{$types->name}}</option> 
                                        @endforeach
                                    @endif 
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Designation <small class="text-danger">*</small></label>
                                <select class="form-control emp-designation" name="designation">
                                <option value="0" disabled selected>Select First Department</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date Of Joining <small class="text-danger">*</small></label>
                                <input type="date" name="join_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                            </div>
                            <div class="form-group">
                                <label>Joining Salary <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="join_salary" placeholder="Current Salary">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Bank Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input type="text" class="form-control" name="holder_name" placeholder="Enter Account Holder Name">
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="acc_number" placeholder="Enter Account Number">
                            </div>
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" placeholder="Enter Bank Name">
                            </div>
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" placeholder="Enter IFCS Code">
                            </div>
                            <div class="form-group">
                                <label>Branch Location</label>
                                <input type="text" class="form-control" name="branch_loc" placeholder="Enter Branch Location">
                            </div>
                            <div class="form-group">
                                <label>Pan Number</label>
                                <input type="text" class="form-control" name="pan_no" placeholder="Enter Pan Number">
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- right column -->
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop