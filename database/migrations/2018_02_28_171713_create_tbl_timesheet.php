<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTimesheet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_timesheet', function (Blueprint $table)
        {
            $table->increments('timesheet_id');
            $table->date('timesheet_date');
            $table->time('time_in');
            $table->time('time_out');
            $table->integer('second_spent');
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('member_id')->on('tbl_member')->onDelete('cascade');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('task_id')->on('tbl_task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}