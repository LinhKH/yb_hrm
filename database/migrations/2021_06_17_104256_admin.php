<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('admin_name',20);
            $table->string('admin_email',50); 
            $table->string('user_name',20); 
            $table->text('user_pass'); 
        });

        DB::table('admin')->insert([
            'admin_name' => 'Site Admin',
            'admin_email' => 'admin@example.com',
            'user_name' => 'admin',
            'user_pass' => Hash::make('123456')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
