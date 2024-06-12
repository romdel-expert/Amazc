<?php
namespace Models;

use Exception;

class Database{
    
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new \PDO('mysql:host=localhost;dbname=amazc;charset=utf8', 'root', 'root');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
