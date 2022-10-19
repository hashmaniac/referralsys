<?php
class DB {
    private $conn = null;
    private $stmt = null;
    public $lastID = null;

    function __construct () {
        // __construct(): connect to the database
        //param: DB_HOST, DB_USER, DB_PASSWORD, DB_NAME 

        //Create connection
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        //check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function __destruct () {
        // __destruct(): close connection when done

        if ($this->stmt !== null) { $this->stmt = null; }
        if ($this->conn !== null) { $this->conn = null; }
    }

    function exec ($sql, $data=null) {
        // exec(): run insert, delete, update, replace query
        //param $sql: SQL query
        //      $data: array of data

        $this->stmt =  $this->conn->prepare($sql);
        $this->stmt->execute($data);
        $this->lastID = $this->conn->insert_id;

        if ($this->conn->query($sql) === FALSE) {
            $this->error = $this->conn->error;
            return false;
        }
        $this->stmt = null;
        return true;
    }

    function fetchAll ($sql, $cond=null, $key=null, $value=null) {
        // fetchAll() : perform select query, multiple rows expected
        //PARAM: $sql : SQL query
        //       $cond : array of conditons
        //       $key : column used to sort, $key=>data order, optional
        //       $value : key must be provided. if string provided sort in $key=>$value order, if function, custom sort.

        $result = [];

        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute($cond);

        //sort in given order
        if(isset($key)) {
            if(isset($cond)) {
                if(is_callable($cond)) {
                    while($row = $this->stmt->fetch(MYSQLI_ASSOC)) {
                        $result[$row[$key]] = $value($row);
                    }
                } else {
                    while($row = $this->stmt->fetch(MYSQLI_ASSOC)) {
                        $result[$row[$key]] = $row[$value];
                    }
                }
            } else {
                while($row = $this->stmt->fetch(MYSQLI_ASSOC)) {
                    $result[$row[$key]] = $row;
                }
            }
        } 
        //no key-value order
        else {
            $result = $this->stmt->fetch();
        }

        //result
        $this->stmt = null;
        return count($result) == 0 ? false : $result;
    }

    function fetch ($sql, $cond=null, $sort=null) {
        // fetch() : perform select query, single row expected, returns an array of column=>value
        // PARAM : $sql : SQL query
        //         $cond : array of conditions
        //         $sort : custom sort function

        $result = [];

        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute($cond);

        if(is_callable($sort)) {
            while($row = $this->stmt->fetch(MYSQLI_ASSOC)) {
                $result = $sort($row);
            }
        } else {
            while($row = $this->stmt->fetch(MYSQLI_ASSOC)) {
                $result = $row;
            }
        }
        
        //RETURN RESULT
        $this->stmt = null;
        return count($result) == 0 ? false : $result;
    }
}