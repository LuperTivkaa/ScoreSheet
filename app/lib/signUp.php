<?php
namespace ScoreSheet;
use \PDO;

/*
Remove PDO namespace in here
Its  not needed
Comment it out
*/
//use \PDO;

class signUp {
    public $instName;
    public $instType;
    public $email;
    public $password;
    public $username;
    public $conn;

// getters and setters
    //set Mail
public function setMail($email)
  {
    if(empty($email))
    {
      exit("Please provide an email");
    }
    $this->email  = $email;
  }

    //get Mail
public function getMail()
  {
    return $this->email;
  }
//set password
public function setPassword($password)
    {
      if(empty($password))
      {
        exit("Please provide a password");
      }
    $this->password  = $password;
    }

    //get password
public function getPassword()
  {
    return $this->password;
  }

//set username
public function setUserName($username)
  {
    if(empty($username))
    {
      exit("Provide a username please");
    }
  $this->username = $username;
  }

// get username
public function getUserName()
  {
  return $this->username;
  }


//class contructor
 public function __construct(dbConnection $db){
    $this->conn = $db;
  }

 //function to create new
 public  function newClient($username,$email,$password)
    {
//always use try and catch block to write code
  try{

        //check for limit of qualifications added
                    $query ="SELECT * FROM client_signup where user_name=? || email =? || password=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $this->username, PDO::PARAM_STR);
                    $this->conn->bind(2, $this->email, PDO::PARAM_STR);
                    $this->conn->bind(3, $this->password, PDO::PARAM_STR);
                    $this->conn->resultset();
                    if ($this->conn->rowCount() >=1)
                    {
                      echo "Choose unique credentials";
                    }
                    else{

  //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
  //There is so much information using the php documentation
                            $sqlQuery = "INSERT INTO client_signup(user_name,email,password) values (?,?,?)";
                            $this->conn->query($sqlQuery);
                            $this->conn->bind(1, $this->username, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->email, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $this->password, PDO::PARAM_STR);
                            $this->conn->execute();
                        if ($this->conn->rowCount() == 1)
                        {
                         // check number of inserted rows
                        echo "ok";
                        }
                        else
                        {
                        echo "Sign up failed";
                      }

                    }
      }

        catch(Exception $e)
        {
      // echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
     }
//////////////////////////////////////////////////////////////////////////////////////////////////

 //method to login into the client portal, after successful login redirect to the client portal
public  function client_login($email,$password)
 {
// always use try and catch block to write code
  try{

// select  a unique client
    $sql = "SELECT id, user_name, email, password
    FROM client_signup WHERE email = ? && password =?";
    //this is a prepared statement, it is good to avoid injection
    //note that variables are named at users discretion, you can name them what you want
    $this->conn->query($sql);
    $this->conn->bind(1, $this->email, PDO::PARAM_STR,12);
    $this->conn->bind(2, $this->password, PDO::PARAM_STR,12);
    $myResult = $this->conn->resultset();

    $sess_info = array();

            if ($this->conn->rowCount() ==1)
            {

              foreach ($myResult as $row => $key)
              {
                //loop through the resultset and get the values and store in variables
                $clientid = $key['id'];
                $user_name = $key['user_name'];
              }
              //create a session
                     session_start();
                     array_push($sess_info, $clientid,$user_name);
                     //$sess_info[] = $clientid;
                     //$sess_info[] = $user_name;
                     $_SESSION['sess_info'] = $sess_info;
                     //$_SESSION['user_info'] = $sess_info;
                     echo "ok";
            }
            else
            {
            echo "Bad Login";
            }

      }
      catch(Exception $e)
      {
      // echo error here
        //this get an error thrown by the system
    echo "Error:". $e->getMessage();
         }

     } //end of signin function


//Client root/initial account

public  function client_root($instid,$email,$username,$password,$editDate,$createDate,$role="3",$status="On")
 {
// always use try and catch block to write code
  try{

// select  a unique client
    $sql = "SELECT id
    FROM users WHERE created_By = ?";
    //this is a prepared statement, it is good to avoid injection
    //note that variables are named at users discretion, you can name them what you want
    $this->conn->query($sql);
    $this->conn->bind(1, $instid, PDO::PARAM_INT);
    //$this->conn->bind(2, $this->password, PDO::PARAM_STR,12);
    $myResult = $this->conn->resultset();

    //$sess_info = array();

            if ($this->conn->rowCount() >= 1)
            {  
                exit("Root access already created for this client!");
            }
            else
            {
            $sqlQuery = "INSERT INTO users(email,user_name,password,role,created_By,edited_on,created_on,status) 
            values (?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlQuery);
                            $this->conn->bind(1, $this->email, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->username, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $this->password, PDO::PARAM_STR);
                            $this->conn->bind(4, $role, PDO::PARAM_INT);
                            $this->conn->bind(5, $instid, PDO::PARAM_INT);
                            $this->conn->bind(6, $editDate, PDO::PARAM_STR,100);
                            $this->conn->bind(7, $createDate, PDO::PARAM_STR);
                            $this->conn->bind(8, $status, PDO::PARAM_STR,100);
                            $this->conn->execute();
                            if ($this->conn->rowCount() == 1)
                              {
                              echo "ok";
                              }
                              else{
                                exit("Error creating root access!");
                              }
            }

      }
      catch(Exception $e)
      {
      // echo error here
        //this get an error thrown by the system
    echo "Error:". $e->getMessage();
         }

     } //end of signin function

//end client or root account

//=============================================================================
//Function to log all users in i.e. admin created users
//=============================================================================
//log users and direct to the appropriate module
function user_login($email,$password,$status="On")
 {
    //try and catch block
  try{

    //select  a unique client
    $sql = "SELECT users.id AS Myid,
    users.user_name AS username,
    institutional_responsibilities.id AS roleID,
    institutional_responsibilities.responsibility_name AS rolename,
    client_signup.id AS schID
    FROM users INNER JOIN institutional_responsibilities ON users.role=institutional_responsibilities.id
    INNER JOIN client_signup ON users.created_By=client_signup.id 
    WHERE users.email = ? AND users.password =? AND users.status=?";
    $this->conn->query($sql);
    $this->conn->bind(1, $this->email, PDO::PARAM_STR,100);
    $this->conn->bind(2, $this->password, PDO::PARAM_STR,100);
    $this->conn->bind(3, $status, PDO::PARAM_STR,100);
    $user_info = array();
    $myLoginObject = array();
    $myResult = $this->conn->resultset();
    $myLoginObject=$myResult;

            if ($this->conn->rowCount() ==1)
            {

              foreach ($myResult as $row => $key)
                {
                //loop through the resultset and get the values and store in variables
                $user_id = $key['Myid'];
                $username = $key['username'];
                $roleid = $key['roleID'];
                $rolename = $key['rolename'];
                $schid = $key['schID'];
               // $schoolname = $key['schoolname'];
                }
                    //create a session
                    session_start();
                    array_push($user_info, $user_id,$username,$roleid,$rolename,$schid);
                    $_SESSION['user_info'] = $user_info;
                    //$logInfo =$_SESSION['user_info'];
                    echo json_encode($myLoginObject);
            }
            else
            {
            echo json_encode("Bad Login");
            }

      }
      catch(Exception $e)
      {
      // echo error here
      //this get an error thrown by the system
      echo "Error:". $e->getMessage();
      }

     } //end of user login ffunction


//get school name in session
function schoolProfileName($email,$password,$status="On")
 {
    //try and catch block
  try{

    //select  a unique client
    $sql = "SELECT users.id AS Myid,
    users.user_name AS username,
    institutional_responsibilities.id AS roleID,
    institutional_responsibilities.responsibility_name AS rolename,
    client_signup.id AS schID,
    institutional_signup.institution_name AS schoolname
    FROM users INNER JOIN institutional_responsibilities ON users.role=institutional_responsibilities.id
    INNER JOIN client_signup ON users.created_By=client_signup.id INNER JOIN institutional_signup ON
    users.created_By=institutional_signup.client_id
    WHERE users.email = ? AND users.password =? AND status=?";
    $this->conn->query($sql);
    $this->conn->bind(1, $this->email, PDO::PARAM_STR,12);
    $this->conn->bind(2, $this->password, PDO::PARAM_STR,12);
    $this->conn->bind(3, $status, PDO::PARAM_STR,12);
    $user_info = array();
    $myLoginObject = array();
    $myResult = $this->conn->resultset();
    $myLoginObject=$myResult;

            if ($this->conn->rowCount() ==1)
            {

              foreach ($myResult as $row => $key)
                {
                //loop through the resultset and get the values and store in variables
                $user_id = $key['Myid'];
                $username = $key['username'];
                $roleid = $key['roleID'];
                $rolename = $key['rolename'];
                $schid = $key['schID'];
                $schoolname = $key['schoolname'];
                }
                    //create a session
                    session_start();
                    array_push($user_info, $user_id,$username,$roleid,$rolename,$schid,$schoolname);
                    $_SESSION['user_info'] = $user_info;
                    //$logInfo =$_SESSION['user_info'];
                    echo json_encode($myLoginObject);
            }
            else
            {
            echo "Bad Login";
            }

      }
      catch(Exception $e)
      {
      // echo error here
      //this get an error thrown by the system
      echo "Error:". $e->getMessage();
      }

     } //end of user login ffunction







































































}




