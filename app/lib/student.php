<?php
namespace ScoreSheet;
use \PDO;
class student extends \ScoreSheet\client {

/// class members

  //class propoerties
  public $surname;
  public $firstname;
  public $lastname;
  public $dateOfBirth;
  public $sex;
  public $religion;
  public $relationship;
  public $occupation;
  public $class;
  public $classArm;
  public $bloodGroup;
  public $admissionType;
  public $sessionadmitted;
  public $conn;
 

function setClass($class)
  {
  $this->class=$class;
  }

function getClass()
  {
  return $this->class;
  }

function setSurname($surname)
  {
  if(empty($surname) || is_numeric($surname) || is_float($surname))
  {
    exit("Please you have entered a bad data!");
  }
  $this->surname = strtoupper($surname);
  }

function getSurname()
  {
  return $this-> surname;
  }

function setFirstname($firstname)
  {
  if(empty($firstname) || is_numeric($firstname) || is_float($firstname))
  {
    exit("Please you have entered a bad data!");
  }
  $this->firstname = ucfirst($firstname);
  }

function getFirstname()
  {
  return $this-> firstname;
  }

function setLastname($lastname)
  {
  if(empty($lastname) || is_numeric($lastname) || is_float($lastname))
  {
    exit("Please you have entered a bad data!");
  }
  $this->lastname = ucfirst($lastname);
  }

function getLastname()
  {
  return $this-> lastname;
  }

function setGender($sex)
  {
  $this->sex = $sex;
  }

function getGender()
  {
    return $this->sex;
  }

function setReligion($religion)
  {
    $this->religion = $religion;
  }

function getReligion()
  {
  return $this->religion;
  }

function setOccupation($occupation)
  {
  $this->occupation = $occupation;
  }

function getOccupation()
  {
    return $this->occupation;
  }


function setDob($dateOfBirth)
  {
  $this->dateOfBirth = $dateOfBirth;
  }

function getDob()
  {
    return $this->dateOfBirth;
  }

function setBloodGroup($bloodGroup)
  {
  $this->bloodGroup = $bloodGroup;
  }

function getBloodGroup()
  {
    return $this->bloodGroup;
  }


