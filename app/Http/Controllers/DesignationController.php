<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Employees;
use Yajra\DataTables\DataTables;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $department = Departments::all();
        if ($request->ajax()) {
            $data = Designations::select(['designations.*','departments.name as department'])
                ->LeftJoin('departments','designations.department_id','=','departments.department_id')
                ->orderBy('designations.id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit_designation btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-designation btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.designation.index',['department'=>$department]);
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
            'designation'=> 'required|unique:designations,name',
            'department' => 'required'
        ]);

        $Designations = new Designations();
        $Designations->name = $request->input("designation");
        $Designations->department_id = $request->input("department");
        $result =  $Designations->save();
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
        $designation = Designations::where('id',$id)->get();
        return $designation;

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
            'designation'=>'required|unique:designations,name,'.$id.',id',
            'department' => 'required'
        ]);

        $Designations = Designations::where(['id'=>$id])->update([
            "name"=>$request->input('designation'),
            "department_id"=>$request->input('department'),
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
        $employee = Employees::where('emp_designation','=',$id)->first();
        if($employee === null){
            $destroy = Designations::where('id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't delete this.";
        }
    }
}
