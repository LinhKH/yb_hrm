@extends('admin.layout')
@section('title','Add New Notice')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Notice Board'=>'admin/notice_board']])
    @slot('title') Add New Notice @endslot
    @slot('add_btn') @endslot
    @slot('active') Add New Notice @endslot
@endcomponent
<!-- Main content -->
<section class="content">
<div class="container-fluid">
    <!-- form start -->
    <form class="form-horizontal" id="addNotice" method="POST">
        @csrf
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <input type="hidden" class="url" value="{{url('admin/notice_board')}}" >
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="notice" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <div class="card-body">
                                <textarea  class="textarea" class="form-control" name="description" placeholder="Place some text here" style="width: 100%; height: 500px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
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
<!-- /.content-wrapper -->

@stop