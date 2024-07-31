<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Models\LeaveApplications;
use Yajra\DataTables\DataTables;

class LeaveTypeController extends Controller
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
            $data = LeaveType::latest()->orderBy('id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit_leave btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete_leave_type btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.leave-type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $request->validate([
            'leave_type'=> 'required|unique:leave_type,leave_type',
            'number_leave' => 'required'
        ]);

        $LeaveType = new LeaveType();
        $LeaveType->leave_type = $request->input("leave_type");
        $LeaveType->number_of_type = $request->input("number_leave");
        $result =  $LeaveType->save();
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
        //return $request->input();

        $LeaveType = LeaveType::where('id',$id)->get();
        return $LeaveType;
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
            'leave_type'=>'required|unique:leave_type,leave_type,'.$id.',id',
            'number_leave'=>'required'
        ]);

        $LeaveType = LeaveType::where(['id'=>$id])->update([
            "leave_type"=>$request->input('leave_type'),
            "number_of_type"=>$request->input('number_leave'),
        ]);

        return $LeaveType;
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
        $check = LeaveApplications::where('leave_type','=',$id)->first();
        if($check === null){
            $LeaveType = LeaveType::where('id',$id)->delete();
            return  $LeaveType;
        }else{
            return "You won't delete this.";
        }
    }
}
