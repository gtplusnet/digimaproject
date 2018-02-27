<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_tags extends Model
{
   	protected $table = 'tbl_tags';
	protected $primaryKey = "tag_id";
	public $timestamps = false;
}
