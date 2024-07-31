@extends('employee/layout') 
@section('title','Dashboard')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
      @include('employee.components.sidebar')
        @foreach($data as $item)
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-user mr-1"></i>Personal Details</h3>
                </div>
                <!-- /.card-header -->
                <table class="card-body table">
                  <tr>
                    <td><strong>Name :</strong></td>
                    <td>{{$item->emp_name}}</td>
                  </tr>
                  <tr>
                    <td><strong>Date of Birth :</strong></td>
                    <td>{{date('d M, Y',strtotime($item->emp_dob))}}</td>
                  </tr>
                  <tr>
                    <td><strong>Gender :</strong></td>
                    <td>{{$item->emp_gender}}</td>
                  </tr>
                  <tr>
                    <td><strong>Email address :</strong></td>
                    <td>{{$item->emp_email}}</td>
                  </tr>
                  <tr>
                    <td><strong>Phone Number :</strong></td>
                    <td>{{$item->emp_phone}}</td>
                  </tr>
                  <tr>
                    <td><strong>Address :</strong></td>
                    <td>{{$item->emp_address}}</td>
                  </tr>
                </table>
                <!-- /.card-body -->
              </div>
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-briefcase mr-1"></i>Company Details</h3>
                </div>
                <table class="card-body table">
                  <tr>
                    <td><strong>Employee ID :</strong></td>
                    <td>{{$item->employeeId}}</td>
                  </tr>
                  <tr>
                    <td><strong>Department Name :</strong></td>
                    <td>{{$item->department}}</td>
                  </tr>
                  <tr>
                    <td><strong>Designation :</strong></td>
                    <td>{{$item->designation}}</td>
                  </tr>
                  <tr>
                    <td><strong>Date Of Joining :</strong></td>
                    <td>{{date('d M, Y',strtotime($item->date_of_joining))}}</td>
                  </tr>
                  <tr>
                    <td><strong>Joining Salary :</strong></td>
                    <td>{{$item->joining_salary}}</td>
                  </tr>
                </table>
                <!-- /.card-body -->
              </div>
              <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-briefcase mr-1"></i> Bank Account Details</h3>
                </div>
                @if(!empty($BankDetail))
                  @foreach($BankDetail as $types)
                    <table class="card-body table">
                      <tr>
                        <td><strong>Account Holder Name :</strong></td>
                        <td>{{$types->acc_name}}</td>
                      </tr>
                      <tr>
                        <td><strong>Account Number:</strong></td>
                        <td>{{$types->acc_no}}</td>
                      </tr>
                      <tr>
                        <td><strong>Bank Name :</strong></td>
                        <td>{{$types->bank_name}}</td>
                      </tr>
                      <tr>
                        <td><strong>IFSC Code :</strong></td>
                        <td>{{$types->ifsc_code}}</td>
                      </tr>
                      <tr>
                        <td><strong>Pan Number :</strong></td>
                        <td>{{$types->pan_number}}</td>
                      </tr>
                      <tr>
                        <td><strong>Branch Location :</strong></td>
                        <td>{{$types->branch_location}}</td>
                      </tr>
                    </table>
                  @endforeach
                @endif
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bullhorn mr-1"></i>Notice Board</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(!empty($NoticeBoard))
                      @foreach($NoticeBoard as $types)
                      <blockquote class="quote-info ml-0 mr-0 mt-0">
                        <small>{{date('d M, Y',strtotime($types->created_at))}}</small>
                        <h6>{{$types->title}}</h6>
                        <p> {!!htmlspecialchars_decode($types->description)!!}</p>
                      </blockquote>
                      @endforeach
                  @endif 
                </div>
              </div>
              <div class="card card-info"> <!--  Upcoming Holidays -->
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-paper-plane mr-1"></i> Upcoming Holidays</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  @if(!empty($Holidays))
                    @foreach($Holidays as $types)
                      <b>{{$types->occasion}}</b> <a class="float-right">{{date('d M, Y', strtotime($types->date))}}</a> 
                      <hr> 
                      @endforeach
                  @endif 
                </div>
                <!-- /.card-body -->
              </div>
              <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy mr-1"></i>Awards</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(!empty($Awards))
                      @foreach($Awards as $types)
                      <div class="callout callout-info bg-light">
                        <p class="m-0">{{ucfirst($types->award_name)}}</p>
                        <small>{{date('d M, Y',strtotime($types->created_at))}}</small>
                      </div>
                      @endforeach
                    @endif
                  </div> 
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop