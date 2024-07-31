<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use DB;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
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
            $currency = DB::table('general_settings')->first()->cur_format;

            $data = Expenses::orderBy('expenses_id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('price_bill',function($row){
                    if($row->price_bill != ''){
                        $img = '<a href="'.asset("/expenses/".$row->price_bill).'" target="_blank"><i class="fa fa-file"></i></a>';
                    }else{
                        $img = '';
                    }
                    return $img;
                })
                ->editColumn('amount',function($row) use ($currency){
                    return $currency.$row->amount;
                })
                ->editColumn('purchase_date',function($row){
                    return date('d M, Y',strtotime($row->purchase_date));
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="expenses/'.$row->expenses_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-expense btn btn-danger btn-sm" data-id="'.$row->expenses_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['price_bill','action'])
                ->make(true);
        }
        return view('admin.expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->input();
        $request->validate([
            'item_name'=>'required',
            'pur_date'=>'required',
            'amount'=>'required',
            'price_bill'=>'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->price_bill){
            $price_bill = $request->price_bill->getClientOriginalName();
            $request->price_bill->move(public_path('expenses'),$price_bill);
        }
        

        $Expenses = new Expenses();
        $Expenses->item_name = $request->input("item_name");
        $Expenses->purchase_date = $request->input("pur_date");
        $Expenses->amount = $request->input("amount");
        if($request->price_bill){
            $Expenses->price_bill = $price_bill;
        }
        $result = $Expenses->save();
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
        $Expenses = Expenses::where(['expenses_id'=>$id])->get();
        return view('admin.expenses.edit',['expenses'=>$Expenses]);

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
            'item_name'=>'required',
            'pur_date'=>'required',
            'amount'=>'required',
        ]);

        if($request->price_bill != ''){        
            $path = public_path().'/expenses/';

            //code for remove old file
            if($request->old_bill != ''  && $request->old_bill != null){
                $file_old = $path.$request->old_bill;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }

            //upload new file
            $file = $request->price_bill;
            $price_bill = rand().$file->getClientOriginalName();
            $file->move($path, $price_bill);
        }else{
            $price_bill = $request->old_bill;
        }

        $Expenses = Expenses::where(['expenses_id'=>$id])->update([
            "item_name"=>$request->input('item_name'),
            "purchase_date" => $request->input("pur_date"),
            "amount" => $request->input("amount"),
            "price_bill" => $price_bill,
        ]);
        return $Expenses;
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
        $destroy = Expenses::where('expenses_id',$id)->delete();
        return  $destroy;
    }
}
