<?php
/**
 *
 */

namespace controllers;

use core\Alert;
use core\Controller;
use core\T;
use models\User;

class SiteController extends Controller
{
    public $dir_view = 'site';
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionLogin()
    {
        if (isset($_POST['login']) && isset($_POST['password'])){
            /** @var User $user */
            $user = User::validUser($_POST['login'], $_POST['password']);
            if ($user) {
                $_SESSION['id'] = $user->user_token;
                $_SESSION['login'] = $user->login;
                $this->redirect('user/view');
            } else {
                Alert::setFlash('error', T::t('ACCESS_DENI'));
            }
        }
        return $this->render('login');
    }
    
    /**
     *
     */
    public function actionLogout()
    {
        session_destroy();
        return $this->redirect('site/index');
    }
    
    public function actionError($message = '', $code = 0)
    {
        return $this->render('404', ['message' => $message, 'code' => $code]);
    }
}
