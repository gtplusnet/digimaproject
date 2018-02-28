<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_task extends Model
{
   	protected $table = 'tbl_task';
	protected $primaryKey = "task_id";
	public $timestamps = false;

    public function scopeProject($query)
    {
        $query->join("tbl_project", "tbl_project.project_id", "=", "tbl_task.task_project");
    }
    public function scopeAssignedBy($query)
    {
        $query->join("tbl_member", "tbl_member.member_id", "=", "tbl_task.task_assigned_by");
    }
}
