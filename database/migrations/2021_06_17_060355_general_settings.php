<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class GeneralSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('com_name');
            $table->string('com_logo'); 
            $table->string('com_email'); 
            $table->string('cur_format',20); 
            $table->string('clock_in_time',10)->nullable(); 
            $table->string('clock_out_time',10)->nullable(); 
        });


        DB::table('general_settings')->insert([
            'com_name' => 'YahooBaba HRM',
            'com_logo' => 'default.png',
            'com_email' => 'company@email.com',
            'cur_format' => '$',
            'clock_in_time' => '09:00',
            'clock_out_time' => '18:00'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
