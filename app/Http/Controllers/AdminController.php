<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Employees;
use App\Models\NoticeBoard;
use App\Models\Awards;
use App\Models\Expenses;
use App\Models\Admin;
use App\Models\GeneralSetting;


class AdminController extends Controller
{

	public function yb_index(Request $request){

		if($request->input()){

			$request->validate([
				'username'=>'required',
				'password'=>'required',
			]); 
			$login = Admin::where(['user_name'=>$request->username])->pluck('user_pass')->first();

			if(empty($login)){
				return response()->json(['username'=>'Username Does not Exists']);
			}else{
				if(Hash::check($request->password,$login)){
					$admin = Admin::first();
					$request->session()->put('admin','1');
					$request->session()->put('admin_name',$admin->admin_name);
					return '1';
					// return response()->json(['success'=>'1']);
				}else{
					return response()->json(['password'=>'Username and Password does not matched']);
				}
			}
			
		}else{
			return view('admin.admin');
		}
		
	}

	public function yb_dashboard(){
		
		$Employees = Employees::Select("*")->get();
		$empCount = $Employees->count();
		
		$NoticeBoard = NoticeBoard::Select("*")->get();
		$noticeCount = $NoticeBoard->count();

		$Awards = Awards::Select("*")->get();
		$awardCount = $Awards->count();

		$Expenses = Expenses::Select("*")->get();
		$expenseCount = $Awards->count();
	
		return view('admin.dashboard',['employee'=> $empCount,'NoticeBoard'=> $noticeCount,'Award'=> $awardCount,'expense'=> $expenseCount]);
	}

	public function yb_logout(Request $req) {
		Auth::logout();
		session()->forget('admin');
		session()->forget('admin_name');
		return '1';
	}
	
}
