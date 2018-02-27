<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_task extends Model
{
   	protected $table = 'tbl_task';
	protected $primaryKey = "task_id";
	public $timestamps = false;
}
