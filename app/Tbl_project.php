<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_project extends Model
{
   	protected $table = 'tbl_project';
	protected $primaryKey = "project_id";
	public $timestamps = false;
}
