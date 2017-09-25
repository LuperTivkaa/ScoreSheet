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


//FUNCTION TO ENROLL STUDENTS/PUPILS IN A CLASS
 function enrollStudent($studentid,$class,$sessionid,$staffid,$inst_id)
  {
  // always use try and catch block to write code
  try
    {

    //SELECT STUDENT BASED ON STUDENTID, CLASS, CLASS ARM AND SESSION
    //TODO: NO STUDENT SHOULD BE ENROLLED TWICE IN A CLASS
                    $query ="SELECT * FROM student_class where studen_id =?
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
                            stud_sess_id,stud_added_by,stud_school_id,)
                            values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studentid, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $class, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $inst_id, PDO::PARAM_INT);
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
function addCa($score,$stud_no,$subj,$class_arm,$staffid,$canumber,$schid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                    //Check for the number of CA added
                    $query ="SELECT  ass_student_id AS studentID FROM assessment WHERE ass_subject_id =?
                    && ass_class_id=? AND ass_term_id=? AND ass_session_id=? AND ca_no_id=? AND ass_student_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $subj, PDO::PARAM_INT);
										$this->conn->bind(2, $class_arm, PDO::PARAM_INT);
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
                            $this->conn->bind(4, $class_arm, PDO::PARAM_INT);
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
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      $student_id = $this->getStudentId($stud_no,$schid);

        try {

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

        catch(Exception $e)
        {
        //echo error here
        //this get an error thrown by the system
        echo "Error:". $e->getMessage();
         }
  }


  //STUDENT SEARCH METHOD
  //SEARCH STUDENT BASED ON NAME OR REGISTRATION NUMBER
  /*
  use this function for the advanced search also
  1. provide term, session, class, as null arguments to the function
  */
function searchStudent($searchVar,$schid)
  {
        //get active term
       // $activeSession= $this->getActiveSession($schid);
        
        // Try and Catch block
        try{
        //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT A STRING OF REG NUMBER
  		    if(is_numeric($searchVar))
  		    {
  			//SELECT STUDENT ID FROM THE STUDENT ADMISSION NUMBER TABLE
  					$query ="SELECT student_initial.id AS studentID, CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID FROM student_initial WHERE student_initial.id=? AND student_initial.stud_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
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
        $activeSession= getActiveSession($schid);
        // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{

  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject
             FROM assessment 
             INNER JOIN class_arm ON assessment.ass_class_id=class_arm.class_id 
             INNER JOIN session ON  assessment.ass_session_id=session.id 
             INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
             INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
             WHERE ass_student_id =?  && ass_sch_id=? && ass_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
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
                        $printOutput.= "<table   width=634>";
                        $printOutput.="<tr><th>S/NO</th><th>STUDENT FULL NAME</th><th>DETAIL ASSESSMENT</th><th>DETAIL TERMINAL EXAMINATION</th></tr>";
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.="tr>";
                        $printOutput.="<td>".$ci."</td>";
                        $printOutput.='<td><button onclick="caDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm"> Assessment Details</button></td>';
                        $printOutput.='<td><button onclick="examDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm">Exam Details</button></td>"; 
                        $printOutput.="</tr>'; 
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                        }
                    $printOutput.= "</table>";
                    return $printOutput;
  		            }
              }   
  	
  		      elseif(is_string($searchVar))
  		        {
                    $activeSession= getActiveSession($schid);
  		 	            //SELECT ID FROM THE STUDENT INITIAL TABLE
           					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject
                    FROM assessment 
                    INNER JOIN class_arm ON assessment.ass_class_id=class_arm.class_id 
                    INNER JOIN session ON  assessment.ass_session_id=session.id 
                    INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
                    INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
                    WHERE ass_student_id =? && exam_session_id=? && ass_sch_id=? && ass_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
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
                        $printOutput.= "<table   width=634>";
                        $printOutput.="<tr><th>S/NO</th><th>STUDENT FULL NAME</th><th>DETAIL ASSESSMENT</th><th>DETAIL TERMINAL EXAMINATION</th></tr>";
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DISPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.="tr>";
                        $printOutput.="<td>".$ci."</td>";
                        $printOutput.='<td><button onclick="caDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm"> Assessment Details</button></td>';
                        $printOutput.='<td><button onclick="examDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm">Exam Details</button></td>"; 
                        $printOutput.="</tr>'; 
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                        }
                    $printOutput.= "</table>";
                    return $printOutput;
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
  
  //Search Examination reecord
  
