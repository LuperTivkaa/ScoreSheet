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

//Test function
 public function TestStudent(){
        echo " This is all my student in the client class extended by student class";
    }
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
public  function instProfile($sch_name,$sch_type,$clientid,$country,$state, $lg, $city,$address,$mobile)
 	{
    // always use try and catch block to write code
     
    try
        {

                //check for duplicate/u
                    $query ="SELECT * FROM institutional_signup WHERE client_id =?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_STR);
                    $this->conn->execute();
                    if ($this->conn->rowCount() >3)
                    {
                      echo "Please you can add only three institutions";
                    }
                    else{


          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO institutional_signup(institution_name,institution_type,
                            client_id,country_id,state_id,
                            lg_id,inst_city_id,inst_add,
                            inst_mobile) values (?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $this->sch_name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $this->sch_type, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $clientid, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $this->country, PDO::PARAM_INT); 
                            $this->conn->bind(5, $this->state, PDO::PARAM_INT);
                            $this->conn->bind(6, $this->lg, PDO::PARAM_INT); 
                            $this->conn->bind(7, $this->city, PDO::PARAM_INT);
                            $this->conn->bind(8, $this->address, PDO::PARAM_STR); 
                            $this->conn->bind(9, $this->mobile, PDO::PARAM_INT);
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
                $query ="SELECT institutional_signup.institution_name,             
                institutional_signup.inst_logo FROM institutional_signup 
                WHERE client_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $id, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output=$myResult;
                    return $output;
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

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
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
     //this function loads state
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
                    $output .='<table class="table">';
                    $output .='<thead><tr><th>Session</th><th>Status</th><th>Action</th><th>Edit</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $session = $key['Session'];
                    $status = $key['Status'];
                    //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                    //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
                   $output.= '<tr>';
                   $output.='<td>'.$session.'</td>';
                   $output.= '<td>'.$status.'</td>';
                     $output.='<td><button onclick="toggleActivate('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i>
Activate/Deactivate</button></td>';
                    $output.='<td><button onclick="editSession('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
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
public  function newClass($class,$clientid,$status='Unpublished')
  {
  
  try{
          //insert new class
                            $sqlStmt = "INSERT INTO class (class_name,my_inst_id,published_status) 
                            values (?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $class, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(3, $status, PDO::PARAM_STR,100);
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
                    $output .='<thead><tr><th>Term</th><th>Status</th><th>Action</th><th>Edit</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['ID'];
                    $term = $key['Term'];
                    $status = $key['Status'];
                    //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                    //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
                   $output.= '<tr>';
                   $output.='<td>'.$term.'</td>';
                   $output.= '<td>'.$status.'</td>';
                   $output.='<td><button onclick="ActivateTerm('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-toggle-on fa-fw" aria-hidden="true"></i>
Activate/Deactivate</button></td>';
                    $output.='<td><button onclick="editTerm('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit</button></td>';
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
            echo json_encode("Error: Unable to fetch academic term");
        }
        }
//end all terms


//display all school subject
//all terms 
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
                    //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
                    //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
                   $output.= '<tr>';
                   $output.='<td>'.$subj.'</td>';
                    $output.='<td><button onclick="editSubject('.$ID.')" class="btn btn-info btn-sm"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>Edit</button></td>';
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
//end all terms

//end display school subject





















  }
  //end of client class