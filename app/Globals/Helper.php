<?php
namespace App\Globals;
use App\Tbl_country;
use stdClass;
use Carbon\Carbon;

class Helper
{
    public static function isTest()
    {
        $domain = $_SERVER['SERVER_NAME'];
        $domain = explode(".", $domain);
        $count = count($domain) - 1;
        $domain = $domain[$count];

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
}