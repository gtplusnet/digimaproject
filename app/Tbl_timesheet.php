<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_timesheet extends Model
{
   	protected $table = 'tbl_timesheet';
	protected $primaryKey = "timesheet_id";
	public $timestamps = false;
}