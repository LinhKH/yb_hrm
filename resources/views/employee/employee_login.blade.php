<!doctype html>
<html lang="en-US">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition login-page bg-white">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"> <b>{{$siteInfo[0]->com_name}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body bg-light">
                <form id="employeeLogin" class="" method="POST">
                   @csrf
                   <input type="hidden" class="url" value="{{url('employee/login')}}">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" placeholder="Enter Your Email">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-info btn-block mb-2">LogIn</button>
                        </div>
                        <div class="col-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(Session::has('EmployeeError'))
                                <div class="alert alert-danger">
                                    {{Session::get('EmployeeError')}}
                                </div>
                            @endif
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
   
    <script src="{{asset('assets/js/additional-methods.min.js')}}"></script>
    <script src="{{asset('assets/js/employee.js')}}"></script>
</body>

