<?php

namespace App\Http\Controllers;
use App\Models\NoticeBoard;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class NoticeBoardController extends Controller
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
            $data = NoticeBoard::latest()->orderBy('notice_id','desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="badge badge-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="notice_board/'.$row->notice_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-notice btn btn-danger btn-sm" data-id="'.$row->notice_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin.notice_board.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.notice_board.create');
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
            'notice'=>'required',
            'description'=>'required',
        ]);

        $NoticeBoard = new NoticeBoard();
        $NoticeBoard->title = $request->input("notice");
        $NoticeBoard->description = htmlspecialchars($request->input("description"));
        $result = $NoticeBoard->save();
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
        $NoticeBoard = NoticeBoard::where(['notice_id'=>$id])->get();
        return view('admin.notice_board.edit',['NoticeBoard'=>$NoticeBoard]);
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
            'notice'=>'required',
            'description'=>'required',
            'status'=>'required',
        ]);

        $NoticeBoard = NoticeBoard::where(['notice_id'=>$id])->update([
            "title" => $request->input("notice"),
            "description" => htmlspecialchars($request->input("description")),
            "status" => $request->input("status"),
        ]);
        return $NoticeBoard;
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
        $destroy =  NoticeBoard::where('notice_id',$id)->delete();
        return  $destroy;
    }
}
