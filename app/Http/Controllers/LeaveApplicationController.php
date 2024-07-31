<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\LeaveApplications;
use App\Models\LeaveType;
use App\Models\Attendance;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data=LeaveApplications::Select(['leave_applications.*','employees.emp_name as emp_name','leave_type.leave_type'])
            ->leftJoin('employees','employees.id', '=','leave_applications.employee_id')
            ->leftJoin('leave_type','leave_applications.leave_type', '=','leave_type.id')
            ->orderBy('leave_id','desc')->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date',function($row){
                    return date('d M, Y',strtotime($row->date));
                })
                ->editColumn('created_at', function($row){
                    return date('d M, Y',strtotime($row->created_at));
                })
                ->addColumn('status', function($row){
                    if($row->status == '0'){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }elseif($row->status == '1'){
                        $status = '<span class="badge badge-success">Approve</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Reject</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    // -1 for Canceled and 1 for Approved
                    if($row->status == '-1' || $row->status == '1'){ 
                        $btn = '<button data-url="'.url('employee/leave/').'" data-id="'.$row->leave_id.'" class="view_leave btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>'; 
                    }else{  
                        $btn = '<button data-url="'.url('admin').'" data-value="1" data-id="'.$row->leave_id.'" class="change_status btn btn-success btn-sm">Approve</button>
                                <button data-url="'.url('admin').'" data-value="-1" data-id="'.$row->leave_id.'" class="change_status btn btn-danger btn-sm">Reject</button>
                                <button data-url="'.url('employee/leave/').'" data-id="'.$row->leave_id.'" class="view_leave btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>';  
                    }
                  return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.leave_application.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $LeaveType = LeaveType::all();
        return view('leave_application.create',['LeaveType'=>$LeaveType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $request->input();
        $request->validate([
            'emp_date'=> 'required',
            'leave_type' => 'required',
            'reason' => 'required'
        ]);

        $LeaveApplications = new LeaveApplications();
        $LeaveApplications->date = $request->input("emp_date");
        $LeaveApplications->leave_type = $request->input("leave_type");
        $LeaveApplications->reason = $request->input("reason");
        $result =  $LeaveApplications->save();
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    } 

     public function yb_view(Request $request)
    {   
        $employee = session()->get('employee_id');
        if ($request->ajax()) {
             $data=LeaveApplications::Select(['leave_applications.*','leave_type.leave_type'])
            ->leftJoin('leave_type','leave_applications.leave_type', '=','leave_type.id')
            ->where('employee_id',$employee)
            ->orderBy('leave_id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('date',function($row){
                    return date('d M, Y',strtotime($row->date));
                })
                ->addColumn('status', function($row){
                    if($row->status == '0'){
                        $status = '<span class="badge badge-warning">Pending</span>';
                    }elseif($row->status == '1'){
                        $status = '<span class="badge badge-success">Approve</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Reject</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<button data-url="'.url('employee/leave/').'" data-id="'.$row->leave_id.'" class="view_leave btn btn-info btn-sm"><i class="fa fa-eye"></i></button>'; 
                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('my-leaves.view'); 
    }

    public function yb_getSingle_leave($id){
        $leave = LeaveApplications::Select(['leave_applications.*','leave_type.leave_type'])->where(['leave_id'=>$id])
        ->leftJoin('leave_type','leave_applications.leave_type', '=','leave_type.id')->get();
        return $leave;
    }

    public function yb_changeLeave_status(Request $request){
        //return $request->input();
        
        $update_application = LeaveApplications::where(['leave_id'=>$request->input('leave_id')])->update($request->input());
        
        $leave_application = LeaveApplications::where(['leave_id'=>$request->input('leave_id')])->first();
        if($leave_application->status == '1'){
                $date = date('Y-m-d',strtotime($leave_application->date));
                $attendance = Attendance::firstOrCreate(['date' => $date,
                    'employeeId' => $leave_application->employee_id]);

                $attendance->leaveType = $leave_application->leave_type;
                $attendance->halfDayType = $leave_application->half_day;
                $attendance->reason = $leave_application->reason;
                $attendance->status = '0';
                $attendance->applied_on = date('Y-m-d',strtotime($leave_application->created_at));
                $attendance->updated_by = 'admin';
                $attendance->application_status = '1';
                $attendance->save();
        }
        return $update_application; 
    }
}
 