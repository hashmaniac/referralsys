<?php
class DB {
    private $conn = null;
    private $stmt = null;
    public $lastID - null;

    function __construct () {
        //connect to the database

        //Create onnection 
        $str= DB_HOST, DB_USER, DB_PASSWORD;

        if (defined('DB_NMAE')) { 
            $str .= DB_NAME;
        }
        $conn = new mysqli($str);

        //check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }
}