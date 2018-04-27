<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 22.04.2018
 * Time: 3:16
 */

namespace controllers;
use core\App;
use core\Controller;
use models\User;

class UserController extends Controller
{
	public $dir_view = 'user';
    
    /**
     * @param int $id
     *
     */
	public function actionView($id = null)
	{
        $user = App::user();
        if (!$user) {
            $user = User::findOne($id);
        }
		
	    return $this->render('view', ['user' => $user]);
	}
 
	/**
     * Create new user
     */
	public function actionCreate()
    {
        $model = new User;
    
        if ($model->load($_POST)) {
            $model->user_token = md5($model->login);
            $model->pass = $model->password;
            $model->loadfile();
            if ($model->save()) {
                $this->redirect('site/index');
            }
        }
        
        return $this->render('create');
    }
    
    public function actionValidLogin($login)
    {
        if (User::findOne(['login' => $login])) {
            echo json_encode(['res' => true]);
        } else {
            echo json_encode(['res' => false]);
        }
    }
}