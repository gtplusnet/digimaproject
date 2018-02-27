<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_member', function (Blueprint $table)
        {
            $table->increments('member_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email', 100)->unique();
            $table->string('username', 100)->unique();
            $table->text('password');
            $table->integer('sponsor')->unsigned();
            $table->tinyInteger('verified_mail')->default(0);
            $table->string('create_date_time');
            $table->string('create_ip_address');
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
        //
    }
}
