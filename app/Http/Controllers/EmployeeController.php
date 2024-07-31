<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Employees;
use App\Models\BankDetail;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Documents;
use App\Models\Awards;
use App\Models\LeaveType;
use App\Models\Holidays;
use App\Models\NoticeBoard;
use App\Models\LeaveApplications;
use App\Models\Attendance;
use File;
use DB;


use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
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
            $data = Employees::select(['employees.*', 'departments.name as department_name', 'designations.name as designation_name'])
                ->leftJoin('departments', 'employees.emp_department', '=', 'departments.department_id')
                ->leftJoin('designations', 'employees.emp_designation', '=', 'designations.id')
                ->LeftJoin('documents', 'employees.employeeId', '=', 'documents.employee_id')
                ->orderBy('employees.id', 'desc')->get();
            return Datatables::of($data)
                ->addColumn('image', function ($row) {
                    if ($row->emp_image != '') {
                        $img = '<img src="' . asset("/employees/" . $row->emp_image) . '" width="70px">';
                    } else {
                        $img = '<img src="' . asset("/employees/default.png") . '" width="70px">';
                    }
                    return $img;
                })
                ->addColumn('at_work', function ($row) {

                    $join_date = date_create(date('Y-m-d', strtotime($row->date_of_joining)));
                    $now = date_create(date('Y-m-d'));
                    $diff = date_diff($join_date, $now);
                    if ($now > $join_date) {
                        return $diff->format("%R%a days");
                    } else {
                        return date('d M, Y', strtotime($row->date_of_joining));
                    }
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == '1') {
                        $status =  '<span class="badge badge-success">Active</span>';
                    } else {
                        $status =  '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="employees/' . $row->id . '/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-employee btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['image', 'at_work', 'status', 'action'])
                ->make(true);
        }
        return view('admin.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //return $request->input();
        $designation = Designations::all();
        $department = Departments::all();
        return view('admin.employees.create', ['designations' => $designation, 'departments' => $department]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    return $request->input(); 

        $request->validate([
            'img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'emp_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:employees,emp_email',
            'password' => 'required',
            'employeeId' => 'required|unique:employees,employeeId',
            'department' => 'required',
            'designation' => 'required',
            'join_date' => 'required',
            'join_salary' => 'required',
            'resume' => 'mimes:pdf,doc,docx',
            'offer_letter' => 'mimes:pdf,doc,docx',
            'join_letter' => 'mimes:pdf,doc,docx',
            'id_proof' => 'mimes:pdf,doc,docx',
        ]);

        if ($request->img) {
            $image = $request->emp_name . rand() . $request->img->getClientOriginalName();
            $request->img->move(public_path('employees'), $image);
        }

        $Employees = new Employees();
        if ($request->img) {
            $Employees->emp_image = $image;
        }
        $Employees->emp_name = $request->input("emp_name");
        $Employees->emp_phone = $request->input("phone");
        if ($request->has('gender') && $request->has('gender') != '') {
            $Employees->emp_gender = $request->input("gender");
        }
        if ($request->has('gender') && $request->has('dob') != '') {
            $Employees->emp_dob = $request->input("dob");
        }
        if ($request->has('local_address') && $request->local_address != '') {
            $Employees->local_address = $request->input("local_address");
        }
        if ($request->has('per_address') && $request->per_address != '') {
            $Employees->per_address = $request->input("per_address");
        }
        $Employees->emp_email  = $request->input("email");
        $Employees->emp_password  = Hash::make($request->input("password"));
        $Employees->employeeId = $request->input("employeeId");
        $Employees->emp_department = $request->input("department");
        $Employees->emp_designation = $request->input("designation");
        $Employees->date_of_joining = $request->input("join_date");
        $Employees->joining_salary = $request->input("join_salary");
        $result =  $Employees->save();

        // check documents and upload
        if ($request->resume) {
            $resume = $request->emp_name . rand() . '.' . $request->resume->getClientOriginalExtension();
            $request->resume->move(public_path('documents'), $resume);
        }

        if ($request->offer_letter) {
            $offer_letter = $request->emp_name . rand() . '.' . $request->offer_letter->getClientOriginalExtension();
            $request->offer_letter->move(public_path('documents'), $offer_letter);
        }

        if ($request->join_letter) {
            $join_letter = $request->emp_name . rand() . '.' . $request->join_letter->getClientOriginalExtension();
            $request->join_letter->move(public_path('documents'), $join_letter);
        }

        if ($request->id_proof) {
            $id_proof = $request->emp_name . rand() . '.' . $request->id_proof->getClientOriginalExtension();
            $request->id_proof->move(public_path('documents'), $id_proof);
        }
        // insert document file names
        if (isset($resume) || isset($id_proof) || isset($join_letter) || isset($offer_letter)) {
            $Documents = new Documents();
            $Documents->employee_id = $Employees->id;
            if (isset($resume)) {
                $Documents->resume = $resume;
            }
            if (isset($offer_letter)) {
                $Documents->offer_letter = $offer_letter;
            }
            if (isset($join_letter)) {
                $Documents->joining_letter = $join_letter;
            }
            if (isset($id_proof)) {
                $Documents->id_proof = $id_proof;
            }
            $result1 =  $Documents->save();
        }


        // insert bank details
        $BankDetail = new BankDetail();
        $BankDetail->employee_id = $Employees->id;
        $BankDetail->acc_name  = $request->input("holder_name");
        $BankDetail->acc_no  = $request->input("acc_number");
        $BankDetail->bank_name  = $request->input("bank_name");
        $BankDetail->ifsc_code  = $request->input("ifsc_code");
        $BankDetail->pan_number = $request->input("pan_no");
        $BankDetail->branch_location = $request->input("branch_loc");
        $result2 =  $BankDetail->save();
        //return $result2;
        return '1';
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
        $employee = Employees::where(['id' => $id])->first();
        $BankDetail = BankDetail::where(['employee_id' => $id])->get();
        $Documents = Documents::where(['employee_id' => $id])->get();
        $designations = Designations::where(['department_id' => $employee->emp_department])->get();
        $departments = Departments::all();

        return view('admin.employees.edit', ['employees' => $employee, 'BankDetail' => $BankDetail, 'documents' => $Documents, 'designations' => $designations, 'departments' => $departments]);
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
        $request->validate([
            'emp_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:employees,emp_email,' . $id . ',id',
            'department' => 'required',
            'designation' => 'required',
            'join_date' => 'required',
            'join_salary' => 'required',
            'resume' => 'mimes:pdf,doc,docx',
            'offer_letter' => 'mimes:pdf,doc,docx',
            'join_letter' => 'mimes:pdf,doc,docx',
            'id_proof' => 'mimes:pdf,doc,docx',
        ]);

        // update employee image
        if ($request->img != '') {
            $path = public_path() . '/employees/';
            //code for remove old file
            if ($request->old_img != ''  && $request->old_img != null) {
                $file_old = $path . $request->old_img;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = $request->emp_name . rand() . $request->img->getClientOriginalName();
            $file->move($path, $image);
        } else {
            $image = $request->old_img;
        }

        // update resume file
        if ($request->resume != '') {
            $path = public_path() . '/documents/';
            //code for remove old file
            if ($request->old_resume != ''  && $request->old_resume != null) {
                $file_old = $path . $request->old_resume;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->resume;
            $resume = $request->emp_name . rand() . $request->resume->getClientOriginalName();
            $file->move($path, $resume);
        } else {
            $resume = $request->old_resume;
        }

        // update offer letter
        if ($request->offer_letter != '') {
            $path = public_path() . '/documents/';
            //code for remove old file
            if ($request->old_offer_letter != ''  && $request->old_offer_letter != null) {
                $file_old = $path . $request->old_offer_letter;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->offer_letter;
            $offer_letter = $request->emp_name . rand() . $request->offer_letter->getClientOriginalName();
            $file->move($path, $offer_letter);
        } else {
            $offer_letter = $request->old_offer_letter;
        }

        // update join letter
        if ($request->join_letter != '') {
            $path = public_path() . '/documents/';
            //code for remove old file
            if ($request->old_join_letter != ''  && $request->old_join_letter != null) {
                $file_old = $path . $request->old_join_letter;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->join_letter;
            $join_letter = $request->emp_name . rand() . $request->join_letter->getClientOriginalName();
            $file->move($path, $join_letter);
        } else {
            $join_letter = $request->old_join_letter;
        }

        if ($request->id_proof != '') {
            $path = public_path() . '/documents/';
            //code for remove old file
            if ($request->old_id_proof != ''  && $request->old_id_proof != null) {
                $file_old = $path . $request->old_id_proof;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->id_proof;
            $id_proof = $request->emp_name . rand() . $request->id_proof->getClientOriginalName();
            $file->move($path, $id_proof);
        } else {
            $id_proof = $request->old_id_proof;
        }

        $Employees = Employees::where(['id' => $id])->update([
            "emp_image" => $image,
            "emp_name" => $request->input('emp_name'),
            "emp_dob" => $request->input('dob'),
            "emp_gender" => $request->input('gender'),
            "emp_phone" => $request->input('phone'),
            "local_address" => $request->input('local_address'),
            "per_address" => $request->input('per_address'),
            "emp_email" => $request->input('email'),
            "emp_department" => $request->input('department'),
            "emp_designation" => $request->input('designation'),
            "date_of_joining" => $request->input('join_date'),
            "joining_salary" => $request->input('join_salary'),
        ]);

        if ($resume || $id_proof || $join_letter || $offer_letter) {
            $Documents = Documents::updateOrCreate(['employee_id' => $id]);
            if ($resume) {
                $Documents->resume = $resume;
            }
            if ($offer_letter) {
                $Documents->offer_letter = $offer_letter;
            }
            if ($join_letter) {
                $Documents->joining_letter = $join_letter;
            }
            if ($id_proof) {
                $Documents->id_proof = $id_proof;
            }
            $result1 =  $Documents->save();
        }

        //    return $id;
        $bankDetails = BankDetail::updateOrCreate(['employee_id' => $id], [
            'acc_name' => $request->input('holder_name'),
            'acc_no' => $request->input('acc_number'),
            'bank_name' => $request->input('bank_name'),
            'ifsc_code' => $request->input('ifsc_code'),
            'pan_number' => $request->input('pan_no'),
            'branch_location' => $request->input('branch_loc')
        ]);

        return '1';
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
        // return $id;
        $destroy = Employees::where('id', $id)->delete();
        return  $destroy;
    }

    function yb_login(Request $request)
    {
        if ($request->input()) {

            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $login = Employees::where(['emp_email' => $request->email])->first();
            if (empty($login)) {
                return response()->json(['email' => 'Email Does not Exists']);
            } else {
                if (Hash::check($request->password, $login->emp_password)) {
                    $request->session()->put('employee', $login->employeeId);
                    $request->session()->put('employee_id', $login->id);
                    $request->session()->put('employee_name', $login->emp_name);
                    return '1';
                } else {
                    return response()->json(['password' => 'Email and Password does not matched']);
                }
            }
        } else {
            return view('employee/employee_login');
        }
    }

    public function yb_profile(Request $request)
    {
        $value = $request->session()->get('employee_id');
        $Attendance = Attendance::where(['employeeId' => $value, 'status' => '1'])->count();
        $BankDetail = BankDetail::where(['employee_id' => $value])->get();
        $Awards = Awards::where(['employee_id' => $value])->get();
        $Holidays = Holidays::orderBy('id', 'desc')->get();
        $available_leaves = LeaveType::sum('number_of_type');
        $employee_leaves_count = LeaveApplications::where(['employee_id' => $value, 'status' => '1'])->count('leave_id');
        $NoticeBoard = NoticeBoard::where('status', '1')->limit(2)->get();
        $data = Employees::Select(['employees.*', 'departments.name as department', 'designations.name as designation'])
            ->leftJoin('departments', 'employees.emp_department', '=', 'departments.department_id')
            ->leftJoin('designations', 'employees.emp_designation', '=', 'designations.id')
            ->where(["employees.id" => $value])->get();
        return view('employee.home', ['data' => $data, 'attendance' => $Attendance, 'BankDetail' => $BankDetail, 'Awards' => $Awards, 'Holidays' => $Holidays, 'NoticeBoard' => $NoticeBoard, 'available_leaves' => $available_leaves, 'employee_leaves_count' => $employee_leaves_count]);
    }

    public function yb_my_leaves()
    {
        $value = session()->get('employee_id');
        // return $value;
        $Attendance = Attendance::where(['employeeId' => $value, 'status' => '1'])->count();
        $employee_leaves_count = LeaveApplications::where(['employee_id' => $value, 'status' => '1'])->count('leave_id');
        $employee_leaves = LeaveApplications::select('leave_type', DB::raw('count(leave_type) as count'))->where(['employee_id' => $value, 'status' => '1'])->groupBy('leave_type')->get();
        $Awards = Awards::where(['employee_id' => $value])->get();
        $LeaveType = LeaveType::all();
        $available_leaves = LeaveType::sum('number_of_type');
        $data = Employees::where(["employees.id" => $value])->get();
        // return $Attendance;
        return view('employee.employee-leave', ['data' => $data, 'attendance' => $Attendance, 'LeaveType' => $LeaveType, 'Awards' => $Awards, 'available_leaves' => $available_leaves, 'employee_leaves_count' => $employee_leaves_count, 'employee_leaves' => $employee_leaves]);
    }

    public function yb_add_leave(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'leave' => 'required',
            'reason' => 'required'
        ]);
        $value = $request->session()->get('employee_id');
        $LeaveApplications = new LeaveApplications();
        $LeaveApplications->employee_id = $value;
        $LeaveApplications->date  = $request->input("date");
        $LeaveApplications->leave_type = $request->input("leave");
        $LeaveApplications->reason  = $request->input("reason");
        $result =  $LeaveApplications->save();
        return $result;
    }

    public function yb_logout(Request $req)
    {
        Auth::logout();
        session()->forget('employee');
        session()->forget('employee_id');
        session()->forget('employee_name');
        return redirect('employee/login');
    }


    public function yb_department_designations(Request $request)
    {
        if ($request->input()) {
            $designations = Designations::where(['department_id' => $request->id])->get();
            return $designations;
        }
    }
}
