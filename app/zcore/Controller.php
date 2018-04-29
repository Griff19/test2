<?php


namespace core;

/**
 * Class Controller
 * @package core
 */
class Controller
{
	public $dir_view;
	public $template = __DIR__ . '/../template/default/index.php';
	
	public function renderAjax($view, $params = [])
	{
		extract($params);
	    include __DIR__ . '/../views/' . $this->dir_view . '/' . $view . '.php';
	}
	
	/**
     * The main method of page formation
	 * @param $view
	 */
	public function render($view, $params = [])
	{
		extract($params);
     
	    ob_start();
		include __DIR__ . '/../views/' . $this->dir_view . '/' . $view . '.php';
		$content = ob_get_contents();
		ob_end_clean();
		include $this->template;
	}
	
	public function redirect($target)
    {
        header('Location:' . App::$root . $target);
    }
	
}
