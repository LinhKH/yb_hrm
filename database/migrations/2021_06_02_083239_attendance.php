<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Attendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('employeeId',20);
            $table->date('date'); 
            $table->tinyInteger('status')->nullable(); 
            $table->string('leaveType',10)->nullable(); 
            $table->string('halfDayType',100)->nullable(); 
            $table->text('reason')->nullable(); 
            $table->string('application_status',10)->nullable(); 
            $table->string('applied_on',10)->nullable(); 
            $table->string('clock_in',50)->nullable(); 
            $table->string('clock_out',50)->nullable(); 
            $table->tinyInteger('is_late')->default('0'); 
            $table->string('updated_by',10)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
