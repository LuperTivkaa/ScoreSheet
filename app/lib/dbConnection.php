<?php 
namespace ScoreSheet;
use \PDO;
class dbConnection {
//class members
private $dsn= 1;
private $host ="localhost";
private $user = "smarty_ems_2017";
private $pass = "*enterprise_ems";
private $dbname = "smarty";

private $dbh;
private $error;
private $stmt;


//constructor functions
//this constructor function is called automatically when an object of the class is initiated

public function __construct(){
	//set DSN
    /*
    this $dsnn connection string is not working properly
    the problem is simply it does not have single quotes around which the connectiion string need to have
    so we comment it out
    */
    //$dsnn ='mysql:host:'.$this->host.';dbname='.$this->dbname;

	//set OPTIONS
	$options = array(
		PDO::ATTR_PERSISTENT=>true,
		PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
		);
	//Create new PDO Object
	try{

		$this->dbh = new PDO('mysql:host=localhost;dbname=smarty',$this->user,$this->pass,$options);
	}
	catch(PDOException $e){
		$this->error = $e->getMessage();
	}
}
//End connection constructor function 

////query function

public function query($query)
{
	// query statement
	$this->stmt = $this->dbh->prepare($query);
}

// bind function
public function bind($param, $value, $type=null)
{
//check whether type is not empty
	if(is_null($type))
	{
		//use a swictch statement for each possible case
		switch(true)
		{
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
	// bind the value

	$this->stmt->bindValue($param, $value, $type);
}

// execute function
public function execute(){

	return $this->stmt->execute();
}
//

//function for resultset, select multiple records
public function resultset(){

	$this->execute();
	// there are different options to use in fetchall method apart from FETCH_ASSOC 
	return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
}
//row count
public function rowCount(){
    return $this->stmt->rowCount();
}

//function to select single
public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
}

//Begin transaction
public function beginTransaction(){
    return $this->dbh->beginTransaction();
}

//End transaction
public function endTransaction(){
    return $this->dbh->commit();
}

//Cancel transaction
public function cancelTransaction(){
    return $this->dbh->rollBack();
}













}// class closure