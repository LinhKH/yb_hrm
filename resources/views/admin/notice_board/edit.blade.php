@extends('admin.layout')
@section('title','Edit Notice')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Notice Board'=>'admin/notice_board']])
    @slot('title') Edit Notice @endslot
    @slot('add_btn') @endslot
    @slot('active') Edit Notice @endslot
@endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateNotice" method="POST">
                @csrf
                {{ method_field('PATCH') }}
                @foreach($NoticeBoard as $row)
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" class="url" value="{{url('admin/notice_board/'.$row->notice_id)}}" >
                        <input type="hidden" class="rdt-url" value="{{url('admin/notice_board')}}" >
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="notice" value="{{$row->title}}" placeholder="Enter Name">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <div class="card-body pad">
                                        <div class="mb-3">
                                            <textarea  class="textarea" class="form-control" name="description" value="" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{htmlspecialchars_decode($row->description)}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class=" form-control-label"> Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ ($row->status == "1" ? "selected":"") }}>Active</option>
                                        <option value="0" {{ ($row->status == "0" ? "selected":"") }}>Inactive</option>
                                    </select>
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
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
                @endforeach
            </form> <!-- /.form start -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->

@stop