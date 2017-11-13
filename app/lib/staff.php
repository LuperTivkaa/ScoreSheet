<?php
namespace ScoreSheet;
use \PDO;

class staff {
public $conn;

//class constructor for initialising the database class
 public function __construct(dbConnection $db){
    $this->conn = $db;
  }
//METHOD TO GET THE ID OF A STUDENT BASED ON ASSIGNED REGISTRATION NUMBER
function getStudentId($regnumber,$schid)
  {
    //always use try and catch block to write code
  try
    {
        //SELECT THE ID OF THE STUDENT/PUPIL FROM THE student_admission_no TABLE
  		 // BASED ON THE REG NUMBER PROVIDED
                  $query ="SELECT student_admission_no.stud_id AS StudentID,
                  admission_number.id AS AdmNoID
                  FROM student_admission_no INNER JOIN admission_number ON student_admission_no.admission_number=admission_number.id
                  WHERE admission_number.serial_number=? AND admission_number.adm_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $regnumber, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                        $myResult = $this->conn->resultset();
                        if ($this->conn->rowCount() == 1)
                        {
                        	//loop through the result set
                        	foreach ($myResult as $row => $key)
					                {

					                $ID = $key['StudentID'];

					                }
					        // retrun the ID  OF THE STUDENT
					        return $ID;
                        }
                        else
                        {
                        exit("This number is not in use");
                        }

        }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
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


//METHOD TO GET THE ACTIVE TERM ID
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

//compare max ca scores
function getMaxCaScores($class,$schid)
 {
    //always use try and catch block to write code
  try 
    {
        //
          $sqlStmt = "SELECT class.class_categoryid AS ClassCatID, ass_score_setting.max_ca_score AS MaxScore FROM class INNER JOIN ass_score_setting ON class.class_categoryid=ass_score_setting.class_category_id WHERE class.id=? AND class.my_inst_id=?";
          $this->conn->query($sqlStmt);
          $this->conn->bind(1, $class, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_STR);
          $myResult = $this->conn->resultset();
              if ($this->conn->rowCount() >= 1)
              {
                 //loop through the result set
                 foreach ($myResult as $row => $key)
					        {
					            $maxScore = $key['MaxScore'];
					        }
					        // compare
                  // if($scores <= $maxScore){

                  // }
                  // else{
                  //   exit("Maximum scores exceeded!");
                  // }
                  return $maxScore;
              }
              else
              {
              exit("No max ca scores set. Contact the admin");

              }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
//end compare max ca scores

//compare max exam scores
function getMaxExamScores($class,$schid)
 {
    //always use try and catch block to write code
  try 
    {
        //
          $sqlStmt = "SELECT class.class_categoryid AS ClassCatID, exam_score_setting.max_exam_score AS MaxScore FROM class INNER JOIN exam_score_setting ON class.class_categoryid=exam_score_setting.class_category_id WHERE class.id=? AND class.my_inst_id=?";
          $this->conn->query($sqlStmt);
          $this->conn->bind(1, $class, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_STR);
          $myResult = $this->conn->resultset();
              if ($this->conn->rowCount() >= 1)
              {
                 //loop through the result set
                 foreach ($myResult as $row => $key)
					        {
					            $maxScore = $key['MaxScore'];
					        }
					        // compare
                  // if($scores <= $maxScore){

                  // }
                  // else{
                  //   exit("Maximum scores exceeded!");
                  // }
                return $maxScore;
              }
              else
              {
              exit("No max exam scores set. Contact the admin");

              }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
  }
//End Compare max exam scores

//FUNCTION TO ENROLL STUDENTS/PUPILS IN A CLASS
 function enrollStudent($studentid,$class,$sessionid,$staffid,$inst_id,$date)
  {
  // always use try and catch block to write code
  try
    {
      $stud_id = $this->getStudentId($studentid,$inst_id);
    //SELECT STUDENT BASED ON STUDENTID, CLASS, CLASS ARM AND SESSION
    //TODO: NO STUDENT SHOULD BE ENROLLED TWICE IN A CLASS
                    $query ="SELECT * FROM student_class where student_id =?
                    && stud_class=?  && stud_sess_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentid, PDO::PARAM_STR);
                    $this->conn->bind(2, $class, PDO::PARAM_STR);
										$this->conn->bind(3, $sessionid, PDO::PARAM_STR);
                    $this->conn->execute();
                    	if ($this->conn->rowCount() ==1)
                    	{
                    	//STUDENT ALREADY ENROLLED IN THE CLASS
                      	echo "This student is already a member of this class";
                    	}
                    	else{

          					// ENROLLED A STUDENT IN THE CLASS
                            $sqlStmt = "INSERT INTO student_class
                            (student_id,stud_class,
                            stud_sess_id,stud_added_by,stud_school_id,created_on)
                            values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $stud_id, PDO::PARAM_INT);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $inst_id, PDO::PARAM_INT);
                            $this->conn->bind(6, $date, PDO::PARAM_STR);

                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// STUDENT ENROLLED SUCCESSFULLY
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error enrolling student";
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




//METHOD TO ADD NEW ASSESSMENT
//Get student id from a function that takes in reg number of a student and return the id of the student
//get session id from a function that select the id of the active session
function addCa($score,$stud_no,$subj,$class,$staffid,$canumber,$schid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                   $maxScores =  $this->getMaxCaScores($class,$schid);
                   if($score <= $maxScores)
                   {
                    //Check for the number of CA added
                    $query ="SELECT  ass_student_id AS studentID FROM assessment WHERE ass_subject_id =?
                    && ass_class_id=? AND ass_term_id=? AND ass_session_id=? AND ca_no_id=? AND ass_student_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $subj, PDO::PARAM_INT);
										$this->conn->bind(2, $class, PDO::PARAM_INT);
										$this->conn->bind(3, $termid, PDO::PARAM_INT);
										$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(5, $canumber, PDO::PARAM_INT);
                    $this->conn->bind(6, $student_id, PDO::PARAM_INT);
                    $this->conn->execute();
                   
                    	if ($this->conn->rowCount() >= 1)
                    	  {
                    	//NUMBER OF ASESSMENT QUOTA PER TERM EXCEEDED
                      exit("This assessment has been added already!");
                    	}
                    	else{

          					        // ADD CONTINOUS ASSESSMENT
                            $sqlStmt = "INSERT INTO assessment(ca_score,ass_student_id,
                            ass_subject_id,ass_class_id,ass_session_id,ass_term_id,ass_added_by,ass_sch_id,date_added,ca_no_id)
                            values (?,?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $student_id, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $subj, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $class, PDO::PARAM_INT);
                            $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(6, $termid, PDO::PARAM_INT);
                            $this->conn->bind(7, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(8, $schid, PDO::PARAM_INT);
                            $this->conn->bind(9, $date, PDO::PARAM_STR);
                            $this->conn->bind(10, $canumber, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// SCORES ADDED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error adding scores";
                      			}

                    		}
              }
              else{
                exit("Maximum scores exceeded!");
              }
        }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }

//METHOD TO ADD NEW TERMINAL EXAMINATION REECORDS
function addTerminalExam($score,$subj,$class,$staffid,$schid,$stud_no,$date)
  {
      

        try {
                    // always use try and catch block to write code
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                    $maxScores = $this->getMaxExamScores($class,$schid);
                    if($score <= $maxScores)
                    {
                    //CHECK WHETHER MULTIPLE EXAMS SCORES ARE ADDED FOR ONE SUBJECT
                    //TODO: NO STUDENT SHOULD BE ENROLLED TWICE IN THE SAME CLASS AND ARM IN THE SAME SESSION
                    $query ="SELECT exam_subj_id AS SubjectID FROM terminal_exam WHERE exam_term_id =?
                    && exam_session_id=? && exam_class_arm_id=? && exam_sch_id=? && exam_stud_id=? && exam_subj_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $termid, PDO::PARAM_INT);
										$this->conn->bind(2, $sessionid, PDO::PARAM_INT);
										$this->conn->bind(3, $class, PDO::PARAM_INT);
										$this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->bind(5, $student_id, PDO::PARAM_INT);
                    $this->conn->bind(6, $subj, PDO::PARAM_INT);
                    $this->conn->execute();
                    	if ($this->conn->rowCount() >= 1)
                    	{
                    	//MESSAGE FOR EXCEEDED RECODS
                      echo "This examination record already exist";
                    	}
                    	else{

          					        //ADD EXAM RECORD
                            $sqlStmt = "INSERT INTO terminal_exam(exam_score,exam_subj_id,
                            exam_term_id,exam_session_id,exam_class_arm_id,
                            tutor_id,exam_sch_id,exam_stud_id,date_added)
                            values (?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $subj, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $class, PDO::PARAM_INT);
                            $this->conn->bind(6, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(7, $schid, PDO::PARAM_INT);
                            $this->conn->bind(8, $student_id, PDO::PARAM_INT);
                            $this->conn->bind(9, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// SCORES ADDED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error adding exam scores";
                      			}

                    		}
                    }
                    else{
                      exit("Max exam scores exceeded!");
                      
                    }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }
  //END ADD TERMINAL EXAM


  //STUDENT SEARCH METHOD
  //SEARCH STUDENT BASED ON NAME OR REGISTRATION NUMBER
  /*
  use this function for the advanced search also
  1. provide term, session, class, as null arguments to the function
  */
function searchStudent($searchVar,$schid)
  {
       
        try{
        //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT A STRING OF REG NUMBER
  		    if(is_numeric($searchVar))
  		    {
  			//SELECT STUDENT ID FROM THE STUDENT ADMISSION NUMBER TABLE
  					// $query ="SELECT student_initial.id AS studentID, CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID FROM student_initial WHERE student_initial.id=? AND student_initial.stud_sch_id=?";
            //         $this->conn->query($query);
            //         $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
					  //         $this->conn->bind(2, $schid, PDO::PARAM_INT);
            $query ="SELECT admission_number.id AS AdmissionNumID,  CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,student_admission_no.stud_id AS StudentID FROM student_initial INNER JOIN student_admission_no ON student_initial.id=student_admission_no.stud_id INNER JOIN admission_number ON admission_number.id=student_admission_no.admission_number 
            WHERE admission_number.serial_number=? AND admission_number.adm_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
                    $myResult= $this->conn->resultset();
                    $output ="";
                    if($this->conn->rowCount() == 0)
                    {
                      exit("No such student exist in the school with such number");
                    }
                    else{
                      $output .='<table class="table">';
                       $output .='<thead><tr><th>#</th><th>Full Name</th><th>Detail Assessment</th><th>Detail Terminl Examination</th></tr></thead><tbody>';
                    $ci=1;
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                       $ID = $key['StudentID'];
                        $fullname = $key['Fullname'];
                        $output.= '<tr>';
                        $output.='<td>'.$ci.'</td>';
                        $output.='<td>'.$fullname.'</td>';
                        $output.='<td><button onclick="caDetails('.$ID.')" class="btn btn-info btn-sm">View</button></td>';
                        $output.='<td><button onclick="examDetails('.$ID.')" class="btn btn-info btn-sm">View</button></td>';
                        $output.='</tr>';                   
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                      }
                       $output.=' </tbody></table>';
                       echo $output;
  		      }
          }
  		 elseif(is_string($searchVar))
  		 {
  		 	//SELECT ID FROM THE STUDENT INITIAL TABLE BASED ON THE REGISTRATION NUMBER
         //FIND ID BASED ON THE REGISTRATION NUMBER
         //$student_ID = $this->getStudentId($searchVar,$schid);
            		$query ="SELECT student_initial.id AS studentID, CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID FROM student_initial WHERE student_initial.surname LIKE :searchVar AND student_initial.stud_sch_id=:schid";
                    $searchVar = "%$searchVar%";
                    $this->conn->query($query);
                    $this->conn->bind(':searchVar', $searchVar, PDO::PARAM_STR);
					          $this->conn->bind(':schid', $schid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
                    $output ="";
                    if($this->conn->rowCount() == 0)
                    {
                      exit("No such student exist in the school with that name");
                    }
                    else{
                       $output .='<table class="table">';
                       $output .='<thead><tr><th>#</th><th>Full Name</th><th>Detail Assessment</th><th>Detail Terminl Examination</th></tr></thead><tbody>';
                       $ci=1;
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $ID = $key['studentID'];
                        $fullname = $key['Fullname'];
                        $output.= '<tr>';
                        $output.='<td>'.$ci.'</td>';
                        $output.='<td>'.$fullname.'</td>';
                        $output.='<td><button onclick="caDetails('.$ID.')" class="btn btn-info btn-sm">View</button></td>';
                        $output.='<td><button onclick="examDetails('.$ID.')" class="btn btn-info btn-sm">View</button></td>';
                        $output.='</tr>';                   
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                      }
                       $output.=' </tbody></table>';
                       echo $output;
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


// Search CA method
function searchCa($searchVar,$schid)
  {
  // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{
          $activeSession = $this->getActiveSession($schid);
          $studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,assessment.id AS caRecordid,assessment.ca_score AS CaScores,ca_settings.ca_title AS caTitle
             FROM assessment 
             INNER JOIN student_initial ON assessment.ass_student_id=student_initial.id
             INNER JOIN class ON assessment.ass_class_id=class.id 
             INNER JOIN session ON  assessment.ass_session_id=session.id 
             INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
             INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
             INNER JOIN ca_settings ON assessment.ca_no_id=ca_settings.ca_id
             WHERE ass_student_id =?  && ass_sch_id=? && ass_session_id=? ORDER BY Subject,caTitle";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentID, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->bind(3, $activeSession, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>CA Title</th>
                        <th>CA Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$key['caRecordid'].'" data-scores="'.$key['CaScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
              }
               else
  		        {
                  exit("Can not find search record, something went wrong!");
  		        }   
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
     }
    //End Simple CA Search


  //Advanced CA Search

function advancedCaSearch($class,$subject,$session,$term,$schid)
  {
  
  // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		// if(is_numeric($searchVar))
  		// {
         // $activeSession = $this->getActiveSession($schid);
          //$studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,assessment.id AS caRecordid,assessment.ca_score AS CaScores,ca_settings.ca_title AS caTitle
             FROM assessment 
             INNER JOIN student_initial ON assessment.ass_student_id=student_initial.id
             INNER JOIN class ON assessment.ass_class_id=class.id 
             INNER JOIN session ON  assessment.ass_session_id=session.id 
             INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
             INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
             INNER JOIN ca_settings ON assessment.ca_no_id=ca_settings.ca_id
             WHERE 
             ass_sch_id=? 
             && ass_session_id=? 
             && ass_class_id=? 
             && ass_term_id=?
             && ass_subject_id=? ORDER BY Fullname,Subject,caTitle";
             $this->conn->query($query);
             //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					   $this->conn->bind(1, $schid, PDO::PARAM_INT);
             $this->conn->bind(2, $session, PDO::PARAM_INT);
             $this->conn->bind(3, $class, PDO::PARAM_INT);
					   $this->conn->bind(4, $term, PDO::PARAM_INT);
             $this->conn->bind(5, $subject, PDO::PARAM_INT);     
             $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>CA Title</th>
                        <th>CA Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$key['caRecordid'].'" data-scores="'.$key['CaScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
              // }
              //  else
  		        // {
              //     exit("Can not find search record, something went wrong!");
  		        // }   
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
  //End advanced CA search 
  


  //Search Examination reecord
function basicExamSearch($searchVar,$schid)
  {
        //Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{
        $activeSession = $this->getActiveSession($schid);
          $studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,terminal_exam.exam_score AS ExamScores,terminal_exam.id AS ExamRecordID
             FROM terminal_exam 
             INNER JOIN student_initial ON terminal_exam.exam_stud_id=student_initial.id
             INNER JOIN class ON terminal_exam.exam_class_arm_id=class.id 
             INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
             INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
             INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
             WHERE exam_stud_id =? && exam_sch_id=? && exam_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentID, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->bind(3, $activeSession, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>Exam Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$key['ExamRecordID'].'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
              }   
  	
  		      else
  		        {
                  exit("Can not find search record, something went wrong!");
  		        }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }

//Advanced exam search method
//Remove regno variable or argument
function advancedExamSearch($class,$subject,$session,$term,$schid)
  {
        // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		// if(is_numeric($searchVar))
  		// {
        //$activeSession = $this->getActiveSession($schid);
          //$studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,terminal_exam.exam_score AS ExamScores,terminal_exam.id AS ExamRecordID
             FROM terminal_exam 
             INNER JOIN student_initial ON terminal_exam.exam_stud_id=student_initial.id
             INNER JOIN class ON terminal_exam.exam_class_arm_id=class.id 
             INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
             INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
             INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
             WHERE 
             exam_sch_id=? 
             && exam_session_id=? 
             && exam_class_arm_id=? 
             && exam_term_id=?
             && exam_subj_id=?";
                    $this->conn->query($query);
                    //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					          $this->conn->bind(1, $schid, PDO::PARAM_INT);
                    $this->conn->bind(2, $session, PDO::PARAM_INT);
                    $this->conn->bind(3, $class, PDO::PARAM_INT);
					          $this->conn->bind(4, $term, PDO::PARAM_INT);
                    $this->conn->bind(5, $subject, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>Exam Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button" data-classid="'.$class.'" data-sessionid="'.$session.'"data-subjectid="'.$subject.'" data-term="'.$term.'" data-recordid="'.$key['ExamRecordID'].'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }

//End advanced exam search
//Staff profile method
function staffProfile($clientid,$staffid)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, gender AS Gender, date_of_birth AS Dob, mobile AS Mobile, user_img FROM staff_profile
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
//End Staff Profile method

//DISTINCT METHOD NOT IN USE
 //loop the print ca code in a for each of the result of the distinct subject
      /*
      e.g 
      foreach($subject as $subj=>$keys)
      {
        put the ca select code and the rest of the logic here
      }
      */
  //Select DISTINCT SUBJECTs OFFERED BY THE Student based on class
function distinctSubjects($studentid,$schoolid)
	  {
		
		try {
			/*
			1. select distinct subject name and subject id from the tables joined in the query
			2. Loop through the array and echo first the subject name in a cell
			3. Use the subject id and pass it to the second Method to fetch CA records to display in the <td>
			4. use the suject ID to also fetch Exam scores using the same algorithm in the CA Method
			*/
      $query ="SELECT DISTINCT subjects.sub_id AS SubjectID 
	  FROM subjects INNER JOIN assessment ON 
	  assessment.ass_subject_id=subjects.sub_id 
	  WHERE assessment.ass_class_id IN (SELECT assessment.ass_class_id FROM assessment WHERE assessment.ass_student_id=? AND assessment.ass_sch_id=?)";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
					          $this->conn->bind(2, $schoolid, PDO::PARAM_INT);
                    $subject = array();
                    $output = $this->conn->resultset();
                    $subject = $output;
					          //echo count($output);
                    if($output){
                      return $output;
                    }
                    else{
                      exit("Unable to get subjects for this particular students for this class");
                    }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//END SELECT DISTINCT SUBJECT

//Method to add ordinal Suffix to a numeric number
function ordinalSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
    }
    return $num.'th';
  }
//End Method to add ordinal Suffix to a numeric number

//print ca method
function print_ca($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
			/*
			1. select distinct subject name and subject id from the tables joined in the query
			2. Loop through the array and echo first the subject name in a cell
			3. Use the subject id and pass it to the second Method to fetch CA records to display in the <td>
			4. use the suject ID to also fetch Exam scores using the same algorithm in the CA Method
			*/
      $query ="SELECT assessment.ca_score AS scores FROM assessment
	    WHERE
	    assessment.ass_student_id=? AND assessment.ass_subject_id=? AND assessment.ass_class_id=? AND assessment.ass_session_id=? AND assessment.ass_term_id=? AND assessment.ass_sch_id=?";
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					  $scores = $key['scores'];
						//loop through the CA's
						$arr.= '<td>'.$scores.'</td>';
					}	
					return $arr;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }

//Terminal Exam Scores
function subject_ScoresTotal($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		try {
      $query ="SELECT terminal_exam.exam_score AS ExamScore
      FROM  terminal_exam 
      WHERE terminal_exam.exam_stud_id=? AND terminal_exam.exam_subj_id=? AND 
      terminal_exam.exam_class_arm_id=? AND terminal_exam.exam_session_id=? AND
      terminal_exam.exam_term_id=? AND terminal_exam.exam_sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$examScores = $key['ExamScore'];
          //$subjPosition = $key['SubjectPosition'];
					//$arr.= '<td>'.$examScores.'</td>';
          //$arr.= '<td>'.$subjPosition.'</td>';
					}	
					//$arr.='</tr><br>';
					return $examScores;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//End of Terminal Exam
//Subject Average
function subjectAv($subjectid,$classid,$sessionid,$termid,$schid)
	  {		
		try {
      $query ="SELECT averagepersubject.SubjectAverageByTerm AS SubjectAv
      FROM  averagepersubject 
      WHERE averagepersubject.subject_id=? AND 
      averagepersubject.class_id=? AND averagepersubject.session_id=? AND
      averagepersubject.term_id=? AND averagepersubject.sch_id=?"; 
      $this->conn->query($query); 
			$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(4, $termid, PDO::PARAM_INT); 
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$subjectAv = $key['SubjectAv'];
					//$arr.= '<td>'.$subjectAv.'</td>';
					}	
					//$arr.='</tr><br>';
					return $subjectAv;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//Subject Average

//Method to get subject position
function getSubjectPosition($studentID,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT subject_position AS SubjectPosition
      FROM  terminal_exam 
      WHERE exam_stud_id=? AND exam_subj_id=? AND 
      exam_class_arm_id=? AND exam_session_id=? AND
      exam_term_id=? AND exam_sch_id=?"; 
      $this->conn->query($query); 
      $this->conn->bind(1, $studentID, PDO::PARAM_INT);
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$subjectPosition = $key['SubjectPosition'];
          $position = $this->ordinalSuffix($subjectPosition);
					//$arr.= '<td>'.$position.'</td>';
					}	
					//$arr.='</tr><br>';
					return $position;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//end method to get subject position

//Method to get class position
function getClassPosition($studentID,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT termposition AS termPosition
      FROM  classpositionals 
      WHERE student_id=? AND 
      class_id=? AND session_id=? AND
      term_id=? AND school_id=?"; 
      $this->conn->query($query); 
      $this->conn->bind(1, $studentID, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(4, $termid, PDO::PARAM_INT); 
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$classPosition = $key['termPosition'];
          $position = $this->ordinalSuffix($classPosition);
					//$arr.= '<td>'.$position.'</td>';
					}	
					return $position;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }


//end Method to get class position

//subject totals scores
function subjectTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT subjecttotals.TermTotal AS SubjectTotal
      FROM  subjecttotals 
      WHERE
      subjecttotals.student_id=? AND subjecttotals.subject_id=? AND 
      subjecttotals.class_id=? AND subjecttotals.session_id=? AND
      subjecttotals.term_id=? AND subjecttotals.sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//$arr="";
					
					foreach($output as $row => $key)
					{
					$subjectTotal = $key['SubjectTotal'];
					//$arr.= '<td>'.$subjectTotal.'</td>';
					}	
					//return $arr;
          return $subjectTotal;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
    //End subject totals

//subject totals

//Get class category based on class id
function getClassCategoryID($class,$schid)
 {
  //always use try and catch block to write code
  try{
        //SELECT THE ID OF THE ACTIVE SESSION BASED ON THE INSTITUTION
          $sqlStmt = "SELECT class_categoryid AS classCatID FROM class WHERE id =? AND my_inst_id=?";
          $this->conn->query($sqlStmt);
          $this->conn->bind(1, $class, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult = $this->conn->resultset();
              if ($this->conn->rowCount() == 1)
                {
                  //loop through the result set
                  foreach ($myResult as $row => $key)
					        {
					            $catID = $key['classCatID'];
					        }
					        // retrun the ID  OF THE STUDENT
					        return $catID;
               }
                        else
                        {
                        exit("No class caetgory available!");
                        }
       }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        }
}

//end get class category id based on class id

//students over all average
function studentOverAllAverage($studentid,$classid,$sessionid,$termid,$schid)
	{
		try {
			/*
			1. find the average of student based on the grand total all scores in subject 
			*/
        $query = "SELECT FORMAT(GrandTermTotal/(SELECT COUNT( DISTINCT class_category_subject.subject_id ) AS SubjectCount
        FROM class INNER JOIN class_category_subject
        ON class.class_categoryid=class_category_subject.class_category_id 
        WHERE class.id=? AND class.my_inst_id=?),2 ) AS TotalAverage
        FROM termgrandtotal WHERE 
        termgrandtotal.student_id=? 
        AND termgrandtotal.class_id=?
        AND termgrandtotal.term_id=? AND termgrandtotal.session_id=?
        AND termgrandtotal.sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $schid, PDO::PARAM_INT); 
                    $this->conn->bind(3, $studentid, PDO::PARAM_INT);
			              $this->conn->bind(4, $classid, PDO::PARAM_INT);
			              $this->conn->bind(5, $termid, PDO::PARAM_INT);
                    $this->conn->bind(6, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(7, $schid, PDO::PARAM_INT);
                    $output = $this->conn->resultset();
                    $tav = "";
      
					          foreach($output as $row => $key)
					          {
					          $totalAverage = $key['TotalAverage'];
					          }	
					          return $totalAverage;
                    
                }//End of try catch block
                catch(Exception $e)
                {
                    echo "Error:". $e->getMessage();
                }
	        }

//END STUDENTS OVER ALL AVERAGE 
 //SELECT GRAND TOTAL
function grandTotals($studentid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT GrandTermTotal AS GrandTotal
      FROM  termgrandtotal 
      WHERE
      student_id=? AND
      class_id=? AND session_id=? AND
      term_id=? AND sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(4, $termid, PDO::PARAM_INT); 
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$grandTotal = $key['GrandTotal'];
					//$arr.= '<td>'.$grandTotal.'</td>';
					}	
					//$arr.='</tr><br>';
					return $grandTotal;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
 //END GRAND TOTAL

//ca Totals 
function caTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT catotals.caTotal AS Total
      FROM  catotals 
      WHERE
      catotals.student_id=? AND catotals.subject_id=? AND 
      catotals.class_id=? AND catotals.session_id=? AND
      catotals.term_id=? AND catotals.sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$totalca = $key['Total'];
					//$arr.= '<td>'.$totalca.'</td>';
					}	
					//$arr.='</tr><br>';
					return $totalca;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
    //End catotals

  
  
  //print totals CA Method
	function print_totals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
     $query ="SELECT 
    catotals.caTotal AS Total,
    terminal_exam.exam_score AS ExamScores,
    subjecttotals.TermTotal AS SubjectTotals,
    averagepersubject.SubjectAverageByTerm AS SubjectAv
    FROM catotals INNER JOIN terminal_exam ON 
    catotals.subject_id=terminal_exam.exam_subj_id
    INNER JOIN subjecttotals ON catotals.subject_id=subjecttotals.subject_id
    INNER JOIN averagepersubject ON catotals.subject_id=averagepersubject.subject_id
    WHERE
    catotals.student_id=? AND catotals.subject_id=? AND catotals.class_id=? 
    AND catotals.session_id=? AND catotals.term_id=? AND catotals.sch_id=?
    GROUP BY catotals.student_id";
      
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			$this->conn->bind(6, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$totalca = $key['Total'];
					$examScores = $key['ExamScores'];
					$subjectTotals= $key['SubjectTotals'];
          $subjAv= $key['SubjectAv'];
					$arr.= '<td>'.$totalca.'</td>';
					$arr.= '<td>'.$examScores.'</td>';	
					$arr.= '<td>'.$subjectTotals.'</td>';	
          $arr.= '<td>'.$subjAv.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }


	//result method
	function print_result($studentid,$classid,$termid,$sessionid,$schoolid)
	  {
		 try {
        $query ="SELECT DISTINCT subjects.subject_name AS subjectName,subjects.sub_id AS SubjectID 
	      FROM subjects INNER JOIN assessment ON 
	      assessment.ass_subject_id=subjects.sub_id 
	      WHERE assessment.ass_class_id IN (SELECT assessment.ass_class_id FROM assessment WHERE assessment.ass_student_id=? AND assessment.ass_sch_id=?)";
        $this->conn->query($query);
        $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
				$this->conn->bind(2, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
          $caMaxScore = $this->getMaxCaScores($classid,$schoolid);
          $examMaxScore = $this->getMaxExamScores($classid,$schoolid);
          $totalCA = 3*$caMaxScore;
          $totalExam = $totalCA + $examMaxScore;
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th></th>
          <th>Subject</th>
          <th>1st CA '.$caMaxScore.'%</th>
          <th>2nd CA '.$caMaxScore.'%</th>
          <TH>3rd CA '.$caMaxScore.'%</th>
          <TH>CA Total'.$totalCA.'%</th>
          <TH>Term Exams '.$examMaxScore.'%</th>
          <TH>Term Total '.$totalExam.'%</th>
          <TH>Class AVerage</th>
          <TH>Highest In Class</th>
          <TH>Lowest In Class</th>
          <TH>Position In Class</th>
          <TH>Grade</th>
          <TH>Comment</th>
          <th>Sign</th>
          </tr>";
					foreach($output as $row => $key)
					{
            $subjectID = $key['SubjectID'];
						$sub_name = $key['SubjectName'];
						$printOutput.='<tr>';
						$printOutput.='<td>'.$sub_name.'</td>';
						$printOutput.=$this->print_ca($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->caTotals($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->subject_ScoresTotal($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.='<td>'.$this->subjectTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.=$this->subjectAv($subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->highestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $printOutput.=$this->lowestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $printOutput.=$this->getSubjectPosition($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->gradingScores($this->subjectTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid));
            $printOutput.=$this->staffSign($classid,$subjectID,$schoolid);
						$printOutput.='</tr>';
					}
          echo $printOutput;

        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }


//Get student name and display in a span tag
//When typing  in a student registration field when adding CA and  EXAM
function getStudent($searchVar,$schid)
  {
        //get active term
       // $activeSession= $this->getActiveSession($schid);
        
        // Try and Catch block
        try{
        //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT A STRING OF REG NUMBER
  		    if(is_numeric($searchVar))
  		    {
  			//SELECT STUDENT ID FROM THE STUDENT ADMISSION NUMBER TABLE
  					$query ="SELECT admission_number.id AS AdmissionNumID,  CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname FROM student_initial INNER JOIN student_admission_no ON student_initial.id=student_admission_no.stud_id INNER JOIN admission_number ON admission_number.id=student_admission_no.admission_number 
            WHERE admission_number.serial_number=? AND admission_number.adm_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
                    if($this->conn->rowCount() == 0)
                    {
                      exit("No such student exist in the school with such number");
                    }
                    else{
              
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        echo $fullname = $key['Fullname'];
                        
                      }
  		      }
          }
  		 else
  		 {
        exit("Please provide a numeric data, the last digits of your admission number without the preceding seperator");
        
  		 }
      }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }



//Function definition to get student subject totals, record id from terminal_exam table and loop through to 
//update the table with the subject position
function subjectPosition($subjectid,$termid,$sessionid,$classid,$schid)
    { 
      try
      {
      $query ="SELECT student_id AS studentID,TermTotal AS Total
		  FROM subjecttotals  
      WHERE 
      subject_id=? AND
	    term_id= ? AND 
      session_id= ? AND 
      class_id=? AND 
      sch_id= ? ORDER BY Total DESC";
      $this->conn->query($query);
      $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(2, $termid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(4, $classid, PDO::PARAM_INT); 
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $arr = array();
      $output = $this->conn->resultset();
      //check for empty result
        if($output)
        {
           foreach($output as $row => $key)
					 {
            //make the record id of the terminal exam table the key of the array
						$arr[$key['studentID']] = $key['Total'];
            //var_dump($arr);
					 }
           
              //get occurences of values in an array
              $occurences = array_count_values($arr);
              $scores_value = current($arr);
              $studentid = key($arr);
              $subjectPosition =1;
                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                    $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue > 1)
                        {
                            for($k=0; $k < $frequencyOfValue; $k++)
                            {
                              //Update terminal_exam record with correct  position
                              $updateQuery = "UPDATE terminal_exam SET 
                              subject_position=? WHERE exam_stud_id=? 
                              AND exam_subj_id=?
                              AND exam_term_id=?
                              AND exam_session_id=?
                              AND exam_class_arm_id=?
                              AND exam_sch_id=?";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->bind(2, $studentid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $subjectid, PDO::PARAM_INT);
                              $this->conn->bind(4, $termid, PDO::PARAM_INT);
                              $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(6, $classid, PDO::PARAM_INT);
                              $this->conn->bind(7, $schid, PDO::PARAM_INT);
                              $this->conn->execute();
                              //check for the success of the update operation and not end of array
                                if($this->conn->rowCount() == 1)
                                {
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                }
                                else
                                {
                                exit("Position update failed!");
                                }
                            }
                          /*
                          write a code snippet to check for end of array
                          */
                            //increment the subjetPosition counter
                            $subjectPosition = $subjectPosition + $frequencyOfValue;
                            $scores_value = next($arr);
                            $studentid = key($arr);
                        }
                        else
                        {
                            //Update terminal_exam record with correct  position
                            $updateQuery = "UPDATE terminal_exam SET 
                              subject_position=? WHERE exam_stud_id=? 
                              AND exam_subj_id=?
                              AND exam_term_id=?
                              AND exam_session_id=?
                              AND exam_class_arm_id=?
                              AND exam_sch_id=?";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->bind(2, $studentid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $subjectid, PDO::PARAM_INT);
                              $this->conn->bind(4, $termid, PDO::PARAM_INT);
                              $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(6, $classid, PDO::PARAM_INT);
                              $this->conn->bind(7, $schid, PDO::PARAM_INT); 
                            $this->conn->execute();
                              if($this->conn->rowCount() == 1)
                                {
                                $scores_value = next($arr);
                                $studentid = key($arr);
                                $subjectPosition+=1;
                                }
                                else
                                {
                                exit("Position 2 update failed!");
                                }
                        }

              }

        }
        else
        {
          exit("No Record is found matching your selection!");
        }
      }
      catch(Exception $e)
      {
          echo "Error:". $e->getMessage();
      }
    } 
// End subject position method

//Highest by subject in a class
function highestInClass($subjectid,$classid,$termid,$sessionid,$schoolid)
	    {
		  try {
        //check to see if records already exist 
        $query ="SELECT TermTotal AS HighestTotal FROM subjecttotals WHERE subject_id=? AND class_id=? AND 
        term_id=? AND session_id=? AND sch_id=? ORDER BY HighestTotal DESC LIMIT 1";
        $this->conn->query($query);
        $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(2, $classid, PDO::PARAM_INT); 
				$this->conn->bind(3, $termid, PDO::PARAM_INT);
        $this->conn->bind(4, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(5, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset();
        $printOutput = " ";
        if($output && $this->conn->rowCount() >=1)
        {
          	foreach($output as $row => $key)
					{
            $highesttotal = $key['HighestTotal'];
					//	$printOutput.='<tr>';
						//$printOutput.='<td>'.$highesttotal.'</td>';
            
					//$printOutput.='</tr>';
					}
          return $highesttotal;
        }
            else
            {
        
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//end Highest by subject in a class

//Lowest by subject in class
function lowestInClass($subjectid,$classid,$termid,$sessionid,$schoolid)
	    {
		  try {
        //check to see if records already exist 
        $query ="SELECT TermTotal AS LowestTotal FROM subjecttotals WHERE subject_id=? AND class_id=? AND 
        term_id=? AND session_id=? AND sch_id=? ORDER BY LowestTotal ASC LIMIT 1";
        $this->conn->query($query);
        $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(2, $classid, PDO::PARAM_INT); 
				$this->conn->bind(3, $termid, PDO::PARAM_INT);
        $this->conn->bind(4, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(5, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset();
        $printOutput = " ";
        if($output && $this->conn->rowCount() >=1)
        {
          	foreach($output as $row => $key)
					{
            $lowesttotal = $key['LowestTotal'];
					//	$printOutput.='<tr>';
						//$printOutput.='<td>'.$lowesttotal.'</td>';
            
					//$printOutput.='</tr>';
					}
          return $lowesttotal;
        }
            else
            {
        
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//end lowest by subject in class

//Scoresheet method
function scoreSheet($subjectid,$classid,$termid,$sessionid,$schoolid)
	    {
		 try {
			
        $query ="SELECT DISTINCT 
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        student_initial.id AS studentID,
        subjects.subject_name AS subjectName,
        subjects.sub_id AS SubjectID,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM student_initial INNER JOIN assessment ON student_initial.id=assessment.ass_student_id
        INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
        INNER JOIN class ON class.id=assessment.ass_class_id
        INNER JOIN session ON session.id=assessment.ass_session_id
        INNER JOIN sch_term ON sch_term.term_id=assessment.ass_term_id 
	      WHERE assessment.ass_subject_id=? AND 
        assessment.ass_class_id=? AND assessment.ass_session_id=?
        AND assessment.ass_term_id=?  AND assessment.ass_sch_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(2, $classid, PDO::PARAM_INT); 
				$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(4, $termid, PDO::PARAM_INT); 
				$this->conn->bind(5, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        $printOutput = " ";
        echo '<p class="printAssessment">
        <a href="classAssessmentSheetPrint.php?subjectid='.$subjectid.'&class='.$classid.'&session='.$sessionid.'&term='.$termid.'&schoolid='.$schoolid.'" target="_blank" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print Sheet</a>
        <hr></p>';
        $printOutput.=$this->scoreSheetHeaderInformation($subjectid,$classid,$termid,$sessionid,$schoolid);
          //ouput table headers below here
					//$printOutput = " ";
          $caMaxScore = $this->getMaxCaScores($classid,$schoolid);
          $examMaxScore = $this->getMaxExamScores($classid,$schoolid);
          $totalCA = 3*$caMaxScore;
          $totalExam = $totalCA + $examMaxScore;
            
          $printOutput.= "<table class='datatable'>";
          $printOutput.='<tr>
          <th>Student Name</th>
          <th>1st CA '.$caMaxScore.'%</th>
          <th>2nd CA '.$caMaxScore.'%</th>
          <TH>3rd CA '.$caMaxScore.'%</th>
          <TH>CA Total'.$totalCA.' %</th>
          <TH>Exam Score '.$examMaxScore.'%</th>
          <TH>Term Total '.$totalExam.'%</th>
          <TH>Class AVerage</th>
          <TH>Highest In Class</th>
          <TH>Lowest In Class</th>
          <TH>Position In Class</th>
          <TH>Grade</th>
          <TH>Comment</th>
          <th>Sign</th>
          </tr>';
					foreach($output as $row => $key)
					{
            $studentID = $key['studentID'];
						$studentName = $key['Fullname'];
            $subjectID = $key['SubjectID'];
            $highestInClass =  $this->highestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $lowestInClass  = $this->lowestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $terminalSUbjectTotals= $this->subjectTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
						$printOutput.='<tr>';
						$printOutput.='<td>'.$studentName.'</td>';
						$printOutput.=$this->print_ca($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.='<td>'.$this->caTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$this->subject_ScoresTotal($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$terminalSUbjectTotals.'</td>';
            $printOutput.='<td>'.$this->subjectAv($subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$highestInClass.'</td>';
            $printOutput.= '<td>'.$lowestInClass.'</td>';
            $printOutput.='<td>'.$this->getSubjectPosition($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.=$this->gradingScores($terminalSUbjectTotals);
            $printOutput.='<td>'.$this->staffSign($classid,$subjectID,$schoolid).'</td>';
						$printOutput.='</tr>';
					}
          $printOutput.='</table>';
          echo $printOutput;

        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
      //end of scoresheet

    //ScoreSheet Header Information

function scoreSheetHeaderInformation($subjectid,$classid,$termid,$sessionid,$schoolid)
	    {
		 try {
			
        $query ="SELECT DISTINCT subjects.subject_name AS subjectName,
        subjects.sub_id AS SubjectID,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM student_initial INNER JOIN assessment ON student_initial.id=assessment.ass_student_id
        INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
        INNER JOIN class ON class.id=assessment.ass_class_id
        INNER JOIN session ON session.id=assessment.ass_session_id
        INNER JOIN sch_term ON sch_term.term_id=assessment.ass_term_id 
	      WHERE assessment.ass_subject_id=? AND 
        assessment.ass_class_id=? AND assessment.ass_session_id=?
        AND assessment.ass_term_id=?  AND assessment.ass_sch_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(2, $classid, PDO::PARAM_INT); 
				$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(4, $termid, PDO::PARAM_INT); 
				$this->conn->bind(5, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
            $subjectName = $key['subjectName'];
						$ClassName = $key['ClassName'];
            $sessionName = $key['SessionName'];
            $termName = $key['TermName'];
					}

        $printOutput.='<div class="student-profile">
        <h5>Class Assessment Sheet</h5>
        <ul class="scoresheet-header">';
              $printOutput.='<li><h6>Class</h6><span>'.$ClassName.'</span></li>';
              $printOutput.='<li><h6>Subject</h6><span>'.$subjectName.'</span></li>';
              $printOutput.='<li><h6>Term</h6><span>'.$termName.'</span></li>';
              $printOutput.='<li><h6>Session</h6><span>'.$sessionName.'</span></li>';
              $printOutput.='<li><h6>Subject Teacher</h6><span>'.$this->staffSign($classid,$subjectid,$schoolid).'</span></li></ul></div>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

    //End scoresheet Header Information

//Examination Summary Sheet

//View result summary
function viewResultSummary($classid,$termid,$sessionid,$schoolid)
	{
		try{
        $query ="SELECT classpositionals.id AS ID, classpositionals.student_id AS StudentID,
        classpositionals.promotion_status AS PromotionStatus,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=?";
        $this->conn->query($query);
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>Student Name</th>
          <TH>Term Grand Total</th>
           <TH>Maximum Scores</th>
          <TH>Student Average</th>
          <TH>Position In Class</th>
          <TH>Promotion Status</th>
          <TH>Print</th>
          </tr>";
					foreach($output as $row => $key)
					{
            //Promotional status
            $studentID = $key['StudentID'];
						$studentName = $key['Fullname'];
            $cumTotal = $this->grandTotals($studentID,$classid,$sessionid,$termid,$schoolid);
            $av = $this->studentOverAllAverage($studentID,$classid,$sessionid,$termid,$schoolid);
            //check promotion status
                        if($key['PromotionStatus'] =='On'){
                        $promotion_status = '<button type="button" class="approvedBtn"> Promoted</button>';
                        }else{
                        $promotion_status= '<button type="button" class="not-approvedBtn"> Not Promoted  </button>';
                        }
						$printOutput.='<tr>';
						$printOutput.='<td>'.$studentName.'</td>';
            $printOutput.='<td>'.$cumTotal.'</td>';
            $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
            $printOutput.='<td>'.$av.'</td>';
            $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$promotion_status.'</td>';
            $printOutput.='<td><a href="resultPrint.php?studentid='.$studentID.'&class='.$classid.'&session='.$sessionid.'&term='.$termid.'&schoolid='.$schoolid.'" target="_blank" id="result-link"><i class="fa fa-print" aria-hidden="true"></i> Print Result</a></td>';
						$printOutput.='</tr>';
					}
          $printOutput.='</table>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }


//End view result summary

function promotionSummarySheet($classid,$termid,$sessionid,$schoolid)
	    {
		  try {
			
        $query ="SELECT classpositionals.id AS ID, classpositionals.student_id AS StudentID,
        classpositionals.promotion_status AS PromotionStatus,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=?";
        $this->conn->query($query);
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
            $sessOutput ='';
            $classOutput = '';
          //output elements to help select session and class to be promoted to
          //ouput table headers below here
          echo '<p  class="mb-3" ><a id="loadClassSettings" href="promotedClassSettings.php"><i class="fa fa-bars" aria-hidden="true"></i> Choose Promotion Information </a></p>
          <p id="promotionSettings"></p>';
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>Student Name</th>
          <TH>Term Grand Total</th>
           <TH>Maximum Scores</th>
          <TH>Student Average</th>
          <TH>Position In Class</th>
          <TH>Action</th>
          </tr>";
					foreach($output as $row => $key)
					{
            //Promotional status
            $studentID = $key['StudentID'];
						$studentName = $key['Fullname'];
            $cumTotal = $this->grandTotals($studentID,$classid,$sessionid,$termid,$schoolid);
            $av = $this->studentOverAllAverage($studentID,$classid,$sessionid,$termid,$schoolid);
            //check promotion status
                        if($key['PromotionStatus'] =='On'){
                        $promotion_status = '<button type="button" data-studentid="'.$key['StudentID'].'" data-recordid="'.$key['ID'].'" class="approvedBtn" id="unpromote">Unpromote</button>';
                        }else{
                        $promotion_status= '<button type="button" data-studentid="'.$key['StudentID'].'"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="promote">Promote</button>';
                        }
						$printOutput.='<tr>';
						$printOutput.='<td>'.$studentName.'</td>';
            $printOutput.='<td>'.$cumTotal.'</td>';
            $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
            $printOutput.='<td>'.$av.'</td>';
            $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$promotion_status.'</td>';
						$printOutput.='</tr>';
					}
          $printOutput.='</table>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
      //End examination sheet

//submit result summary by class teacher only

//Insert promotion details in the student _class table
function insertPromotionDetails($studid,$class,$sessionid,$staffid,$schid)
  {
      
        try {
                        $date = date("Y-m-d");
                          $sqlStmt = "INSERT INTO student_class (student_id,stud_class,stud_sess_id,stud_added_by,stud_school_id,created_on) values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studid, PDO::PARAM_INT);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->bind(6, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//session activated
                        		//echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error creating promotion records for student!";
                      			}
                            
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//end insert promotion details

//Remove promotion details
function removePromotionDetails($studentid,$class,$session,$schid)
   {
      
                 try {

          					        //Remove Promotion Details
                            $sqlStmt = "DELETE  FROM student_class WHERE student_id=? AND stud_class=? AND stud_sess_id=? AND stud_school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $session, PDO::PARAM_INT);
                            $this->conn->bind(4, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// action successful
                        		//echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error removing student promotion details";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
    }
//end remove promotion details

//Method to promote a student
function promoteStudent($studentid,$recordid,$class,$sessionid,$schid,$staffid,$promotionStatus="On")
  {
      
        try {

                        $sqlStmt = "UPDATE classpositionals SET promotion_status=? WHERE id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $promotionStatus, PDO::PARAM_STR);
                            $this->conn->bind(2, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                            //Insert promotion details
                            $this->insertPromotionDetails($studentid,$class,$sessionid,$staffid,$schid);
                         		//session activated
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error promoting this student";
                      			}
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
//End method to promote a student

//Method to unpromote student
function unpromoteStudent($studentid,$recordid,$class,$sessionid,$schid,$staffid,$promotionStatus="Off")
  {
      
        try {

                        $sqlStmt = "UPDATE classpositionals SET promotion_status=? WHERE id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $promotionStatus, PDO::PARAM_STR);
                            $this->conn->bind(2, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(3, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                            //Insert promotion details
                            $this->removePromotionDetails($studentid,$class,$sessionid,$schid);
                         		//
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error unpromoting this student";
                      			}
                }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//end method to unpromote student

//submit result for processing

function submitSummary($classid,$termid,$sessionid,$schoolid)
	    {
		  try {
        //check to see if records already exist 
        $query ="SELECT class_id FROM classpositionals WHERE class_id=? AND 
        term_id=? AND session_id=? AND school_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset();
        if($output && $this->conn->rowCount() >=1)
        {
          exit("This result has been submitted already!");
        }
        else
        {
        $query ="INSERT INTO classpositionals(student_id,class_id,term_id,session_id,school_id)
        SELECT student_id,class_id,term_id,session_id,sch_id
	      FROM termgrandtotal t
	      WHERE t.class_id=? AND t.session_id=?
        AND t.term_id=?  AND t.sch_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(3, $termid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->execute(); 
					if($output)
          {
            echo "ok";
          }
          else
          {
            echo "Unable to submit result summary for onward processing";
          }
        }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
//end submit result summary

//Method to assign class position only class teacher
function classPosition($termid,$sessionid,$classid,$schid)
    { 
      try
      {
      $query ="SELECT student_id AS studentID,GrandTermTotal AS Total
		  FROM termgrandtotal  
      WHERE 
	    term_id= ? AND 
      session_id= ? AND 
      class_id=? AND 
      sch_id= ? ORDER BY Total DESC";
      $this->conn->query($query);
      $this->conn->bind(1, $termid, PDO::PARAM_INT); 
			$this->conn->bind(2, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $schid, PDO::PARAM_INT);
      $arr = array();
      $output = $this->conn->resultset();
      //check for empty result
        if($output)
        {
           foreach($output as $row => $key)
					 {
            //make the record id of the terminal exam table the key of the array
						$arr[$key['studentID']] = $key['Total'];
            //var_dump($arr);
					 }
           
              //get occurences of values in an array
              $occurences = array_count_values($arr);
              $scores_value = current($arr);
              $studentid = key($arr);
              $classPosition =1;
                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                    $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue > 1)
                        {
                            for($k=0; $k < $frequencyOfValue; $k++)
                            {
                              //Update terminal_exam record with correct  position
                              $updateQuery = "UPDATE classpositionals SET 
                              termposition=? WHERE student_id=? 
                              AND term_id=?
                              AND session_id=?
                              AND class_id=?
                              AND school_id=?";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $classPosition, PDO::PARAM_INT);
                              $this->conn->bind(2, $studentid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $termid, PDO::PARAM_INT);
                              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(5, $classid, PDO::PARAM_INT);
                              $this->conn->bind(6, $schid, PDO::PARAM_INT);
                              $this->conn->execute();
                              //check for the success of the update operation and not end of array
                                if($this->conn->rowCount() == 1)
                                {
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                }
                                else
                                {
                                exit("Position update failed!");
                                }
                            }
                          /*
                          write a code snippet to check for end of array
                          */
                            //increment the subjetPosition counter
                            $classPosition = $classPosition + $frequencyOfValue;
                            $scores_value = next($arr);
                            $studentid = key($arr);
                        }
                        else
                        {
                            //Update terminal_exam record with correct  position
                             $updateQuery = "UPDATE classpositionals SET 
                              termposition=? WHERE student_id=? 
                              AND term_id=?
                              AND session_id=?
                              AND class_id=?
                              AND school_id=?";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $classPosition, PDO::PARAM_INT);
                              $this->conn->bind(2, $studentid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $termid, PDO::PARAM_INT);
                              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(5, $classid, PDO::PARAM_INT);
                              $this->conn->bind(6, $schid, PDO::PARAM_INT);
                              $this->conn->execute();
                              if($this->conn->rowCount() == 1)
                                {
                                $scores_value = next($arr);
                                $studentid = key($arr);
                                $classPosition+=1;
                                }
                                else
                                {
                                exit("Position update failed!");
                                }
                        }

              }

        }
        else
        {
          exit("No Record is found matching your selection!");
        }
      }
      catch(Exception $e)
      {
          echo "Error:". $e->getMessage();
      }
    }

//End method to assign class position

//Grading and comment method
function gradingScores($num)
  {
    $printOutput =" ";
    //Grades
    $a = "A";
    $b = "B";
    $c = "C";
    $d = "D";
    $e = "E";
    //Rating
    $good = "Good";
    $poor = "Poor";
    $fair ="Fair";
    $vgood = "Very Good";
    $excellent = "Excellent";
    $notdefined = " - ";
    $norating = "No Rating";
    switch(TRUE)
    {
      case($num <= 39):
      $printOutput.='<td>'.$e.'</td>';
      $printOutput.= '<td>'.$poor.'</td>';
      return $printOutput;
      break;

      case($num >= 40 && $num <=54):
      $printOutput.='<td>'.$d.'</td>';
      $printOutput.= '<td>'.$fair.'</td>';
      return $printOutput;
      break;

      case($num >= 55 && $num <=64):
      $printOutput.='<td>'.$c.'</td>';
      $printOutput.= '<td>'.$good.'</td>';
      return $printOutput;
      break;

      case($num >= 65 && $num <=74):
      $printOutput.='<td>'.$b.'</td>';
      $printOutput.= '<td>'.$vgood.'</td>';
      return $printOutput;
      break;

      case($num >= 75 && $num <=100):
      $printOutput.='<td>'.$a.'</td>';
      $printOutput.= '<td>'.$excellent.'</td>';
      return $printOutput;
      break;

      default:
      $printOutput.='<td>'.$notdefined.'</td>';
      $printOutput.= '<td>'.$norating.'</td>';
      return $printOutput;
      break;

    }
  }

//Staff card profile

//Method to print school Profile
function schoolProfileHeader($clientid)
	    {
		 try {
			
        $query ="SELECT institutional_signup.institution_name AS SchoolName,
        institutional_signup.web_address AS WebAddress,
        institutional_signup.email_add AS Email, institutional_signup.street_address AS StreetAdd,
        institutional_signup.mail_box AS PostOffice,
        CONCAT(city.city_name, ', ', states.state_name, ', ', nationality.nationality) AS CityStateCountry,
        institutional_signup.inst_mobile AS Mobile
	      FROM institutional_signup 
        INNER JOIN nationality ON institutional_signup.country_id=nationality.id
        INNER JOIN states ON institutional_signup.state_id = states.id
        INNER JOIN city ON institutional_signup.state_id = states.id
	      WHERE institutional_signup.client_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $clientid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
                    $schoolName = $key['SchoolName'];
                    $Web = $key['WebAddress'];
                    $Email= $key['Email'];
                    $streetAdd = $key['StreetAdd'];
                    $mailBox = $key['PostOffice'];
                    $cityStateCountry = $key['CityStateCountry'];
                    $Mobile = $key['Mobile'];
                    //$Logo = $key['Logo'];
                    // $printOutput.='<h5>'.$schoolName.'</h5>';
                    // $printOutput.='<p>'.$Address.'</p>';
                    // $printOutput.='<p>'.$countryState.'</p>';
                    // $printOutput.='<p>'.$Mobile.'</p>';
					}
          if(empty($schoolName)){

            }else{
              $printOutput.='<h5>'.$schoolName.'</h5>';
            }

            if(empty($streetAdd)){

            }else{
              $printOutput.='<p><i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
                '.$streetAdd.'</p>';
            }  

            if(empty($mailBox)){

            }else{
              $printOutput.='<p><i class="fa fa-fax" aria-hidden="true"></i>
            '.$mailBox.'</p>';
            }

            if(empty($cityStateCountry)){

            }else{
              $printOutput.='<p><i class="fa fa-globe fa-fw" aria-hidden="true"></i>
            '.$cityStateCountry.'</p>';
            }

            if(empty($Mobile)){

            }else{
              $printOutput.='<p><i class="fa fa-phone fa-fw" aria-hidden="true"></i>

          '.$Mobile.'</p>';
            }
            if(empty($Email)){

            }else{
            $printOutput.='<p><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
            '.$Email.'</p>';
            }
            
            if(empty($Web)){

            }else{
              $printOutput.='<p><i class="fa fa-link fa-fw" aria-hidden="true"></i>
            '.$Web.'</p>';
            }

          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
        //End school profile method
//Staff subject sign
function staffSign($classid,$subjectid,$schid)
	  {		
		try {
      $query ="SELECT CONCAT(staff_profile.surname, ', ', 
      IFNULL(LEFT(UPPER(staff_profile.middle_name),1), ''), 
      '.', IFNULL(LEFT(UPPER(staff_profile.lastName),1), '') ) AS Fullname
    FROM staff_profile INNER JOIN staff_subject_taught ON 
    staff_profile.user_id=staff_subject_taught.my_id INNER JOIN subjects 
    ON staff_subject_taught.subject_id=subjects.sub_id
    WHERE staff_subject_taught.class_taught=? AND staff_subject_taught.subject_id=? AND staff_subject_taught.sch_identity=?"; 
      $this->conn->query($query); 
			$this->conn->bind(1, $classid, PDO::PARAM_INT);
      $this->conn->bind(2, $subjectid, PDO::PARAM_INT); 
			$this->conn->bind(3, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$fullname = $key['Fullname'];
					//$arr.= '<td>'.$fullname.'</td>';
          $arr = $fullname;
					}	
					//$arr.='</tr><br>';
					return $arr;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//End staff subject sign

//Staff profile card method used on the staff profile page
function staffProfileCard($clientid,$userid)
        {
        try {
                $query ="SELECT CONCAT(staff_profile.surname, ', ', staff_profile.middle_name, ' ', staff_profile.lastname) AS Fullname, staff_profile.date_of_birth AS Dob, staff_profile.user_img AS Image,staff_profile.gender AS Sex,users.email AS Email,institutional_responsibilities.responsibility_name AS Role FROM staff_profile INNER JOIN users ON staff_profile.user_id=users.id INNER JOIN institutional_responsibilities ON institutional_responsibilities.id=users.role 
                WHERE staff_profile.my_school_id=? AND staff_profile.user_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $userid, PDO::PARAM_INT); 
                    $myResult = $this->conn->resultset();
                    $printOutput = " ";
                    if($myResult)
                    {
                        foreach($myResult as $row => $key)
                        {
                            $fullname = $key['Fullname'];
                            $Dob = $key['Dob'];
                            $image = $key['Image'];
                            $sex = $key['Sex'];
                            $email = $key['Email'];
                            $role = $key['Role'];
                            $logoPrint = '<img src="'.$image.'" alt="Staff Avatar" class="bg-image">';    
                        }
                                if(empty($fullname)){
                                    $fullname = "ScoreSheet";
                                } elseif(empty($image)){
                                    $logoPrint = '<img src="../images/profile-icon.png" alt="Staff Avatar" class="bg-image"></>';
                                }
                                $printOutput.='<div class="card"><div class="img-div">
                                    <img src="../images/bg.jpg" alt="background image" style="width:100%">';
                                    $printOutput.=$logoPrint.'</div>';
                                    $printOutput.='<div class="card-container">
                                        <span class="image-upload">
                                        <label for="image-file">
                                        <i class="fa fa-camera fa-fw" aria-hidden="true"></i>
                                        </label>
                                        <input type="file" name="image-file" class="form-control" id="image-file">
                                        </span>';
                                        $printOutput.='<h5>'.$fullname.'</h5>';
                                        $printOutput.='<p class="title">'.$role.'</p>';
                                        $printOutput.='</div></div>';
                    }
                    echo $printOutput;
            }// End of try catch block
         catch(Exception $e)
            {
            echo ("Error: Unable to fetch sstaff Profile");
            }
        }


//EDIT EXAMS  SCORES
function editTerminalExam($score,$subj,$class,$staffid,$recordid,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
      $this->isSubjectTeacher($staffid,$subj,$class,$schid);
        try {

          					//EDIT EXAM RECORD
                            $sqlStmt = "UPDATE terminal_exam SET exam_score=?,exam_subj_id=?,
                            exam_class_arm_id=?,tutor_id=? WHERE terminal_exam.id=? AND exam_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $subj, PDO::PARAM_INT,100);
                            //$this->conn->bind(3, $termid, PDO::PARAM_INT,100);
                            //$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $class, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(6, $schid, PDO::PARAM_INT);
                            //$this->conn->bind(8, $student_id, PDO::PARAM_INT);
                            //$this->conn->bind(9, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// SCORES EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error edting exam scores";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }

//END EDIT EXAM

//Reload exam record after edit
function reloadExam($class,$subject,$schid)
  {
        // Try and Catch block
   try
    {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,terminal_exam.exam_score AS ExamScores,terminal_exam.id AS ExamRecordID
             FROM terminal_exam 
             INNER JOIN student_initial ON terminal_exam.exam_stud_id=student_initial.id
             INNER JOIN class ON terminal_exam.exam_class_arm_id=class.id 
             INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
             INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
             INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
             WHERE 
             exam_sch_id=? 
             && exam_session_id=? 
             && exam_class_arm_id=? 
             && exam_term_id=?
             && exam_subj_id=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $schid, PDO::PARAM_INT);
          $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(3, $class, PDO::PARAM_INT);
					$this->conn->bind(4, $termid, PDO::PARAM_INT);
          $this->conn->bind(5, $subject, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>Exam Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button" data-classid="'.$class.'" data-sessionid="'.$sessionid.'"data-subjectid="'.$subject.'" data-term="'.$termid.'" data-examrecordid="'.$key['ExamRecordID'].'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//End reload exam after edit

//Reload CA Records after edit
function reloadCa($class,$subject,$schid)
  {
        // Try and Catch block
   try
    {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,assessment.id AS caRecordid,assessment.ca_score AS CaScores,ca_settings.ca_title AS caTitle
             FROM assessment 
             INNER JOIN student_initial ON assessment.ass_student_id=student_initial.id
             INNER JOIN class ON assessment.ass_class_id=class.id 
             INNER JOIN session ON  assessment.ass_session_id=session.id 
             INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
             INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
             INNER JOIN ca_settings ON assessment.ca_no_id=ca_settings.ca_id
             WHERE 
             ass_sch_id=? 
             && ass_session_id=? 
             && ass_class_id=? 
             && ass_term_id=?
             && ass_subject_id=? ORDER BY Fullname,Subject,caTitle";
             $this->conn->query($query);
             //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					   $this->conn->bind(1, $schid, PDO::PARAM_INT);
             $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
             $this->conn->bind(3, $class, PDO::PARAM_INT);
					   $this->conn->bind(4, $termid, PDO::PARAM_INT);
             $this->conn->bind(5, $subject, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                         $printOutput = " ";
                        $printOutput.= '<table  class="table table-striped table-responsive">';
                        $printOutput.='<tr><th>No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>CA Title</th>
                        <th>CA Scores</th>
                        <th>Action</th></tr>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-CAid="'.$key['caRecordid'].'" data-scores="'.$key['CaScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//End reload exam after edit
//End reload CA Records after edit

//EDIT CA 
function editCa($score,$subj,$class,$staffid,$recordid,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
      $this->isSubjectTeacher($staffid,$subj,$class,$schid);
        try {

          					//EDIT EXAM RECORD
                            $sqlStmt = "UPDATE assessment SET ca_score=?,ass_subject_id=?,
                            ass_class_id=?,ass_added_by=? WHERE id=? AND ass_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $subj, PDO::PARAM_INT,100);
                            //$this->conn->bind(3, $termid, PDO::PARAM_INT,100);
                            //$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $class, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $recordid, PDO::PARAM_INT);
                            $this->conn->bind(6, $schid, PDO::PARAM_INT);
                            //$this->conn->bind(8, $student_id, PDO::PARAM_INT);
                            //$this->conn->bind(9, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// SCORES EDITED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error edting assessment scores";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//function to fetch students and display them for adding traits
function traits($classid,$schoolid)
	    {
		 try {
      $termid = $this->getActiveTerm($schoolid);
      $sessionid = $this->getActiveSession($schoolid);
        $query ="SELECT DISTINCT 
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        student_initial.id AS StudentID,
        classpositionals.id AS RecordID,
        termgrandtotal.GrandTermTotal AS CumulativeScores,
        classpositionals.termposition AS Position,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN termgrandtotal ON termgrandtotal.student_id=student_initial.id
        INNER JOIN session ON session.id=classpositionals.session_id
        INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        if($this->conn->rowCount() >= 1)
            {
          $printOutput = " ";
        
          $printOutput.= "<table class='table table-responsive'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <TH>Class</th>
          <TH>Term</th>
          <TH>Session</th>
          <TH>Cumulative Scores</th>
          <TH>Position</th>
          <TH>Action</th>
          </tr>";
				  $ci=1;
          foreach($output as $row => $key)
          {
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          $printOutput.='<td>'.$key['Fullname'].'</td>';
          $printOutput.='<td>'.$key['ClassName'].'</td>';
          $printOutput.='<td>'.$key['TermName'].'</td>';
          $printOutput.='<td>'.$key['SessionName'].'</td>';
          $printOutput.='<td>'.$key['CumulativeScores'].'</td>';
          $printOutput.='<td>'.$this->ordinalSuffix($key['Position']).'</td>';
          $printOutput.='<td><button type="button" data-classid="'.$classid.'"  data-recordid="'.$key['StudentID'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-plus" aria-hidden="true"></i>Add Traits & comments</button></td>';
          $printOutput.='</tr>'; 
          $ci++;
          }
          $printOutput.= "</table>";
          echo $printOutput;
            }
            else{
              exit("No result found yet!");
            }

        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
//End traits

//Create affective domain rating
function newAffectiveDomain($domain,$rating,$studentid,$schid,$staffid,$date)
  {
  // always use try and catch block to write code
       try {  
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $query ="SELECT  id  FROM stud_affective_skills WHERE domain_id =?
                    AND termid=? AND sessionid=? AND schid=?";
                    $this->conn->query($query);
										$this->conn->bind(1, $domain, PDO::PARAM_INT);
										$this->conn->bind(2, $termid, PDO::PARAM_INT);
										$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->resultset();
                   
                    	if ($this->conn->rowCount() >= 1)
                    	  {
                        exit("Item added already!");
                    	  }
                    	else{
                            $sqlStmt = "INSERT INTO stud_affective_skills(domain_id,rating,studentid,
                            termid,sessionid,schid,staffid,date_added)
                            values (?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $domain, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $rating, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $studentid, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $termid, PDO::PARAM_INT);
                            $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(6, $schid, PDO::PARAM_INT);
                            $this->conn->bind(7, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(8, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// SCORES ADDED
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error adding scores";
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

//end method to create affectivec domain ratings

//Create psychomotor skills
function newPsychomotorSkills($domain,$rating,$studentid,$schid,$staffid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    //Check for the number of CA added
                    $query ="SELECT  id  FROM stud_psychomotor_skills WHERE psycho_domain=?
                    AND termid=? AND sessionid=? AND schid=?";
                    $this->conn->query($query);
										$this->conn->bind(1, $domain, PDO::PARAM_INT);
										$this->conn->bind(2, $termid, PDO::PARAM_INT);
										$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->resultset();
                   
                    	if ($this->conn->rowCount() >= 1)
                    	  {
                      exit("Item added already!");
                    	  }
                    	else{
          					        // ADD PSYCHOMOTOR SKILLS
                            $sqlStmt = "INSERT INTO stud_psychomotor_skills(psycho_domain,rating,studentid,
                            termid,sessionid,schid,staff_id,date_added)
                            values (?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $domain, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $rating, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $studentid, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $termid, PDO::PARAM_INT);
                            $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(6, $schid, PDO::PARAM_INT);
                            $this->conn->bind(7, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(8, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		   {
                         		   // SCORES ADDED
                        		   echo "ok";
                        		   }
                        		   else
                        		   {
                        		   echo "Error adding scores";
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
//end create psychomotor skills

////Method to add number of days student attended school 
function studentDaysAttended($classid,$days,$studentid,$schid,$staffid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    //Check for the number of CA added
                    $query ="SELECT  id  FROM student_attendance WHERE classid=?
                    AND termid=? AND sessionid=? AND sch_id=? AND studentid=?";
                    $this->conn->query($query);
										$this->conn->bind(1, $classid, PDO::PARAM_INT);
										$this->conn->bind(2, $termid, PDO::PARAM_INT);
										$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->bind(5, $studentid, PDO::PARAM_INT);
                    $this->conn->resultset();
                   
                    	if ($this->conn->rowCount() >= 1)
                    	  {
                      exit("Attendance added already!");
                    	  }
                    	else{
          					        // ADD PSYCHOMOTOR SKILLS
                            $sqlStmt = "INSERT INTO student_attendance(studentid,classid,sessionid,
                            termid,days_attended,class_teacher_id,sch_id,date_created)
                            values (?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studentid, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $classid, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $sessionid, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $termid, PDO::PARAM_INT);
                            $this->conn->bind(5, $days, PDO::PARAM_INT);
                            $this->conn->bind(6, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(7, $schid, PDO::PARAM_INT);
                            $this->conn->bind(8, $date, PDO::PARAM_STR);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		   {
                         		   // SCORES ADDED
                        		   echo "ok";
                        		   }
                        		   else
                        		   {
                        		   echo "Error adding attendance";
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
//End Method to add number of days student attended school



//load added traits items for a particular student
/* 
The exam id is the particula exam record id found in the classpositionals table
This id relate to only one student for a particular term only
Using it relates directly to a student
*/
function reloadAffectiveTraits($studentid,$schid)
  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT stud_affective_skills.id AS Skills_ID,affective_domain.description AS Description, rating_system.description AS Rating
             FROM stud_affective_skills 
             INNER JOIN affective_domain ON affective_domain.id=stud_affective_skills.domain_id
             INNER JOIN rating_system ON rating_system.id=stud_affective_skills.rating
             WHERE 
             stud_affective_skills.studentid=? 
             AND stud_affective_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added aafective traits seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="transparent-table">';
                        $printOutput.='<tr><th>#</th>
                        <th>Affective Domain</th>
                        <th>Rating</th>
                        <th>Remove</th>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Description'].'</td>';
                        $printOutput.='<td>'.$key['Rating'].'</td>';
                        $printOutput.='<td><button type="button" data-id="'.$key['Skills_ID'].'" class="btn btn-outline-danger btn-sm" id="remove-trait"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }

//End load added traits items for a particular student

//RELOAD ENROLLED STUDENTS
function reloadEnrolledStudents($class,$schid)
  {
  // Try and Catch block
   try
        {
           //$termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT student_class.id AS ID,
           CONCAT(student_initial.surname, ', ', LOWER(student_initial.firstName), '  ',LOWER(student_initial.lastName) ) AS Fullname
          FROM student_class
          INNER JOIN student_initial ON student_class.student_id=student_initial.id
          WHERE 
          student_class.stud_class=? AND student_class.stud_sess_id=?
          AND student_class.stud_school_id=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $class, PDO::PARAM_INT);
          $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(3, $schid, PDO::PARAM_INT);
          $myResult = $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No enrolled student seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.="<hr>";
                        $printOutput.='<h6 class="top-header">New Enrolled Students</h6>';
                        $printOutput.= '<table  class="transparent-table">';
                        $printOutput.='<tr><th>#</th>
                        <th>Student Name</th>
                        <th>Remove</th>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td><button type="button" data-id="'.$key['ID'].'" class="btn btn-outline-danger btn-sm" id="remove-enrolled-student"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }


//RELOAD ENROLLED STUDENTS

//REMOVE ENROLLED STUDENT
function deleteEnrolledStudent($id)
   {
      
                 try {

          					     //EDIT EXAM RECORD
                            $sqlStmt = "DELETE  FROM student_class WHERE id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $id, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// action successful
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error removing student item";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
    }


//END REMOVE ENROLLED STUDENT

//Load psychomotor skills added for a particular student
function reloadPsychomotorSkills($studentid,$schid)


  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT stud_psychomotor_skills.id AS Skills_ID,psychomotor_skills.description AS Description, rating_system.description AS Rating
             FROM stud_psychomotor_skills 
             INNER JOIN psychomotor_skills ON psychomotor_skills.id=stud_psychomotor_skills.psycho_domain
             INNER JOIN rating_system ON rating_system.id=stud_psychomotor_skills.rating
             WHERE 
             stud_psychomotor_skills.studentid=? 
             AND stud_psychomotor_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added psychomotor skills seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="transparent-table">';
                        $printOutput.='<tr><th>#</th>
                        <th>Psychomotor</th>
                        <th>Rating</th>
                        <th>Remove</th>';
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Description'].'</td>';
                        $printOutput.='<td>'.$key['Rating'].'</td>';
                        $printOutput.='<td><button type="button" data-id="'.$key['Skills_ID'].'" class="btn btn-outline-danger btn-sm" id="remove-psycho-trait"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>'; 
                        $printOutput.='</tr>'; 
                        $ci++;
                        }
                      $printOutput.= "</table>";
                      echo $printOutput;
  		            }
            //   }   
  	
  		      // else
  		      //   {
            //       exit("Can not find search record, something went wrong!");
  		      //   }
    }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//End load psychomotor skills for a student
//Remove affective traits
function deleteAffectiveTraits($id)
  {
      
                 try {

          					     //EDIT EXAM RECORD
                            $sqlStmt = "DELETE  FROM stud_affective_skills WHERE stud_affective_skills.id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $id, PDO::PARAM_INT);
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

 //REMOVE PSYCHO SKILLS
function deletePsychoSkills($id)
   {
      
                 try {

          					     //EDIT EXAM RECORD
                            $sqlStmt = "DELETE  FROM stud_psychomotor_skills WHERE stud_psychomotor_skills.id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $id, PDO::PARAM_INT);
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
//add staff comments
function newStaffComment($studentid,$comment,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET class_teacher_comm=? WHERE student_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $comment, PDO::PARAM_INT);
                            $this->conn->bind(2, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// comments added
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error adding staff comment";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

/*
This  is a method that selects all students in a class and display
their status in added comments. traits 
*/

//Add admin comment

function newAdminComment($studentid,$comment,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET head_teacher_comm=? WHERE student_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $comment, PDO::PARAM_INT);
                            $this->conn->bind(2, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		// comments added
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error adding Admin comment";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//Add new admin comments

//Comments summary
function commentSummary($classid,$termid,$sessionid,$schoolid)
	    {
		 try {
        $query ="SELECT DISTINCT classpositionals.student_id AS recordID,
        termgrandtotal.GrandTermTotal AS cumTotal,classpositionals.termposition AS Position,
        classpositionals.class_teacher_comm AS StaffComment,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN termgrandtotal ON termgrandtotal.student_id=student_initial.id
        INNER JOIN session ON session.id=classpositionals.session_id
        INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=? AND classpositionals.school_id=? ORDER BY Position";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $termid, PDO::PARAM_INT); 
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        $printOutput = " ";
          //ouput table headers below here
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <th>Class</th>
          <th>Term</th>
          <TH>Session</th>
          <TH>Cum. Total</th>
          <TH>Position</th>
          <TH>Affective Domain</th>
          <TH>Psychomotor Skills</th>
          <TH>Staff Comment</th>
          <TH>Action</th>
          </tr>";
          $ci=1;
					foreach($output as $row => $key)
					{
            if(empty($key['StaffComment']) ||$key['StaffComment']==null ){
              $comm = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
            }else{
              $comm= '<i class="fa fa-check" aria-hidden="true"></i>';
            }
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          $printOutput.='<td>'.$key['Fullname'].'</td>';
          $printOutput.='<td>'.$key['ClassName'].'</td>';
          $printOutput.='<td>'.$key['TermName'].'</td>';
          $printOutput.='<td>'.$key['SessionName'].'</td>';
          $printOutput.='<td>'.$key['cumTotal'].'</td>';
          $printOutput.='<td>'.$key['Position'].'</td>';
          $printOutput.='<td>'.$this->isAffectiveDomain($key['recordID'],$schoolid).'</td>';
          $printOutput.='<td>'.$this->isPsychomotorSkills($key['recordID'],$schoolid).'</td>';
          $printOutput.='<td>'.$comm.'</td>';
          $printOutput.='<td><button type="button"  data-recordid="'.$key['recordID'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-plus" aria-hidden="true"></i>Add Traits & comments</button></td>';
          $printOutput.='</tr>'; 
          $ci++;
					}
          $printOutput.='</table>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
      //End comment summary


//Check availability of affective domain
function isAffectiveDomain($studentid,$schid)
  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT domain_id
             FROM stud_affective_skills 
             WHERE 
             stud_affective_skills.studentid=? 
             AND stud_affective_skills.schid=? LIMIT 1";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();
          $var ="";

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        $var = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                        return $var;
                        }
                        else{
                        $var = '<i class="fa fa-check" aria-hidden="true"></i>';
                        return $var;
  		                    }
  
       }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
    //End check for affective domain

//Check for availability of psychomotor
function isPsychomotorSkills($studentid,$schid)
  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT psycho_domain
             FROM stud_psychomotor_skills 
             WHERE 
             stud_psychomotor_skills.studentid=? 
             AND stud_psychomotor_skills.schid=? LIMIT 1";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();
            $var = "";
                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        $var = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                        return $var;
                        }
                        else{
                        $var = '<i class="fa fa-check" aria-hidden="true"></i>';
                        return $var;
  		                    }
  
       }
        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }
//End check for availability of psychomotor

//Publish Final Result by staff
function publishFinalResult($class,$term,$session,$schid,$status="Yes")
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET published_status=? WHERE class_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $status, PDO::PARAM_STR,12);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $term, PDO::PARAM_INT);
                            $this->conn->bind(4, $session, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() >= 1)
                        		{
                         		// comments added
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error publishing result";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }

//RESULT DETAILS BY SUBJECT FOR RESULT SHEET
function resultDetails($studentid,$classid,$termid,$sessionid,$schoolid)
	    {
		  try {
			
        $query ="SELECT DISTINCT 
        subjects.subject_name AS subjectName,
        subjects.sub_id AS SubjectID
	      FROM subjects INNER JOIN assessment ON assessment.ass_subject_id=subjects.sub_id
	      WHERE assessment.ass_student_id=? AND 
        assessment.ass_class_id=? AND assessment.ass_session_id=?
        AND assessment.ass_term_id=?  AND assessment.ass_sch_id=?";
        $this->conn->query($query);
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $studentid, PDO::PARAM_INT);
        $this->conn->bind(2, $classid, PDO::PARAM_INT); 
				$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(4, $termid, PDO::PARAM_INT); 
				$this->conn->bind(5, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
         // $printOutput.=$this->scoreSheetHeaderInformation($subjectid,$classid,$termid,$sessionid,$schoolid);
          //ouput table headers below here
					//$printOutput = " ";
          $caMaxScore = $this->getMaxCaScores($classid,$schoolid);
          $examMaxScore = $this->getMaxExamScores($classid,$schoolid);
          $totalCA = 3*$caMaxScore;
          $totalExam = $totalCA + $examMaxScore;
            
          $printOutput.= "<table class='datatable'>";
          $printOutput.='<tr>
          <th>Student Name</th>
          <th>1st CA '.$caMaxScore.'%</th>
          <th>2nd CA '.$caMaxScore.'%</th>
          <TH>3rd CA '.$caMaxScore.'%</th>
          <TH>CA Total'.$totalCA.' %</th>
          <TH>Exam Score '.$examMaxScore.'%</th>
          <TH>Term Total '.$totalExam.'%</th>
          <TH>Class AVerage</th>
          <TH>Highest In Class</th>
          <TH>Lowest In Class</th>
          <TH>Position In Class</th>
          <TH>Grade</th>
          <TH>Comment</th>
          <th>Sign</th>
          </tr>';
					foreach($output as $row => $key)
					{
            //$studentID = $key['studentID'];
						$subjectName = $key['subjectName'];
            $subjectID = $key['SubjectID'];
            $highestInClass =  $this->highestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $lowestInClass  = $this->lowestInClass($subjectID,$classid,$termid,$sessionid,$schoolid);
            $terminalSUbjectTotals= $this->subjectTotals($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
						$printOutput.='<tr>';
						$printOutput.='<td>'.$subjectName.'</td>';
						$printOutput.=$this->print_ca($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.='<td>'.$this->caTotals($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$this->subject_ScoresTotal($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$terminalSUbjectTotals.'</td>';
            $printOutput.='<td>'.$this->subjectAv($subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.='<td>'.$highestInClass.'</td>';
            $printOutput.= '<td>'.$lowestInClass.'</td>';
            $printOutput.='<td>'.$this->getSubjectPosition($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid).'</td>';
            $printOutput.=$this->gradingScores($terminalSUbjectTotals);
            $printOutput.='<td>'.$this->staffSign($classid,$subjectID,$schoolid).'</td>';
						$printOutput.='</tr>';
					}
          $printOutput.='</table>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }


/*
This block of code below retrieve cognitive and psychomotor skills
*/

//Retrieve Affecctive ratings
function resultAffectiveTraits($studentid,$schid)
  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT stud_affective_skills.id AS Skills_ID,affective_domain.description AS Description, rating_system.rating_scores AS Rating
             FROM stud_affective_skills 
             INNER JOIN affective_domain ON affective_domain.id=stud_affective_skills.domain_id
             INNER JOIN rating_system ON rating_system.id=stud_affective_skills.rating
             WHERE 
             stud_affective_skills.studentid=? 
             AND stud_affective_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        echo("No added affective traits seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= "<table class='rating-table'>";
                        $printOutput.='<tr>
                        <th>Trait(s)</th>
                        <th>Rating</th>
                        </tr>';
                        //$printOutput.= '<ul class="traits-display">';
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$key['Description'].'</td>';
                        $printOutput.='<td>'.$key['Rating'].'</td>';
                        $printOutput.='</tr>';
                        // $printOutput.='<li>';
                        // $printOutput.='<span>'.$key['Description'].'</span>' . '<span>'.$key['Rating'].'</span>';
                        // //$printOutput.='<span>'.$key['Rating'].'</span>';
                        // $printOutput.='</li>'; 
                        }
                        
                        $printOutput.='</table>';
                     //$printOutput.= "</ul>";
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
//End affective  ratings

//Retrieve psychomotor skills
function resultPsychomotorSkills($studentid,$schid)


  {
  // Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT stud_psychomotor_skills.id AS Skills_ID,psychomotor_skills.description AS Description, rating_system.rating_scores AS Rating
             FROM stud_psychomotor_skills 
             INNER JOIN psychomotor_skills ON psychomotor_skills.id=stud_psychomotor_skills.psycho_domain
             INNER JOIN rating_system ON rating_system.id=stud_psychomotor_skills.rating
             WHERE 
             stud_psychomotor_skills.studentid=? 
             AND stud_psychomotor_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added psychomotor skills seen!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= "<table class='rating-table'>";
                        $printOutput.='<tr>
                        <th>Trait(s)</th>
                        <th>Rating</th>
                        </tr>';
                        //$printOutput.= '<ul class="traits-display">';
                        //$ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        // $printOutput.='<li>';
                        // $printOutput.='<p>'.$key['Description'].'</p>';
                        // $printOutput.='<span>'.$key['Rating'].'</span>'; 
                        // $printOutput.='</li>';
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$key['Description'].'</td>';
                        $printOutput.='<td>'.$key['Rating'].'</td>';
                        $printOutput.='</tr>'; 
                        //$ci++;
                        }
                        $printOutput.='</table>';
                     // $printOutput.= "</ul>";
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

//end psychomotor skills


//key to ratings 
function keyToRatings()
  {
  // Try and Catch block
   try
        {
  			   $query ="SELECT rating_scores AS Rating, description AS Description 
             FROM rating_system";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					//$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          //$this->conn->bind(2, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        echo("No keys seen");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= "<table class='rating-table'>";
                        //$printOutput.= '<ul class="traits-display">';
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED

                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$key['Rating'].'</td>';
                        $printOutput.='<td>'.$key['Description'].'</td>';
                        $printOutput.='</tr>';
                       
                        //  $printOutput.='<li>';
                        //  $printOutput.='<span>'.$key['Rating'].'</span>' .' = '. '<span>'.$key['Description'].'</span>';
                          //$printOutput.='<span>'.$key['Rating'].'</span>';
                        // $printOutput.='</li>'; 
                        }
                        
                       $printOutput.='</table>';
                     //$printOutput.= "</ul>";
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
//key to ratings


//Random Color Generator
function randomColor(){
  $var = "";
    $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
    $color = '#'.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
 $var.='style="background:'.$color.'"';
    echo $var; 
}

//Student Avatar generator
function studentAvatar($studentid,$schid)
	    {
		try {     	
        $query ="SELECT surname AS Fullname,
        img AS Image
        FROM student_initial
       
	    WHERE id=? AND stud_sch_id=? ";
        $this->conn->query($query);
        $this->conn->bind(1, $studentid, PDO::PARAM_INT);
        $this->conn->bind(2, $schid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
            $studentName = $key['Fullname'];
            $initial = strtoupper(substr($studentName, 0, 1));
            $Image = $key['Image'];
            //$color = $this->randomColor();
					}
          if(empty($Image))
          {
          $printOutput.='<div class="student-avatar">
          <h5 class="avatar-h5">'.$initial.'</h5>
          </div>';
          }
          else
          {
          $printOutput.='<div class="student-avatar">
          <h5><img src="'.$Image.'" alt="'.$studentName.'" class="avatar-img"></h5>
          </div>';
          }
                    
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	     }
//End student avatar method

//Method to fetch school avatar

function schoolAvatar($schid)
	    {
		try {     	
        $query ="SELECT institutional_signup.institution_name AS SchoolName,             
                institutional_signup.inst_logo AS Logo FROM institutional_signup 
                WHERE client_id=?";
        $this->conn->query($query);
        //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
        $this->conn->bind(1, $schid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
            $schName = $key['SchoolName'];
            $initial = strtoupper(substr($schName, 0, 1));
            $Image = $key['Logo'];
            //$color = $this->randomColor();
					}
          if(empty($Image))
          {
          $printOutput.='<div class="logo-img">
          <h5 class="avatar-h5">'.$initial.'</h5>
          </div>';
          }
          else
          {
          $printOutput.='<div class="logo-img">
          <h5><img src="'.$Image.'" alt="'.$schName.'" class="logo-img"></h5>
          </div>';
          }
                    
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	     }

//Method to fetch school avatar

//Test whether a staff is a subject teacher
function isSubjectTeacher($staff_id,$subjectid,$class_id,$schid)
  {
   //always use try and catch block to write code
  try{
      //find the subject teacher
                    $query ="SELECT id FROM staff_subject_taught WHERE subject_id=? AND class_taught=? AND my_id=? AND sch_identity=?";
                    $this->conn->query($query);
                     $this->conn->bind(1, $subjectid, PDO::PARAM_INT);
                    $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                    $this->conn->bind(3, $staff_id, PDO::PARAM_INT);
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($this->conn->rowCount() == 0)
                    {
                      exit("Sorry! You don't have access to edit this scores");
                    }
                    else{
                          
                        }     
        }

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
    }




//View Published results
function findPublishedResult($classid,$schoolid,$status='Yes')
	    {
		 try {
      $termid = $this->getActiveTerm($schoolid);
      $sessionid = $this->getActiveSession($schoolid);
      //Removed DISTINCT Keyword in the SELECT Statement
        $query ="SELECT  
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        student_initial.id AS StudentID,
        classpositionals.id AS RecordID,
        termgrandtotal.GrandTermTotal AS CumulativeScores,
        classpositionals.termposition AS Position,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN termgrandtotal ON termgrandtotal.student_id=student_initial.id
        INNER JOIN session ON session.id=classpositionals.session_id
        INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=? AND classpositionals.published_status=?";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
		    $this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
		    $this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $this->conn->bind(5, $status, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        if($this->conn->rowCount() >= 1)
            {
          $printOutput = " ";
        
          $printOutput.= "<table class='table table-responsive'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <TH>Class</th>
          <TH>Term</th>
          <TH>Session</th>
          <TH>Cumulative Scores</th>
          <TH>Position</th>
          <TH>Action</th>
          </tr>";
				  $ci=1;
          foreach($output as $row => $key)
          {
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          $printOutput.='<td>'.$key['Fullname'].'</td>';
          $printOutput.='<td>'.$key['ClassName'].'</td>';
          $printOutput.='<td>'.$key['TermName'].'</td>';
          $printOutput.='<td>'.$key['SessionName'].'</td>';
          $printOutput.='<td>'.$key['CumulativeScores'].'</td>';
          $printOutput.='<td>'.$this->ordinalSuffix($key['Position']).'</td>';
          $printOutput.='<td><button type="button"  data-recordid="'.$key['StudentID'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-plus" aria-hidden="true"></i>Add Traits & comments</button></td>';
          $printOutput.='</tr>'; 
          $ci++;
          }
          $printOutput.= "</table>";
          echo $printOutput;
            }
            else{
              exit("No result published for this class yet!");
            }

        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//end published results

//Fetch result for approval

function resultForApproval($classid,$termid,$sessionid,$schoolid)
	    {
		 try {
        $query ="SELECT DISTINCT classpositionals.student_id AS recordID,
        termgrandtotal.GrandTermTotal AS cumTotal,classpositionals.termposition AS Position,
        classpositionals.class_teacher_comm AS StaffComment,
        classpositionals.head_teacher_comm AS headComment,
        classpositionals.approval_status AS Approval,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        class.class_name AS ClassName,
        session.session AS SessionName,
        sch_term.term AS TermName
	      FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN termgrandtotal ON termgrandtotal.student_id=classpositionals.student_id
        INNER JOIN session ON session.id=classpositionals.session_id
        INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
	      WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=? AND classpositionals.school_id=? ORDER BY Position";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $termid, PDO::PARAM_INT); 
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        $printOutput = " ";
          //ouput table headers below here
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <th>Class</th>
          <th>Term</th>
          <TH>Session</th>
          <TH>Cum. Total</th>
          <TH>Position</th>
          <TH>Affective Domain</th>
          <TH>Psychomotor Skills</th>
          <TH>Staff Comment</th>
          <TH>Head Teacher's Comment</th>
          <TH>Action</th>
          </tr>";
          $ci=1;
					foreach($output as $row => $key)
					{
            if(empty($key['StaffComment']) ||$key['StaffComment']==null ){
              $comm = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
            }else{
              $comm= '<i class="fa fa-check" aria-hidden="true"></i>';
            }
            //check for head teacher comment
            if(empty($key['headComment']) || $key['headComment']==null ){
              $hcomm = '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
            }else{
              $hcomm= '<i class="fa fa-check" aria-hidden="true"></i>';
            }
            //approval status
            if(empty($key['Approval']) || $key['Approval']==null ){
              $approval_status = '<button type="button"  data-recordid="'.$key['recordID'].'" class="not-approvedBtn btn-sm" id="approve">Approve</button>';
            }else{
              $approval_status= '<button type="button"  data-recordid="'.$key['recordID'].'" class="approvedBtn btn-sm" id="disapprove">Undo Approval</button>';
            }
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          $printOutput.='<td>'.$key['Fullname'].'</td>';
          $printOutput.='<td>'.$key['ClassName'].'</td>';
          $printOutput.='<td>'.$key['TermName'].'</td>';
          $printOutput.='<td>'.$key['SessionName'].'</td>';
          $printOutput.='<td>'.$key['cumTotal'].'</td>';
          $printOutput.='<td>'.$key['Position'].'</td>';
          $printOutput.='<td>'.$this->isAffectiveDomain($key['recordID'],$schoolid).'</td>';
          $printOutput.='<td>'.$this->isPsychomotorSkills($key['recordID'],$schoolid).'</td>';
          $printOutput.='<td>'.$comm.'</td>';
          $printOutput.='<td>'.$hcomm.'</td>';
          $printOutput.='<td>'.$approval_status.'</td>';
          $printOutput.='</tr>'; 
          $ci++;
					}
          $printOutput.='</table>';
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
//end get result for approval


//Approve Result
function approveResult($studentid,$schid,$approve="Yes")
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET approval_status=? WHERE student_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $approve, PDO::PARAM_INT);
                            $this->conn->bind(2, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error approving result";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
//end approve result

//Disapprove result
function disapproveResult($studentid,$schid,$approve="")
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET approval_status=? WHERE student_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $approve, PDO::PARAM_INT);
                            $this->conn->bind(2, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(3, $termid, PDO::PARAM_INT);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() == 1)
                        		{
                         		//result approved
                        		echo "ok";
                        		}
                        		else
                        		{
                        		echo "Error disapproving result";
                      			}

                    		}

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
        
      }
  }
//End of disapprove result

//Method to find maximum scores available (total scores available e.g. 1000 )

function maxScoresAvailable($classid,$schid)
	{
		
		try {
			/*
			1. find the total number of subjects offered by a particular class
      2. multiply the number by 100 to have the total maximum scores available 

      NOTE:: USE THE NEW TABLES CREATED FOR class_category_subject AND class
			*/
        $query = "SELECT
        COUNT(DISTINCT class_category_subject.subject_id) AS SubjectNumber FROM class 
        INNER JOIN class_category_subject 
        ON class.class_categoryid=class_category_subject.class_category_id
        WHERE class.id=? AND my_inst_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $schid, PDO::PARAM_INT); 
                    $output = $this->conn->resultset();
			              
					          foreach($output as $row => $key)
					          {
					          $subjectNumber = $key['SubjectNumber'];
					          }	
                    $maxAvailableScores = $subjectNumber * 100;
					
					          return $maxAvailableScores;
                }//End of try catch block
                catch(Exception $e)
                {
                    echo "Error:". $e->getMessage();
                }
	        }
          //End method to find maximum scores available

// function to get  class teacher
function classTeacher($classid,$schid)
	{
		
		try {
			/*
			1. This method gets the name of class teacher given a particular class
			*/
        $query = "SELECT CONCAT(staff_profile.surname, ', ', 
        IFNULL(LEFT(UPPER(staff_profile.middle_name),1), ''), 
        '.', IFNULL(LEFT(UPPER(staff_profile.lastName),1), '') ) AS Fullname FROM staff_profile
        INNER JOIN class_teacher
        ON class_teacher.staff_id = staff_profile.user_id
        WHERE class_teacher.class_id=? AND school_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $schid, PDO::PARAM_INT); 
                    $output = $this->conn->resultset();
			              
					          foreach($output as $row => $key)
					          {
					          $fullname = $key['Fullname'];
					          }	
					
					          return $fullname;
                }//End of try catch block
                catch(Exception $e)
                {
                    echo "Error:". $e->getMessage();
                }
	        }


//Ed\nd function to get class teacher


//METHOD TO GET ACTIVE SESSION NAME
function activeSession($clientid,$status="Active")
    {
        try {
                $query ="SELECT id AS ID,session AS SessionName FROM session WHERE sess_inst_id=? AND active_status=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $this->conn->bind(2, $status, PDO::PARAM_STR);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['ID'];
            $sessionName = $key['SessionName'];

       //$output =+  '<a href="'.  $key['ID'].'">' . $link['amount']. '</a></br>';
      //echo  '<a href="'.  $link['FMarticle_id'].'">' . $link['title']. '</a></br>';
          $output .= "<option value=".$ID.">".$sessionName."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load active sessions";
        }
    }
//END METHOD TO GET ACTIVE SESSIO NAME


//Method to get active term
public function activeTerm($clientid,$status="Active")
    {
        try {
                $query ="SELECT term_id AS ID,term AS TermName FROM sch_term WHERE term_inst_id=? AND term_status=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $this->conn->bind(2, $status, PDO::PARAM_STR);
                    $myResult = $this->conn->resultset();
                   $output =" "; 
        foreach ($myResult as $row => $key) 
        {
            
            $ID = $key['ID'];
            $termName = $key['TermName'];

       //
          $output .= "<option value=".$ID.">".$termName."</option>";
                
        }
       echo $output;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to load active term";
        }
    }

//End Method to get active term


//USER ACCESS CONTROL
function adminUser($userid,$schid)
  {
    
    switch(TRUE)
    {
      case($userid == 2):
    
      break;

      default:
      session_start();
      session_destroy();
      header("location:../../index.php");
      break;

    }
  }
  //End adminUser method

  //Staff User method
function staffUser($userid,$schid)
  {
    
    switch(TRUE)
    {
      case($userid == 1):
    
      break;

      default:
      session_start();
      session_destroy();
      header("location:../../index.php");
      break;

    }
  }
  //end staff user method


  //Client user
function clientUser($userid,$schid)
  {
    
    switch(TRUE)
    {
      case($userid == 3):
    
    
      break;

      default:
      //session_start();
      session_destroy();
      header("location:../../index.php");
      break;

    }
  }

//End client user



































































}
