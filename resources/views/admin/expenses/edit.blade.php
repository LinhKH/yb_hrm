@extends('admin.layout')
@section('title','Edit Expense')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Expenses'=>'admin/expenses']])
        @slot('title') Edit Expense @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit Expense @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateExpense" method="POST">
                @csrf
                {{ method_field('PATCH') }}
                @foreach($expenses as $row)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <input type="hidden" class="url" value="{{url('admin/expenses/'.$row->expenses_id)}}" >
                        <input type="hidden" class="rdt-url" value="{{url('admin/expenses')}}" >
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Item Name</label>
                                            <input type="text" class="form-control" name="item_name" value="{{$row->item_name}}" placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Purchase Date</label>
                                            <div class="input-group date" id="reservationdate_2"  data-target-input="nearest">
                                                <div class="input-group-append" data-target="#reservationdate_2" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                <input type="text" name="pur_date" value="{{$row->purchase_date}}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Amount Price</label>
                                            <input type="number" class="form-control" name="amount" value="{{$row->amount}}" placeholder="Enter Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <label>Attach Bill</label>
                                            <div class="custom-file">
                                                <input type="hidden" name="old_bill" value="{{$row->price_bill}}" />
                                                <input type="file" class="custom-file-input" name="price_bill" onChange="readURL(this);">
                                                <label class="custom-file-label">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        @if($row->price_bill != '')
                                            <img id="bill" src="{{asset('expenses/'.$row->price_bill)}}" alt=""  width="100px" height="100px">
                                        @else
                                            <img id="bill" src="{{asset('expenses/default.jpg')}}" alt=""  width="100px" height="100px">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                     <!-- /.col -->
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
                $('#bill').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop