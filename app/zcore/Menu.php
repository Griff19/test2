<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 26.04.2018
 * Time: 19:16
 */

namespace core;


class Menu
{
    /**
     * @param array $items =
     * [
     *     ['item' => ['Page 1' => 'controller/action', 'title' => "String title"]],
     *     ['item' => ['Page 2' => 'controller/action', 'visible' => false]],
     *     ...     => ... ,
     *     ['item' => ['Page n' => 'controller/action']],
     * ]
     *
     */
    public function menu($items)
    {
        $str = '';
        foreach ($items as $item) {
            foreach ($item as $key => $values) {
                
                if (is_array($values)) {
                    foreach ($values as $name => $value) {
                        if ($name == 'title'){
                            $str = str_replace("title=''", "title='$value'", $str);
                        } elseif ($name == 'visible') {
                            if (!$value) $str = '';
                        } else {
                            $str = "<a href='".Helper::url($value)."' title=''>$name</a> ";
                        }
                    }
                    echo $str;
                }
            }
        }
    }
}