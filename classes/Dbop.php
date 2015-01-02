<?php

class Dbop {

    private $connection;

    /**
     * getObject gets the connection object by calling method getDBObject
     * @param Array $database containing the connection data
     * <p> This function is use to get the connection object to create connection with database</p>
     * @return void
     */
    public function getObject($database) {
        $this->connection = DbConn::getDBObject($database);
    }

    /**
     * getParamType gets the type of parameter
     * @param String $type containing the datatype
     * <p> This function is use to get the type of parameter</p>
     * @return Char
     */
    private function getParamType($type) {
        switch ($type) {
            case 'integer':
                $returnValue = 'i';
                break;
            case 'double':
                $returnValue = 'd';
                break;
            default:
                $returnValue = 's';
        }
        return $returnValue;
    }

    /**
     * select retrives data from database table
     * @param String $sql containing the query string which executes to retrive data
     * @param String $params is array variable which stores parameter types
     * @param Array $database contains database details
     * <p> This function retrives the data from database table by calling prepare & execute method</p>
     * @return Array
     */
    protected function select($sql, $params = array(), $database = DB1) {
        $resultArr = array();
        $paramType = '';
        $bindParams = array();
        $bindParams[0] = '';
        $i = 0;
        $this->getObject($database);
        $statement = $this->connection->prepare($sql);

        if (DEBUG == 1 && !$statement) {
            error_log($this->getError() . ' :: ' . $sql);
        }

        if (is_array($params)) {
            foreach ($params as $param) {
                $i++;
                $bindParams[0] .= $this->getParamType(gettype($param));
                $bindParams[$i] = $param;
            }
            $tmp = array();
            foreach ($bindParams as $key => $value)
                $tmp[$key] = &$bindParams[$key];
            call_user_func_array(array($statement, "bind_param"), $tmp);
        }

        $statement->execute();

        $allFieldsArr = $statement->result_metadata()->fetch_fields();
        foreach ($allFieldsArr as $fields) {
            $allFields[] = trim($fields->name);
        }

        for ($fieldI = 0; $fieldI < $statement->field_count; $fieldI++) {
            $fieldArray[$fieldI] = '';
        }

        $tmp = array();
        foreach ($fieldArray as $key => $value)
            $tmp[$key] = &$fieldArray[$key];
        call_user_func_array(array($statement, "bind_result"), $tmp);

        $i = 0;
        while ($row = $statement->fetch()) {
            $j = 0;
            foreach ($fieldArray as $key => $value) {
                $resultArr[$i][$allFields[$j]] = $value;
                $j++;
            }
            $i++;
        }
        $statement->close();
        return $resultArr;
    }

    /**
     * update edit data from database table
     * @param String $sql containing the query string which executes to update data
     * @param Array $params is array variable which stores parameter types
     * @param Array $database contains database details
     * <p> This function update the data from database table by calling prepare & execute method</p>
     * @return INT [Number of affected_rows]
     */
    protected function update($sql, $params = array(), $database = DB1) {
        $resultArr = array();
        $paramType = '';
        $bindParams = array();
        $bindParams[0] = '';
        $i = 0;
        $this->getObject($database);
        $statement = $this->connection->prepare($sql);

        if (DEBUG == 1 && !$statement) {
            error_log($this->getError() . ' :: ' . $sql);
        }

        if (is_array($params)) {
            foreach ($params as $param) {
                $i++;
                $bindParams[0] .= $this->getParamType(gettype($param));
                $bindParams[$i] = $param;
            }
            $tmp = array();
            foreach ($bindParams as $key => $value)
                $tmp[$key] = &$bindParams[$key];
            call_user_func_array(array($statement, "bind_param"), $tmp);
        }

        $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();
        return $affectedRows;
    }

