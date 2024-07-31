@extends('admin.layout')
@section('title','Profile Settings')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Profile Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Profile Settings @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @foreach($data as $item)
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" id="updateProfileSetting" method="POST">
                    {{ csrf_field() }}
                        <input type="hidden" class="url" value="{{url('admin/profile-settings/')}}" >
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Admin Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Admin Name</label>
                                            <input type="text" class="form-control" name="admin_name"  value="{{$item->admin_name}}" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Admin Email</label>
                                            <input type="text" class="form-control" name="admin_email" value="{{$item->admin_email}}"  placeholder="Enter Email Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" name="username"  value="{{$item->user_name}}" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </form>
                    <form class="form-horizontal" id="updateAdminPassword" method="POST">
                    {{ csrf_field() }}
                        <input type="hidden" class="p-url" value="{{url('admin/profile-settings/change-password')}}" >
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Old Password</label>
                                            <input type="password" class="form-control" name="password" value=""  placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" class="form-control" name="new_pass" id="new-pass" value=""  placeholder="Enter New Password">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Re-enter New Password</label>
                                            <input type="password" class="form-control" name="con_pass" value=""  placeholder="Re-enter New Password">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </form>
                </div>
            </div><!-- /.row -->
            @endforeach
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop