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