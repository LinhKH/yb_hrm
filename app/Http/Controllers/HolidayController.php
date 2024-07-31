<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holidays;
use Yajra\DataTables\DataTables;

class HolidayController extends Controller
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
            $data = Holidays::latest()->orderBy('id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                 ->editColumn('date',function($row){
                    return date('d M, Y',strtotime($row->date));
                 })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="delete-holiday btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.holiday.index');
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
            'holiday_date'=> 'required|unique:holidays,date',
            'occasion' => 'required',
        ]);

        $Holidays = new Holidays();
        $Holidays->date = $request->input("holiday_date");
        $Holidays->occasion = $request->input("occasion");
        $result =  $Holidays->save();
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
    public function destroy($id){
        //
        $destroy = Holidays::where('id',$id)->delete();
        return  $destroy;
    }
}
