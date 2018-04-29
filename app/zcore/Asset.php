<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 23.04.2018
 * Time: 19:00
 */

namespace core;


class Asset
{
    const HEAD = 'HEAD';
    const BODY = 'BODY';
    
    public static $js = [];
    
    public static function addJs($place = Asset::HEAD, $params = [])
    {
        $files = [];
        $params = array_merge(Asset::$js, $params);
        
        foreach ($params as $file => $arPlace) {
            if ($place == $arPlace) {
                $files[] = $file;
            }
        }
        
        $scripts = "";
        foreach ($files as $file) {
            $scripts .= '<script src='.$file.' type="text/javascript"></script>' . "\n\r";
        }
        
        return $scripts;
    }
    
    /**
     * @param string $file
     * @param string $place
     */
    public static function registerJsFile($file, $place = Asset::HEAD)
    {
        Asset::$js[App::$root . $file] = $place;
    }
}