function searchExams($searchVar,$schid)
  {
        $activeSession= getActiveSession($schid);
        // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{

  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject
             FROM terminal_exam 
             INNER JOIN class ON terminal_exam.exam_class_arm_id=class_arm.class_id 
             INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
             INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
             INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
             WHERE exam_stud_id =? && exam_sch_id=? && exam_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
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
                        $printOutput.= "<table   width=634>";
                        $printOutput.="<tr><th>S/NO</th><th>STUDENT FULL NAME</th><th>DETAIL ASSESSMENT</th><th>DETAIL TERMINAL EXAMINATION</th></tr>";
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.="tr>";
                        $printOutput.="<td>".$ci."</td>";
                        $printOutput.='<td><button onclick="caDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm"> Assessment Details</button></td>';
                        $printOutput.='<td><button onclick="examDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm">Exam Details</button></td>"; 
                        $printOutput.="</tr>'; 
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                        }
                    $printOutput.= "</table>";
                    return $printOutput;
  		            }
              }   
  	
  		      elseif(is_string($searchVar))
  		        {
                    $activeSession= getActiveSession($schid);
  		 	            //SELECT ID FROM THE STUDENT INITIAL TABLE
           				$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject
                  FROM terminal_exam 
                  INNER JOIN class ON terminal_exam.exam_class_arm_id=class_arm.class_id 
                  INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
                  INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
                  INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
                  WHERE exam_stud_id =? && exam_sch_id=? && exam_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
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
                        $printOutput.= "<table   width=634>";
                        $printOutput.="<tr><th>S/NO</th><th>STUDENT FULL NAME</th><th>DETAIL ASSESSMENT</th><th>DETAIL TERMINAL EXAMINATION</th></tr>";
                        $ci=1;
                        foreach($myResult as $row => $key)
                        {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DISPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $printOutput.="tr>";
                        $printOutput.="<td>".$ci."</td>";
                        $printOutput.='<td><button onclick="caDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm"> Assessment Details</button></td>';
                        $printOutput.='<td><button onclick="examDetails('.$key['StudentID'].')" class="btn btn-warning btn-sm">Exam Details</button></td>"; 
                        $printOutput.="</tr>'; 
                        $ci++;
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                        }
                    $printOutput.= "</table>";
                    return $printOutput;
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

//Staff profile method
public function staffProfile($clientid,$staffid)
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

//Terminal Exam
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
					$arr.= '<td>'.$examScores.'</td>';
          //$arr.= '<td>'.$subjPosition.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
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
					$arr.= '<td>'.$subjectAv.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
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
					$arr.= '<td>'.$position.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
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
					$arr.= '<td>'.$position.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }


//end Method to get class position

//subject totals
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
			//echo count($output);
			$arr="";
					
					foreach($output as $row => $key)
					{
					$subjectTotal = $key['SubjectTotal'];
					$arr.= '<td>'.$subjectTotal.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
    //End subject totals

//subject totals
//DISTINCT COUNT SUBJECTS
function studentOverAllAverage($studentid,$classid,$sessionid,$termid,$schid)
	{
		
		try {
			/*
			1. find the average of student based on the grand total all scores in subject 
			*/
    $query = "SELECT FORMAT(GrandTermTotal / (SELECT COUNT( subjects.sub_id )
    FROM subjects INNER JOIN class_subject
    ON subjects.sub_id=class_subject.subject_id 
    WHERE class_subject.class_id=? AND class_subject.school_id=?),2 ) AS TotalAverage
    FROM termgrandtotal WHERE 
    termgrandtotal.student_id=? 
    AND termgrandtotal.class_id=?
    AND termgrandtotal.term_id=? AND termgrandtotal.session_id=?
    AND termgrandtotal.sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			              $this->conn->bind(2, $subjectid, PDO::PARAM_INT);
                    $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(5, $termid, PDO::PARAM_INT); 
			              $this->conn->bind(6, $schid, PDO::PARAM_INT);
                    $output = $this->conn->resultset();
			              
			              $arr="";
					
					          foreach($output as $row => $key)
					          {
					          $TotalAv = $key['TotalAverage'];
					          //$arr.= '<td>'.$TotalAv.'</td>';
                    $arr = $TotalAv;
					          }	
					
					          echo $arr;
                }//End of try catch block
                catch(Exception $e)
                {
                    echo "Error:". $e->getMessage();
                }
	        }

