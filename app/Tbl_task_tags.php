<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_task_tags extends Model
{
   	protected $table = 'tbl_task_tags';
	protected $primaryKey = "task_tag_id";
	public $timestamps = false;

    public function scopeTag($query)
    {
        $query->join("tbl_tags", "tbl_tags.tag_id", "=", "tbl_task_tags.tag_id");
    }
}
