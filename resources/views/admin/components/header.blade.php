

<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') > {{$siteInfo[0]->com_name}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-url" content="{{ url('/') }}">
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
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/css/summernote-bs4.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert-bootstrap-4.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets/daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/icheck-bootstrap.min.css')}}">
    <!-- Style.CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper position-relative">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" title="Leave Application Notification" href="#">
                        <i class="far fa-bell"></i>
                        @if(count($notification) > 0)
                        <span class="badge badge-danger navbar-badge">{{count($notification)}}</span>
                        @endif
                    </a>
                     @if(count($notification) > 0)
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @foreach($notification as $noty)
                        <a href="#" class="dropdown-item">
                            <div class="media"> <!-- Message Start -->
                                <div class="media-body">
                                <span class="span-label label-sm mb-3 p-2 bg-info align-top d-inline-block"><i class="fa fa-bell"></i></span>
                                    
                                    <p class="text-md d-inline-block"><strong>{{$noty->emp_name}}</strong> has applied for leave for {{ date('d M, Y',strtotime($noty->date))}}</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{date('d M, Y',strtotime($noty->created_at))}}</p>
                                </div>
                            </div><!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        <a href="{{url('admin/leave_application')}}" class="dropdown-item dropdown-footer">See All Applications</a>
                    </div>
                    @endif
                </li>
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <span class="d-none d-md-inline">Hello, {{session()->get('admin_name')}}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="width:180px;">
                    <li class="nav-item text-center"><a href="{{url('admin/profile-settings')}}" class="nav-link">My Profile</a></li>
                    <li class="nav-item text-center"><a href="javascript:void(0)" class="nav-link admin-logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