  //constructor for initializing the database
   public function __construct(dbConnection $db)
    {
    $this->conn = $db;
    }


//Get student whose id not found in student parent
public function loadNewStudent($client_id)
    {
        try {

            $query ="SELECT id, CONCAT(UPPER(surname), ' ', firstName) AS fullname FROM 
            student_initial WHERE student_initial.id NOT IN 
            (SELECT student_id_no FROM student_parent WHERE parent_sch_id=?)";
             
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $fullname = $key['fullname'];

          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
          //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$fullname."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get student details";
        }
   }
   //end load new student


//load relations
public function loadRelationship()
    {
        try {
                $query ="SELECT * FROM relationship";
                $this->conn->query($query);
                $myResult= $this->conn->resultset();
               $output =" "; 
          foreach ($myResult as $row => $key) 
            {  
            $ID = $key['id'];
            $relationship = $key['relationship'];
       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$relationship."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load relationship";
        }
   }



//Get student whose id not found in student admission table
public function getStudentAssign($client_id)
    {
        try {
            $query ="SELECT id, CONCAT(UPPER(surname), ' ', firstName) AS fullname FROM 
            student_initial WHERE student_initial.id NOT IN 
            (SELECT stud_id FROM student_admission_no WHERE my_stud_sch_id=?)";
             
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $fullname = $key['fullname'];
       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$fullname."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get student details";
        }
   }
   //end load new  and unassigned student

//function to assign a new number to a student/pupil
public  function assignNewNumber($studid,$admissionNoId,$clientid)
  {
    //always use try and catch block to write code   
  try{

          //insert new number
                            $sqlStmt = "INSERT INTO student_admission_no(stud_id,admission_number,my_stud_sch_id) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->$this->conn->bind(1, $studid, PDO::PARAM_INT);
                            $this->$this->conn->bind(2, $admissionNoId, PDO::PARAM_INT);
                            $this->$this->conn->bind(3, $clientid, PDO::PARAM_INT); 
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                         //TOGGLE ADMISSION NUMBER
                         $this->toggleAssignNum($admissionNoId);
                        } 
                        else
                        {
                        echo "Unable to add assign admission number";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
  //



//update assigned number
//change flag to true, which means active 
//active status means number can not be assigned again
public  function toggleAssignNum($admNumId)
  {
   //always use try and catch block to write code  
    try{
          //insert new number
                            $sqlStmt = "UPDATE admission_number SET status='True' WHERE id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $admNumId, PDO::PARAM_INT);
                            $this->conn->execute(); 
                              if ($this->conn->rowCount() == 1) 
                              {
                              // check number of inserted rows
                              echo "ok";
                              } 
                              else
                              {
                              echo "Unable to change admission number status";
                              }
        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
  //end  toogle assigned number


//Generate admission numbers
public function newAdmissionNumber($clientid,$limit,$dateCreated,$status='False')
        {
        try {
                    $query ="SELECT serial_number FROM admission_number WHERE adm_sch_id=? ORDER BY id DESC LIMIT 1 ";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    //$output = array();
                    $myResult = $this->conn->resultset();
                    if($myResult)
                    {
                        foreach ($myResult as $row => $key) 
                        {
                        $serial_no = $key['serial_number'];
                        }
                          //loop through the result
                          //add the 1 value to the already existing number for the initial increment
                          $serial_no+=1;
                          for($i=1; $i <= $limit; $i++)
                          {
                          
                          $sqlStmt = "INSERT INTO admission_number
                            (adm_sch_id, serial_number, status, createdBy) 
                            values (?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(2, $serial_no, PDO::PARAM_INT);
                            $this->conn->bind(3, $status, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $dateCreated, PDO::PARAM_INT);
                            $this->conn->execute(); 
                            $serial_no+=1;
                         }
                         echo "ok";
                    }
                    else
                    {
                     // generate admisssion numbers starting from 1
                      $serial_no = 0;
                       $serial_no+=1;
                       for($i=1; $i<=$limit; $i++)
                        {
                          //add the i value to the already existing number
                          //$status = False;
                          $sqlStmt = "INSERT INTO admission_number
                            (adm_sch_id, serial_number, status, createdBy) 
                            values (?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(2, $serial_no, PDO::PARAM_INT);
                            $this->conn->bind(3, $status, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $dateCreated, PDO::PARAM_INT);
                            $this->conn->execute(); 
                            $serial_no+=1;
                        }
                        echo "ok";
                    }
        }// End of try catch block
         catch(Exception $e)
        {
            echo ("Unable to create admission numbers, try again!");
        }
        }
        //end generate new admission numbers


        //LOAD UNASSIGNED ADMISSION NUMBERS
public function loadUnassignedNumber($clientid,$status='False')
        {
        try {
            //SELECT THE TOP MOST UNASSIGNED  NUMBER
                $query ="SELECT id,serial_number  
                FROM admission_number  WHERE adm_sch_id=? AND status=? ORDER BY id ASC LIMIT 1";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $status, PDO::PARAM_STR);
                    $myResult = $this->conn->resultset();
                    $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $serialNumber = $key['serial_number'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$serialNumber."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load Admission Numbers";
        }
        }
        //END LOAD UN ASSIGNED ADMISION NUMBERS




//Add New Student parent
public  function newParent($surname,$firstname,$lastname,
  $occupation,$sex,$contact_add,$mobile,$email,$relationship,
  $stud_id,$sch_id,$emergency)
    {
    // always use try and catch block to write code
     
    try{

    //
                    $sqlStmt = "INSERT INTO student_parent(surname,firstname,lastname,occupation,
                    sex,contact_add,mobile,email,relationship,student_id_no,parent_sch_id,emergency)
                             values (?,?,?,?,?,?,?,?,?,?,?,?)";
                    $this->conn->query($sqlStmt);
                    $this->$this->conn->bind(1, $this->surname, PDO::PARAM_STR);
                    $this->$this->conn->bind(2, $this->firstname, PDO::PARAM_STR);
                    $this->$this->conn->bind(3, $this->lastname, PDO::PARAM_STR);
                    $this->$this->conn->bind(4, $this->occupation, PDO::PARAM_STR);
                    $this->$this->conn->bind(5, $this->sex, PDO::PARAM_STR);
                    $this->$this->conn->bind(6, $contact_add, PDO::PARAM_STR);
                    $this->$this->conn->bind(7, $this->mobile, PDO::PARAM_STR);
                    $this->$this->conn->bind(8, $this->email, PDO::PARAM_STR);
                    $this->$this->conn->bind(9, $relationship, PDO::PARAM_STR);
                    $this->$this->conn->bind(10, $stud_id, PDO::PARAM_INT);
                    $this->$this->conn->bind(11, $sch_id, PDO::PARAM_INT);
                    $this->$this->conn->bind(12, $emergency, PDO::PARAM_STR);
                    $this->conn->execute();
                    //can not fetch result after executing insert query, it will throw general error
                   // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >=1)
                    {
                      echo "ok";
                    }
                    else{

                        echo "Error creating parent";
                        }

                   
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//end new student parent

//Add New Student
public  function newStudent($surname,$firstname,$lastname,$sex,
  $class_admtitted,$session_admitted,$adm_type,$class_arm,$date_created,
  $createdBy,$permAdd,$contAdd,$email,$sch_id,$country,$state,$city,$lga,
  $religion,$dob,$mobile,$blood,$status='Active')
    {
  
    // always use try and catch block to write code
     
  try{

          // 
          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO student_initial (surname,firstName,lastName,gender,classAdmitted,sessionAdmitted,
                            admissionType,class_description,dateCreated,createdBy,perm_home_add,contact_add,
                            email,stud_sch_id,nationality,state,city,lga,religion,dateOfBirth,mobile,status_active,blood_group)
                             values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->surname, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->firstname, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $this->lastname, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->sex, PDO::PARAM_INT); 
                            $this->conn->bind(5, $class_admtitted, PDO::PARAM_STR);
                            $this->conn->bind(6, $session_admitted, PDO::PARAM_STR,100);
                            $this->conn->bind(7, $adm_type, PDO::PARAM_STR,100);
                            $this->conn->bind(8, $class_arm, PDO::PARAM_STR,100);
                            $this->conn->bind(9, $date_created, PDO::PARAM_INT); 
                            $this->conn->bind(10, $createdBy, PDO::PARAM_STR);
                            $this->conn->bind(11, $permAdd, PDO::PARAM_STR);
                            $this->conn->bind(12, $contAdd, PDO::PARAM_STR,100);
                            $this->conn->bind(13, $this->email, PDO::PARAM_STR,100);
                            $this->conn->bind(14, $sch_id, PDO::PARAM_STR,100);
                            $this->conn->bind(15, $this->country, PDO::PARAM_INT); 
                            $this->conn->bind(16, $this->state, PDO::PARAM_STR);
                            $this->conn->bind(17, $this->city, PDO::PARAM_STR);
                            $this->conn->bind(18, $this->this->lga, PDO::PARAM_STR,100);
                            $this->conn->bind(19, $this->religion, PDO::PARAM_STR,100);
                            $this->conn->bind(20, $dob, PDO::PARAM_STR,100);
                            $this->conn->bind(21, $this->mobile, PDO::PARAM_INT); 
                            $this->conn->bind(22, $status, PDO::PARAM_STR);
                            $this->conn->bind(23, $blood, PDO::PARAM_STR);
                            
                            $this->conn->execute(); 

                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error creating student";
                      }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
//end new student parent


//ADD ADMISSION NUMBER PERFIX SETTINGS
public  function addPrefixSettings($name,$seperator,$sch_id,$addedby,$added_date,$edited_date,$status='Active')
  {
   // always use try and catch block to write code
   try{
     //TODO: Add a code  to check and make sure that school prefix is not added twice
     //TODO: Deactivate the older one first

         //INSERT PREFIX SETTINGS
                            $sqlStmt = "INSERT INTO admission_number_prefix (prefix_name,prefix_seperator,prefix_sch_id,prefix_addedby,prefix_added_date,prefix_edited_date,
                            status)
                             values (?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $seperator, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $sch_id, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $addedby, PDO::PARAM_INT); 
                            $this->conn->bind(5, $added_date, PDO::PARAM_STR);
                            $this->conn->bind(6, $edited_date, PDO::PARAM_STR,100);
                            $this->conn->bind(7, $status, PDO::PARAM_STR,100);
                            $this->conn->execute(); 

                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error creating admission number prefix settings";
                        }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
    //end new student parent










































}