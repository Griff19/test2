<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 26.04.2018
 * Time: 21:34
 */

namespace core;

use Throwable;

class Exception extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        
        header('Location: site/error?message=' . $message . '&code=' . $code);
    }
}