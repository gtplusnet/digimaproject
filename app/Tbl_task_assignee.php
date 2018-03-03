<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_task_assignee extends Model
{
   	protected $table = 'tbl_task_assignee';
	protected $primaryKey = "task_assignee_id";
	public $timestamps = false;

	public function scopeMember($query)
	{
		$query->join("tbl_member", "tbl_member.member_id", "=", "tbl_task_assignee.task_assigned_to");
	}
}