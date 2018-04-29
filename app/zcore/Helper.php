<?php
/**
 * Class Helper
 *
 */
namespace core;

class Helper
{
    /**
     * Secure string
     * @param $str
     * @return string
     */
    public static function safetyStr($str)
    {
        $s = trim($str);
        $s = strip_tags($s);
        $s = htmlspecialchars($s, ENT_QUOTES);
        $s = stripslashes($s);
        return $s;
    }
    
    public static function url($url)
    {
        return App::$root . $url;
    }
}