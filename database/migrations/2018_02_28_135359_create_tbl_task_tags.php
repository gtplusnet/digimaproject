<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTaskTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_task_tags', function (Blueprint $table)
        {
            $table->increments('task_tag_id');
            $table->integer('task_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->foreign('task_id')->references('task_id')->on('tbl_task')->onDelete('cascade');
            $table->foreign('tag_id')->references('tag_id')->on('tbl_tags')->onDelete('cascade');
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
