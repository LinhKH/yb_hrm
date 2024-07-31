<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
     <link rel="stylesheet" href="{{asset('assets/fontawesome-free/css/all.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('assets/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/css/adminlte.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/daterangepicker/daterangepicker.css')}}">
    <!-- Style.CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
       <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-info">
            <div class="container-fluid">
            <!-- Left navbar links -->
                @foreach($siteInfo as $types)
                <a href="#" class="brand-link">
                    <img src="{{asset('company/'.$types->com_logo)}}" alt="{{$types->com_name}}" class="brand-image img-circle elevation-3">
                    </a>
                @endforeach
            <!-- right navbar links -->
            <ul class="navbar-nav order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                <a href="{{url('employee/home')}}" class="nav-link {{(Request::path() == 'employee/home')? 'active':''}}">Home</a>
                </li>
                <li class="nav-item">
                <a href="{{url('employee/leaves')}}" class="nav-link {{(Request::path() == 'employee/leaves')? 'active':''}}">Leaves</a>
                </li>
                <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">My Account</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    <li><a href="{{url('employee/logout')}}" class="dropdown-item">Logout</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </nav>
        <!-- /.navbar --> 