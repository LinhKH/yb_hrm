<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Employees;
use Yajra\DataTables\DataTables;

class DepartmentController extends Controller
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
            $data = Departments::latest()->orderBy('department_id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->department_id.'"  class="edit_department btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-department btn btn-danger btn-sm" data-id="'.$row->department_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.department.index');

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

         //return $request->input();

        $request->validate([
           'department'=>'required|unique:departments,name'
        ]);

        $Departments = new Departments();
        $Departments->name = $request->input("department");
        $result =  $Departments->save();
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
        $department = Departments::where(['department_id'=>$id])->get();
        return $department;

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

        $request->validate(['department'=>'required|unique:departments,name,'.$id.',department_id']);
     
        $Departments = Departments::where(['department_id'=>$id])->update([
            "name"=>$request->input('department'),
        ]);
        return $Departments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employees::where('emp_department','=',$id)->first();
        if($employee === null){
            $destroy = Departments::where('department_id',$id)->delete();
            return  $destroy;
        }else{ 
            return "You won't delete this.";
        }
        
    }
}
