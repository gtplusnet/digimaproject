<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_login extends Model
{
   	protected $table = 'tbl_login';
	protected $primaryKey = "login_id";
	public $timestamps = false;

    public function scopeJoinMember($query)
    {
        $query->join("tbl_member", "tbl_member.member_id", "=", "tbl_login.member_id");
    }
}
