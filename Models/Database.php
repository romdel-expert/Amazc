<?php
namespace Models;

use Exception;

class Database{
    
    protected $db;

    public function __construct()
    {
        try {
            $this->db = new \PDO('mysql:host=db5015873186.hosting-data.io;dbname=dbs12940885;charset=utf8', 'dbu1599747', 'Romdeljesus1*');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
