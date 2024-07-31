@extends('admin.layout')
@section('title','Edit Award')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Awards'=>'admin/awards']])
        @slot('title') Edit Award @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit Award @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateAward" method="POST">
                @csrf
                {{ method_field('PATCH') }}
                @foreach($award as $row)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <input type="hidden" class="url" value="{{url('admin/awards/'.$row->award_id)}}" >
                        <input type="hidden" class="rdt-url" value="{{url('admin/awards')}}" >
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Award </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Award Name</label>
                                            <input type="text" class="form-control" name="award_name" value="{{$row->award_name}}" placeholder="Enter Award Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Item</label>
                                            <input type="text" class="form-control" name="item" value="{{$row->item}}" placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Cash Price</label>
                                            <input type="number" class="form-control" name="price" value="{{$row->cash_price}}" placeholder="Enter Cash Price">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Employee Name</label>
                                            <select class="form-control" name="emp"  style="width: 100%;">
                                                <option disabled selected value="" >Select The Employee Name</option>
                                                @if(!empty($employee))
                                                    @foreach($employee as $types)
                                                        @if($types->id == $row->employee_id)
                                                        <option value="{{$types->id}}" selected="">{{$types->emp_name}}</option>
                                                        @else
                                                        <option value="{{$types->id}}">{{$types->emp_name}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
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
                        <button type="submit" class="btn btn-primary">Update</button>
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