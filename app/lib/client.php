<?php 
namespace ScoreSheet;
use \PDO;

class client {

	//class propoerties
	public $sch_name;
	public $sch_type;
	public $country;
	public $state;
	public $lga;
	public $city;
	public $email;
	public $mobile;
	public $address;
	public $username;
	public $password;
	public $priority;
	public $notes;
    public $role;
    public $conn;


function setRole($role)
    {
  // if(empty($role) || is_numeric($role) || !is_float($role))
  // {
  //   exit("Inconsistent data");
  // }
  $this->role=$role;
    }

function getRole()
    {
return $this->role;
    }

function setSchName($sch_name)
	{
	if(empty($sch_name) || is_numeric($sch_name) || is_float($sch_name))
	{
		exit("Please you have entered a bad data!");
	}
	$this->sch_name = ucwords($sch_name);
	}

function getSchName()
	{
	return $this-> sch_name;
	}

function setSchType($sch_type)
	{
	$this->sch_type = $sch_type;
	}

function getSchType()
	{
		return $this->sch_type;
	}

function setCountry($country)
	{
		$this->country = $country;
	}

function getCountry()
	{
	return $this->country;
	}

function setState($state)
	{
	$this->state = $state;
	}

function getState()
	{
		return $this->state;
	}

function setLga($lga)
	{
		$this->lga = $lga;
	}

function getLga()
	{
		return $this->lga;
	}

function setCity($city)
	{
		$this->city = $city;
	}

function getCity()
	{
		return $this->city;
	}

function setEmail($email)
	{
		if(empty($email)){
			exit("Provide an email!");
		}
		$this->email= $email;
	}


function getEmail()
  {
  return $this->email;
  }
function setAddress($address)
	{
		if(empty($address)){
			exit("Provide an address");
		}
		$this->address = $address;
	}

function getAddress()
	{
		return $this->address;
	}

function setMobile($mobile)
	{
		if($mobile == null && !is_numeric($mobile) && strlen($mobile) !=11)
    	{
        exit("Bad phone number given");
    	}
		$this->mobile = $mobile;
	}

function getMobile()
	{
		return $this->mobile;
	}

function setUserName($username)
	{
		if(empty($username))
		{
			exit("Provide a username");
		}
		$this->username =ucfirst($username);
	}

function getUserName()
	{
		return $this->username;
	}

function setPassword($password)
	{
		if(empty($password))
		{
			exit("Provide a password");
		}
		$this->password = $password;
	}

function getPassword()
	{
		return $this->password;
	}


function setPriority($priority)
	{
	if(empty($priority) || is_numeric($priority) || is_float($priority))
	{
		exit("Please you have entered a bad data!");
	}
	$this->priority = $priority;
	}

function getPriority()
	{
	return $this->priority;
	}

function setNotes($notes)
	{
		if(empty($notes))
		{
			exit("Please give details of your problem");
		}
		$this->notes = $notes;
	}


function getNotes()
	{
		return $this->notes;
	}

