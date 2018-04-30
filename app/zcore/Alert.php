<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 24.04.2018
 * Time: 23:07
 */

namespace core;


class Alert
{
    public static $mess;
    /**
     *
     */
    public static function getFlash()
    {
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-error">' . $_SESSION['error'] .'</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] .'</div>';
            unset($_SESSION['success']);
        }
    }
    
    /**
     * The message that will be displayed in the notification area
     * @param $type string - type of message error or success
     * @param $message string - content
     */
    public static function setFlash($type, $message)
    {
        $_SESSION[$type] = $message;
        $_SESSION['count'] = 0;
    }
}