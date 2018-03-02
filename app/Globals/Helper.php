<?php
namespace App\Globals;
use App\Tbl_country;
use stdClass;
use Carbon\Carbon;
use DateTime;


class Helper
{
    public static function isTest()
    {
        $domain     = $_SERVER['SERVER_NAME'];
        $domain     = explode(".", $domain);
        $count      = count($domain) - 1;
        $domain     = $domain[$count];

        $ip = $_SERVER['REMOTE_ADDR'];

        if($domain == "test" || $ip == "127.0.0.1")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function onlineAgo($time_ago, $full = false)
    {
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "<span style='color: green;'>Online</span>";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "1 minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }
    public static function convertSeconds($init, $minute_only = false)
    {
        $hours = sprintf("%02d", floor($init / 3600));
        $minutes = sprintf("%02d", floor(($init / 60) % 60));
        $seconds = sprintf("%02d", $init % 60);

        if($minute_only)
        {
            return "$hours:$minutes";
        }
        else
        {
            return "$hours:$minutes:$seconds";
        }
        
    }
    public static function timeUntil($deadline)
    {
        $now = new DateTime();
        $future_date = new DateTime($deadline);

        $interval = $future_date->diff($now);

        if ($interval->invert == 0)
        {
            return "<span style='color: red;'>Overdue</span>"; 
        }
        elseif(intval($interval->format("%a")) > 1)
        {
            return $interval->format("%a days"); 
        }
        elseif(intval($interval->format("%a")) == 1)
        {
            return $interval->format("Tomorrow"); 
        }
        elseif(intval($interval->format("%h")) > 1)
        {
            return $interval->format("%h hours"); 
        }
        elseif(intval($interval->format("%h")) == 1)
        {
            return $interval->format("%h hour"); 
        }
        else
        {
            return $interval->format("%i minutes"); 
        }
    }

}