    //class  constructor
public function __construct(dbConnection $db)
    {
    $this->conn = $db;
    }

    
 //METHOD TO GET ACTIVE SESSION
function getActiveSession($schid,$status='Active')
 {
  //always use try and catch block to write code
  try{
        //SELECT THE ID OF THE ACTIVE SESSION BASED ON THE INSTITUTION
          $sqlStmt = "SELECT id AS SESSION_ID FROM session WHERE sess_inst_id=? AND active_status=?";
          $this->conn->query($sqlStmt);
          $this->conn->bind(1, $schid, PDO::PARAM_INT);
          $this->conn->bind(2, $status, PDO::PARAM_STR);
          $myResult = $this->conn->resultset();
              if ($this->conn->rowCount() == 1)
                {
                  //loop through the result set
                  foreach ($myResult as $row => $key)
					        {
					            $sessionID = $key['SESSION_ID'];
					        }
					        // retrun the ID  OF THE STUDENT
					        return $sessionID;
               }
                        else
                        {
                        exit("No active sesion available for your institution, please enable it!");
                        }
       }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//END GET ACTIVE SESSION METHOD


//METHOD TO GET THE ACTIVE TERM
function getActiveTerm($schid,$status='Active')
 {
    //always use try and catch block to write code
  try 
    {
        //SELECT THE ID OF THE ACTIVE TERM BASED ON THE INSTITUTION
          $sqlStmt = "SELECT term_id AS TERM_ID FROM sch_term WHERE term_inst_id=? AND term_status=?";
          $this->conn->query($sqlStmt);
          $this->conn->bind(1, $schid, PDO::PARAM_INT);
          $this->conn->bind(2, $status, PDO::PARAM_STR);
          $myResult = $this->conn->resultset();
              if ($this->conn->rowCount() == 1)
              {
                 //loop through the result set
                 foreach ($myResult as $row => $key)
					        {
					            $termID = $key['TERM_ID'];
					        }
					        // retrun the ID  OF THE STUDENT
					        return $termID;
              }
              else
              {
              exit("No active term available for your institution, please enable it!");

              }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
//END METHOD TO GET ACTIVE TERM   
    
    //load class arm
public function loadClassArm($class_id)
    {
        try {
                $query ="SELECT id,arm_description AS arm FROM class_arm WHERE class_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $class_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $arm = $key['arm'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$arm."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get class arms";
        }
   }
   //end load class arm function
    //get all fees
public function allFeeItems($clientid)
        {
        try {
                $query ="SELECT fee_items.id AS ID,fee_items.item_name AS name, 
                fee_items.amount AS amt,sch_term.term AS myt,session.session AS S
                FROM fee_items 
                INNER JOIN sch_term ON fee_items.item_term = sch_term.term_id 
                INNER JOIN session ON fee_items.item_session=session.id  
                WHERE fee_item_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset(); 
                    $output = "";
                    $output .= '<h5 class="top-header mt-2">All Fee Item(s)</h5><br/>';
                    $output .='<table class="table">';
                    $output .='<thead><tr><th>Item Name</th><th>Amount</th><th>Term</th><th>Session</th><th>Edit</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $itemname = $key['name'];
                    $itemamount = $key['amt'];
                    $term = $key['myt'];
                    $session = $key['S'];
                    
                    //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                    //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
                   $output.= '<tr>';
                   $output.='<td>'.$itemname.'</td>';
                   $output.= '<td>'.$itemamount.'</td>';
                   $output.='<td>'.$term.'</td>';
                   $output.= '<td>'.$session.'</td>';
                    $output.='<td><button onclick="editFee('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
Edit</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else
                    {
                      echo ("No fee items added yet!");
                    }
        }// End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch fee items");
        }
        }

        //end get fee items
//load sessions
public function loadSession($clientid)
    {
        try {
                $query ="SELECT id,session FROM session WHERE sess_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $session = $key['session'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$session."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load sessions";
        }
    }
        //end load all sessions
//load terms
public function loadTerm($clientid)
    {
        try {
                $query ="SELECT term_id,term FROM sch_term WHERE term_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['term_id'];
            $term = $key['term'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$term."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load sessions";
        }
        }
//select all institutional subjects
public function allSubjects($client_id)
    {
        try {

                $query ="SELECT subjects.sub_id,subject_name AS subjectname FROM subjects 
                WHERE my_sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['sub_id'];
            $subjectname = $key['subjectname'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$subjectname."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get subject details";
        }
   }
   //end all subjects

public function getAllStudents($id)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ', ', lastName, ' ', lastname) AS fullname, gender,img,status_active FROM student_initial
                WHERE stud_sch_id=? ORDER BY gender AND surname ASC";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output= $myResult;
                    if($output)
                    {
                      echo json_encode($output);
                    }
                    else
                    {
                      echo json_encode("No matching records found!");
                    }
                }//End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Uanble to fetch active students records");
        }
    }
    //end of all students
//add new fee item
public  function feeItem($item_name,$amount,$amt_wrds,$clientid,$term,$session)
  {  
  try{
          //insert new term
                            $sqlStmt = "INSERT INTO fee_items 
                            (item_name,amount,amount_words,fee_item_sch_id,item_term,item_session) 
                            values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $item_name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $amount, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $amt_wrds, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $clientid, PDO::PARAM_STR,100);
                            $this->conn->bind(5, $term, PDO::PARAM_STR,100);
                            $this->conn->bind(6, $session, PDO::PARAM_STR,100);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Fee item not created, try again!";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//end  fee item method

//Method to get student list that are active
public function initialStudentList($schid,$status="Active")
        {
        try {
                $query ="SELECT id AS studentID, CONCAT(UPPER(surname), ', ', lastName, ' ', lastname) AS fullname, gender AS Sex,img AS Image,status_active AS Active FROM student_initial
                WHERE stud_sch_id=? && status_active =? ORDER BY gender AND surname DESC LIMIT 0,10";
                    $this->conn->query($query);
                    $this->conn->bind(1, $schid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $status, PDO::PARAM_STR); 
                    $output = "";
                    $myResult = $this->conn->resultset();
                    //echo table headings
                $output .='<table class="table">';
                $output .='<thead><tr><th>Full Name</th><th>Sex</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['studentID'];
                    $fullname = $key['fullname'];
                    $sex = $key['Sex'];
                    $status = $key['Active'];
                    //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                    //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
                   $output.= '<tr>';
                   $output.='<td>'.$fullname.'</td>';
                   $output.= '<td>'.$sex.'</td>';
                   $output.='<td>'.$status.'</td>';
                   $output.='<td><button onclick="displayDetails('.$ID.')" class="btn btn-info btn-sm">View</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No student found!";
                    }
                    
                }//End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Uanble to fetch active students records");
        }
    }
//End initial student list

//Other students list
public function otherStudentList($schid,$status="Active",$no)
        {
        try {
                $query ="SELECT id AS studentID, CONCAT(UPPER(surname), ', ', lastName, ' ', lastname) AS fullname, gender AS Sex,img AS Image,status_active AS Active FROM student_initial
                WHERE stud_sch_id=? && status_active =? ORDER BY gender AND surname DESC LIMIT :start,10";
                    $this->conn->query($query);
                    $this->conn->bind(1, $schid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $status, PDO::PARAM_INT);
                    $this->conn->bind(':start', $no, PDO::PARAM_INT);
                    $output = "";
                    $myResult = $this->conn->resultset();
                //echo table headings
                //$output .='<table class="table">';
                //$output .='<thead><tr><th>#</th><th>Full //Name</th><th>Sex</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['studentID'];
                    $fullname = $key['fullname'];
                    $sex = $key['Sex'];
                    $status = $key['Active'];
                    //
                   $output.='<tr>';
                   $output.='<td>'.$fullname.'</td>';
                   $output.='<td>'.$sex.'</td>';
                   $output.='<td>'.$status.'</td>';
                   $output.='<td><button onclick="displayDetails('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-eye fa-fw" aria-hidden="true"></i>
View</button></td>';
                   $output.='</tr>';
                    }
                    //$output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No student found!";
                    }
                    
                }//End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Uanble to fetch active students records");
        }
    }
