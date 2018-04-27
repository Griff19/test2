<?php
/**
 * Class Db
 * Класс работы с базой данных
 * @property PDO $connection
 * @property checkLogin
 */

namespace core;

class Db
{
    public $host;
    public $user;
    public $pass;
    public $base;
    
    public $errors;
    public $connection;
    
    
    /**
     * Db constructor.
     */
    function __construct()
    {
        $config = require(__DIR__ . '/../config/local.php');
        
        $this->host = $config['db']['host'];
        $this->user = $config['db']['user'];
        $this->pass = $config['db']['pass'];
        $this->base = $config['db']['base'];
        
        try {
            $connect = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->base, $this->user, $this->pass);
            $this->connection = $connect;
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
        }
    }
    
    /**
     * Используется для проверки уникальности логина при вводе в форме регистрации
     * @param $login
     * @return bool
     */
    public function checkLogin($login)
    {
        $sql = "SELECT id FROM users WHERE login = :login";
        
        $prepare = $this->connection->prepare($sql);
        if (!$prepare) {
            return false;
        }
        
        $prepare->execute(['login' => $login]);
        
        $res = $prepare->fetch(\PDO::FETCH_LAZY);
        
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    
}