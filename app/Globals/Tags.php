<?php
namespace App\Globals;
use App\Tbl_tags;
use App\Tbl_task_tags;

class Tags
{
    public static function get($task_id)
    {
        $_tags = Tbl_task_tags::where("task_id", $task_id)->tag()->get();

        if(count($_tags) > 0)
        {
            $return = "";

            foreach($_tags as $tag)
            {
                $return .= "<span class='tags' style='color: " . $tag->tag_forecolor . "; background-color: " .  $tag->tag_backcolor . ";'>" . $tag->tag_label . "</span> ";
            }

            return $return;
        }
        else
        {
            return "<span style='color: #aaa'>NO TAGS</span>";
        }
        
    }
}