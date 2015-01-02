<?php
class Example extends Dbop {

    private $dbConn;

    public function __construct($db = 1) {
            $this->dbConn = $db;
    }

    public function __deconstruct() {

    }

// Functions

    public function listQuizzes($id, $name) {
    $returnArray = array();
            $querySelect = 'select * from questions where id = ? and name = ?';
            $returnArray = $this->select($querySelect, array($id, $name), $this->dbConn);
            return $returnArray;
    }

    public function deleteQuizzes($userKey) {
            $queryDelete = 'delete from questions where user_key = ?';
            $cubesId = $this->delete($queryDelete, array($userKey), $this->dbConn);
            return $cubesId;
    }
}
?>