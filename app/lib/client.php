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
	if(empty($sch_name) )
	{
		exit("Please provide a school name");
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
		if(empty($mobile) || !is_numeric($mobile))
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

    
 //METHOD TO GET ACTIVE SESSION ID
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

    //Get students by class and session
    public function studentsByClass($classid,$sessionid,$schid)
        {
        try {
            $query ="SELECT CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName) AS fullname,
            student_initial.img AS Avatar,  
            student_initial.gender AS Gender, 
            class.class_name AS ClassName,
            student_class.student_id AS studentID
            FROM student_class 
            INNER JOIN student_initial ON student_initial.id= student_class.student_id
            INNER JOIN class ON student_class.stud_class=class.id
            WHERE student_class.stud_class=? 
            AND student_class.stud_sess_id=? 
            AND student_class.stud_school_id=? ORDER BY fullname AND Gender ASC";
            $this->conn->query($query);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $sessionid, PDO::PARAM_INT); 
            $this->conn->bind(3, $schid, PDO::PARAM_INT); 
            $myResult = $this->conn->resultset();
            $output="";
            $avatarRow ="";
            $output.="<h5 class='top-header mt-2'> My Student(s) </h5><br/>";
            $output .='<table class="table">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Upload Avatar</th>
                    </tr>
                </thead>
                <tbody>';
                //$avatarData ='<img src="'.$avatar.'" alt="Staff Avatar" class="small-avatar">';
        if($myResult){
            foreach ($myResult as $row => $key) 
            {
            $fullname = $key['fullname'];
            $avatar = $key['Avatar'];
            $sex = $key['Gender'];
            $class = $key['ClassName'];
            $studentID = $key['studentID'];
            //generate icon if picture is not uploaded other wise show picture
                if(empty($avatar)){
                    $avatarRow ='<td><img src="../images/avatar.jpg" alt="Avatar" class="small-avatar"></td>';
                }
                else{
                    $avatarRow = '<td><img src="'.$avatar.'" alt="Avatar" class="small-avatar"></td>';
                }
            $output.= '<tr>';
            $output.=$avatarRow;
            $output.='<td>'.$fullname.'</td>';
            $output.='<td>'.$sex.'</td>';
            $output.='<td>'.$class.'</td>';
            $output.='<td><button type="button"  data-recordid="'.$key['studentID'].'" class="btn btn-info btn-sm upload-div" id="uploadModal"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> upload</button></td>';
            $output.='</tr>';
           //$output .= "<option value=".$ID.">".$category."</option>";
            }
            $output.='</tbody></table>';
            echo $output;
        }
        else{
            exit("No record seen or student(s) not enrolled in this class yet!");
        }
    }//End of try catch block
     catch(Exception $e)
    {
        echo json_encode("Error: Something went wrong, Unable to fetch students records");
    }
}
//End get students by class and session

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
                $query ="SELECT id AS studentID, CONCAT(UPPER(surname), ', ', firstName, ' ', lastName) AS fullname, gender AS Sex,img AS myImage,status_active AS Active FROM student_initial
                WHERE stud_sch_id=? && status_active =? ORDER BY gender AND surname DESC LIMIT 0,10";
                    $this->conn->query($query);
                    $this->conn->bind(1, $schid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $status, PDO::PARAM_STR); 
                    $output = "";
                    $myResult = $this->conn->resultset();
                    //echo table headings
                $output .='<table class="table">';
                $output .='<thead><tr><th>Avatar</th><th>Full Name</th><th>Sex</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                    if($myResult){
                    foreach ($myResult as $row => $key) 
                    {
                    $ID = $key['studentID'];
                    $fullname = $key['fullname'];
                    $sex = $key['Sex'];
                    $status = $key['Active'];
                    $studavatar = $key['myImage'];
                    if($studavatar){
                    $studentAvatarData='<img src="'.$studavatar.'" class="small-avatar">';
                    }else{
                    $studentAvatarData='<img src="../images/profile-icon.png" class="small-avatar">';
                    }
                   
                   $output.= '<tr>';
                   $output.='<td>'.$studentAvatarData.'</td>';
                   $output.='<td>'.$fullname.'</td>';
                   $output.= '<td>'.$sex.'</td>';
                   $output.='<td>'.$status.'</td>';
                   //$output.='<td><button type="button" data-recordid="'.$key['studentID'].'"  class="btn btn-info btn-sm" id="my-stud-edit" data-toggle="modal" data-target=".stud-profile-edit"><i class="fa fa-eye fa-fw" aria-hidden="true"></i> Edit </button></td>';
                   $output.='<td><a href="myStudentEdit.php?studentid='.$key['studentID'].'" class="btn btn-info btn-sm" target="_blank" id="result-link"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></td>';

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
                   $output.='<td><a href="myStudentEdit.php?studentid='.$key['studentID'].'" class="btn btn-info btn-sm" target="_blank" id="result-link"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></td>';
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

    //EDIT STAFF SUBJECT TAUGHT
    public  function editStaffSubject($recordid,$subject_id,$class_id,$staff_id,$sch_id,$editedDate)
        {
             // always use try and catch block to write code
            try{
            //check for duplicate values for subject, class arm and staff
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
                      exit("This staff already has being assigned this subject for this class");
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
                            $sqlStmt ="UPDATE staff_subject_taught SET subject_id=?, class_taught=?, editedDate=?, addedBy=? WHERE id=? AND my_id=? AND sch_identity=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                            $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                            $this->conn->bind(3, $editedDate, PDO::PARAM_STR);
                            $this->conn->bind(4, $sch_id, PDO::PARAM_INT);
                            $this->conn->bind(5, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(6, $staff_id, PDO::PARAM_INT); 
                            $this->conn->bind(7, $sch_id, PDO::PARAM_STR); 
                            $this->conn->execute(); 
                            if ($this->conn->rowCount() == 1) 
                            {
                            //check number of inserted rows
                            echo "ok";
                            } 
                            else
                            {
                            echo "Error editing records";
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
//END EDIT STAFF SUBJET TAUGHT

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
                            values (?,?,?,?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $sch_name, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $sch_type, PDO::PARAM_INT);
                            $this->conn->bind(3, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(4, $country, PDO::PARAM_INT); 
                            $this->conn->bind(5, $state, PDO::PARAM_INT);
                            $this->conn->bind(6, $lg, PDO::PARAM_INT); 
                            $this->conn->bind(7, $city, PDO::PARAM_INT);
                            $this->conn->bind(8, $mobile, PDO::PARAM_STR);
                            $this->conn->bind(9, $webadd, PDO::PARAM_STR);
                            $this->conn->bind(10, $email, PDO::PARAM_STR);
                            $this->conn->bind(11, $strtAdd, PDO::PARAM_STR);
                            $this->conn->bind(12, $mailbox, PDO::PARAM_STR);
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
                        }

                                if(empty($logo)){
                                    $logoPrint = '<li><img src="../images/profile-icon.png" alt="School Logo" class="school-avatar"></li>';
                                }else{
                                $logoPrint = $logoPrint = '<li><img src="'.$logo.'" alt="School Logo" class="school-avatar"></li>';
                                }
                                if(empty($schoolname)){
                                $schoolname = "ScoreSheet";
                                }

                                $printOutPut.='<ul class="school-header">';
                                $printOutPut.=$logoPrint;
                                $printOutPut.='<li><h4>'.$schoolname.'</h4></li>';
                                $printOutPut.='</ul>';
                    }
                    else
                    {
                                
                                $schoolname = "ScoreSheet";
                                $logoPrint = '<li><img src="../images/profile-icon.png" alt="School Logo" class="school-avatar"></li>';
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

//Load approvd staff for assigning subjects
public function loadApprovedStaff($client_id,$status="On")
    {
        try {
                $query ="SELECT users.id,users.user_name FROM users WHERE created_By=? AND status=?";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                 $this->conn->bind(2, $status, PDO::PARAM_STR);
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
//End load approved staff for assigning subjects

//Get All Staff
public function loadStaff($client_id)
    {
        try {
                $query ="SELECT users.id,users.user_name FROM users WHERE users.created_By=?";
                $this->conn->query($query);
                $this->conn->bind(1, $client_id, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            // $query ="SELECT users.id,users.user_name FROM users WHERE users.id NOT IN (SELECT user_id FROM staff_profile WHERE my_school_id=?)";
            
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
   //end load staff function list



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
                $query ="SELECT subjects.sub_id AS subjectID, subjects.subject_name AS SubjectName,class_category_subject.class_category_id AS CatID FROM subjects INNER JOIN class_category_subject ON subjects.sub_id=class_category_subject.subject_id INNER JOIN class ON class.class_categoryid=class_category_subject.class_category_id WHERE class.id=? AND class.my_inst_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $class_id, PDO::PARAM_INT);
                $this->conn->bind(2, $sch_id, PDO::PARAM_INT);
                $myResult= $this->conn->resultset();
                $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['subjectID'];
            $subjectname = $key['SubjectName'];

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

//Create New School Affective skills records
public  function createAffectiveDomain($description,$clientid,$userid,$date)
  {

  //always use try and catch block to write code   
  try{
          //insert new term
                            $sqlStmt = "INSERT INTO affective_domain (description,sch_id,createdby,date_added) 
                            values (?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $description, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(3, $userid, PDO::PARAM_INT);
                            $this->conn->bind(4, $date, PDO::PARAM_STR);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create school affective domain skills";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//End create new school affective skills records

//RELOAD AFFECTIVE DOMAIN CREATED METHOD
function allAfectiveSkills($schid)
  {
  // Try and Catch block
   try
        {
  			   $query ="SELECT id AS ID, description AS DomainName
             FROM affective_domain 
             WHERE 
             sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $schid, PDO::PARAM_INT);
                $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added affective skills seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.='<h6 class="top-header">Affective Domain Added</h6>';
                        $printOutput.= '<table  class="transparent-table">';
                        $printOutput.='<tr><th>#</th>
                        <th>Affective Domain</th>
                        <th>Remove</th>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['DomainName'].'</td>';
                        $printOutput.='<td><button type="button" data-id="'.$key['ID'].'" class="btn btn-outline-danger btn-sm" id="remove-domain"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }  
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//END RELOAD AFFECTIVE DOMAIN CREATED METHOD

//RELOAD ALL PSYCHO SKILLS SETIINGS
function allPsychoSkills($schid)
  {
  // Try and Catch block
   try
        {
  			   $query ="SELECT id AS ID, description AS DomainName
             FROM psychomotor_skills
             WHERE 
             sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $schid, PDO::PARAM_INT);
                $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added psychomotor skills seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.='<h6 class="top-header">Psychomotor Skills Added</h6>';
                        $printOutput.= '<table  class="transparent-table">';
                        $printOutput.='<tr><th>#</th>
                        <th>Psychomotor Domain</th>
                        <th>Remove</th>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['DomainName'].'</td>';
                        $printOutput.='<td><button type="button" data-id="'.$key['ID'].'" class="btn btn-outline-danger btn-sm" id="remove-psycho"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }  
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }


//END RELOAD ALL PSYCHO SKILLS SETTINGS

//DELETE PSYCHOMOTOR DOMAIN SKILL SETTING
function deletePsychoSkillSettings($id,$schid)
   {
                 try {

          					     //EDIT EXAM RECORD
                            $sqlStmt = "DELETE  FROM psychomotor_skills WHERE id=? AND sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $id, PDO::PARAM_INT);
                            $this->conn->bind(2, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// action successful
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error removing psychomotor item";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
    }
//END DELETE PSYCHOMOTOR DOMAIN SKILLS SETTINGS
//======================================================================================================
//DELETE AFFECTIVE DOMAIN SKILLS SETTINGS
function deleteAffectiveSkillSettings($id,$schid)
   {
                 try {

          					     //EDIT EXAM RECORD
                            $sqlStmt = "DELETE  FROM affective_domain WHERE id=? AND sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $id, PDO::PARAM_INT);
                            $this->conn->bind(2, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// action successful
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error removing affective item";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
    }

//DELETE AFFECTIVE DOMAIN SKILLS SETTINGS

//Create new school psychomotor
public  function createPsychoDomain($description,$clientid,$userid,$date)
  {

  //always use try and catch block to write code   
  try{
          
                            $sqlStmt = "INSERT INTO psychomotor_skills (description,sch_id,staff_id,date_created) 
                            values (?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $description, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                            $this->conn->bind(3, $userid, PDO::PARAM_INT);
                            $this->conn->bind(4, $date, PDO::PARAM_STR);
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create school affective domain skills";
                        }

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}
//End create new school psychomotor 

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
                        echo "No admission prefix setting found yet!";
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
method block to assign subject to class category
*/
public  function assignSubject($subject_id,$class_category_id,$sch_id)
  {
  try{
    //Check to prevent assigning the same subject to a class category twice
     $query ="SELECT id FROM 
            class_category_subject
            WHERE subject_id=? AND class_category_id=? AND school_id=?";
             
                $this->conn->query($query);
                $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                $this->conn->bind(2, $class_category_id, PDO::PARAM_INT);
                $this->conn->bind(3, $sch_id, PDO::PARAM_INT);
                $this->conn->resultset();
                if ($this->conn->rowCount() >=1)
                {
                    exit("This subject has already been added to this class category!");
                }
                else{
                            //insert new subjects  taught by staff 
                            $sql = "INSERT INTO class_category_subject(subject_id,
                            class_category_id,school_id)
                             values (?,?,?)";
                            $this->conn->query($sql);
                            $this->conn->bind(1, $subject_id, PDO::PARAM_INT);
                            $this->conn->bind(2, $class_category_id, PDO::PARAM_INT);
                            $this->conn->bind(3, $sch_id, PDO::PARAM_INT); 
                            $this->conn->execute(); 
                        if ($this->conn->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error assigning subject to class category";
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
//Process Logo
public function processLogo($clientid,$files)
        {
        try {
            //define valid file extensions
            $validextensions = array('jpeg', 'jpg', 'png', 'gif');

            //Define variable to store file extension
            $temporary = explode(".", $files['name']);
            $file_extension = end($temporary);

            // local Image folder
            $uploaddir = '../galleryUploads/';
            //check for valid file type and extenstion
            if ((($files['type'] == "image/png")
            || ($files['type'] == "image/jpg")
            || ($files['type'] == "image/jpeg"))
            && ($files['size'] < 1000000)//approx. 100kb files can be uploaded
            && in_array($file_extension, $validextensions))
            {
                //PHP Image Uploading Code
                //move file to the temp folder
                //if move is successfull, insert into the database 
                //can upload same image using rand function
                $userImageName = $files['name'];
                $tmp = $files['tmp_name'];

                //Final Image name concatenating with  random number

                $finalImageName = rand(1000,1000000).$userImageName;
                $path = $uploaddir.strtolower($finalImageName);
                
                //move uploaded files to the temp folder
                if(move_uploaded_file($tmp,$path))
                {
                    //update the institutional_signup table with new image in the database
                    $query ="UPDATE institutional_signup SET inst_logo =? WHERE client_id=?";
					$this->conn->query($query);
					$this->conn->bind(1, $path, PDO::PARAM_STR);
                    $this->conn->bind(2, $clientid, PDO::PARAM_INT);
					$this->conn->execute();
					if ($this->conn->rowCount() == 1)
					{
					echo "ok";
					}
					else
					{
                    //Unlink the copied file from the tmp folder
                    unlink($path);
					exit("Aha! logo not saved");
					}

                }
                else
                {
                    //Display error when file is not copied
                    exit("Unable to copy image file!");

                }
            }
            else{
                exit("Inavild file size or file type provided!");
            }
                   
            }// End of try catch block
        catch(Exception $e)
            {
            echo ("Error: Unable to process request");
            }
        }
//===========================================
//End process logo

//Process staff passport
public function processStaffPhoto($userid,$clientid,$files)
        {
        try {
            //define valid file extensions
            $validextensions = array('jpeg', 'jpg', 'png', 'gif');

            //Define variable to store file extension
            $temporary = explode(".", $files['name']);
            $file_extension = end($temporary);

            // local Image folder
            $uploaddir = '../galleryUploads/';
            //check for valid file type and extenstion
            if ((($files['type'] == "image/png")
            || ($files['type'] == "image/jpg")
            || ($files['type'] == "image/jpeg"))
            && ($files['size'] < 1000000)//approx. 100kb files can be uploaded
            && in_array($file_extension, $validextensions))
            {
                //PHP Image Uploading Code
                //move file to the temp folder
                //if move is successfull, insert into the database 
                //can upload same image using rand function
                $userImageName = $files['name'];
                $tmp = $files['tmp_name'];

                //Final Image name concatenating with  random number

                $finalImageName = rand(1000,1000000).$userImageName;
                $path = $uploaddir.strtolower($finalImageName);
                
                //move uploaded files to the temp folder
                if(move_uploaded_file($tmp,$path))
                {
                    //update the institutional_signup table with new image in the database
                    $query ="UPDATE staff_profile SET user_img=? WHERE user_id=? AND my_school_id=?";
					$this->conn->query($query);
					$this->conn->bind(1, $path, PDO::PARAM_STR);
                    $this->conn->bind(2, $userid, PDO::PARAM_INT);
                    $this->conn->bind(3, $clientid, PDO::PARAM_INT);
					$this->conn->execute();
					if ($this->conn->rowCount() == 1)
					{
					echo "ok";
					}
					else
					{
                    //Unlink the copied file from the tmp folder
                    unlink($path);
					exit("Aha! photo not saved");
					}

                }
                else
                {
                    //Display error when file is not copied
                    exit("Unable to copy image file!");

                }
            }
            else{
                exit("Inavild file size or file type provided!");
            }
                   
            }// End of try catch block
        catch(Exception $e)
            {
            echo ("Error: Unable to process request");
            }
        }

//End process staff passport


//=====================================
//Upload student picture
public function processStudentPhoto($studentid,$clientid,$files)
        {
        try {
            //define valid file extensions
            $validextensions = array('jpeg', 'jpg', 'png', 'gif');

            //Define variable to store file extension
            $temporary = explode(".", $files['name']);
            $file_extension = end($temporary);

            // local Image folder
            $uploaddir = '../studentsUploads/';
            //check for valid file type and extenstion
            if ((($files['type'] == "image/png")
            || ($files['type'] == "image/jpg")
            || ($files['type'] == "image/jpeg"))
            && ($files['size'] < 1000000)//approx. 100kb files can be uploaded
            && in_array($file_extension, $validextensions))
            {
                //PHP Image Uploading Code
                //move file to the temp folder
                //if move is successfull, insert into the database 
                //can upload same image using rand function
                $userImageName = $files['name'];
                $tmp = $files['tmp_name'];

                //Final Image name concatenating with  random number

                $finalImageName = rand(1000,1000000).$userImageName;
                $path = $uploaddir.strtolower($finalImageName);
                
                //move uploaded files to the temp folder
                if(move_uploaded_file($tmp,$path))
                {
                    //update the institutional_signup table with new image in the database
                    $query ="UPDATE student_initial SET img =? WHERE stud_sch_id=? AND id=?";
					$this->conn->query($query);
					$this->conn->bind(1, $path, PDO::PARAM_STR);
                    $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                    $this->conn->bind(3, $studentid, PDO::PARAM_INT);
					$this->conn->execute();
					if ($this->conn->rowCount() == 1)
					{
					echo "ok";
					}
					else
					{
                    //Unlink the copied file from the tmp folder
                    unlink($path);
					exit("Aha! photo not saved");
					}

                }
                else
                {
                    //Display error when file is not copied
                    exit("Unable to copy image file!");

                }
            }
            else{
                exit("Invalid file size or file type provided!");
            }
                   
            }// End of try catch block
        catch(Exception $e)
            {
            echo ("Error: Unable to process request");
            }
        }
//End upload student picture
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

//=========================
//EDIT CLASS TEACHER CLASS
public  function editClassTeacher($recordid,$class_id,$staff_id,$sch_id,$userid,$editedDate)
    {
 // always use try and catch block to write code
            try{
    //make sure only one staff is assigned as a class teacher
                  $query ="SELECT id FROM class_teacher WHERE staff_id=? AND class_id=? AND school_id=?";
                  $this->conn->query($query);
                   $this->conn->bind(1, $staff_id, PDO::PARAM_INT);
                  $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                  $this->conn->bind(3, $sch_id, PDO::PARAM_INT);
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
                          $this->conn->bind(2, $sch_id, PDO::PARAM_INT);
                          $this->conn->execute();
                                  if ($this->conn->rowCount() >= 1)
                                  {
                                      exit("This class has been assigned a class teacher already");
                                  }
                                      else{
                                      //insert new subjects  taught by staff 
                                      $sqlStmt = "UPDATE class_teacher set staff_id=?,
                                      class_id=?,addedBy=?,dateAdded=? WHERE id=? AND school_id=?";
                                      $this->conn->query($sqlStmt);
                                      $this->conn->bind(1, $staff_id, PDO::PARAM_INT);
                                      $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                                      $this->conn->bind(3, $userid, PDO::PARAM_INT);
                                      $this->conn->bind(4, $editedDate, PDO::PARAM_STR);  
                                      $this->conn->bind(5, $recordid, PDO::PARAM_INT);
                                      $this->conn->bind(6, $sch_id, PDO::PARAM_INT);
                                      
                                      $this->conn->execute(); 
                                          if ($this->conn->rowCount() == 1) 
                                          {
                                          //check number of inserted rows
                                          echo "ok";
                                          } 
                                          else
                                          {
                                          echo "Error editing class teacher";
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
///END EDIT CLASS TEACHER CLASS




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

//Define Random Color
//Function getColor used for pick random color from defined color array
function getColor(){
	$ColorArr = array("#A27BA7","#C72A3B","#DA6784","#0495C2","#0F3353","#6872FF","#488957","#FF59AC","#999999","#996855","#3C3636");//Default colors array
	$k = array_rand($ColorArr);
	return $ColorArr[$k];
}

//End Define Random color

//Code to generate User icon
function generateUserIcon($_name){
	$nameArr = explode(" ", $_name);
	$name_str = "";
	foreach ($nameArr as $name) {
		$name_str.= substr($name, 0, 1);//take first letter from first name and last name
    }
    $randomColor = $this->getColor();
	$icon = '<a class="user_icon" style="background-color:'.$randomColor.'">'.$name_str.'</a>';
	return $icon;
}
//End code to generate user icon


//METHOD TO GET CLASS TEACHER'S CLASS ID
public function classTeacherClassID($staffid,$schid)
  {
   try {
        $query ="SELECT class_teacher.class_id AS ID FROM class_teacher
        WHERE staff_id=? AND school_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $staffid, PDO::PARAM_INT);
            $this->conn->bind(2, $schid, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
           $output =" "; 
           if($myResult)
           {
            foreach ($myResult as $row => $key) 
            {
            $ID = $key['ID'];
            }
            return $ID;
        }else{}
     }// End of try catch block
     catch(Exception $e)
     {
    echo "Error: Unable to load class teacher ID";
      }
    }
//END METHOD TO GET CLASS TEACHER'S CLASS ID

//METHOD TO  SELECT STUDENTS AND UPLOAD THEIR UPLOAD

public function studentsPhoto($staffid,$schid)
  {
  try {
    $classTeacherClassID = $this->classTeacherClassID($staffid,$schid);
    $activeSession = $this->getActiveSession($schid);
        $query ="SELECT CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName) AS fullname, 
        student_initial.img AS Avatar,  
        student_initial.gender AS Gender, 
        class.class_name AS ClassName,
        student_class.student_id AS studentID
        FROM student_class 
        INNER JOIN student_initial ON student_initial.id= student_class.student_id
        INNER JOIN class ON student_class.stud_class=class.id
        WHERE student_class.stud_class=? 
        AND student_class.stud_sess_id=? 
        AND student_class.stud_school_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $classTeacherClassID, PDO::PARAM_INT);
            $this->conn->bind(2, $activeSession, PDO::PARAM_INT);
            $this->conn->bind(3, $schid, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $output="";
            $avatarRow ="";
            $output.="<h5 class='top-header mt-2'> My Student(s) </h5><br/>";
            $output .='<div class="list_box">			
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Class</th>
                        <th>Upload Avatar</th>
                    </tr>
                </thead>
                <tbody>';
                //$avatarData ='<img src="'.$avatar.'" alt="Staff Avatar" class="small-avatar">';
            if($myResult){
            foreach ($myResult as $row => $key) 
            {
            $fullname = $key['fullname'];
            $avatar = $key['Avatar'];
            $sex = $key['Gender'];
            $class = $key['ClassName'];
            $studentID = $key['studentID'];
            //generate icon if picture is not uploaded other wise show picture
                if(empty($avatar)){
                    $avatarRow ='<td><div class="icon_div">'. $this->generateUserIcon($key['fullname']).'</div></td>';
                }
                else{
                    $avatarRow = '<td><div class="icon_div"><img src="'.$avatar.'" alt="Staff Avatar" class="icon_img"></div></td>';
                }
            $output.= '<tr>';
            $output.=$avatarRow;
            $output.='<td>'.$fullname.'</td>';
            $output.='<td>'.$sex.'</td>';
            $output.='<td>'.$class.'</td>';
            $output.='<td><button type="button"  data-recordid="'.$key['studentID'].'" class="btn btn-info btn-sm upload-div" id="uploadModal"><i class="fa fa-upload fa-fw" aria-hidden="true"></i> upload</button></td>';
            $output.='</tr>';
           //$output .= "<option value=".$ID.">".$category."</option>";
            }
            $output.='</tbody></table></div>';
            echo $output;
 }//
else{
    exit("You have no student(s) enrolled in your class yet!");
}
}
 catch(Exception $e)
  {
//echo error here
//this get an error thrown by the system
echo "Error:". $e->getMessage();

}
}

//END METHOD TO SELECT STUDENTS AND UPLOAD THEIR UPLOAD


//LOAD all subject taught by each Staff 
public function subjectTeacher($schid)
        {
        try {
                $query ="SELECT CONCAT(UPPER(staff_profile.surname), ', ', staff_profile.middle_name) AS fullname, 
                staff_profile.user_img AS Avatar,  
                staff_subject_taught.my_id AS StaffID, 
                staff_subject_taught.id AS subjectTaughtID, 
                class.class_name AS ClassName, 
                subjects.subject_name AS SubjectName
                FROM staff_profile 
                INNER JOIN staff_subject_taught ON staff_subject_taught.my_id = staff_profile.user_id
                INNER JOIN class ON staff_subject_taught.class_taught=class.id
                INNER JOIN subjects ON subjects.sub_id=staff_subject_taught.subject_id
                WHERE staff_subject_taught.sch_identity=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $schid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                    $output="";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'> Subject(s) Teachers </h5><br/>";
                    $output .='<table class="table">';
                    $output .='<thead><tr><th>Avatar</th><th> Name</th><th>Subject</th><th>Class</th><th>Remove</th><th>Edit</th></tr></thead><tbody>';
                    if($myResult && $this->conn->rowCount()>=1)
                    {
                    foreach ($myResult as $row => $key) 
                    {
                    $fullname = $key['fullname'];
                    $avatar = $key['Avatar'];
                    $avatarData ='<img src="'.$avatar.'" alt="Avatar" class="small-avatar">';
                    $staffID = $key['StaffID'];
                    $Recordid = $key['subjectTaughtID'];
                    $class = $key['ClassName'];
                    $subj = $key['SubjectName'];
                    $output.= '<tr>';
                    $output.='<td>'.$avatarData.'</td>';
                    $output.='<td>'.$fullname.'</td>';
                    $output.='<td>'.$subj.'</td>';
                    $output.='<td>'.$class.'</td>';
                    $output.='<td><button type="button"  data-recordid="'.$key['subjectTaughtID'].'" class="btn btn-info btn-sm" id="removesubjecttaught"><i class="fa fa-trash fa-fw" aria-hidden="true"></i> Remove</button></td>';
                    $output.='<td><button type="button" data-staffid="'.$key['StaffID'].'" data-recordid="'.$key['subjectTaughtID'].'" class="btn btn-info btn-sm staffsubjects-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
                   $output.='</tr>';
                   //$output .= "<option value=".$ID.">".$category."</option>";
                    }
                    $output.=' </tbody></table>';
                    echo $output;
         }
         else{
            $query ="SELECT users.user_name AS Username,  
            staff_subject_taught.my_id AS StaffID, 
            staff_subject_taught.id AS subjectTaughtID, 
            class.class_name AS ClassName, 
            subjects.subject_name AS SubjectName FROM users 
            INNER JOIN staff_subject_taught ON staff_subject_taught.my_id = users.id
            INNER JOIN class ON staff_subject_taught.class_taught=class.id
            INNER JOIN subjects ON subjects.sub_id=staff_subject_taught.subject_id
            WHERE staff_subject_taught.sch_identity=?";
                $this->conn->query($query);
                $this->conn->bind(1, $schid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output="";
                $myResult = $this->conn->resultset();
                $output.="<h5 class='top-header mt-2'> Subject(s) Teachers </h5><br/>";
                $output .='<table class="table">';
                $output .='<thead><tr><th> User Name</th><th>Subject</th><th>Class</th><th>Remove</th><th>Edit</th></tr></thead><tbody>';
                foreach ($myResult as $row => $key) 
                {
                $fullname = $key['Username'];
                //$avatar = $key['Avatar'];
                //$avatarData ='<img src="'.$avatar.'" alt="Staff Avatar" class="small-avatar">';
                $staffID = $key['StaffID'];
                $Recordid = $key['subjectTaughtID'];
                $class = $key['ClassName'];
                $subj = $key['SubjectName'];
                $output.= '<tr>';
                //$output.='<td>'.$avatarData.'</td>';
                $output.='<td>'.$fullname.'</td>';
                $output.='<td>'.$subj.'</td>';
                $output.='<td>'.$class.'</td>';
                $output.='<td><button type="button"  data-recordid="'.$key['subjectTaughtID'].'" class="btn btn-info btn-sm" id="removesubjecttaught"><i class="fa fa-trash fa-fw" aria-hidden="true"></i> Remove</button></td>';
                $output.='<td><button type="button" data-staffid="'.$key['StaffID'].'" data-recordid="'.$key['subjectTaughtID'].'" class="btn btn-info btn-sm staffsubjects-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
               $output.='</tr>';
               //$output .= "<option value=".$ID.">".$category."</option>";
                }
                $output.=' </tbody></table>';
                echo $output;

         }      
        }// End of try catch block
         catch(Exception $e)
          {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
//END LOAD SUBJEECT TEACHERS

//REMOVE SUBJECT TEACHER
function removeSubjectTeacher($recordid,$schid)
   {
      
                 try {

          					        //Remove Promotion Details
                            $sqlStmt = "DELETE  FROM staff_subject_taught WHERE id=? AND sch_identity=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(2, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// action successful
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error removing Subject Teacher";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
    }

//REMOVE SUBJECT TEACHER

// REMOVE CLASS TEACHER
function removeClassTeacher($recordid,$schid)
  {
   
              try {

                                   //Remove Promotion Details
                         $sqlStmt = "DELETE  FROM class_teacher WHERE id=? AND school_id=?";
                         $this->conn->query($sqlStmt);
                         $this->conn->bind(1, $recordid, PDO::PARAM_INT);
                         $this->conn->bind(2, $schid, PDO::PARAM_INT);
                         $this->conn->execute();
                             if ($this->conn->rowCount() == 1)
                             {
                              // action successful
                             echo "ok";
                             }
                             else
                             {
                             echo "Error removing Class Teacher";
                               }

                         }

     catch(Exception $e)
     {
     //echo error here
     //this get an error thrown by the system
     echo "Error:". $e->getMessage();
     
   }
 }

//END REMOVE CLASS TEACHER
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


//Method to display Staff Name and Icon on the Primary Nav
public function staffIconName($clientid,$staffid){
  try
  {
    $query ="SELECT  staff_profile.user_img AS MyImage,users.user_name AS Username
    FROM staff_profile
    INNER JOIN users ON staff_profile.user_id=users.id
    WHERE staff_profile.my_school_id=? AND staff_profile.user_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
        $this->conn->bind(2, $staffid, PDO::PARAM_INT); 
        $myResult = $this->conn->resultset();
            if($myResult)
            {
                foreach($myResult as $row => $key)
                {
                    $Image = $key['MyImage'];
                    $username = $key['Username'];
                } 
                    if(empty($Image))
                    {
                        $avatar ='<img src="../images/profile-icon.png" class="list-avatar">';
                    }
                    else
                    {
                        $avatar ='<img src="'.$Image.'"  class="list-avatar">';
                    }
                    $output = "";

                    $output.='<span class="prim-profile">'.$avatar.'</span><span class="prim-profile">'.$username.'</span>';

                    echo $output;

            }
            else
            {
            echo ("Error");
            }
  }
  catch(Exception $e)
  {
    echo "Error:". $e->getMessage();
  }
}
//End Method to display Staff name and Icon on the Primary Nav

//Method to list all users (Staff)
public function allStaffUsers($clientid)
        {
        try {

                $query ="SELECT users.id AS ID, users.user_name AS Username, users.status AS Status,institutional_responsibilities.responsibility_name AS Role
                FROM users
                INNER JOIN institutional_responsibilities ON users.role=institutional_responsibilities.id
                WHERE users.created_By=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $output=" ";
                    $myResult = $this->conn->resultset();
                    $output.="<h5 class='top-header mt-2'>All Staff Users</h5><br/>";
                    $output .='<table class="table">';
            $output .='<thead>
            <tr><th>UserName</th><th>Role</th><th>Action</th><th>View</th></tr>
            </thead>
            <tbody>';
                    if($myResult){
                        //CONCAT(staff_profile.surname, ', ', staff_profile.middle_name, ' ', staff_profile.lastname) AS FullName,
                    foreach ($myResult as $row => $key) 
                    {
                         
                        //approval status
                        if($key['Status'] =='On'){
                        $active_status = '<button type="button"  data-recordid="'.$key['ID'].'" class="approvedBtn" id="staffOff">Deactivate</button>';
                        }else{
                        $active_status= '<button type="button"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="staffOn">Activate</button>';
                        }
                   
                    $fullname = $key['Username'];
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
//==========================================================================================
//SCHOOL SETTINGS

//Method to return current term name 
public function currentTerm($clientid,$status="Active")
{
    try {
            $query ="SELECT term AS TermName FROM sch_term WHERE term_inst_id=? AND term_status=?";
                $this->conn->query($query);
                $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                $this->conn->bind(2, $status, PDO::PARAM_STR);
                $myResult = $this->conn->resultset();
                $output ="No Active Setting"; 
                    if($myResult && $this->conn->rowCount() >=1){
                foreach ($myResult as $row => $key) 
                    {
                    $termName = $key['TermName'];
            
                    }
                    return $termName;
                }else{
                    return $output;
                }      
            }// End of try catch block
            catch(Exception $e)
            {
                echo "Error: Unable to load active term";
            }
}
//End Method to get active term

//Method to return current term name 
public function currentSession($clientid,$status="Active")
        {
            try {
            $query ="SELECT session AS MySession FROM session 
            WHERE sess_inst_id=? AND active_status=?";
                $this->conn->query($query);
                $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                $this->conn->bind(2, $status, PDO::PARAM_STR);
                $myResult = $this->conn->resultset();
                $output ="No Active Setting"; 
                    if($myResult && $this->conn->rowCount() >=1)
                    {
                foreach ($myResult as $row => $key) 
                    {
                    $sess = $key['MySession'];
            
                    }
                    return $sess;
                }else{
                    return $output;
                }      
            }// End of try catch block
            catch(Exception $e)
            {
                echo "Error: Unable to load active session";
            }
}
//End Method to get active term

//Current school settings
public function currentSchoolSettings($clientid)
    {
        $printOutput ="";
        $printOutput.='<div class="current-settings">
        <h5><i class="fa fa-wrench fa-fw" aria-hidden="true"></i> 
        Current Setting</h5>
        <p class="stud-details-item"><i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> 
        Term <span class="item-detail-span">'.$this->currentTerm($clientid).'</span></p>
        <p class="stud-details-item"><i class="fa fa-briefcase fa-fw" aria-hidden="true"></i> 
        Session <span class="item-detail-span">' .$this->currentSession($clientid).'</span> </p>
        </div>';
        echo $printOutput;
    }

//GET STUDENT SERIAL NUMBER
function studentSerialNumber($studentid,$clientid)
    {
    try {
            $query ="SELECT  admission_number.serial_number AS MySerialNumber
            FROM admission_number
            INNER JOIN my_number ON admission_number.id=my_number.admission_number
            WHERE my_number.stud_id=? AND my_number.my_stud_sch_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $studentid, PDO::PARAM_INT);
            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $output ="Null"; 
            if($myResult && $this->conn->rowCount()>=1)
            {
            foreach ($myResult as $row => $key) 
            {
                $serialNumber = $key['MySerialNumber'];
                //$output .= "<option value=".$ID.">".$termName."</option>";
            }
            return $serialNumber;
        }else{
            return $output;
        }
        }// End of try catch block
            catch(Exception $e)
            {
                echo "Error: Unable to get serial number for student";
            }
}
//END STUDENT SERIAL NUMBER

//=================================
/**
 * Load all students upon select of a class especially when staff is enterring scores
 * This will help the staff to look up students name and number by just scrolling up and down the list
 * select student admission number from appropriate table
 */

public function studentListOnClass($clientid,$classid)
    {
        try {
            if($this->getActiveSession($clientid))
            {
        $sessionid = $this->getActiveSession($clientid);
        $query ="SELECT  CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName, ' ', student_initial.lastName) AS fullname, 
        student_initial.img AS MyImage,
        student_class.student_id AS StudentID
        FROM student_class
        INNER JOIN student_initial ON student_initial.id=student_class.student_id
        WHERE student_class.stud_class=? AND student_class.stud_school_id=? AND student_class.stud_sess_id=? ORDER BY fullname ASC";
            $this->conn->query($query);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $printOutput ="";
            $errorOutput ="";
            
            $printOutput ='<div class="studlist-on-class">
            <h5><i class="fa fa-history fa-fw" aria-hidden="true"></i>Working Class</h5>
            <ul class="stud-list-highlight">';
            if($myResult && $this->conn->rowCount() >=1)
            {
                foreach($myResult as $row => $key)
                {
                $fullname = $key['fullname'];
                $img = $key['MyImage'];
                if($img){
                    $thumbnail='<img src="'.$img.'" class="list-avatar">';
                   

                }else{
                    $thumbnail='<img src="../images/profile-icon.png" class="list-avatar">';
                }
                $studentid = $key['StudentID'];
                $serial_no = $this->studentSerialNumber($studentid,$clientid);
                   $printOutput.='<li>
                                <div class="small-stud-avatar">'.
                                $thumbnail.'
                                </div>

                            <div class="small-stud-detail">
                                <p class="stud-details-item">'.$fullname.'</p>
                                <p class="stud-details-sub-item">'.$serial_no.'</p>
                            </div>
                          </li>';
                }

                echo $printOutput;
            }
            else{
                //do nothing
                // $errorOutput.='<div class="error-div">'.$null.'</div>';
                // echo $errorOutput;
            }
        }else{
            //do nothing;
        }
        }//End of try catch block
    catch(Exception $e)
    {
    echo "Error:". $e->getMessage();
    }
}

//End student list on class


//Method to list students enrolled student in a particular class based on staff for brief secondary column display
public function studentInClass($staffid,$clientid)
    {
     try {
       
        $staffClassID =$this->classTeacherClassID($staffid,$clientid);
        if($staffClassID && $this->getActiveSession($clientid))
         {
        
        $sessionid = $this->getActiveSession($clientid);
        $query ="SELECT student_class.student_id AS StudentID,
        CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName) AS studName, 
        student_initial.img AS MyImage
        FROM student_class
        INNER JOIN staff_profile ON student_class.stud_added_by=staff_profile.user_id
        INNER JOIN student_initial ON student_class.student_id=student_initial.id
        WHERE student_class.stud_added_by=? AND student_class.stud_school_id=? AND student_class.stud_sess_id=? AND student_class.stud_class=? ORDER BY studName ASC";
            $this->conn->query($query);
            $this->conn->bind(1, $staffid, PDO::PARAM_INT); 
            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
            $this->conn->bind(4, $staffClassID, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $null ='<p class="top-header"> No student yet! </p>';
            $printOutput ="";
            
                if($myResult && $this->conn->rowCount() >=1)
                {
                    $printOutput ='<div class="studlist-on-class">
                    <h5><i class="fa fa-bar-chart fa-fw" aria-hidden="true"></i>
                    Roll Call</h5>
                        <ul class="stud-list-highlight">';
                    foreach($myResult as $row => $key)
                    {
                    $studID = $key['StudentID'];
                    $studname = $key['studName'];
                    $img = $key['MyImage'];
                        if($img){
                            $thumbnail='<img src="'.$img.'" class="list-avatar">';
                        

                        }else{
                            $thumbnail='<img src="../images/profile-icon.png" class="list-avatar">';
                         }
                            $studSerialNum =$this->studentSerialNumber($studID,$clientid);
                            $printOutput.='<li>
                                <div class="small-stud-avatar">
                                '.$thumbnail.'
                                </div>

                                <div class="small-stud-detail">
                                    <p class="stud-details-item">'.$studname.'</p>
                                    <p class="stud-details-sub-item">'.$studSerialNum.'</p>
                                </div>
                            </li>';
                    }
                    $printOutput.='</ul></div>';
                    echo $printOutput;
                }
            else{
                echo $null;
                }
            }
            else{
                //staff is not a class teacher, display nothing
            }
        }//End of try catch block
    catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
    }
//End method to list enrolled students in a particular class based on staff


//==================================================================================================================

//GET ADMISSION LIST PER CLASS ADMITTED
//===========================================================
public function admissionListByClass($classid,$sessionid,$clientid)
  {
    try {
    $sessionid = $this->getActiveSession($clientid);
    //$staffClassID =$this->classTeacherClassID($staffid,$schid);
    $query ="SELECT
    CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName, ' ', student_initial.lastName) AS studName, student_initial.id AS StudentID, student_initial.img AS MyImage, student_initial.gender AS Gender,
    class.class_name AS className,
    session.session AS SessionName
    FROM student_initial
    INNER JOIN class ON student_initial.classAdmitted=class.id
    INNER JOIN session ON student_initial.sessionAdmitted=session.id
    WHERE student_initial.classAdmitted=? AND student_initial.sessionAdmitted=? AND student_initial.stud_sch_id=? ORDER BY studName ASC";
    $this->conn->query($query);
    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
    $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
    $this->conn->bind(3, $clientid, PDO::PARAM_INT);
    $myResult = $this->conn->resultset();
    $null ="<p>No student yet!</p>";
        $ci =1;
        $output="";
    $output.= '<p class="printAssessment">
    <a href="admissionListPrint.php?class='.$classid.'&session='.$sessionid.'&schoolid='.$clientid.'" target="_blank" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print List </a>
    <hr></p>';
    
    $myResult = $this->conn->resultset();
    $output.='<h5 class="top-header mt-2"><i class="material-icons">group</i>  Admission List </h5><br/>';
    $output.='<table class="table-print">
    <thead><tr><th>#</th><th>Avatar</th><th>Name</th><th>Gender</th><th>Class</th><th>Session</th><th>Admission Number</th></tr></thead><tbody>';
        if($myResult && $this->conn->rowCount()>=1)
            {
                foreach ($myResult as $row => $key) 
                {
                $fullname = $key['studName'];
                $avatar = $key['MyImage'];
                        if($avatar){
                        $thumbnail='<img src="'.$avatar.'" class="list-avatar">';
                        }else{
                        $thumbnail='<img src="../images/profile-icon.png" class="list-avatar">';
                         }
                    
                //$avatarData ='<img src="'.$avatar.'" alt="Student Avatar" class="small-avatar">';
                $studentID = $key['StudentID'];
                $gender = $key['Gender'];
                $class = $key['className'];
                $session = $key['SessionName'];
                $studSerialNum =$this->studentSerialNumber($studentID,$clientid);
                $output.= '<tr>';
                $output.='<td>'.$ci.'</td>';
                $output.='<td>'.$thumbnail.'</td>';
                $output.='<td>'.$fullname.'</td>';
                $output.='<td>'.$gender.'</td>';
                $output.='<td>'.$class.'</td>';
                $output.='<td>'.$session.'</td>';
                $output.='<td>'.$studSerialNum.'</td>';
                $output.='</tr>';
                $ci++;
    //$output .= "<option value=".$ID.">".$category."</option>";
        }
    echo $output.=' </tbody></table>';
    }else{
    echo $null;
    }
    }
//End of try catch block
    catch(Exception $e)
    {
    echo "Error:". $e->getMessage();
    }
    }
    //end method to get list of admitted students by class
//==========================================================

//METHOD TO PRINT ADMISSION LIST
public function admissionListPrint($classid,$sessionid,$clientid)
{
  try {
  $sessionid = $this->getActiveSession($clientid);
  //$staffClassID =$this->classTeacherClassID($staffid,$schid);
  $query ="SELECT
  CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName) AS studName, student_initial.id AS StudentID, student_initial.img AS MyImage, student_initial.gender AS Gender,
  class.class_name AS className,
  session.session AS SessionName
  FROM student_initial
  INNER JOIN class ON student_initial.classAdmitted=class.id
  INNER JOIN session ON student_initial.sessionAdmitted=session.id
  WHERE student_initial.classAdmitted=? AND student_initial.sessionAdmitted=? AND student_initial.stud_sch_id=? ORDER BY studName ASC";
  $this->conn->query($query);
  $this->conn->bind(1, $classid, PDO::PARAM_INT); 
  $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
  $this->conn->bind(3, $clientid, PDO::PARAM_INT);
  $myResult = $this->conn->resultset();
  $null ="<p>No student yet!</p>";
      $ci =1;
  $output="";
  $myResult = $this->conn->resultset();
  $output.='<table class="table-print">
  <thead><tr><th>#</th><th>Avatar</th><th>Name</th><th>Gender</th><th>Class</th><th>Session</th><th>Admission Number</th></tr></thead><tbody>';
      if($myResult && $this->conn->rowCount()>=1)
          {
              foreach ($myResult as $row => $key) 
              {
              $fullname = $key['studName'];
              $avatar = $key['MyImage'];
                      if($avatar){
                      $thumbnail='<img src="'.$avatar.'" class="list-avatar">';
                      }else{
                      $thumbnail='<img src="../images/profile-icon.png" class="list-avatar">';
                       }
                  
              //$avatarData ='<img src="'.$avatar.'" alt="Student Avatar" class="small-avatar">';
              $studentID = $key['StudentID'];
              $gender = $key['Gender'];
              $class = $key['className'];
              $session = $key['SessionName'];
              $studSerialNum =$this->studentSerialNumber($studentID,$clientid);
              $output.= '<tr>';
              $output.='<td>'.$ci.'</td>';
              $output.='<td>'.$thumbnail.'</td>';
              $output.='<td>'.$fullname.'</td>';
              $output.='<td>'.$gender.'</td>';
              $output.='<td>'.$class.'</td>';
              $output.='<td>'.$session.'</td>';
              $output.='<td>'.$studSerialNum.'</td>';
              $output.='</tr>';
              $ci++;
  //$output .= "<option value=".$ID.">".$category."</option>";
      }
  echo $output.=' </tbody></table>';
  }else{
  echo $null;
  }
  }
//End of try catch block
  catch(Exception $e)
  {
  echo "Error:". $e->getMessage();
  }
  }




//METHOD TO PRINT ADMISSION LIST


//Full enrolled students display with delete button and deactivate button
public function classEnrollmentPreview($staffid,$clientid)
    {
        try {
            $sessionid = $this->getActiveSession($clientid);
            $staffClassID =$this->classTeacherClassID($staffid,$clientid);
            $query ="SELECT student_class.id AS classID, student_class.student_id AS StudentID,
            CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName, ' ', student_initial.lastName) AS studName, student_initial.img AS MyImage, 
            class.class_name AS className
            FROM student_class
            INNER JOIN staff_profile ON student_class.stud_added_by=staff_profile.user_id
            INNER JOIN class ON student_class.stud_class = class.id
            INNER JOIN student_initial ON student_class.student_id=student_initial.id
            WHERE student_class.stud_added_by=? AND student_class.stud_school_id=? AND student_class.stud_sess_id=? AND student_class.stud_class=? ORDER BY studName ASC";
            $this->conn->query($query);
            $this->conn->bind(1, $staffid, PDO::PARAM_INT); 
            $this->conn->bind(2, $clientid, PDO::PARAM_INT);
            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
            $this->conn->bind(4, $staffClassID, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $null ="<p>No student yet!</p>";
        
        $output="";
        $myResult = $this->conn->resultset();
        $output.='<h5 class="top-header mt-2"><i class="material-icons">group</i> Current Enrolled Students </h5><br/>';
        $output .='<table class="table">';
        $output .='<thead><tr><th>Avatar</th><th> Name</th><th>Class</th><th>Remove</th><th>Preview</th></tr></thead><tbody>';
        if($myResult && $this->conn->rowCount()>=1)
         {
                foreach ($myResult as $row => $key) 
                {
                $fullname = $key['studName'];
                $avatar = $key['MyImage'];
                $avatarData ='<img src="'.$avatar.'" alt="Student Avatar" class="small-avatar">';
                $studentID = $key['StudentID'];
                $Recordid = $key['classID'];
                $class = $key['className'];
                $output.= '<tr>';
                $output.='<td>'.$avatarData.'</td>';
                $output.='<td>'.$fullname.'</td>';
                $output.='<td>'.$class.'</td>';
                $output.='<td><button type="button"  data-recordid="'.$key['classID'].'" class="btn btn-info btn-sm" id="removeEnrolledStud"><i class="material-icons">delete_forever</i> Remove</button></td>';
                $output.='<td><button type="button" data-studentid="'.$key['StudentID'].'" data-recordid="'.$key['classID'].'" class="btn btn-info btn-sm enrolledStudent-div" id="enrolledStudPreview"> <i class="material-icons">perm_identity</i> Preview</button></td>';
                $output.='</tr>';
            //$output .= "<option value=".$ID.">".$category."</option>";
                }
            echo $output.=' </tbody></table>';
    }else{
        echo $null;
    }
}
    //End of try catch block
catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }
}
//End full enrolled students display with delete button and deactivate button

//STUDENT ENROLLMENT BY CLASS AND SESSION, SELECTION BASED ON CLASS TEACHER

public function classEnrollmentFilter($classid,$session,$staffid,$clientid)
    {
        try {
        //$sessionid = getActiveSession($clientid);
        //$staffClassID =$this->classTeacherClassID($staffid,$schid);
        $query ="SELECT student_class.id AS classID, student_class.student_id AS StudentID,
        CONCAT(UPPER(student_initial.surname), ', ', student_initial.firstName, ' ', student_initial.lastName) AS studName, student_initial.img AS MyImage, 
        class.class_name AS className,
        session.session AS SessionName
        FROM student_class
        INNER JOIN staff_profile ON student_class.stud_added_by=staff_profile.user_id
        INNER JOIN class ON student_class.stud_class = class.id
        INNER JOIN session ON student_class.stud_sess_id=session.id
        INNER JOIN student_initial ON student_class.student_id=student_initial.id
        WHERE student_class.stud_added_by=? AND student_class.stud_school_id=? AND student_class.stud_sess_id=? AND student_class.stud_class=? ORDER BY studName ASC";
        $this->conn->query($query);
        $this->conn->bind(1, $staffid, PDO::PARAM_INT); 
        $this->conn->bind(2, $clientid, PDO::PARAM_INT);
        $this->conn->bind(3, $session, PDO::PARAM_INT);
        $this->conn->bind(4, $classid, PDO::PARAM_INT);
        $myResult = $this->conn->resultset();
        $null ="<p>No student yet!</p>";
    
        $output="";
        $myResult = $this->conn->resultset();
       $output.='<h5 class="top-header mt-2"><i class="material-icons">group</i>  Enrolled Students List </h5><br/>';
        $output .='<table class="table">';
        $output .='<thead><tr><th>Avatar</th><th> Name</th><th>Class</th><th>Session</th><th>Preview</th></tr></thead><tbody>';
    if($myResult && $this->conn->rowCount()>=1)
     {
            foreach ($myResult as $row => $key) 
            {
            $fullname = $key['studName'];
            $avatar = $key['MyImage'];
            $avatarData ='<img src="'.$avatar.'" alt="Student Avatar" class="small-avatar">';
            $studentID = $key['StudentID'];
            $Recordid = $key['classID'];
            $class = $key['className'];
            $session = $key['SessionName'];
            $output.= '<tr>';
            $output.='<td>'.$avatarData.'</td>';
            $output.='<td>'.$fullname.'</td>';
            $output.='<td>'.$class.'</td>';
            $output.='<td>'.$session.'</td>';
            $output.='<td><button type="button" data-studentid="'.$key['StudentID'].'" class="btn btn-info btn-sm enrolledStudent-div" id="enrolledStudPreview"> <i class="material-icons">perm_identity</i> Preview</button></td>';
            $output.='</tr>';
        //$output .= "<option value=".$ID.">".$category."</option>";
            }
        echo $output.=' </tbody></table>';
}else{
    echo $null;
}
}
//End of try catch block
catch(Exception $e)
{
    echo "Error:". $e->getMessage();
}
}

//END STUDENT ENROLLMENT BY CLASS AND SESSION, SELECTION BASED ON CLASS TEACHER

//METHOD TO LIST  CLASS TEACHERS
public function listClassTeachers($schid)
 {
    try {
        $query ="SELECT CONCAT(UPPER(staff_profile.surname), ', ', staff_profile.middle_name) AS fullname, 
        staff_profile.user_img AS Avatar,  
        class_teacher.staff_id AS StaffID, 
        class_teacher.id AS classteacherID, 
        class.class_name AS ClassName
        FROM staff_profile 
        INNER JOIN class_teacher ON class_teacher.staff_id = staff_profile.user_id
        INNER JOIN class ON class_teacher.class_id=class.id
        WHERE class_teacher.school_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $schid, PDO::PARAM_INT);
            $myResult = $this->conn->resultset();
            $output="";
            $output.="<h5 class='top-header mt-2'> Class Teachers </h5><br/>";
            $output .='<table class="table">';
            $output .='<thead><tr><th>Avatar</th><th> Name</th><th>Class</th><th>Remove</th><th>Edit</th></tr></thead><tbody>';
            if($myResult && $this->conn->rowCount()>=1)
            {
            foreach ($myResult as $row => $key) 
            {
            $fullname = $key['fullname'];
            $avatar = $key['Avatar'];
            $avatarData ='<img src="'.$avatar.'" alt="Avatar" class="small-avatar">';
            $staffID = $key['StaffID'];
            $Recordid = $key['classteacherID'];
            $class = $key['ClassName'];
            $output.= '<tr>';
            $output.='<td>'.$avatarData.'</td>';
            $output.='<td>'.$fullname.'</td>';
            $output.='<td>'.$class.'</td>';
            $output.='<td><button type="button"  data-recordid="'.$key['classteacherID'].'" class="btn btn-info btn-sm" id="removeclassteacher"><i class="fa fa-trash fa-fw" aria-hidden="true"></i> Remove</button></td>';
            $output.='<td><button type="button" data-staffid="'.$key['StaffID'].'" data-recordid="'.$key['classteacherID'].'" class="btn btn-info btn-sm classteacher-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
           $output.='</tr>';
           //$output .= "<option value=".$ID.">".$category."</option>";
            }
            $output.=' </tbody></table>';
            echo $output;
 }
 else{
    $query ="SELECT users.user_name AS Username,  
    class_teacher.staff_id AS StaffID, 
    class_teacher.id AS classteacherID, 
    class.class_name AS ClassName
    FROM users 
    INNER JOIN class_teacher ON class_teacher.staff_id = users.id
    INNER JOIN class ON class_teacher.class_id=class.id
    WHERE class_teacher.school_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $schid, PDO::PARAM_INT);
        $myResult = $this->conn->resultset();
        $output="";
        if($myResult && $this->conn->rowCount()>=1)
        {
        $output.="<h5 class='top-header mt-2'> Class Teachers </h5><br/>";
        $output .='<table class="table">';
        $output .='<thead><tr><th> User Name</th><th>Class</th><th>Remove</th><th>Edit</th></tr></thead><tbody>';
        foreach ($myResult as $row => $key) 
        {
        $fullname = $key['Username'];
        //$avatar = $key['Avatar'];
        //$avatarData ='<img src="'.$avatar.'" alt="Staff Avatar" class="small-avatar">';
        $staffID = $key['StaffID'];
        $Recordid = $key['classteacherID'];
        $class = $key['ClassName'];
        $output.= '<tr>';
        //$output.='<td>'.$avatarData.'</td>';
        $output.='<td>'.$fullname.'</td>';
        $output.='<td>'.$class.'</td>';
        $output.='<td><button type="button"  data-recordid="'.$key['classteacherID'].'" class="btn btn-info btn-sm" id="removeclassteacher"><i class="fa fa-trash fa-fw" aria-hidden="true"></i> Remove</button></td>';
        $output.='<td><button type="button" data-staffid="'.$key['StaffID'].'" data-recordid="'.$key['classteacherID'].'" class="btn btn-info btn-sm classteacher-div" id="editModal"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit</button></td>';
       $output.='</tr>';
       //$output .= "<option value=".$ID.">".$category."</option>";
        }
        $output.=' </tbody></table>';
        echo $output;
    }else
    {
        exit("No staff added or no class assigned yet!");
    }
}      
}// End of try catch block
 catch(Exception $e)
  {
//echo error here
//this get an error thrown by the system
echo "Error:". $e->getMessage();

}
}
////END METHOD TO LIST CLASS TEACHERS

//school preview method

function schoolProfilePreview($clientid)
{
try {
        $query ="SELECT institutional_signup.inst_id AS ID, institutional_category.category_name AS schType,nationality.nationality AS Nation, states.state_name AS State, lga.lga AS Lg, city.city_name AS City, institutional_signup.inst_mobile AS Mobile,institutional_signup.web_address AS WebAdd, institutional_signup.email_add AS Email FROM institutional_signup
        INNER JOIN institutional_category ON institutional_signup.institution_type=institutional_category.id
        INNER JOIN nationality ON institutional_signup.country_id=nationality.id
        INNER JOIN states ON institutional_signup.state_id=states.id
        INNER JOIN lga ON institutional_signup.lg_id=lga.id
        INNER JOIN city ON institutional_signup.inst_city_id=city.id
        WHERE institutional_signup.client_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $clientid, PDO::PARAM_INT);
            $output = array();
            $myResult = $this->conn->resultset();
            $output = $myResult;
            $printOutput = "";
            if($output)
            {

              foreach($output as $row => $key)
                        {
                //make the record id of the terminal exam table the key of the array
                $schtype = $key['schType'];
                $nation = $key['Nation'];
                $state= $key['State'];
                $lg = $key['Lg'];
                $city = $key['City'];
                $mobile= $key['Mobile'];
                $web = $key['WebAdd'];
                $email = $key['Email'];
                //var_dump($arr);
                        }
              $printOutput.='<h6 class="top-header">School Profile</h6>
              <ul class="preview-list-container">';
              $printOutput.='<li class=""> <span class=""><i class="material-icons">school</i>
School Type</span> '.$schtype.'</li>';
              $printOutput.='<li class=""> <span class=""><i class="material-icons">public</i> Country </span>'.$nation.'</li>';
              $printOutput.='<li class=""> <span class=""> <i class="material-icons">place</i>
State </span>' .$state.'</li>';
               $printOutput.='<li class=""> <span class=""> <i class="material-icons">my_location</i>
City </span>'.$city.'</li>';
              $printOutput.='<li class=""><span class=""><i class="material-icons">call</i>
Mobile </span> '.$mobile.'</li>';
$printOutput.='<li class=""><span class=""><i class="material-icons">link</i>
Web Address </span> '.$web.'</li>';
$printOutput.='<li class=""><span class=""><i class="material-icons">mail</i>
Email </span> '.$email.'</li>';
              $printOutput.='</ul>';
            }
            else
            {
              echo "No School profile yet!";
            }
            echo $printOutput;
        }//End of try catch block
 catch(Exception $e)
    {
    echo ("Error: Unable to school profile");
    }
}
//end school preview method


//Count the number of male  students in my class
public function maleStudentCount($staffid,$clientid,$gender="Male")
    {
        try {
            
            $staffClassID =$this->classTeacherClassID($staffid,$clientid);
            if($staffClassID)
            {
            $sessionid = $this->getActiveSession($clientid);
            $query ="SELECT  COUNT(student_initial.gender) AS Male
            FROM student_initial
            WHERE student_initial.stud_sch_id=? AND student_initial.gender=? AND student_initial.id IN (SELECT student_id FROM student_class WHERE stud_class=? AND stud_sess_id=? AND stud_added_by=? AND stud_school_id=?)";
            $this->conn->query($query);
            $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
            $this->conn->bind(2, $gender, PDO::PARAM_STR); 
            $this->conn->bind(3, $staffClassID, PDO::PARAM_INT); 
            $this->conn->bind(4, $sessionid, PDO::PARAM_INT); 
            $this->conn->bind(5, $staffid, PDO::PARAM_INT); 
            $this->conn->bind(6, $clientid, PDO::PARAM_INT); 
        
            $myResult = $this->conn->resultset();
            $output = "null";
            if($myResult && $this->conn->rowCount() >=1)
               {
                   foreach($myResult as $row => $key)
                   {
                    $no = $key['Male'];
                   }
                   return $no;
               }
               else
                {
                return $null;
                }
            //echo json_encode($output);
            }
        else{
            //do nothing
        }
        }//End of try catch block
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }
    }
//end get male staff



//METHOD TO GET NUMBER OF FEMALE STUDENTS IN CLASS
public function femaleStudentCount($staffid,$clientid,$gender="Female")
    {
    try {
        
         // $sessionid = $this->getActiveSession($clientid);
          $staffClassID =$this->classTeacherClassID($staffid,$clientid);
        if($staffClassID)
        {
            $sessionid = $this->getActiveSession($clientid);
        $query ="SELECT  COUNT(student_initial.gender) AS Female
        FROM student_initial
        WHERE student_initial.stud_sch_id=? AND student_initial.gender=? AND student_initial.id IN (SELECT student_id FROM student_class WHERE stud_class=? AND stud_sess_id=? AND stud_added_by=? AND stud_school_id=?)";
        $this->conn->query($query);
        $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
        $this->conn->bind(2, $gender, PDO::PARAM_STR); 
        $this->conn->bind(3, $staffClassID, PDO::PARAM_INT); 
        $this->conn->bind(4, $sessionid, PDO::PARAM_INT); 
        $this->conn->bind(5, $staffid, PDO::PARAM_INT); 
        $this->conn->bind(6, $clientid, PDO::PARAM_INT); 
        
        $myResult = $this->conn->resultset();
        $output = "null";
        if($myResult && $this->conn->rowCount() >=1)
           {
               foreach($myResult as $row => $key)
               {
                $no = $key['Female'];
               }
               return $no;
           }
           else
            {
            return $null;
            }
        //echo json_encode($output);
        }
        else{
            //do nothing
        }
    }//End of try catch block
    catch(Exception $e)
    {
    echo "Error:". $e->getMessage();
    }
    }
//END METHOD TO GET NUMBER OF FEMALE STUDENTS IN CLASS

//count number of students in a particular class
public function StudentsClassCount($staffid,$clientid)
  {
    try {
        
        $sessionid = $this->getActiveSession($clientid);
        $staffClassID =$this->classTeacherClassID($staffid,$clientid);
        if($staffClassID)
        {
        $query ="SELECT  COUNT(student_id) AS StudentCount 
        FROM
        student_class 
        WHERE stud_class=? AND stud_sess_id=? AND stud_added_by=? AND stud_school_id=?";
        $this->conn->query($query); 
        $this->conn->bind(1, $staffClassID, PDO::PARAM_INT); 
        $this->conn->bind(2, $sessionid, PDO::PARAM_INT); 
        $this->conn->bind(3, $staffid, PDO::PARAM_INT); 
        $this->conn->bind(4, $clientid, PDO::PARAM_INT); 
        $myResult = $this->conn->resultset();
        $output = "null";
        if($myResult && $this->conn->rowCount() >=1)
           {
               foreach($myResult as $row => $key)
               {
                $no = $key['StudentCount'];
               }
               return $no;
           }
           else
            {
            return $null;
            }
        //echo json_encode($output);
        }
        else{
            //Do nothing
        }
    }//End of try catch block
   catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }
   }
//End count number of students in a particular class


//class count summary
public function ClassSummaryCount($staffid,$clientid)
 {
 try {
     if( $this->classTeacherClassID($staffid,$clientid) && $this->getActiveSession($clientid))
     {
            $sessionid = $this->getActiveSession($clientid);
            $staffClassID =$this->classTeacherClassID($staffid,$clientid);
            $classCount = $this->StudentsClassCount($staffid,$clientid);
            $femaleStudCount = $this->femaleStudentCount($staffid,$clientid);
            $maleStudentCount = $this->maleStudentCount($staffid,$clientid);

    //call student male function
    //call female student count function
    if($staffClassID)
     {
                     $printOutput ="";
                     $printOutput ='<div class="class-stats">
                    <h5><i class="fa fa-bars fa-fw" aria-hidden="true"></i>
                    Class Summary</h5>
                      <ul class="stud-list-highlight">';
                     $printOutput.='<li>
                     <p class="stud-details-item"><i class="fa fa-users fa-fw" aria-hidden="true"></i> Total Student(s)   <span class="badge badge-pill badge-primary">'.$classCount.'</span></p></li>';
                     $printOutput.='<li><p class="stud-details-item"><i class="fa fa-male fa-fw" aria-hidden="true"></i> Male Student(s)    <span class="badge badge-pill badge-info">'.$maleStudentCount.'</span></p></li>';
                     $printOutput.='<li><p class="stud-details-item"><i class="fa fa-female fa-fw" aria-hidden="true"></i> Female Student(s)    <span class="badge badge-pill badge-info">'.$femaleStudCount.'</span></p></li>';
                    $printOutput.='</ul></div>';
                    echo $printOutput;
      }else{
          //display nothing
      }
    }else{
        //empty session, do nothing
    }
        
    }//End of try catch block
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }
}
//class count summary

//STUDEN EDIT FUNCTIONALITY
public function studentEditProfile($studentid,$clientid)
    {
    try {
        $query ="SELECT student_initial.surname AS Surname, 
        student_initial.firstName AS FirstName,
        student_initial.lastName AS LastName,
        student_initial.perm_home_add AS HomeAdd,
        student_initial.contact_add AS ContactAdd,
        student_initial.email AS Mail,
        student_initial.mobile AS Mobile
        FROM student_initial
        WHERE stud_sch_id=? AND id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
            $this->conn->bind(2, $studentid, PDO::PARAM_INT); 
            $myResult = $this->conn->resultset();
            $output=$myResult;
            return $output;
    }// End of try catch block
    catch(Exception $e)
    {
    echo ("Error: Unable to fetch student Profile");
    }
}
//END STUDENT EDIT FUNCTIONALITY


//EDIT STAFF PROFILE FUNCTIONALITY
public function staffEditProfile($staffid,$clientid)
    {
        try {
            $query ="SELECT staff_profile.surname AS Surname, 
            staff_profile.middle_name AS FirstName,
            staff_profile.lastname AS LastName,
            staff_profile.email AS Mail,
            staff_profile.mobile AS Mobile
            FROM staff_profile
            WHERE my_school_id=? AND user_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
            $this->conn->bind(2, $staffid, PDO::PARAM_INT); 
            $myResult = $this->conn->resultset();
            $output=$myResult;
            return $output;
    }// End of try catch block
    catch(Exception $e)
    {
    echo ("Error: Unable to fetch staff Profile");
    }
}




//END EDIT STAFF PROFILE FUNCTIONALITY





































































































































































































































































































  }
  //end of client class