<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_member extends Model
{
   	protected $table = 'tbl_member';
	protected $primaryKey = "member_id";
	public $timestamps = false;
}