//end other student list

//male staff count
public function getMaleStaff($id)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, user_img FROM staff_profile
                WHERE my_school_id=? AND gender='male'";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output = $myResult;
                    if($output)
                    {
                      echo json_encode($output);
                    }
                    else
                    {
                      echo json_encode("No Male Staff Yet!");
                    }
                }//End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch Male Staff");
        }
        }

        //end get male staff



//male staff count

public function getFemaleStaff($id)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, user_img FROM staff_profile
                WHERE my_school_id=? AND gender='female'";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output = $myResult;
                    if($output)
                    {
                      echo json_encode($output);
                    }
                    else
                    {
                      echo json_encode("No Female Staff Yet!");
                    }
                    //echo json_encode($output);
        }//End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch female Staff");
        }
        }

        //end get male staff


//add subject taught by staff
public  function addSubject($subject_id,$class_id,$staff_id,$sch_id,$addedDate,$editedDate,$createdBy)
  {
   // always use try and catch block to write code
  try{
      //ccheck for duplicate values for subject, class arm and staff
                    $query ="SELECT * FROM staff_subject_taught WHERE subject_id=? AND class_taught=? AND my_id=? AND sch_identity=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                    $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                    $this->conn->bind(3, $staff_id, PDO::PARAM_INT);
                    $this->conn->bind(4, $sch_id, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("This user already has already being assigned this subject for this class");
                    }
                    else{
                        //check for duplicate subject per class
                        $query ="SELECT * FROM staff_subject_taught WHERE subject_id=? AND class_taught=? AND sch_identity=?";
                        $this->conn->query($query);
                         $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                        $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                        $this->conn->bind(3, $sch_id, PDO::PARAM_INT);
                        $this->conn->execute();
                        if ($this->conn->rowCount() >= 1)
                        {
                            exit("This subject exist for this class already");
                        }
                        else{
                        //insert new subjects  taught by staff 
                            $sqlStmt = "INSERT INTO staff_subject_taught(subject_id,
                            class_taught,my_id,sch_identity,addedDate,editedDate,addedBy)
                             values (?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $subject_id, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $class_id, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $staff_id, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $sch_id, PDO::PARAM_INT); 
                            $this->conn->bind(5, $addedDate, PDO::PARAM_STR);
                            $this->conn->bind(6, $editedDate, PDO::PARAM_STR); 
                            $this->conn->bind(7, $createdBy, PDO::PARAM_INT); 
                            $this->conn->execute(); 
                            if ($this->conn->rowCount() == 1) 
                            {
                            //check number of inserted rows
                            echo "ok";
                            } 
                            else
                            {
                            echo "Error adding subject";
                            }
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
    //end subject taught

//Add New Staff
public  function newStaff($email,$username,$password,$role,$clientid,$editedDate,$createdDate)
  {
    // always use try and catch block to write code
    try
        {

                   //check for existence of the staff
                    $query ="SELECT * FROM users where email=? || user_name =? || password=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $this->email, PDO::PARAM_STR);
                    $this->conn->bind(2, $this->username, PDO::PARAM_STR);
                    $this->conn->bind(3, $this->password, PDO::PARAM_STR);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >=1)
                    {
                      echo "Please make sure your credentials are unique";
                    }
                    else{

        
                    //Insert new staff user
                            $sqlStmt = "INSERT INTO users(email,user_name,
                            password,role,created_By,
                            edited_on,created_on)
                             values (?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->email, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->username, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $this->password, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->role, PDO::PARAM_STR,100);
                            $this->conn->bind(5, $clientid, PDO::PARAM_INT); 
                            $this->conn->bind(6, $editedDate, PDO::PARAM_STR);
                            $this->conn->bind(7, $createdDate, PDO::PARAM_STR);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                            {
                         //check number of inserted rows
                            echo "ok";
                            } 
                            else
                            {
                            echo "Error creating staff";
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
//end new staff

    //function to create institution profile
public  function instProfile($sch_name,$sch_type,$clientid,$country,$state,$lg,$city,$mobile,$webadd,$email,$strtAdd,$mailbox)
 	{
    // always use try and catch block to write code
     
    try
        {

                //check for duplicate/u
                    $query ="SELECT * FROM institutional_signup WHERE client_id =?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_STR);
                    $this->conn->execute();
                    if ($this->conn->rowCount() >= 1)
                    {
                      echo "Please you can add only one institution per user";
                    }
                    else{


          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO institutional_signup(institution_name,institution_type,
                            client_id,country_id,state_id,
                            lg_id,inst_city_id,
                            inst_mobile,web_address,email_add,street_address,mail_box) 
                            values (?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->sch_name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->sch_type, PDO::PARAM_INT);
                            $this->conn->bind(3, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(4, $this->country, PDO::PARAM_INT); 
                            $this->conn->bind(5, $this->state, PDO::PARAM_INT);
                            $this->conn->bind(6, $this->lg, PDO::PARAM_INT); 
                            $this->conn->bind(7, $this->city, PDO::PARAM_INT);
                            $this->conn->bind(8, $this->mobile, PDO::PARAM_STR);
                            $this->conn->bind(9, $webadd, PDO::PARAM_STR);
                            $this->conn->bind(10, $this->email, PDO::PARAM_STR);
                            $this->conn->bind(11, $this->strtAdd, PDO::PARAM_STR);
                            $this->conn->bind(12, $this->mailbox, PDO::PARAM_STR);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                            {
                         // check number of inserted rows
                            echo "ok";
                            } 
                        else
                            {
                            echo "Error creating institutional profile";
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

// get profile of intitution form the database
public function schProfile($id)
        {
        try {
                $query ="SELECT institutional_signup.institution_name, 
                institutional_category.category_name,
                nationality.nationality,states.state_name,
                lga.lga,city.city_name,institutional_signup.inst_add,
                institutional_signup.inst_mobile,
                institutional_signup.inst_logo FROM institutional_signup 
                INNER JOIN institutional_category ON institutional_signup.institution_type = institutional_category.id 
                INNER JOIN nationality ON institutional_signup.country_id=nationality.id 
                INNER JOIN states ON institutional_signup.state_id=states.id 
                INNER JOIN lga ON institutional_signup.lg_id=lga.id 
                INNER JOIN city ON institutional_signup.inst_city_id=city.id 
                WHERE client_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output=$myResult;
                    echo json_encode($output);
        }// End of try catch block
         catch(Exception $e)
            {
            echo json_encode("Error: Unable to fetch school Profile");
            }
        }

        //end get profile


// Institution Header
//This functions displays the name of the school at the top of every page
public function schHeader($id)
        {
        try {
                $query ="SELECT institutional_signup.institution_name AS SchoolName,             
                institutional_signup.inst_logo AS Logo FROM institutional_signup 
                WHERE client_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $myResult = $this->conn->resultset();
                    $printOutPut = " ";
                    if($myResult)
                    {
                        foreach($myResult as $row => $key)
                        {
                            $schoolname = $key['SchoolName'];
                            $logo = $key['Logo'];
                            $logoPrint = '<li><img src="'.$logo.'" alt="School Logo" class="school-avatar"></li>';    
                        }
                                if(empty($schoolname)){
                                    $schoolname = "ScoreSheet";
                                } elseif(empty($logo)){
                                    $logoPrint = '<li><img src="../images/profile-icon.png" alt="School Logo" class="school-avatar"></>';
                                }
                                $printOutPut.='<ul class="school-header">';
                                $printOutPut.=$logoPrint;
                                $printOutPut.='<li><h4>'.$schoolname.'</h4></li>';
                                $printOutPut.='</ul>';
                    }
                    echo $printOutPut;
            }// End of try catch block
         catch(Exception $e)
            {
            echo ("Error: Unable to fetch school Profile");
            }
        }

        //end get profile

//end of Institution Header

 //this function loads institutional category
public function loadInstCategory()
    {
        try {
                $query ="SELECT * FROM institutional_category";
                    $this->conn->query($query);
 		            //$this->conn->execute();
                $myResult = $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $category = $key['category_name'];

          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
          //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$category."</option>";
                
        }
        echo $output;
            }// End of try catch block
            catch(Exception $e)
            {
            echo "Error: Unable to institution category";
            }
   }
   //end load institutional category

//Load all staff
public function allStaff($client_id)
    {
        try {
                $query ="SELECT users.id,users.user_name FROM users WHERE  created_By=?";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $username = $key['user_name'];
          $output .= "<option value=".$ID.">".$username."</option>";
                
        }
       echo $output;
            }// End of try catch block
         catch(Exception $e)
            {
            echo "Error: Unable to get staff details";
            }
   }

//End all Staff

//Get All Staff
public function loadStaff($client_id)
    {
        try {
                $query ="SELECT users.id,users.user_name FROM users WHERE users.id NOT IN (SELECT user_id FROM staff_profile WHERE my_school_id=?)";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $username = $key['user_name'];
          $output .= "<option value=".$ID.">".$username."</option>";
                
        }
       echo $output;
            }// End of try catch block
         catch(Exception $e)
            {
            echo "Error: Unable to get staff details";
            }
   }
   //end load staff functionlist



//Get class
public function loadClass($client_id)
    {
        try {
                $query ="SELECT id,class_name FROM class WHERE my_inst_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $classname = $key['class_name'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$classname."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get class details";
        }
   }
   //end load class function



//Get subject
public function loadSubject($class_id,$sch_id)
    {
        try {
                $query ="SELECT subjects.sub_id,subject_name FROM subjects INNER JOIN class_subject ON 
                class_subject.subject_id=subjects.sub_id WHERE class_subject.class_id=? AND subjects.my_sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $class_id, PDO::PARAM_INT);
                $this->conn->bind(2, $sch_id, PDO::PARAM_INT);
                $myResult= $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['sub_id'];
            $subjectname = $key['subject_name'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$subjectname."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get subject details";
        }
   }
   //end load subject function


   //load institutional roles function
   public function loadRoles()
    {
        try {
                $query ="SELECT * FROM institutional_responsibilities";
                    $this->conn->query($query);
                $myResult = $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $role = $key['responsibility_name'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$role."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Error loading roles";
        }
   }

// end of institutional category

 //this function loads nationality
public function loadNationality()
    {
        try {
                $query ="SELECT * FROM nationality";
                    $this->conn->query($query);
                $myResult = $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $country = $key['nationality'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$country."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load country";
        }
   }

// load states on selection of nationality
     //this function loads state
public function loadStates($id)
    {
        try {
                $query ="SELECT id,state_name FROM states WHERE nation_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
            {
            
            $ID = $key['id'];
            $states = $key['state_name'];

            //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$states."</option>";
                
            }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load states";
        }
        }

// load lga  on selection of states
     //this function loads state
public function loadLga($id)
    {
        try {
        
                $query ="SELECT id,lga FROM lga WHERE state_lg_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
            {
            
            $ID = $key['id'];
            $lga = $key['lga'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$lga."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load local goverment";
        }
        }


// load city  on selection of local governments
public function loadCity($id)
    {
        try {
                $query ="SELECT id,city_name FROM city WHERE lg_govt_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $city = $key['city_name'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$city."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load cities";
        }
        }
        //end function to load city

//Method to load class category based on school
public function classCategory($clientid)
    {
        try {
                $query ="SELECT id,class_category FROM class_category WHERE class_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
               $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $classCategory = $key['class_category'];

          $output .= "<option value=".$ID.">".$classCategory."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load class   category";
        }
        }


//End method to load class category based on school


//Create new class category
public  function newClassCategory($category,$clientid,$userid)
  {
  //always use try and catch block to write code   
  try{
          //insert new term
                            $sqlStmt = "INSERT INTO class_category (class_category,class_sch_id,createdBy) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $category, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(3, $userid, PDO::PARAM_INT);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create class category, try again";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//Create new class category

//add new school term
public  function newTerm($term,$clientid,$status='Inactive')
  {

  //always use try and catch block to write code   
  try{
          //insert new term
                            $sqlStmt = "INSERT INTO sch_term (term,term_inst_id,term_status) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $term, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $status, PDO::PARAM_STR,100);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create school term, try again";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//end term

//new academic session
 //create new academic sessionss
public  function newAcademicSession($session,$clientid,$status="Inactive")
  {
     
  try{
          //insert new session
                            $sqlStmt = "INSERT INTO session(session,sess_inst_id,active_status) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $session, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $status, PDO::PARAM_STR,100);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create session, try again";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
  //end  create academic session
//Get My Session
public function allSessions($clientid)
        {
        try {

                $query ="SELECT id AS ID, session AS Session,active_status AS Status
                FROM session
                WHERE sess_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Sessions</h5><br/>";
                    $output .='<table class="table">';
                    $output .='<thead>
                    <tr><th>Session</th><th>Action</th><th>Edit</th>
                    </tr></thead>
                    <tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $session = $key['Session'];
                    $status = $key['Status'];
                    //active status
                        if($key['Status'] =='Active'){
                        $active_status = '<button type="button"  data-recordid="'.$key['ID'].'" class="approvedBtn" id="off">Deactivate</button>';
                        }else{
                        $active_status= '<button type="button"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="on">Activate</button>';
                        }
                   
                   $output.= '<tr>';
                   $output.='<td>'.$session.'</td>';
                   $output.='<td>'.$active_status.'</td>';
                    $output.='<td><button type="button" data-value="'.$session.'" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm session-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
                   $output.='</tr>';
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No session found yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch sessions");
        }
        }
        //end get my sessions

//Function to select all classes

//Function to select admission number settings
public function admissionNumberSettings($clientid)
        {
        try {

                $query ="SELECT prefix_id AS ID, prefix_name AS settingName, status AS Status
                FROM admission_number_prefix
                WHERE prefix_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Sessions</h5><br/>";
                    $output .='<table class="table">';
                    $output .='<thead>
                    <tr><th>Setting</th><th>Action</th><th>Edit</th>
                    </tr></thead>
                    <tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $setting = $key['settingName'];
                    $status = $key['Status'];
                    //active status
                        if($key['Status'] =='Active'){
                        $active_status = '<button type="button"  data-recordid="'.$key['ID'].'" class="approvedBtn" id="prefixOff">Deactivate</button>';
                        }else{
                        $active_status= '<button type="button"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="prefixOn">Activate</button>';
                        }
                   
                   $output.= '<tr>';
                   $output.='<td>'.$setting.'</td>';
                   $output.='<td>'.$active_status.'</td>';
                    $output.='<td><button type="button" data-value="'.$setting.'" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm prefix-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
                   $output.='</tr>';
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No session found yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch sessions");
        }
        }
//End function to select admission number settings



public function allClasses($clientid)
        {
        try {

                $query ="SELECT id AS ID, class_name AS ClassName
                FROM class
                WHERE my_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Classes</h5><br/>";
                    $output .='<table class="table">';
                    $output .='<thead>
                    <tr><th>Class Name</th><th>Edit</th>
                    </tr></thead>
                    <tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $class = $key['ClassName'];
                   $output.= '<tr>';
                   $output.='<td>'.$class.'</td>';
                    $output.='<td><button type="button" data-value="'.$class.'" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm class-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
                   $output.='</tr>';
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No Class found yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch Class");
        }
        }

//End function to select all classes

        //============================================================
//add new subject
public  function newSubject($subjname,$clientid)
  { 
  try{

                //insert new subject
                            $sqlStmt = "INSERT INTO subjects (subject_name,my_sch_id) 
                            values (?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $subjname, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                        // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create school subject, try again";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
    }
//end new subject
//=================================================
/*
method block to assign subject to class
*/
public  function assignSubject($subject_id,$class_id,$sch_id)
  {
  try{
    //Check to prevent assigning the same subject to a class twice
     $query ="SELECT id FROM 
            class_subject
            WHERE subject_id=? && class_id=? && school_id=?";
             
                $this->conn->query($query);
                $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                $this->conn->bind(3, $sch_id, PDO::PARAM_INT);
                $this->conn->resultset();
                if ($this->conn->rowCount() >=1)
                {
                    exit("This subject has already been added to this class!");
                }
                else{
                            //insert new subjects  taught by staff 
                            $sql = "INSERT INTO class_subject(subject_id,
                            class_id,school_id)
                             values (?,?,?)";
                            $this->conn->query($sql);
                            $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                            $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                            $this->conn->bind(3, $sch_id, PDO::PARAM_INT); 
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error assigning subject to class";
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
    // End of method block to assign subject
    //===========================================

//================================================
//ADD NEW SCHOOL CLASS
public  function newClass($class,$category,$clientid)
  {
  
  try{
          //insert new class
                            $sqlStmt = "INSERT INTO class (class_name,my_inst_id,class_categoryid) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $class, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(3, $category, PDO::PARAM_INT);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                        // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create school class, try again";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
        }
    //end  create new class


  /*
method block to assign subject to class
*/

//=============================
//REMOVE METHOD
// public  function assignClassArm($class_desc,$class_id)
//   {
//   try{

//                             //insert new subjects  taught by staff 
//                             $sql = "INSERT INTO class_arm(
//                             arm_description,class_id)
//                              values (?,?)";
//                             $this->conn->query($sql);
//                             $this->conn->bind(1, $class_desc, PDO::PARAM_STR);
//                             $this->conn->bind(2, $class_id, PDO::PARAM_INT);
//                             $this->conn->execute(); 
//                         if ($this->conn->rowCount() == 1) 
//                         {
//                          //check number of inserted rows
//                         echo "ok";
//                         } 
//                         else
//                         {
//                         echo "Error creating class description";
//                         }  
//       }

//         catch(Exception $e)
//         {
//         //echo error here
//         //this get an error thrown by the system
//         echo "Error:". $e->getMessage();
//          }
// }
// End of method block to assign class arm description
//===========================================

//================================
//all terms 
public function allTerms($clientid)
        {
        try {

                $query ="SELECT term_id AS ID, term AS Term, term_status AS Status
                FROM sch_term
                WHERE term_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Terms</h5><br/>";
                    $output .='<table class="table">';
            $output .='<thead>
            <tr><th>Term</th><th>Action</th><th>Edit</th></tr>
            </thead>
            <tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                         
                        //approval status
                        if($key['Status'] =='Active'){
                        $active_status = '<button type="button"  data-recordid="'.$key['ID'].'" class="approvedBtn" id="deactivate">Deactivate</button>';
                        }else{
                        $active_status= '<button type="button"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="activate">Activate</button>';
                        }
                   // $ID = $key['ID'];
                    $term = $key['Term'];
                    $status = $key['Status'];
                   
                    $output.= '<tr>';
                    $output.='<td>'.$term.'</td>';
                    $output.='<td>'.$active_status.'</td>';
                    $output.='<td><button type="button" data-value="'.$term.'" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm term-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No academic term added yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo ("Error: Unable to fetch academic term");
        }
        }
//end all terms


//display all school subject
public function mySubjects($clientid)
        {
        try {

                $query ="SELECT sub_id AS ID, subject_name AS Subject
                FROM subjects
                WHERE my_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Subjects </h5><br/>";
                    $output .='<table class="table">';
                    $output .='<thead><tr><th>Subject</th><th>Edit</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $subj = $key['Subject'];
                    $output.= '<tr>';
                    $output.='<td>'.$subj.'</td>';
                    $output.='<td><button type="button" data-value="'.$subj.'" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm subject-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No subject added yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo json_encode("Error: Unable to fetch academic term");
        }
        }
//end display school subject

//Load affective and psychomotor skills
public function fetchPsychomotor($clientid)
    {
        try {
                $query ="SELECT id,description FROM psychomotor_skills WHERE sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $descr = $key['description'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$descr."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load sessions";
        }
    }
        //end fetch psychomotor skills

        //fetch affective domain
public function fetchAffectiveDomain($clientid)
        {
        try {
                $query ="SELECT id,description FROM affective_domain WHERE sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $descr = $key['description'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$descr."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load sessions";
        }
    }
//end fetch affective domain


//fetch skills grading system
public function fetchGrading()
        {
        try {
                $query ="SELECT id,description FROM rating_system";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['id'];
            $descr = $key['description'];

          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$descr."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load sessions";
        }
        }

        //end fetch grading system

//Create class teacher
public  function addClassTeacher($staff_id,$class_id,$schid,$createdBy,$addedDate)
  {
   // always use try and catch block to write code
  try{
      //make sure only one staff is assigned as a class teacher
                    $query ="SELECT id FROM class_teacher WHERE staff_id=? AND class_id=? AND school_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $staff_id, PDO::PARAM_INT);
                    $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                    $this->conn->bind(3, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("This staff has been assigned this class already!");
                    }
                    else{
                            //check for duplicate subject per class
                            $query ="SELECT class_id FROM class_teacher WHERE class_id=? AND school_id=?";
                            $this->conn->query($query);
                            $this->conn->bind(1, $class_id, PDO::PARAM_INT);
                            $this->conn->bind(2, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                                    if ($this->conn->rowCount() >= 1)
                                    {
                                        exit("This class has been assigned a class teacher already");
                                    }
                                        else{
                                        //insert new subjects  taught by staff 
                                        $sqlStmt = "INSERT INTO class_teacher (staff_id,
                                        class_id,school_id,addedBy,dateAdded)
                                        values (?,?,?,?,?)";
                                        $this->conn->query($sqlStmt);
                                        $this->conn->bind(1, $staff_id, PDO::PARAM_INT);
                                        $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                                        $this->conn->bind(3, $schid, PDO::PARAM_INT);
                                        $this->conn->bind(4, $createdBy, PDO::PARAM_INT);  
                                        $this->conn->bind(5, $addedDate, PDO::PARAM_STR);
                                        $this->conn->execute(); 
                                            if ($this->conn->rowCount() == 1) 
                                            {
                                            //check number of inserted rows
                                            echo "ok";
                                            } 
                                            else
                                            {
                                            echo "Error adding class teacher";
                                            }
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
//end create class teacher

//load class assigned to a staff as CLAS TEACHER
public function loadClassTeacherClass($staffid,$schid)
        {
        try {
                $query ="SELECT class_teacher.class_id AS ID,class.class_name AS ClassName FROM class_teacher
                INNER JOIN class ON class_teacher.class_id=class.id
                WHERE class_teacher.staff_id=? AND class_teacher.school_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $staffid, PDO::PARAM_INT);
                    $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['ID'];
            $class = $key['ClassName'];

          //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$class."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load staff classes";
        }
        }
//END METHOD TO LOAD CLASS TEACHER CLASS

//Activate Term
function activateTerm($termid,$schid,$activate="Active")
  {
      
        try {

            //Check for an active term
                    $query ="SELECT term_id FROM sch_term WHERE term_status=? AND term_inst_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $activate, PDO::PARAM_INT);
                    $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("Please deactivate the active term firts!");
                    }

                    else{
                          $sqlStmt = "UPDATE sch_term SET term_status=? WHERE term_id=? AND term_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $termid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error activating term";
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
//End Activate Term

//Deactivate Term
function deactivateTerm($termid,$schid,$activate="Inactive")
  {
      
        try {

                          $sqlStmt = "UPDATE sch_term SET term_status=? WHERE term_id=? AND term_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $termid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error deactivating term";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
//End deactivate term


//activate Session
function activateSession($sessionid,$schid,$activate="Active")
  {
      
        try {

            //Check for an active term
                    $query ="SELECT id FROM session WHERE active_status=? AND sess_inst_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $activate, PDO::PARAM_INT);
                    $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("Please deactivate the active session first!");
                    }

                    else{
                          $sqlStmt = "UPDATE session SET active_status=? WHERE id=? AND sess_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//session activated
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error activating session";
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

//end activate session

//deactivate Sessions
function deactivateSession($sessionid,$schid,$activate="Inactive")
  {  
        try {

                          $sqlStmt = "UPDATE session SET active_status=? WHERE id=? AND sess_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//deactivate Session
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error deactivating session";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
  //End deactivate session



  //Activate Admission number Settings
function activateSetting($settingid,$schid,$activate="Active")
  {
      
        try {
            //Check for an active term
                    $query ="SELECT prefix_id FROM admission_number_prefix WHERE status=? AND prefix_sch_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $activate, PDO::PARAM_INT);
                    $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("Please deactivate the active settings first!");
                    }

                    else{
                          $sqlStmt = "UPDATE admission_number_prefix SET status=? WHERE prefix_id=? AND prefix_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $settingid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//session activated
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error activating setting";
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
  //End activate academic number Settings



//Deactivate academic settings

function deactivateSetting($settingid,$schid,$activate="Inactive")
  {
      
        try {
            
                          $sqlStmt = "UPDATE admission_number_prefix SET status=? WHERE prefix_id=? AND prefix_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $settingid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//session activated
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error deactivating setting";
                      			}
                            
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }


//End deactivate academic settings

//=============================================
//Code block to edit academic settings

//Function to edit school term
function editSchTerm($termid,$term,$schid)
  {
    
        try {

          					//EDIT school tern
                            $sqlStmt = "UPDATE sch_term SET term=?
                            WHERE term_id=? AND term_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $term, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $termid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                           
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// term EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error editing term";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }

  //Method to edit subject

function editSchSubject($subjectid,$subject,$schid)
  {
    
        try {

          					//EDIT school tern
                            $sqlStmt = "UPDATE subjects SET subject_name=?
                            WHERE sub_id=? AND my_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $subject, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $subjectid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                           
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// Subject EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error editing subject";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
  //end method to edit subject


//Method to edit sessions

function editSchSession($sessionid,$session,$schid)
  {
    
        try {

          					//EDIT school tern
                            $sqlStmt = "UPDATE session SET session=?
                            WHERE id=? AND sess_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $session, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $sessionid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                           
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// session EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error editing session";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
//End method to edit sessions


//Method to edit class
function editSchClass($classid,$class,$schid)
  {
        try {
          					//EDIT school tern
                            $sqlStmt = "UPDATE class SET class_name=?
                            WHERE id=? AND my_inst_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $class, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $classid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                           
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// Class EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error editing term";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
//End method to edit class

//Edit school prefix  settings
function editSchPrefixSettings($prefixid,$prefix,$schid)
  {
    
        try {

          					//EDIT school tern
                            $sqlStmt = "UPDATE admission_number_prefix SET prefix_name=?
                            WHERE prefix_id=? AND prefix_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $prefix, PDO::PARAM_STR);
                            $this->conn->bind(2, $prefixid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// prefix EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error editing school prefix ";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
//End edit school prefix settings


//Method to list all users (Staff)
public function allStaffUsers($clientid)
        {
        try {

                $query ="SELECT users.id AS ID, CONCAT(staff_profile.surname, ', ', staff_profile.middle_name, ' ', staff_profile.lastname) AS FullName, users.status AS Status,institutional_responsibilities.responsibility_name AS Role
                FROM users
                INNER JOIN staff_profile ON users.id=staff_profile.user_id 
                INNER JOIN institutional_responsibilities ON users.role=institutional_responsibilities.id
                WHERE users.created_By=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output=" ";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Staff Users</h5><br/>";
                    $output .='<table class="table">';
            $output .='<thead>
            <tr><th>Name</th><th>Role</th><th>Action</th><th>View</th></tr>
            </thead>
            <tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                         
                        //approval status
                        if($key['Status'] =='On'){
                        $active_status = '<button type="button"  data-recordid="'.$key['ID'].'" class="approvedBtn" id="staffOff">Deactivate</button>';
                        }else{
                        $active_status= '<button type="button"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="staffOn">Activate</button>';
                        }
                   
                    $fullname = $key['FullName'];
                   // $status = $key['Status'];
                    $role = $key['Role'];
                   
                    $output.= '<tr>';
                    $output.='<td>'.$fullname.'</td>';
                     $output.='<td>'.$role.'</td>';
                    $output.='<td>'.$active_status.'</td>';
                    $output.='<td><button type="button" data-recordid="'.$key['ID'].'" class="btn btn-info btn-sm viewUser-div" id="viewStaffUser"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> View</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
                    }
                    else{
                        echo "No staff users yet!";
                    }
                    
        }// End of try catch block
         catch(Exception $e)
        {
            echo ("Error: Unable to fetch  staff users!");
        }
        }

//End method to list all users  (Staff)

//Approve staff user
function approveStaffUser($userid,$schid,$activate="On")
  {
      
        try {

            //Staff user
                          $sqlStmt = "UPDATE users SET status=? WHERE id=? AND created_By=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $userid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error approving staff user";
                      			}
                            
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//End approve staff user

//Unapprove Staff user
function unapproveStaffUser($userid,$schid,$activate="Off")
  {
      
        try {

            //Staff user
                          $sqlStmt = "UPDATE users SET status=? WHERE id=? AND created_By=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $activate, PDO::PARAM_INT);
                            $this->conn->bind(2, $userid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error unapproving staff user";
                      			}
                            
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//End un approve Staff user

//Add max CA Score Settings
public  function newMaxCaScore($cascore,$category,$clientid)
  {
  
  try{
       $query ="SELECT id FROM ass_score_setting WHERE class_category_id=? AND sch_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $category, PDO::PARAM_INT);
                    $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("You can not add more than one scores for a category");
                    }
                    {
          //insert new ca max score
                            $sqlStmt = "INSERT INTO ass_score_setting (max_ca_score,class_category_id,sch_id) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $cascore, PDO::PARAM_INT);
                            $this->conn->bind(2, $category, PDO::PARAM_INT);
                            $this->conn->bind(3, $clientid, PDO::PARAM_INT);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                        // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not add max ca score, try again";
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
//end max CA Score Settings


//Create Max Exam Score
public  function newMaxExamScore($examscore,$category,$clientid)
  {
  
  try{

      //Check for multiple category
        $query ="SELECT id FROM exam_score_setting WHERE class_category_id=? AND sch_id=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $category, PDO::PARAM_INT);
                    $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() >= 1)
                    {
                      exit("You can not add more than one scores for a category");
                    }
                    {
          //insert new ca max score
                            $sqlStmt = "INSERT INTO exam_score_setting (max_exam_score,class_category_id,sch_id) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $examscore, PDO::PARAM_INT);
                            $this->conn->bind(2, $category, PDO::PARAM_INT);
                            $this->conn->bind(3, $clientid, PDO::PARAM_INT);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                        // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not add max exam score, try again";
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
//End create Max Exam Score

//Create attendance settings
function attendanceSettings($daysOpen,$daysClosed,$termid,$sessionid,$schid)
  {
  // always use try and catch block to write code
       try {        
                    $query ="SELECT  id  FROM school_attendance 
                    WHERE termid=? AND sessionid=? AND sch_att_id=? ";
                    $this->conn->query($query);
                    $this->conn->bind(1, $termid, PDO::PARAM_INT);
                    $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(3, $schid, PDO::PARAM_INT);
                    $this->conn->resultset();
                   
                    	if ($this->conn->rowCount() >= 1)
                    	  {
                      exit("Attendance settings added already!");
                    	  }
                    	else{
          					        // ADD PSYCHOMOTOR SKILLS
                            $sqlStmt = "INSERT INTO school_attendance(days_open,days_closed,termid,sessionid,
                            sch_att_id)
                            values (?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $daysOpen, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $daysClosed, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		   {
                         		   // SCORES ADDED
                        		   echo "ok";
                        		   }
                        		   else
                        		   {
                        		   echo "Error adding attendance settings";
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
//end create attendance settings


//Resumption Date settings
function resumptionDate($schid,$date)
  {
  // always use try and catch block to write code
       try {        
                    $currentTerm = $this->getActiveTerm($schid);
                    $currentSession = $this->getActiveSession($schid);
                    $query ="SELECT  id  FROM term_begins 
                    WHERE termid=? AND sessionid=? AND schoolid=? ";
                    $this->conn->query($query);
                    $this->conn->bind(1, $currentTerm, PDO::PARAM_INT);
                    $this->conn->bind(2, $currentSession, PDO::PARAM_INT);
                    $this->conn->bind(3, $schid, PDO::PARAM_INT);
                    $this->conn->resultset();
                   
                    	  if ($this->conn->rowCount() >= 1)
                    	  {
                          exit("Resumption Date already created!");
                    	  }
                    	  else{
          					// ADD PSYCHOMOTOR SKILLS
                            $sqlStmt = "INSERT INTO term_begins (termid,sessionid,
                            schoolid,resumptionDate)
                            values (?,?,?,?)";
                            $this->conn->query($sqlStmt);
                           
                            $this->conn->bind(1, $currentTerm, PDO::PARAM_INT);
                            $this->conn->bind(2, $currentSession, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                             $this->conn->bind(4, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		   {
                         		   // SCORES ADDED
                        		   echo "ok";
                        		   }
                        		   else
                        		   {
                        		   echo "Error adding resumption date";
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






//end resumption date settings






















  }
  //end of client class