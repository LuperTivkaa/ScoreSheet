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
  if(empty($surname))
  {
    exit("Please provide surname");
  }
  $this->surname = strtoupper($surname);
  }

function getSurname()
  {
  return $this-> surname;
  }

function setFirstname($firstname)
  {
  if(empty($firstname))
  {
    exit("Please provide first name");
  }
  $this->firstname = ucfirst($firstname);
  }

function getFirstname()
  {
  return $this-> firstname;
  }

function setLastname($lastname)
  {
  if(empty($lastname) )
  {
    exit("Please provide last name");
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

//load all subjects taught across borad given a staff id
public function staffSubject($user_id)
    {
        try {

            $query = "SELECT subjects.sub_id AS SubjectID, subjects.subject_name AS SubjectName FROM subjects INNER JOIN staff_subject_taught ON subjects.sub_id=staff_subject_taught.subject_id WHERE staff_subject_taught.my_id=?";
             
                $this->conn->query($query);
                $this->conn->bind(1, $user_id, PDO::PARAM_INT);
               // $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        { 
          $ID = $key['SubjectID'];
          $subjectname = $key['SubjectName'];
          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
          //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$subjectname."</option>";       
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to staff subject details";
        }
   }
  //end staff subjects

  //load staff subject taught on selection of class assigned to teach class
public function staffSubjectByClass($user_id,$classid,$clientid)
    {
        try {

            $query = "SELECT subjects.sub_id AS SubjectID, subjects.subject_name AS SubjectName FROM subjects INNER JOIN staff_subject_taught ON subjects.sub_id=staff_subject_taught.subject_id WHERE staff_subject_taught.my_id=? AND staff_subject_taught.class_taught=? AND staff_subject_taught.sch_identity=?";
             
                $this->conn->query($query);
                $this->conn->bind(1, $user_id, PDO::PARAM_INT);
                $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $this->conn->bind(3, $clientid, PDO::PARAM_INT);
               // $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        { 
          $ID = $key['SubjectID'];
          $subjectname = $key['SubjectName'];
          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
          //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$subjectname."</option>";       
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to staff subject details";
        }
   }
  //end load subject by class

//load CA Settings
public function loadCASettings()
    {
        try {
                $query ="SELECT * FROM ca_settings";
                $this->conn->query($query);
                $myResult= $this->conn->resultset();
               $output =" "; 
          foreach ($myResult as $row => $key) 
            {  
            $ID = $key['ca_id'];
            $title = $key['ca_title'];
       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$title."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load CA Settings";
        }
   }
   //End of CA Settings

   //Load students whose guardian have not been added yet
public function loadStudentGuardian($client_id)
    {
        try {

            $query ="SELECT id, CONCAT(UPPER(surname), ' ', firstName) AS fullname FROM 
            student_initial WHERE student_initial.stud_sch_id=? AND student_initial.id NOT IN 
            (SELECT student_id_no FROM student_guardian WHERE parent_sch_id=?)";
             
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $this->conn->bind(2, $client_id, PDO::PARAM_INT);
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



   //end load students whose guradian have not been added yet

//Get student whose id not found in student parent
public function loadNewStudent($client_id)
    {
        try {

            $query ="SELECT id, CONCAT(UPPER(surname), ' ', firstName) AS fullname FROM 
            student_initial WHERE student_initial.stud_sch_id=? AND student_initial.id NOT IN 
            (SELECT student_id_no FROM student_parent WHERE parent_sch_id=?)";
             
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $this->conn->bind(2, $client_id, PDO::PARAM_INT);
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
function getStudentAssign($client_id)
    {
        try {
            $query ="SELECT student_initial.id, CONCAT(UPPER(student_initial.surname), ' ', student_initial.firstName) AS fullname FROM 
            student_initial WHERE student_initial.stud_sch_id=? AND student_initial.id NOT IN 
            (SELECT stud_id FROM my_number WHERE my_stud_sch_id=?)";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $this->conn->bind(2, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $fullname = $key['fullname'];
      
          $output .= '<option value='.$ID.'>'.$fullname.'</option>';
                
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
function assignNewNumber($studid,$admNoId,$clientid)
  {
    //always use try and catch block to write code   
  try{

          //insert new number
                            $sqlStmt = "INSERT INTO my_number(stud_id,admission_number,my_stud_sch_id) 
                            values (?,?,?)";
                            // $sqlStmt = "INSERT INTO my_number
                            // (studid, admno, schid) 
                            // values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studid, PDO::PARAM_INT);
                            $this->conn->bind(2, $admNoId, PDO::PARAM_INT);
                            $this->conn->bind(3, $clientid, PDO::PARAM_INT); 
                            $this->conn->execute(); 
                          if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                         //TOGGLE ADMISSION NUMBER
                         $this->toggleAssignNum($admNoId);
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


function toggleAssignNum($admNumId)
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
function newAdmissionNumber($clientid,$limit,$dateCreated,$status='False')
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
                          //add  1 value to the already existing number for the initial increment
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
function loadUnassignedNumber($clientid,$status='False')
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


//Add new guardian
function newGuardian($surname,$firstname,$lastname,
  $occupation,$sex,$contact_add,$mobile,$email,$relationship,
  $stud_id,$sch_id,$emergency)
    {
    // always use try and catch block to write code
     
    try{

    //
                    $sqlStmt = "INSERT INTO student_guardian(surname,firstname,lastname,occupation,
                    sex,contact_add,mobile,email,relationship,student_id_no,parent_sch_id,emergency)
                             values (?,?,?,?,?,?,?,?,?,?,?,?)";
                    $this->conn->query($sqlStmt);
                    $this->conn->bind(1, $this->surname, PDO::PARAM_STR);
                    $this->conn->bind(2, $this->firstname, PDO::PARAM_STR);
                    $this->conn->bind(3, $this->lastname, PDO::PARAM_STR);
                    $this->conn->bind(4, $this->occupation, PDO::PARAM_STR);
                    $this->conn->bind(5, $this->sex, PDO::PARAM_STR);
                    $this->conn->bind(6, $contact_add, PDO::PARAM_STR);
                    $this->conn->bind(7, $this->mobile, PDO::PARAM_STR);
                    $this->conn->bind(8, $this->email, PDO::PARAM_STR);
                    $this->conn->bind(9, $relationship, PDO::PARAM_STR);
                    $this->conn->bind(10, $stud_id, PDO::PARAM_INT);
                    $this->conn->bind(11, $sch_id, PDO::PARAM_INT);
                    $this->conn->bind(12, $emergency, PDO::PARAM_STR);
                    $this->conn->execute();
                    //can not fetch result after executing insert query, it will throw general error
                   // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >=1)
                    {
                      echo "ok";
                    }
                    else{

                        echo "Error creating guardian";
                        }

                   
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//add new guarddian

//Add New Student parent
function newParent($surname,$firstname,$lastname,
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
                    $this->conn->bind(1, $this->surname, PDO::PARAM_STR);
                    $this->conn->bind(2, $this->firstname, PDO::PARAM_STR);
                    $this->conn->bind(3, $this->lastname, PDO::PARAM_STR);
                    $this->conn->bind(4, $this->occupation, PDO::PARAM_STR);
                    $this->conn->bind(5, $this->sex, PDO::PARAM_STR);
                    $this->conn->bind(6, $contact_add, PDO::PARAM_STR);
                    $this->conn->bind(7, $this->mobile, PDO::PARAM_STR);
                    $this->conn->bind(8, $this->email, PDO::PARAM_STR);
                    $this->conn->bind(9, $relationship, PDO::PARAM_STR);
                    $this->conn->bind(10, $stud_id, PDO::PARAM_INT);
                    $this->conn->bind(11, $sch_id, PDO::PARAM_INT);
                    $this->conn->bind(12, $emergency, PDO::PARAM_STR);
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

//Edit Student 
public  function editStudent($studid,$schid,$surname,$firstname,$lastname,$sex,
$class_admtitted,$session_admitted,$adm_type,$date_created,
$createdBy,$permAdd,$contAdd,$email,$sch_id,$country,$state,$city,$lga,
$religion,$dob,$mobile,$blood,$status='Active')
  {

  // always use try and catch block to write code
   
try{
                          $sqlStmt = "UPDATE student_initial SET surname=?,firstName=?,lastName=?,gender=?,classAdmitted=?,sessionAdmitted=?,
                          admissionType=?,dateCreated=?,createdBy=?,perm_home_add=?,contact_add=?,
                          email=?,stud_sch_id=?,nationality=?,state=?,city=?,lga=?,religion=?,dateOfBirth=?,mobile=?,status_active=?,blood_group=? WHERE id=? AND stud_sch_id=?";
                          $this->conn->query($sqlStmt);
                          $this->conn->bind(1, $this->surname, PDO::PARAM_STR,100);
                          $this->conn->bind(2, $this->firstname, PDO::PARAM_STR,100);
                          $this->conn->bind(3, $lastname, PDO::PARAM_STR,100);
                          $this->conn->bind(4, $this->sex, PDO::PARAM_INT); 
                          $this->conn->bind(5, $class_admtitted, PDO::PARAM_STR);
                          $this->conn->bind(6, $session_admitted, PDO::PARAM_STR,100);
                          $this->conn->bind(7, $adm_type, PDO::PARAM_STR,100);
                          $this->conn->bind(8, $date_created, PDO::PARAM_INT); 
                          $this->conn->bind(9, $createdBy, PDO::PARAM_STR);
                          $this->conn->bind(10, $permAdd, PDO::PARAM_STR);
                          $this->conn->bind(11, $contAdd, PDO::PARAM_STR,100);
                          $this->conn->bind(12, $this->email, PDO::PARAM_STR,100);
                          $this->conn->bind(13, $sch_id, PDO::PARAM_STR,100);
                          $this->conn->bind(14, $this->country, PDO::PARAM_INT); 
                          $this->conn->bind(15, $this->state, PDO::PARAM_STR);
                          $this->conn->bind(16, $this->city, PDO::PARAM_STR);
                          $this->conn->bind(17, $this->lga, PDO::PARAM_STR,100);
                          $this->conn->bind(18, $this->religion, PDO::PARAM_STR,100);
                          $this->conn->bind(19, $dob, PDO::PARAM_STR,100);
                          $this->conn->bind(20, $mobile, PDO::PARAM_INT); 
                          $this->conn->bind(21, $status, PDO::PARAM_STR);
                          $this->conn->bind(22, $blood, PDO::PARAM_STR);
                          $this->conn->bind(23, $studid, PDO::PARAM_INT);
                          $this->conn->bind(24, $schid, PDO::PARAM_INT);
                          
                          $this->conn->execute(); 

                      if ($this->conn->rowCount() == 1) 
                      {
                       //check number of inserted rows
                      echo "ok";
                      } 
                      else
                      {
                      echo "Error editing student";
                    }
    }

      catch(Exception $e)
      {
      //echo error here
      //this get an error thrown by the system
      echo "Error:". $e->getMessage();
       }
}
//end edit student

//Add New Student
public  function newStudent($surname,$firstname,$lastname,$sex,
  $class_admtitted,$session_admitted,$adm_type,$date_created,
  $createdBy,$permAdd,$contAdd,$email,$sch_id,$country,$state,$city,$lga,
  $religion,$dob,$mobile,$blood,$status='Active')
    {
  
    // always use try and catch block to write code
     
  try{

          // 
          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO student_initial (surname,firstName,lastName,gender,classAdmitted,sessionAdmitted,
                            admissionType,dateCreated,createdBy,perm_home_add,contact_add,
                            email,stud_sch_id,nationality,state,city,lga,religion,dateOfBirth,mobile,status_active,blood_group)
                             values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->surname, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->firstname, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $lastname, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->sex, PDO::PARAM_INT); 
                            $this->conn->bind(5, $class_admtitted, PDO::PARAM_STR);
                            $this->conn->bind(6, $session_admitted, PDO::PARAM_STR,100);
                            $this->conn->bind(7, $adm_type, PDO::PARAM_STR,100);
                            $this->conn->bind(8, $date_created, PDO::PARAM_INT); 
                            $this->conn->bind(9, $createdBy, PDO::PARAM_STR);
                            $this->conn->bind(10, $permAdd, PDO::PARAM_STR);
                            $this->conn->bind(11, $contAdd, PDO::PARAM_STR,100);
                            $this->conn->bind(12, $this->email, PDO::PARAM_STR,100);
                            $this->conn->bind(13, $sch_id, PDO::PARAM_STR,100);
                            $this->conn->bind(14, $this->country, PDO::PARAM_INT); 
                            $this->conn->bind(15, $this->state, PDO::PARAM_STR);
                            $this->conn->bind(16, $this->city, PDO::PARAM_STR);
                            $this->conn->bind(17, $this->lga, PDO::PARAM_STR,100);
                            $this->conn->bind(18, $this->religion, PDO::PARAM_STR,100);
                            $this->conn->bind(19, $dob, PDO::PARAM_STR,100);
                            $this->conn->bind(20, $mobile, PDO::PARAM_INT); 
                            $this->conn->bind(21, $status, PDO::PARAM_STR);
                            $this->conn->bind(22, $blood, PDO::PARAM_STR);
                            
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
public  function addPrefixSettings($name,$sch_id,$addedby,$added_date,$edited_date,$status='Active')
  {
   // always use try and catch block to write code
   try{
     //TODO: Add a code  to check and make sure that school prefix is not added twice
     //To add another setting, you must deactivate the use of the first one
     //TODO: Deactivate the older one first
       $query ="SELECT prefix_id FROM 
            admission_number_prefix
            WHERE prefix_sch_id=? AND status=?";
             
                $this->conn->query($query);
                $this->conn->bind(1, $sch_id, PDO::PARAM_INT);
                $this->conn->bind(2, $status, PDO::PARAM_STR);
                $this->conn->resultset();
                if ($this->conn->rowCount() >=1)
                {
                  exit("oops! Error creating prefix, to add another setting, you must deactivate the one added earlier");
                }
                  else{
                     //INSERT PREFIX SETTINGS
                            $sqlStmt = "INSERT INTO admission_number_prefix(prefix_name,prefix_sch_id,prefix_addedby,prefix_added_date,prefix_edited_date,
                            status)
                             values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $sch_id, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $addedby, PDO::PARAM_INT); 
                            $this->conn->bind(4, $added_date, PDO::PARAM_STR);
                            $this->conn->bind(5, $edited_date, PDO::PARAM_STR,100);
                            $this->conn->bind(6, $status, PDO::PARAM_STR,100);
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
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
      }
      //end new student parent

//Method to add staff profile
public  function newStaffProfile($surname,$firstname,$lastname,
$religion,$country,$state,$lga,$city,$contact_add1,$perm_add2,$user_id,$sch_id,$email,$mobile,$sex,
$dateOfBirth,$bloodGroup,$date_created)
    {
    // always use try and catch block to write code
      try{
      $sqlStmt = "SELECT user_id FROM  staff_profile WHERE user_id=?";
      $this->conn->query($sqlStmt);
      $this->conn->bind(1, $user_id, PDO::PARAM_INT);
      $this->conn->resultset();
        if($this->conn->rowCount()>=1)
        {
          exit("You have already added your personal profile.!");
        }
        else{
          
          //Enter user information
                            $sqlStmt = "INSERT INTO staff_profile (surname,middle_name,lastname,gender,date_of_birth,mobile,
                            address_line1,address_line2,user_id,my_school_id,dateAdded,country,state,lga,city,email,bloodgroup,religion)
                             values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->surname, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->firstname, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $this->lastname, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->sex, PDO::PARAM_STR,100);
                            $this->conn->bind(5, $this->dateOfBirth, PDO::PARAM_STR,100);
                            $this->conn->bind(6, $this->mobile, PDO::PARAM_STR);
                            $this->conn->bind(7, $contact_add1, PDO::PARAM_STR,100);
                            $this->conn->bind(8, $perm_add2, PDO::PARAM_STR);
                            $this->conn->bind(9, $user_id, PDO::PARAM_INT);
                            $this->conn->bind(10, $sch_id, PDO::PARAM_INT);
                            $this->conn->bind(11, $date_created, PDO::PARAM_STR);
                            $this->conn->bind(12, $this->country, PDO::PARAM_INT);
                            $this->conn->bind(13, $this->state, PDO::PARAM_INT);
                            $this->conn->bind(14, $this->lga, PDO::PARAM_INT);
                            $this->conn->bind(15, $this->city, PDO::PARAM_INT);
                            $this->conn->bind(16, $this->email, PDO::PARAM_STR);      
                            $this->conn->bind(17, $this->bloodGroup, PDO::PARAM_STR,100);
                            $this->conn->bind(18, $this->religion, PDO::PARAM_INT);
                            $this->conn->execute(); 

                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error creating your profile";
                        }
        }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
  //End method to add staff profile

//Method to edit staff profile
public  function editStaffProfile($staffid,$sch_id,$surname,$firstname,$lastname,
$religion,$country,$state,$lga,$city,$contact_add1,$perm_add2,$email,$mobile,$sex,
$dateOfBirth,$bloodGroup)
    {
       // always use try and catch block to write code
      try{
        // $sqlStmt = "SELECT user_id FROM  staff_profile WHERE user_id=?";
         // $this->conn->query($sqlStmt);
         // $this->conn->bind(1, $user_id, PDO::PARAM_INT);
        // $this->conn->resultset();
         //   if($this->conn->rowCount()>=1)
          //   {
       //     exit("You have already added your personal profile!");
       //   }
        //else{
          
                            //Update staff profile
                            $sqlStmt = "UPDATE staff_profile SET surname=?,middle_name=?,lastname=?,gender=?,date_of_birth=?,mobile=?,
                            address_line1=?,address_line2=?,country=?,state=?,lga=?,city=?,email=?,bloodgroup=?,religion=? WHERE user_id=? AND my_school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->surname, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->firstname, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $lastname, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->sex, PDO::PARAM_STR,100);
                            $this->conn->bind(5, $this->dateOfBirth, PDO::PARAM_STR,100);
                            $this->conn->bind(6, $this->mobile, PDO::PARAM_STR);
                            $this->conn->bind(7, $contact_add1, PDO::PARAM_STR,100);
                            $this->conn->bind(8, $perm_add2, PDO::PARAM_STR);
                           // $this->conn->bind(9, $user_id, PDO::PARAM_INT);
                            // $this->conn->bind(10, $sch_id, PDO::PARAM_INT);
                            // $this->conn->bind(11, $date_created, PDO::PARAM_STR);
                            $this->conn->bind(9, $this->country, PDO::PARAM_INT);
                            $this->conn->bind(10, $this->state, PDO::PARAM_INT);
                            $this->conn->bind(11, $this->lga, PDO::PARAM_INT);
                            $this->conn->bind(12, $this->city, PDO::PARAM_INT);
                            $this->conn->bind(13, $this->email, PDO::PARAM_STR);      
                            $this->conn->bind(14, $this->bloodGroup, PDO::PARAM_STR,100);
                            $this->conn->bind(15, $this->religion, PDO::PARAM_INT);
                            $this->conn->bind(16, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(17, $sch_id, PDO::PARAM_INT);
                            $this->conn->execute(); 

                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error creating your profile";
                        }
        //}
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
//End method to edit staff profile




//Method to add qualification
public  function staffQualification($instname,$certificate,$yrgrad,$user_id,$sch_id)
    {
    // always use try and catch block to write code
     
    try{

    //
                    $sqlStmt = "INSERT INTO staff_qaulification(sch_attended,year_graduated,cert_obtained,staff_user_id,sch_id)
                             values (?,?,?,?,?)";
                    $this->conn->query($sqlStmt);
                    $this->conn->bind(1, $instname, PDO::PARAM_STR);
                    $this->conn->bind(2, $yrgrad, PDO::PARAM_STR);
                    $this->conn->bind(3, $certificate, PDO::PARAM_STR);
                    $this->conn->bind(4, $user_id, PDO::PARAM_STR);
                    $this->conn->bind(5, $sch_id, PDO::PARAM_STR);
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






































}