    /**
     * delete, deletes data row from database table
     * @param String $sql containing the query string which executes to delete data
     * @param Array $params is array variable which stores parameter types
     * @param Array $database contains database details
     * <p> This function deletes the data from database table by calling prepare & execute method</p>
     * @return INT [Number of affected_rows]
     */
    protected function delete($sql, $params = array(), $database = DB1) {
        $resultArr = array();
        $paramType = '';
        $bindParams = array();
        $bindParams[0] = '';
        $i = 0;
        $this->getObject($database);
        $statement = $this->connection->prepare($sql);

        if (DEBUG == 1 && !$statement) {
            error_log($this->getError() . ' :: ' . $sql);
        }

        if (is_array($params)) {
            foreach ($params as $param) {
                $i++;
                $bindParams[0] .= $this->getParamType(gettype($param));
                $bindParams[$i] = $param;
            }
            $tmp = array();
            foreach ($bindParams as $key => $value)
                $tmp[$key] = &$bindParams[$key];
            call_user_func_array(array($statement, "bind_param"), $tmp);
        }

        $statement->execute();
        $affectedRows = $statement->affected_rows;
        $statement->close();
        return $affectedRows;
    }

    /**
     * insert is a normal method to insert data row into database table
     * @param String $sql containing the query string which executes to insert data
     * @param Array $params is array variable which stores parameter types
     * @param Array $database contains database details
     * <p> This function inserted the data in database table by calling prepare & execute method</p>
     * @return INT [Number of affected_rows]
     */
    protected function insert($sql, $params = array(), $database = DB1) {
        $success = false;
        $resultArr = array();
        $paramType = '';
        $bindParams = array();
        $bindParams[0] = '';
        $i = 0;
        $this->getObject($database);
        $statement = $this->connection->prepare($sql);

        if (DEBUG == 1 && !$statement) {
            error_log($this->getError() . ' :: ' . $sql);
        }

        if (is_array($params)) {
            foreach ($params as $param) {
                $i++;
                $bindParams[0] .= $this->getParamType(gettype($param));
                $bindParams[$i] = $param;
            }
            $tmp = array();
            foreach ($bindParams as $key => $value)
                $tmp[$key] = &$bindParams[$key];
            call_user_func_array(array($statement, "bind_param"), $tmp);
        }

        $success = $statement->execute();
        if (DEBUG == 1 && $success !== true) {
            error_log($this->getError() . ' :: ' . $sql);
        }
        $insertID = $statement->insert_id;
        $statement->close();
        return $insertID;
    }

    /**
     * execQuery is a normal method to execute the query
     * @param String $sql containing the query string which executes to update data
     * @param Array $database contains database details
     * <p> This function executes query which passed as an argument after creation of database connection</p>
     * @return Boolean [true or false] or ResultSet
     */
    protected function execQuery($sql, $database) {
        $this->getObject($database);
        try {
            return $this->connection->query($sql);
        } catch (Exception $err) {
            $err = $this->connection->error;
            throw new Exception($err);
        }
    }

    /**
     * getError displays the error message
     * <p> This function displays error message if code is not executed successfully</p>
     * @return String [Error message]
     */
    protected function getError() {
        return $this->connection->error;
    }

    /**
     * multiQuery displays the error message
     * @param String $sql contains the SQL Query
     * @param String $database contains the Database Connection Object
     * <p> This function executes one or multiple queries which are concatenated by a semicolon. </p>
     * @return Boolean [Returns FALSE if the first statement failed otherwise true]
     */
    protected function multiQuery($sql, $database) {

        $this->getObject($database);
        try {
            return $this->connection->multi_query($sql);
        } catch (Exception $err) {
            $err = $this->connection->error;
            throw new Exception($err);
        }
    }

    /**
     * getUUID create unique ID through uuid() of mysqli
     * @param Array $database contains the details of database
     * <p> This function creates UUID which is a 128-bit number represented by a utf8 string of five hexadecimal numbers in aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee format:  </p>
     * @return String Returns a Universal Unique Identifier
     */
    protected function getUUID($database) {
        $this->getObject($database);
        try {
            $query = 'select uuid() as uuid';
            $uidArr = $this->select($query, '', $database);
            return $uidArr[0]['uuid'];
        } catch (Exception $err) {
            $err = $this->connection->error;
            throw new Exception($err);
        }
        return '';
    }

}

//End of class
?>