<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTblTaskAssigned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_task', function (Blueprint $table)
        {
            $table->integer('task_assigned_by')->unsigned();
            $table->foreign('task_assigned_by')->references('member_id')->on('tbl_member')->onDelete('cascade');
        });

        Schema::create('tbl_task_assignee', function (Blueprint $table)
        {
            $table->increments('task_assignee_id');
            $table->integer('task_id')->unsigned();
            $table->integer('task_assigned_to')->unsigned();
            $table->foreign('task_id')->references('task_id')->on('tbl_task')->onDelete('cascade');
            $table->foreign('task_assigned_to')->references('member_id')->on('tbl_member')->onDelete('cascade');
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
