<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(file_exists(storage_path('installed'))){
            if (Schema::hasTable('general_settings')) {
                $siteInfo = DB::table('general_settings')->get();
                // print_r()
            }
            if (Schema::hasTable('leave_applications') && Schema::hasTable('employees')) {
                $notification = DB::table('leave_applications')->select(['leave_applications.*','employees.emp_name'])
                                ->where(['leave_applications.status'=>'0'])
                                ->leftJoin('employees','employees.id','=','leave_applications.employee_id')
                                ->get();
                view()->share(['siteInfo'=> $siteInfo,'notification'=>$notification]);
    
            }
        }else{
            return redirect('/install');
        }
        

    }
}
