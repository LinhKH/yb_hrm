<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Awards;
use App\Models\Employees;
use Yajra\DataTables\DataTables;

class AwardController extends Controller
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
           // $data = Awards::latest()->orderBy('award_id','desc')->get();
            $data=Awards::Select(['awards.*','employees.emp_name'])
            ->leftJoin('employees','awards.employee_id', '=','employees.id')
            ->orderBy('awards.award_id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date',function($row){
                    $date = date('d M, Y',strtotime($row->created_at));
                    return $date;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="awards/'.$row->award_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-award btn btn-danger btn-sm" data-id="'.$row->award_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['date','action'])
                ->make(true);
        }
        return view('admin.award.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Employees = Employees::all();
        return view('admin.award.create',['employee'=>$Employees]);
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
            'award_name'=>'required',
            'emp'=>'required',
        ]);

        $Awards = new Awards();
        $Awards->award_name = $request->input("award_name");
        if($request->input("item")){
            $Awards->item = $request->input("item");
        }
        if($request->input("price")){
            $Awards->cash_price = $request->input("price");
        }
        $Awards->employee_id = $request->input("emp");
        $result = $Awards->save();
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
        $Employees = Employees::all();
        $Award = Awards::where(['award_id'=>$id])->get();
        return view('admin.award.edit',['award'=>$Award,'employee'=> $Employees]);
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
            'award_name'=>'required',
            'emp'=>'required',
        ]);

        $Awards = Awards::where(['award_id'=>$id])->update([
            "award_name" => $request->input("award_name"),
            "item" => $request->input("item"),
            "cash_price" => $request->input("price"),
            "employee_id" => $request->input("emp"),
        ]);
        return $Awards;
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
        $destroy = Awards::where('award_id',$id)->delete();
        return  $destroy;
    }
}
