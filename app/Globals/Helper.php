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
    public static function onlineAgo($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : '<span style="color: green;">Online</span>';
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