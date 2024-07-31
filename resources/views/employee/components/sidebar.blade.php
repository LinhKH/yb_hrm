<div class="col-md-4">
@foreach($data as $item)
    <div class="card card-info card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                @if($item->emp_image != '')
                <img class="profile-user-img img-fluid img-circle"
                    src="{{asset('employees/'.$item->emp_image)}}"
                    alt="User profile picture">
                @else
                <img class="profile-user-img img-fluid img-circle"
                    src="{{asset('employees/default.png')}}"
                    alt="User profile picture">
                @endif
            </div>
            <h3 class="profile-username text-center">{{$item->emp_name}}</h3>
            <p class="text-muted text-center">{{$item->designation}}</p>
            <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                <b>Attendance</b> <a class="float-right">{{$attendance}}/@php echo $num_days = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));  @endphp</a>
                </li>
                <li class="list-group-item">
                <b>Leave</b> <a class="float-right">{{$employee_leaves_count}}/{{$available_leaves}}</a>
                </li>
                <li class="list-group-item">
                <b>Awards</b> 
                <a class="float-right"> {{count($Awards)}}</a>
                </li>
            </ul>
        </div><!-- /.card-body -->
    </div><!-- /.card -->
@endforeach
</div>