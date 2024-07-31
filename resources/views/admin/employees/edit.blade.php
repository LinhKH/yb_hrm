@extends('admin.layout')
@section('title','Edit Employee')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Employees'=>'admin/employees']])
    @slot('title') Edit Employees @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Employees @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updateEmployee"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($employees)
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <input type="hidden" class="url" value="{{url('admin/employees/'.$employees->id)}}" >
                    <input type="hidden" class="rdt-url" value="{{url('admin/employees')}}" >
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Personal Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-md-2">Image <small class="text-danger">*</small></label>
                                <div class="custom-file col-md-7">
                                    <input type="hidden" class="custom-file-input" name="old_img" value="{{$employees->emp_image}}" />
                                    <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <div class="col-md-3 text-right">
                                    @if($employees->emp_image != '')
                                    <img id="image" src="{{asset('employees/'.$employees->emp_image)}}" alt="" width="80px" height="80px">
                                    @else
                                    <img id="image" src="{{asset('employees/default.png')}}" alt="" width="80px" height="80px">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Employee Name <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="emp_name" placeholder="Name" value="{{$employees->emp_name}}">
                            </div>
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Phone Number <small class="text-danger">*</small></label>
                                <div class="input-group" >
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" value="{{$employees->emp_phone}}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gender </label>
                                <select class="form-control" name="gender"  style="width: 100%;">
                                    <option value="male" {{($employees->emp_gender == "male" ? "selected":"")}}>Male</option>
                                    <option value="female" {{($employees->emp_gender == "female" ? "selected":"")}}>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" value="{{$employees->emp_dob}}" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Local Address</label>
                                <textarea name="local_address" class="form-control">{{$employees->local_address}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Permanent Address</label>
                                <textarea name="per_address" class="form-control">{{$employees->per_address}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Email address <small class="text-danger">*</small></label>
                                <input type="email" class="form-control" name="email" value="{{$employees->emp_email}}" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password <small class="text-danger">*</small></label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <small class="text-danger">(Leave password empty if not change in password.)</small>
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
                            @if(!empty($documents))
                                @foreach($documents as $data)
                                    @if($data->resume != '')
                                        @php $resume = $data->resume @endphp
                                    @endif
                                    @if($data->offer_letter != '')
                                        @php $offer_letter = $data->offer_letter @endphp
                                    @endif
                                    @if($data->joining_letter != '')
                                        @php $join_letter = $data->joining_letter @endphp
                                    @endif
                                    @if($data->id_proof != '')
                                        @php $id_proof = $data->id_proof @endphp
                                    @endif
                                @endforeach
                                
                            @endif
                            <div class="form-group">
                                <label>Resume</label>
                                <div class="custom-file">
                                    <input type="hidden" class="custom-file-input" name="old_resume" value="" />
                                    <input type="file" class="custom-file-input" name="resume" onChange="readURL(this);">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                @if(isset($resume))
                                <div class="mt-2 p-2">
                                    <a href="https://docs.google.com/viewer?url={{asset('documents/'.$resume)}}" class="btn btn-primary" target="_blank">View File</a>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Offer Letter</label>
                                <div class="custom-file">
                                    <input type="hidden" class="custom-file-input" name="old_offer_letter" value=""/>
                                    <input type="file" class="custom-file-input" name="offer_letter"  onChange="readURL(this);">
                                    <label class="custom-file-label">Choose file</label> 
                                </div>
                                @if(isset($offer_letter))
                                <div class="mt-2 p-2">
                                    <a href="https://docs.google.com/viewer?url={{asset('documents/'.$offer_letter)}}" class="btn btn-primary" target="_blank">View File</a>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Joining Letter</label>
                                <div class="custom-file">
                                    <input type="hidden" class="custom-file-input" name="old_join_letter" value="" />
                                    <input type="file" class="custom-file-input" name="join_letter" >
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                @if(isset($join_letter))
                                <div class="bg-secondary mt-2 p-2">
                                    <a href="https://docs.google.com/viewer?url={{asset('documents/'.$join_letter)}}" class="btn btn-primary" target="_blank">View File</a>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>ID proof</label>
                                <div class="custom-file">
                                    <input type="hidden" class="custom-file-input" name="old_id_proof" value=""/>
                                    <input type="file" class="custom-file-input" name="id_proof">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                @if(isset($id_proof))
                                <div class="mt-2 p-2">
                                    <a href="https://docs.google.com/viewer?url={{asset('documents/'.$id_proof)}}" class="btn btn-primary" target="_blank">View File</a>
                                </div>
                                @endif
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
                                <input type="text" class="form-control" value="{{$employees->employeeId}}" placeholder="Enter Employee ID" disabled>
                            </div>
                            <div class="form-group">
                                <label>Department Name <small class="text-danger">*</small></label>
                                <select class="form-control emp-department" name="department">
                                    <option disabled >Select The Department</option>
                                        @if(!empty($departments))
                                            @foreach($departments as $types)
                                                @if($employees->emp_department == $types->department_id)
                                                    <option value="{{$types->department_id}}" selected>{{$types->name}}</option>
                                                    @else
                                                    <option value="{{$types->department_id}}">{{$types->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif 
                               </select>
                            </div>
                            <div class="form-group">
                                <label>Designation <small class="text-danger">*</small></label>
                                <select class="form-control emp-designation" name="designation">
                                    <option disabled >Select The Designation</option>
                                        @if(!empty($designations))
                                            @foreach($designations as $types)
                                                @if($employees->emp_designation == $types->id)
                                                <option value="{{$types->id}}" selected>{{$types->name}}</option>
                                                @else
                                                <option value="{{$types->id}}">{{$types->name}}</option>
                                                @endif
                                          @endforeach
                                        @endif
                                    </select>
                            </div>
                            <div class="form-group">
                                <label>Date Of Joining <small class="text-danger">*</small></label>
                                <input type="date" name="join_date" class="form-control" value="{{$employees->date_of_joining}}"/>
                            </div>
                            <div class="form-group">
                                <label>Joining Salary <small class="text-danger">*</small></label>
                                <input type="text" class="form-control" name="join_salary" value="{{$employees->joining_salary}}" placeholder="Current Salary">
                            </div>
                         </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Bank Account Details</h3>
                        </div>
                        <div class="card-body">
                            @php
                            $holder = $acc_no = $bank_name = $ifsc_code = $pan_no = $branch = '';
                            @endphp
                            @if(!empty($BankDetail))
                                @foreach($BankDetail as $bank)
                                    @php
                                    $holder = $bank->acc_name;
                                    $acc_no = $bank->acc_no;
                                    $bank_name = $bank->bank_name;
                                    $ifsc_code = $bank->ifsc_code;
                                    $pan_no = $bank->pan_number;
                                    $branch = $bank->branch_location;
                                    @endphp
                                @endforeach
                            @endif
                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input type="text" class="form-control" name="holder_name" value="{{$holder}}"placeholder="Enter Account Holder Name">
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" class="form-control" name="acc_number" value="{{$acc_no}}" placeholder="Enter Account Number">
                            </div>
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" value="{{$bank_name}}" placeholder="Enter Bank Name">
                            </div>
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input type="text" class="form-control" name="ifsc_code" value="{{$ifsc_code}}" placeholder="Enter IFCS Code">
                            </div>
                            <div class="form-group">
                                <label>Pan Number</label>
                                <input type="text" class="form-control" name="pan_no" value="{{$pan_no}}" placeholder="Enter Pan Number">
                            </div>
                            <div class="form-group">
                                <label>Branch Location</label>
                                <input type="text" class="form-control" name="branch_loc" value="{{$branch}}" placeholder="Enter Branch Location">
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            @endif
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