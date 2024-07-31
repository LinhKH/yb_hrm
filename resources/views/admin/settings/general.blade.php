@extends('admin.layout')
@section('title','General Settings')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') General Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') General Settings @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateGeneralSetting" method="POST">
            {{ csrf_field() }}
                @foreach($data as $item)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                    <input type="hidden" class="url" value="{{url('admin/general-settings')}}" >
                    <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label class="col-md-3">Company Logo</label>
                                            <div class="col-md-9">
                                                <input type="hidden" class="custom-file-input" name="old_logo" value="{{$item->com_logo}}" />
                                                <input type="file" hidden class="change-com-img" name="logo" onChange="readURL(this);">
                                                @if(empty($item->com_logo))
                                                    <img class="img-thumbnail" id="image" src="{{asset('company/default.png')}}">
                                                @else
                                                    <img class="img-thumbnail" id="image" src="{{asset('company/'.$item->com_logo)}}">
                                                @endif
                                                <button type="button" class="btn btn-info d-block mt-2 change-logo">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" name="name" value="{{$item->com_name}}"  placeholder="Enter Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Email</label>
                                            <input type="email" class="form-control" name="email"  value="{{$item->com_email}}" placeholder="Enter Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Currency</label>
                                            <input type="text" class="form-control" name="currency" value="{{$item->cur_format}}"  placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Office Clock In Time</label>
                                            <input type="time" class="form-control" name="clock_in" value="09:00"  >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group mb-4">
                                            <label>Office Clock Out Time</label>
                                            <input type="time" class="form-control" name="clock_out" value="18:00"  >
                                        </div>
                                    </div>
                                     <div class="form-group col-md-4 col-12">
                                        <input type="submit" class="btn btn-primary update-general-settings" value="Update"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                @endforeach
            </form> <!-- /.form start -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
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