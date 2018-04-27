<?php
/**
 *
 */
namespace models;

use core\Db;
use core\Model;
use core\T;
use core\Alert;

/**
 * Class User
 * @package models
 * @property $login string
 * @property $user_token string
 * @property $pass string
 * @property $email string
 * @property $snp string
 * @property $memo string
 * @property $link_file
 */
class User extends Model
{
    public $password;
    public $password2;
    
    public static function tableName()
    {
        return 'users';
    }
    
    public function fields()
    {
        return [
            'login', 'user_token', 'pass', 'email', 'snp', 'memo', 'link_file',
        ];
    }
    
    /**
     * @param $login
     * @param $password
     * @return bool
     */
    public static function validUser($login, $password)
    {
        $sql = "SELECT * FROM users WHERE login = :login AND pass = :pass";
        $db = new Db();
        $prepare = $db->connection->prepare($sql);
        if (!$prepare) {
            return false;
        }
        
        $prepare->execute(['login' => $login, 'pass' => $password]);
        
        $res = $prepare->fetch(\PDO::FETCH_LAZY);
        
        if ($res) {
            return $res;
        } else {
            return false;
        }
    }
    
    /**
     * Load image
     * @return bool|string
     */
    public function loadfile()
    {
        if ($_FILES['user_file']['size'] <= 0)
            return true;
        
        $upload_dir = __DIR__ .'/../img/';
        $file_name = md5(basename($_FILES['user_file']['name']));
        $upload_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['user_file']['tmp_name'], $upload_file)) {
            Alert::setFlash('success', T::t('FILE_LOAD'));
            $this->link_file = 'img/'. $file_name;
            return $this->link_file;
        } else {
            Alert::setFlash('error', T::t('FILE_ERROR'));
            return false;
        }
    }
    
    /**
     *
     */
    public static function isLogin()
    {
        if (isset($_SESSION['id']) && isset($_SESSION['login'])) {
            return true;
        } else {
            return false;
        }
    }
    
}