//END DISTINCT COUNT SUBJECTS 
 //SELECT GRAND TOTAL
function grandTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT GrandTermTotal AS GrandTotal
      FROM  termgrandtotal
      WHERE
      student_id=? AND subject_id=? AND 
      class_id=? AND session_id=? AND
      term_id=? AND sch_id=?"; 
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
					$grandTotal = $key['GrandTotal'];
					$arr.= '<td>'.$grandTotal.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
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
					$arr.= '<td>'.$totalca.'</td>';
					}	
					//$arr.='</tr><br>';
					return $arr;	
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
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th></th>
          <th>Subject</th>
          <th>1st CA 10%</th>
          <th>2nd CA 10%</th>
          <TH>3rd CA 10%</th>
          <TH>CA Total 30%</th>
          <TH>Term Exams 70%</th>
          <TH>Term Total 100%</th>
          <TH>Class AVerage</th>
          <TH>Subject Position</th>
          <TH>Grade</th>
          <TH>Comment</th>
          </tr>";
					foreach($output as $row => $key)
					{
            $subjectID = $key['SubjectID'];
						$sub_name = $key['SubjectName'];
						$printOutput.='<tr>';
						$printOutput.='<td>'.$sub_name.'</td>';
						$printOutput.= $this->print_ca($studentid,$subjectID,$classid,$sessionid,$termid,$schoolid);
						$printOutput.='</tr><br>';
					}
          echo $printOutput;

        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }


//Get student name and display in a span tag
//When typing key up in a student registration field when adding CA and  EXAM
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
                    //$output ="";
                    if($this->conn->rowCount() == 0)
                    {
                      exit("No such student exist in the school with such number");
                    }
                    else{
              
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                       //$ID = $key['studentID'];
                        echo $fullname = $key['Fullname'];
                        
                        //$printOutput.="<td><a href=examScores.php?id=".$key['StudentID']." onclick="GetCourseDetails('.$row['ccid'].')">View Examination Scores </a></td>";
                      }
                      // $output.=' </tbody></table>';
                      // echo $output;
  		      }
          }
  		 else
  		 {
        exit("Please provide a numeric data, the last digits of your admission number without the preceding text");
        
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
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>Student Name</th>
          <th>1st CA 10%</th>
          <th>2nd CA 10%</th>
          <TH>3rd CA 10%</th>
          <TH>CA Total 30%</th>
          <TH>Term Exams 70%</th>
          <TH>Term Total 100%</th>
          <TH>Class AVerage</th>
          <TH>Subject Position</th>
          </tr>";
					foreach($output as $row => $key)
					{
            $studentID = $key['studentID'];
						$studentName = $key['Fullname'];
            $subjectID = $key['SubjectID'];
						$printOutput.='<tr>';
						$printOutput.='<td>'.$studentName.'</td>';
  
						$printOutput.=$this->print_ca($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->caTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->subject_ScoresTotal($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->subjectTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->subjectAv($subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->getSubjectPosition($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
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

//Examination Summary Sheet
function ExaminationSummarySheet($classid,$termid,$sessionid,$schoolid)
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
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
				$this->conn->bind(2, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(3, $termid, PDO::PARAM_INT); 
				$this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
          $printOutput.= "<table class='datatable'>";
          $printOutput.="<tr>
          <th>Student Name</th>
          <TH>Term Grand Total 100%</th>
          <TH>Student AVerage</th>
          <TH>Student Position</th>
          </tr>";
					foreach($output as $row => $key)
					{
            $studentID = $key['studentID'];
						$studentName = $key['Fullname'];
            $subjectID = $key['SubjectID'];
						$printOutput.='<tr>';
						$printOutput.='<td>'.$studentName.'</td>';
            $printOutput.=$this->grandTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->studentOverAllAverage($studentID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid);
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

//end result summary

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
        $query ="INSERT INTO classpositionals(student_id,class_id,term_id,session_id,school_id,termgrandtotal)
        SELECT student_id,class_id,term_id,session_id,sch_id,GrandTermTotal
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

//Method to assign class position
function classPosition($termid,$sessionid,$classid,$schid)
    { 
      try
      {
      $query ="SELECT student_id AS studentID,termgrandtotal AS Total
		  FROM classpositionals  
      WHERE 
	    term_id= ? AND 
      session_id= ? AND 
      class_id=? AND 
      school_id= ? ORDER BY Total DESC";
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

//End method to assign position























}
