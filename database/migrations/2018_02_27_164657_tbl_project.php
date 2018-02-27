<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_project', function (Blueprint $table)
        {
            $table->increments('project_id');
            $table->string('project_name');
        });

        Schema::table('tbl_task', function (Blueprint $table)
        {
            $table->integer('task_project')->unsigned();
            $table->foreign('task_project')->references('project_id')->on('tbl_project')->onDelete('cascade');
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
