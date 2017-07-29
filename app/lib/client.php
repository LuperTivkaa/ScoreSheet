<?php 

class client{

	//class propoerties
	private $sch_name;
	private $sch_type;
	private $country;
	private $state;
	private $lga;
	private $city;
	private $email;
	private $mobile;
	private $address;
	private $username;
	private $password;
	private $priority;
	private $notes;
  private $role;


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


//all students

public function getAllStudents($id)
        {
        try {
            include'db.php';
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', lastName, ' ', lastname) AS fullname, gender,img,status_active FROM student_initial
                WHERE stud_sch_id=? ORDER BY gender AND surname ASC";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
                    $stmt->execute();
                    $output = array();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

//male staff count

public function getMaleStaff($id)
        {
        try {
            include'db.php';
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, user_img FROM staff_profile
                WHERE my_school_id=? AND gender='male'";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
                    $stmt->execute();
                    $output = array();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            include'db.php';
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, user_img FROM staff_profile
                WHERE my_school_id=? AND gender='female'";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
                    $stmt->execute();
                    $output = array();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
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


//add subject taught
public  function addSubject($subject_id,$class_id,$staff_id,$sch_id,$addedDate,$editedDate,$createdBy)
  {
  //database connection file
  include 'db.php';
// always use try and catch block to write code
     
  try{

    //insert new subjects  taught by staff 
                            $sqlStmt = "INSERT INTO staff_subject_taught(subject_id,
                            class_taught,my_id,sch_identity,addedDate,editedDate,addedBy)
                             values (?,?,?,?,?,?,?)";
                            $result = $db->prepare($sqlStmt);
                            $result->bindParam(1, $subject_id, PDO::PARAM_STR,100);
                            $result->bindParam(2, $class_id, PDO::PARAM_STR,100);
                            $result->bindParam(3, $staff_id, PDO::PARAM_STR,100);
                            $result->bindParam(4, $sch_id, PDO::PARAM_INT); 
                            $result->bindParam(5, $addedDate, PDO::PARAM_STR);
                            $result->bindParam(6, $editedDate, PDO::PARAM_STR); 
                            $result->bindParam(7, $createdBy, PDO::PARAM_STR); 
                            
                            $result->execute(); 
                        if ($result->rowCount() == 1) 
                        {
                         //check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Error adding subject";
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
public  function newStaff($email,$sur_name,$mypass,$role,$clientid,$editedDate,$createdDate)
  {
  //database connection file
  include 'db.php';
// always use try and catch block to write code
     
  try{

    //check for limit of qualifications added
                    $query ="SELECT * FROM users where email=? || user_name =? || password=?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $user_name, PDO::PARAM_STR);
                    $stmt->bindParam(2, $mypass, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($stmt->rowCount() >=1)
                    {
                      echo "Please make sure your credentials are unique";
                    }
                    else{


          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO users(email,user_name,
                            password,role,created_By,
                            edited_on,created_on)
                             values (?,?,?,?,?,?)";
                            $result = $db->prepare($sqlStmt);
                            $result->bindParam(1, $email, PDO::PARAM_STR,100);
                            $result->bindParam(2, $sur_name, PDO::PARAM_STR,100);
                            $result->bindParam(3, $mypass, PDO::PARAM_STR,100);
                            $result->bindParam(4, $role, PDO::PARAM_STR,100);
                            $result->bindParam(5, $clientid, PDO::PARAM_INT); 
                            $result->bindParam(6, $editedDate, PDO::PARAM_STR);
                            $result->bindParam(7, $createdDate, PDO::PARAM_STR);
                            $result->execute(); 

                        if ($result->rowCount() == 1) 
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
public  function instProfile($inst_name,$inst_type, $clientid,$country,$state, $lg, $city,$address,$mobile)
 	{
  //database connection file
  include 'db.php';
// always use try and catch block to write code
     
  try{

    //check for limit of qualifications added
                    $query ="SELECT * FROM institutional_signup where client_id =?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $clientid, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($stmt->rowCount() >=3)
                    {
                      echo "Choose unique credentials";
                    }
                    else{


          //this is code uses the PDO class with its related methods, pls check the PHP documentation for this, just type: PHP PDO
          //There is so much information using the php documentation 
                            $sqlStmt = "INSERT INTO institutional_signup(institution_name,institution_type,
                            client_id,country_id,state_id,
                            lg_id,inst_city_id,inst_add,
                            inst_mobile) values (?,?,?,?,?,?,?,?,?)";
                            $result = $db->prepare($sqlStmt);
                            $result->bindParam(1, $inst_name, PDO::PARAM_STR,100);
                            $result->bindParam(2, $inst_type, PDO::PARAM_STR,100);
                            $result->bindParam(3, $clientid, PDO::PARAM_STR,100);
                            $result->bindParam(4, $country, PDO::PARAM_INT); 
                            $result->bindParam(5, $state, PDO::PARAM_INT);
                            $result->bindParam(6, $lg, PDO::PARAM_INT); 
                            $result->bindParam(7, $city, PDO::PARAM_INT);
                            $result->bindParam(8, $address, PDO::PARAM_STR); 
                            $result->bindParam(9, $mobile, PDO::PARAM_INT);
                            
                            $result->execute(); 
                        if ($result->rowCount() == 1) 
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



    //this function loads institution category
    public function inst_category()
        {
        try {
            include'db.php';
                $query ="SELECT * FROM institutional_category";
                    $stmt= $db->prepare($query);
                 $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
        {
            
            $ID = $key['id'];
            $inst_name = $key['category_name'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$inst_name."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: unexpected action, process terminated";
        }
        }
// load institution category

        // get profile of intitution form the database


public function schProfile($id)
        {
        try {
            include'db.php';
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
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
                    $stmt->execute();
                    $output = array();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            include'db.php';
                $query ="SELECT institutional_signup.institution_name,             
                institutional_signup.inst_logo FROM institutional_signup 
                WHERE client_id=?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT); 
                    $stmt->execute();
                    $output = array();
                    $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo ("Error: Unable to fetch school Profile");
        }
        }

        //end get profile

//end of Institution Header

//function to submit form
public  function myTicket($clientid, $title,$priority,$notes,$date,$status="Open",$clientid)
 	{
  //database connection file
  include 'db.php';
//always use try and catch block to write code
     
  try{



          //insert new ticket
                            $sqlStmt = "INSERT INTO tickets(my_client_id,priority,notes,date_added,status_ticket,ticket_userid) 
                            values (?,?,?,?,?,?)";
                            $result = $db->prepare($sqlStmt);
                            $result->bindParam(1, $clientid, PDO::PARAM_STR,100);
                            $result->bindParam(2, $priority, PDO::PARAM_STR,100);
                            $result->bindParam(3, $notes, PDO::PARAM_STR,100);
                            $result->bindParam(4, $date, PDO::PARAM_INT);   
                            $result->bindParam(5, $status, PDO::PARAM_STR); 
                            $result->bindParam(6, $clientid, PDO::PARAM_INT); 
                            $result->execute(); 
                        if ($result->rowCount() == 1) 
                        {
                         // check number of inserted rows
                        echo "ok";
                        } 
                        else
                        {
                        echo "Could not create your ticket";
                      	}

        }
      
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}


 //this function loads institutional category
public function loadInstCategory()
    {
        try {
            include'db.php';
                $query ="SELECT * FROM institutional_category";
                    $stmt= $db->prepare($query);
 		            $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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

            include'db.php';
                $query ="SELECT users.id,users.user_name FROM users WHERE users.id NOT IN (SELECT user_id FROM staff_profile WHERE my_school_id=?)";
                $stmt= $db->prepare($query);
                $stmt->bindParam(1, $client_id, PDO::PARAM_INT);
                $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $output =" "; 
        foreach ($resultset as $row => $key) 
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
   //end load staff function



//Get class
public function loadClass($client_id)
    {
        try {

            include'db.php';
                $query ="SELECT id,class_name FROM class WHERE my_inst_id=?";
                $stmt= $db->prepare($query);
                $stmt->bindParam(1, $client_id, PDO::PARAM_INT);
                $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $output =" "; 
        foreach ($resultset as $row => $key) 
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
public function loadSubject($class_id)
    {
        try {

            include'db.php';
                $query ="SELECT subjects.sub_id,subject_name FROM subjects INNER JOIN class_subject ON 
                class_subject.subject_id=subjects.sub_id WHERE class_subject.class_id=?";
                $stmt= $db->prepare($query);
                $stmt->bindParam(1, $class_id, PDO::PARAM_INT);
                $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $output =" "; 
        foreach ($resultset as $row => $key) 
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
            include'db.php';
                $query ="SELECT * FROM institutional_responsibilities";
                    $stmt= $db->prepare($query);
                $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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
            include'db.php';
                $query ="SELECT * FROM nationality";
                    $stmt= $db->prepare($query);
 		            $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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
            include'db.php';
                $query ="SELECT id,state_name FROM states WHERE nation_id=?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT);
 		            $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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
            include'db.php';
                $query ="SELECT id,lga FROM lga WHERE state_lg_id=?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT);
 		            $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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
            include'db.php';
                $query ="SELECT id,city_name FROM city WHERE lg_govt_id=?";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $id, PDO::PARAM_INT);
 		            $stmt->execute();
                $resultset = $stmt->fetchAll(PDO::FETCH_ASSOC);
               $output =" "; 
        foreach ($resultset as $row => $key) 
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



}
//end of client sign up