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
     *     ['item' => ['Page 1' => 'controller/action', 'title' => "String title"], 'visible' => true],
     *     ['item' => ['Page 2' => 'controller/action'], 'visible' => false],
     *     ...     => ... ,
     *     ['item' => ['Page n' => 'controller/action'], 'visible' => true],
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
                        } else {
                            $str = "<a href='$value' title=''>$name</a> ";
                        }
                    }
                } else {
                    if ($key == 'visible' && $values) {
                        echo $str;
                    }
                }
            }
        }
    }
}