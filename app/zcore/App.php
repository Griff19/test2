<?php
/**
 * Created by PhpStorm.
 * User: Gredasow Iwan (Griff19)
 * Date: 21.04.2018
 * Time: 15:47
 */

namespace core;

use models\User;

class App
{
    public static $config;
    public static $root;
    public static $ic = 0; //index controller
    public static $ia = 1; //index action
    
    /**
     * App constructor.
     * @param $config
     */
    public function __construct($config)
    {
        App::$config = $config;
        if (isset($config['js'])) {
            Asset::$js = $config['js'];
        }
        if (isset(App::$config['root']) && !empty(App::$config['root'])) {
            App::$root = App::$config['root'];
            App::$ic = 1;
            App::$ia = 2;
        }
    }

    /**
     * @return mixed
     */
    public static function getParams()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params = $_POST;
        } else {
            $params = $_GET;
        }
        return $params;
    }
    
    /**
     * @return string
     */
    public static function getUrl()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        var_dump($url, App::$root);
        if (isset(App::$root))
            $url = str_replace(App::$root, '', $url);
        
        return $url;
    }
    
    /**
     * Determine the called page.
     * If the address is empty then go to the main (site / index)
     * If the address is not correct then we call page 404
     */
    public function run()
    {
        $controller_name = 'Site';
        $action_name = 'Index';
        $error = false;
        /** Disassemble the URL string for the isolation of the Class and Method */
        $pars_url = parse_url(trim($_SERVER['REQUEST_URI'], '/'));
        $route = explode('/', $pars_url['path']);
    
        /** Define the controller class */
        if (isset($route[App::$ic]) && !empty($route[App::$ic])) {
            $controller_name = $route[App::$ic];
            $model_name = '\models\\' . ucfirst($controller_name);
            $model_file = ucfirst($controller_name) . '.php';
            if (file_exists('app'. $model_name . '.php')) {
                require_once __DIR__ . '/../models/' . $model_file;
            }
        }
    
        $controller_name = ucfirst($controller_name) . 'Controller';
        $controller_file = $controller_name . '.php';
        if (file_exists('app/controllers/' . $controller_file)) {
            $controller_name = '\controllers\\' . $controller_name;
            require_once __DIR__ . '/../controllers/' . $controller_file;
    
            /** If the controller is found, we define the class method */
            if (isset($route[App::$ia])) {
                $action_name = $route[App::$ia];
                $action_name = str_ireplace('-', ' ', $action_name);
                $action_name = ucwords($action_name);
                $action_name = str_replace(' ', '', $action_name);
            }
            $action_name = 'action' . ucfirst($action_name);
            if (!method_exists($controller_name, $action_name)) {
                $error = true;
            }
        } else {
            $error = true;
        }
        
        if ($error) {
            //$controller_name = '\controllers\SiteController';
            //$action_name = 'actionError';
            throw new Exception(T::t('PAGE_404'), 404);
        }
        
        $controller = new $controller_name;
        //$controller->$action_name(App::getParams());
        $params = App::getParams();
        if ($params) {
            call_user_func_array([$controller, $action_name], $params);
        } else {
            call_user_func([$controller, $action_name]);
        }
    }
    
    /**
     * Get an authorized user
     * @return bool|mixed
     */
    public static function user()
    {
        if (isset($_SESSION['login']) && isset($_SESSION['id'])) {
            
            return User::findOne(['user_token' => $_SESSION['id']]);
        } else {
            return false;
        }
    }
}
