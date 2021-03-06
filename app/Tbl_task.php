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
    public function scopeFilterAssignee($query, $member_id)
    {
        $query->join("tbl_task_assignee", "tbl_task_assignee.task_id", "=", "tbl_task.task_id");
        $query->where("task_assigned_to", $member_id);
    }
    public function scopeFilterTags($query, $tag_id)
    {
        $query->join("tbl_task_tags", "tbl_task_tags.task_id", "=", "tbl_task.task_id");
        $query->where("tbl_task_tags.tag_id", $tag_id);
    }
}