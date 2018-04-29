<?php

namespace core;

use models\User;

/**
 * Class Model
 * @package core
 * @property $table string - name of table in database
 * @property db \PDO
 */
class Model
{
	public $id;
	public $db;
 
	public static function tableName()
    {
        return '';
    }
    
    /**
     * Model constructor.
     * @throws Exception
     */
    function __construct()
    {
        try {
            $db       = new Db;
            $this->db = $db->connection;
        } catch (Exception $exception) {
            echo 'схватили исключение: ' . $exception; die;
        }
    }
    
    public function getTable()
    {
        $class = get_called_class();
        return $class::$table;
    }
    
    /**
     * List of fields in the model
     * @return array
     */
	public function fields()
    {
        return [];
    }
    
    /**
     *
     */
    public function fieldsToStr()
    {
        $arr = [];
        foreach ($this as $key => $value) {
            if (in_array($key, $this->fields())){
                $arr[] = $key;
            }
        }
        return implode(', ', $arr);
    }
    
    /**
     * @return array
     */
    public function fieldsToArrSql()
    {
        $arr = [];
        foreach ($this as $key => $value) {
            if (in_array($key, $this->fields())) {
                $arr[':' . $key] = $value;
            }
        }
        
        return $arr;
    }
    
    /**
     * Save the model in the database
     * @return bool
     */
    public function save()
    {
        $sql = "INSERT INTO ";
        $sql .= static::tableName(). " (";
        $sql .= $this->fieldsToStr();
        $sql .= ") VALUES (";
        $sql .= implode(', ', array_keys($this->fieldsToArrSql()));
        $sql .= ");";
        
        echo $sql;
        
        $db = new Db();
        $prepare = $db->connection->prepare($sql);
        if (!$prepare) {
            return false;
        }
        $prepare->execute($this->fieldsToArrSql());
        
        if ($prepare->errorCode()) {
            echo print_r($prepare->errorInfo());
        }
        $this->id = $db->connection->lastInsertId();
        $prepare = null;
        
        return true;
    }
    
    /**
     * Loading data into the model
     * @param $data
     * @return bool
     */
    public function load($data)
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                //if (in_array($key, $this->fields())) {
                    $this->$key = $value;
                //}
            }
        } else {
            return false;
        }
        return true;
    }
    
    /**
     * @param $token
     * @return mixed
     */
    public static function find($token)
    {
        $sql = "SELECT * FROM ". static::tableName() ." WHERE user_token = :token";
        
        $db = new Db;
        $prepare = $db->connection->prepare($sql);
        $prepare->execute(['token' => $token]);
        
        $result = $prepare->fetch(\PDO::FETCH_LAZY);
        return $result;
    }
    
    /**
     * @param $condition
     * @return mixed
     *
     */
    public static function findOne($condition)
    {
        $query = "SELECT * FROM ". static::tableName() . " WHERE ";
        if (is_array($condition)) {
            $value = reset($condition);
            $key = key($condition);
            $query .= $key . " = :" . $key . ";";
            $execute = [$key => $value];
        } else {
            $query .= " id = :id;";
            $execute = ['id' => $condition];
        }
        
        $db = new Db;
        $prepare = $db->connection->prepare($query);
        $prepare->execute($execute);
        
        $result = $prepare->fetch(\PDO::FETCH_LAZY);
        if ($result)
            return $result;
        else
            return false;
    }
    
	
}