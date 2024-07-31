<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware'=>['installed']],function(){

Route::post('/',[AdminController::class,'yb_index']);

    Route::group(['middleware'=>['admin']],function(){
        Route::get('admin/dashboard',[AdminController::class,'yb_dashboard']);
        Route::get('admin/attendance/attendance-ajax',[AttendanceController::class,'yb_ajax_attendance']);
        Route::post('admin/attendance-filter',[AttendanceController::class,'yb_filter_attendance']);
        Route::resource('admin/attendance',AttendanceController::class);
        Route::post('admin/department-designations',[EmployeeController::class,'yb_department_designations']);
        Route::resource('admin/employees',EmployeeController::class);
        Route::resource('admin/bankDetail',BankDetailController::class);
        Route::resource('admin/departments',DepartmentController::class);
        Route::resource('admin/designations',DesignationController::class);
        Route::resource('admin/notice_board',NoticeBoardController::class);
        Route::resource('admin/expenses',ExpenseController::class);
        Route::resource('admin/awards',AwardController::class);
        Route::resource('admin/holidays',HolidayController::class);
        Route::resource('admin/leave_type',LeaveTypeController::class);
        Route::resource('admin/leave_application',LeaveApplicationController::class);
        
        Route::post('admin/change-leave-status',[LeaveApplicationController::class,'yb_changeLeave_status']);
        
        Route::get('admin/general-settings',[SettingsController::class,'yb_general_settings']);
        Route::post('admin/general-settings',[SettingsController::class,'yb_general_settings']);

        Route::get('admin/profile-settings',[SettingsController::class,'yb_profile_settings']);
        Route::post('admin/profile-settings',[SettingsController::class,'yb_profile_settings']);
        Route::post('admin/profile-settings/change-password',[SettingsController::class,'yb_change_password']);
        
        
        Route::get('/',[AdminController::class,'yb_index']);
        Route::get('admin/logout',[AdminController::class,'yb_logout']);
    }); 

    Route::get('employee/leave/{id}',[LeaveApplicationController::class,'yb_getSingle_leave']);
    Route::post('employee/login',[EmployeeController::class,'yb_login']);

    Route::group(['middleware'=>['empprotectedPage']],function(){
        Route::get('employee/home',[EmployeeController::class,'yb_profile']);
        Route::get('employee/leaves',[EmployeeController::class,'yb_my_leaves']); 
        Route::post('employee/employee-leave',[EmployeeController::class,'yb_add_leave']); 
        Route::get('employee/my-leaves',[LeaveApplicationController::class,'yb_view']);
        Route::get('employee/login',[EmployeeController::class,'yb_login']);
        Route::get('employee/logout',[EmployeeController::class,'yb_logout']);
    }); 

});