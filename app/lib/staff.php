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
                            $sqlStmt = "SELECT stud_id AS ID FROM student_admission_no WHERE admission_number=? AND my_stud_sch_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $regnumber, PDO::PARAM_INT);
                            $this->conn->bind(2, $schid, PDO::PARAM_INT);
                            $myResult = $this->con->resultset();
                        if ($this->conn->rowCount() == 1)
                        {
                        	//loop through the result set
                        	foreach ($myResult as $row => $key)
					        {

					            $ID = $key['ID'];

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
 function enrollStudent($studentid,$class,$class_arm,$sessionid,$staffid,$inst_id)
  {
  // always use try and catch block to write code
  try
    {

    //SELECT STUDENT BASED ON STUDENTID, CLASS, CLASS ARM AND SESSION
    //TODO: NO STUDENT SHOULD BE ENROLLED TWICE IN THE SAME CLASS AND ARM IN THE SAME SESSION
                    $query ="SELECT * FROM student_class where studen_id =?
                    && stud_class=? && stud_class_arm=? && stud_sess_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentid, PDO::PARAM_STR);
                    $this->conn->bind(2, $class, PDO::PARAM_STR);
										$this->conn->bind(3, $class_arm, PDO::PARAM_STR);
										$this->conn->bind(4, $sessionid, PDO::PARAM_STR);
                    $this->conn->execute();
                    	if ($this->conn->rowCount() ==1)
                    	{
                    	//STUDENT ALREADY ENROLLED IN THE CLASS
                      	echo "This student is already a member of this class";
                    	}
                    	else{

          					// ENROLLED A STUDENT IN THE CLASS
                            $sqlStmt = "INSERT INTO student_class(student_id,stud_class,
                            stud_class_arm,stud_sess_id,stud_added_by,stud_school_id,)
                            values (?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $studentid, PDO::PARAM_STR,100);
                            $this->conn->bind(2, $class, PDO::PARAM_STR,100);
                            $this->conn->bind(3, $class_arm, PDO::PARAM_STR,100);
                            $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(5, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(6, $inst_id, PDO::PARAM_INT);
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
function addCa($score,$stud_no,$subj,$class_arm,$staffid,$schid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                    //Check for the number of CA added
                    $query ="SELECT ass_student_id AS studentID FROM assessment where ass_subject_id =?
                    && ass_class_id=? && ass_term_id=? && ass_session_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $subj, PDO::PARAM_INT);
										$this->conn->bind(2, $class_arm, PDO::PARAM_INT);
										$this->conn->bind(3, $termid, PDO::PARAM_INT);
										$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                    $this->conn->execute();
                   
                    	if ($this->conn->rowCount() > 3)
                    	  {
                    	//NUMBER OF ASESSMENT QUOTA PER TERM EXCEEDED
                      exit("Number of assessment test per term exceeded");
                    	}
                    	else{

          					        // ADD CONTINOUS ASSESSMENT
                            $sqlStmt = "INSERT INTO assessment(ca_score,ass_student_id,
                            ass_subject_id,ass_class_id,ass_session_id,ass_term_id,ass_added_by,ass_sch_id,date_added)
                            values (?,?,?,?,?,?,?,?,?)";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $stud_id, PDO::PARAM_INT,100);
                            $this->conn->bind(3, $subj, PDO::PARAM_INT,100);
                            $this->conn->bind(4, $class_arm, PDO::PARAM_INT);
                            $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(6, $term, PDO::PARAM_INT);
                            $this->conn->bind(7, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(8, $schid, PDO::PARAM_INT);
                            $this->conn->bind(9, $date, PDO::PARAM_STR);
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
                    && exam_session_id=? && exam_class_arm_id=? && exam_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $termid, PDO::PARAM_INT);
										$this->conn->bind(2, $sessionid, PDO::PARAM_INT);
										$this->conn->bind(3, $class, PDO::PARAM_INT);
										$this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $this->conn->execute();
                    	if ($this->conn->rowCount() > 1)
                    	{
                    	//MESSAGE FOR EXCEEDED RECODS
                      echo "Exam record already exist";
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

        //end get male staff


//End Staff Profile method














}
