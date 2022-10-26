<?php


class db{
    public $HOST; public $USERNAME; public $PASSWORD; public $DATABASE; public $conn;

    function __construct($host='localhost', $username='root', $password='', $database='test'){
        $this->HOST = $host;
        $this->USERNAME = $username;
        $this->PASSWORD = $password;
        $this->DATABASE = $database;
    }

    function connect(){
        if ($this->DATABASE != ''){
            $this->conn = new mysqli($this->HOST, $this->USERNAME, $this->PASSWORD, $this->DATABASE);
        }
        else{
            $this->conn = new mysqli($this->HOST, $this->USERNAME, $this->PASSWORD);
        }

        return $this->conn;
    }

    function query($query){
        return mysqli_query($this->conn, $query);
    }
}

?>