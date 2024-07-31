<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    //

    public function yb_general_settings(Request $request){

       //return $this->general_settings(['com_name','com_logo']);

        if($request->input()){
            $request->validate([
                'name'=> 'required',
                'email'=> 'required',
                'currency'=> 'required',
                'logo'=> 'image|mimes:jpg,jpeg,png,svg',
            ]);

            if($request->logo != ''){        
                $path = public_path().'/company/';

                //code for remove old file
                if($request->old_logo != ''  && $request->old_logo != null){
                    $file_old = $path.$request->old_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->logo;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_logo;
            }

            $update = DB::table('general_settings')->update([
                'com_name'=>$request->name,
                'com_logo'=>$filename,
                'com_email'=>$request->email,
                'cur_format'=>$request->currency,
                'clock_in_time'=>$request->clock_in,
                'clock_out_time'=>$request->clock_out,
            ]);
            return $update;

        }else{
            $settings = DB::table('general_settings')->get();
            return view('admin.settings.general',['data'=>$settings]);
        }
    }


    public function yb_profile_settings(Request $request){

        if($request->input()){
            $request->validate([
                'admin_name'=> 'required',
                'admin_email'=> 'required|email:rfc',
                'username'=> 'required'
            ]);

            $update = DB::table('admin')->update([
                'admin_name'=>$request->admin_name,
                'admin_email'=>$request->admin_email,
                'user_name'=>$request->username
            ]);
            return $update;

        }else{
            $settings = DB::table('admin')->get();
            return view('admin.settings.profile',['data'=>$settings]);
        }
    }

    public function yb_change_password(Request $request){

        if($request->input()){
            $request->validate([
                'password'=> 'required',
                'new_pass'=> 'required',
                'con_pass'=> 'required'
            ]);

            $select = DB::table('admin')->pluck('user_pass');

            if(Hash::check($request->password,$select[0])){
                $update = DB::table('admin')->update([
                    'user_pass'=>Hash::make($request->new_pass)
                ]);
                return '1';
            }else{
                return response()->json(['password'=>'Please Enter Correct Old Password']);
            }
        }
    }
    
}
