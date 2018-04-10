<?php

/*
* 
* PDO Database Class 
* Connect to DB
* Create Prepared Statements
* Bind Values
* Return rows and results
*
*/

class Database
{
    private $dbdriver = DB_DRIVER;
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct()
    {
        // Set DSN
        $dsn = $this->dbdriver . ':host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        
        // Create new PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    
    // prepare statement with query
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    
    // bind values
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    // execute prepared statement
    public function executeStmt()
    {
        return $this->stmt->execute();
    }
    
    // Get result set as array of objects
    public function resultSet()
    {
        $this->executeStmt();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Get single result
    public function single()
    {
        $this->executeStmt();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    
    // Get row count
    public function countAllRows()
    {
        return $this->stmt->rowCount();
    }
}

