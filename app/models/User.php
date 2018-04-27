<?php
/**
 *
 */
namespace models;

use core\Db;
use core\Model;
use core\T;
use core\Alert;
use core\Helper;

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
     * Verify user login
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
     * Checking the uniqueness of the login before saving the model
     * @return bool
     */
    public function validLogin()
    {
        if (User::findOne(['login' => $this->login])) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * General model check
     * @return bool
     */
    public function validate()
    {
        $str_err = '';
        
        if(empty($this->login)) {
            $str_err .= T::t('FILL_FIELD_LOGIN'). '<br/>';
        }
        else {
            if (!preg_match('/^[a-z0-9_-]+$/i', $this->login)){
                $str_err .= T::t('LOGIN_INVALID'). '<br/>';
            } elseif ($this->validLogin()) {
                $this->login = Helper::safetyStr($this->login);
            } else {
                $str_err .= T::t('LOGIN_EXIST') . '<br/>';
            }
        }
        
        if(!empty($this->memo)) {
            $this->memo = Helper::safetyStr($this->memo);
        }
        
        if (empty($this->password))
            $str_err .= T::t('ENTER_PASS').'<br/>';
        else {
            $password = $this->password;
            if (!preg_match('/^[a-z0-9_-]{6,}$/', $password))
                $str_err .= T::t('PASS_TO_EASY'). ' <br/>';
            if (empty($this->password2))
                $str_err .= T::t('CONFIRM_PASS'). '<br/>';
            else {
                $password2 = $this->password2;
                if ($password !== $password2) {
                    $str_err .= T::t('CONFIRM_PASS_MATCH_PASS') . ' <br/>';
                }
            }
        }
        
        if (!empty($this->email)) {
            $this->email = Helper::safetyStr($this->email);
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
                $str_err .= T::t('INVALID_EMAIL'). '<br/>';
        }
        
        if (empty($this->snp)) {
            $str_err .= T::t('FILL_SNP') . '<br/>';
        } else {
            $this->snp = Helper::safetyStr($this->snp);
            $reg = '/^[^0-9]+$/i';
            if (!preg_match($reg, $this->snp))
                $str_err .= T::t('CONTAIN_ONLY_LETTERS'). '<br/>';
        }
        
        if ($str_err !== '') {
            Alert::setFlash('error', $str_err);
            return false;
        }
        return true;
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
