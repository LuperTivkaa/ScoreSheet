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
public function getStudentId($regnumber,$schid)
  {
    //always use try and catch block to write code
  try
    {
        //SELECT THE ID OF THE STUDENT/PUPIL FROM THE my_number TABLE
  		 // BASED ON THE REG NUMBER PROVIDED
                  $query ="SELECT my_number.stud_id AS StudentID,
                  admission_number.id AS AdmNoID
                  FROM my_number INNER JOIN admission_number ON my_number.admission_number=admission_number.id
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
//THE ID WILL BE USED TO IDENTIFY THE SESSION
public function getActiveSession($schid,$status='Active')
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
public function getActiveTerm($schid,$status='Active')
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
public function getMaxCaScores($class,$schid)
 {
    //always use try and catch block to write code
  try 
    {
        //write sql statement
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
public function getMaxExamScores($class,$schid)
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

//METHOD TO ENROLL NEW STUDENT
public function studEnrollment($stud_id,$staffid,$inst_id,$date)
            {
            // always use try and catch block to write code
            try
              {
              $class = $this->classTeacherClassID($staffid,$inst_id);
              $sessionid = $this->getActiveSession($inst_id);
              //$stud_id = $this->getStudentId($studentid,$inst_id);
            //SELECT STUDENT BASED ON STUDENTID, CLASS, CLASS ARM AND SESSION
            //TODO: NO STUDENT SHOULD BE ENROLLED TWICE IN A CLASS
                            $query ="SELECT * FROM student_class where student_id =?
                            && stud_class=?  && stud_sess_id=?";
                            $this->conn->query($query);
                            $this->conn->bind(1, $stud_id, PDO::PARAM_STR);
                            $this->conn->bind(2, $class, PDO::PARAM_STR);
                            $this->conn->bind(3, $sessionid, PDO::PARAM_STR);
                            $this->conn->execute();
                              if ($this->conn->rowCount() ==1)
                              {
                              //STUDENT ALREADY ENROLLED IN THE CLASS
                                exit ("This student is already a member of this class");
                              }
                              else{
                                    //check to see that a student is not enrolled twice in the same session
                                    //this prevents re adding a student in a different class
                                    $query ="SELECT * FROM student_class where student_id =?
                                    && stud_sess_id=?";
                                    $this->conn->query($query);
                                    $this->conn->bind(1, $stud_id, PDO::PARAM_STR);
                                    //$this->conn->bind(2, $class, PDO::PARAM_STR);
                                    $this->conn->bind(2, $sessionid, PDO::PARAM_STR);
                                    $this->conn->execute();

                                        if($this->conn->rowCount() >=1){
                                        exit("This student has been added in this session already!");
                                        }
                                        else
                                        {

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
              }

                catch(Exception $e)
                {
                //echo error here
              //this get an error thrown by the system
                echo "Error:". $e->getMessage();
                }
  }

//END  METHOD TO ENROLL STUDENT

//METHOD TO LOCK RESULT AND PREVENT EDIT, CREATE, PUBLISH,POST
public function lockResult($class,$schid,$approval='Yes')
              {
              //prevent edit or create after result is approved
              try
              {
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $query ="SELECT * FROM classpositionals 
                      WHERE 
                      approval_status=? 
                      AND class_id=? 
                      AND term_id=? 
                      AND session_id=?
                      AND school_id=?";
                    $this->conn->query($query);
                    //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
                    $this->conn->bind(1, $approval, PDO::PARAM_INT);
                    $this->conn->bind(2, $class, PDO::PARAM_INT);
                    $this->conn->bind(3, $termid, PDO::PARAM_INT);
                    $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(5, $schid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();

                                  //loop through the result
                                if($this->conn->rowCount() >=1)
                                  {
                                  exit("Please this result is approved, any further action is restricted!");
                                  }
                                  else
                                  {

                                  }
                            }
                  catch(Exception $e)
                  {
                  //echo error here
                  //this get an error thrown by the system
                  echo "Error:". $e->getMessage();
                  }
}
//END METHOD TO LOCK RESULT AND PREVENT EDIT, CREATE, PUBLISH, POST

//Validate scores
public function validateScores($scores)
  {
    if(!is_numeric($scores))
    {
      exit ("Invalid Input Scores");
    }
  }
//End validate scores


//METHOD TO ADD NEW ASSESSMENT
public function addCa($score,$stud_no,$subj,$class,$staffid,$canumber,$schid,$date)
  {
  //always use try and catch block to write code
       try {
                    //validate scores
                    $this->validateScores($score);
                    //Check for lock records
                    $this->lockResult($class,$schid);
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                   $maxScores =  $this->getMaxCaScores($class,$schid);
                   $this->isSubjectTeacher($staffid,$subj,$class,$schid);
                   $this->isStudentClass($student_id,$class,$schid);
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
public function addTerminalExam($score,$subj,$class,$staffid,$schid,$stud_no,$date)
  {    
        try {
                    // always use try and catch block to write code
                     //validate scores
                    $this->validateScores($score);
                    //check for lock result
                    $this->lockResult($class,$schid);
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $student_id = $this->getStudentId($stud_no,$schid);
                    $maxScores = $this->getMaxExamScores($class,$schid);
                    $this->isSubjectTeacher($staffid,$subj,$class,$schid);
                    $this->isStudentClass($student_id,$class,$schid);
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
public function searchStudent($searchVar,$schid)
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
            $query ="SELECT admission_number.id AS AdmissionNumID,  CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,gender AS Sex,img AS myImage,status_active AS Active,my_number.stud_id AS StudentID FROM student_initial INNER JOIN my_number ON student_initial.id=my_number.stud_id INNER JOIN admission_number ON admission_number.id=my_number.admission_number 
            WHERE admission_number.serial_number=? AND admission_number.adm_sch_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $searchVar, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();
                    $myResult= $this->conn->resultset();
                    $output ="";
                    if($this->conn->rowCount() == 0)
                    {
                      exit("No such student exist in the school with such number or student not enrolled in class yet");
                    }
                    else{
                      $output .='<table class="table">';
                       $output .='<thead><tr><th>#</th><th>Full Name</th><th>Sex</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                    $ci=1;
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        $ID = $key['StudentID'];
                        $fullname = $key['Fullname'];
                        $sex = $key['Sex'];
                        $status = $key['Active'];
                        $studavatar = $key['myImage'];
                            if($studavatar){
                            $studentAvatarData='<img src="'.$studavatar.'" class="small-avatar">';
                            }else{
                            $studentAvatarData='<img src="../images/profile-icon.png" class="small-avatar">';
                            }

                        //$studentAvatarData ='<img src="'.$studavatar.'" alt="Staff Avatar" class="small-avatar">';
                        $output.= '<tr>';
                        $output.='<td>'.$ci.'</td>';
                        $output.='<td>'.$studentAvatarData.'</td>';
                        $output.='<td>'.$fullname.'</td>';
                        $output.= '<td>'.$sex.'</td>';
                        $output.='<td>'.$status.'</td>';
                        $output.='<td><a href="myStudentEdit.php?studentid='.$key['StudentID'].'" class="btn btn-info btn-sm" target="_blank" id="result-link"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></td>';
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
            		$query ="SELECT student_initial.id AS studentID, CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,gender AS Sex,img AS myImage,status_active AS Active, student_initial.id AS StudentID FROM student_initial WHERE student_initial.surname LIKE :searchVar AND student_initial.stud_sch_id=:schid";
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
                       $output .='<thead><tr><th>#</th><th>Avatar</th><th>Full Name</th><th>Sex</th><th>Status</th><th>Action</th></tr></thead><tbody>';
                       $ci=1;
                      foreach($myResult as $row => $key)
                      {
                        //TODO: CREATE TWO FUNCTIONS IN JAVASCRIPT TO DIAPLAY DETAILS OF CA AND EXAMS WHEN BUTTON IS CLICKED
                        // $ID = $key['StudentID'];
                        $fullname = $key['Fullname'];
                        $sex = $key['Sex'];
                        $status = $key['Active'];
                        $studavatar = $key['myImage'];
                            if($studavatar){
                            $studentAvatarData='<img src="'.$studavatar.'" class="small-avatar">';
                            }else{
                            $studentAvatarData='<img src="../images/profile-icon.png" class="small-avatar">';
                            }

                        //$studentAvatarData ='<img src="'.$studavatar.'" alt="Staff Avatar" class="small-avatar">';
                        $output.= '<tr>';
                        $output.='<td>'.$ci.'</td>';
                        $output.='<td>'.$studentAvatarData.'</td>';
                        $output.='<td>'.$fullname.'</td>';
                        $output.= '<td>'.$sex.'</td>';
                        $output.='<td>'.$status.'</td>';
                        $output.='<td><a href="myStudentEdit.php?studentid='.$key['StudentID'].'" class="btn btn-info btn-sm" target="_blank" id="result-link"><i class="fa fa-pencil" aria-hidden="true"></i> Edit </a></td>';
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
public function searchCa($searchVar,$schid)
  {
  // Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{
          $activeSession = $this->getActiveSession($schid);
          $termid = $this->getActiveTerm($schid);
          $studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,class.id AS ClassID,session.session AS Session,sch_term.term AS Term,subjects.subject_name AS Subject,subjects.sub_id AS SubjID,assessment.id AS caRecordid,assessment.ca_score AS CaScores,ca_settings.ca_title AS caTitle
             FROM assessment 
             INNER JOIN student_initial ON assessment.ass_student_id=student_initial.id
             INNER JOIN class ON assessment.ass_class_id=class.id 
             INNER JOIN session ON  assessment.ass_session_id=session.id 
             INNER JOIN sch_term ON assessment.ass_term_id=sch_term.term_id 
             INNER JOIN subjects ON assessment.ass_subject_id=subjects.sub_id
             INNER JOIN ca_settings ON assessment.ca_no_id=ca_settings.ca_id
             WHERE ass_student_id =?  && ass_sch_id=? && ass_session_id=?  && ass_term_id=? ORDER BY Term,Subject,caTitle DESC";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentID, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->bind(3, $activeSession, PDO::PARAM_INT);
                    $this->conn->bind(4, $termid, PDO::PARAM_INT);
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
                        $ID = $key['caRecordid'];
                        $class = $key['ClassID'];
                        // $session = $key['SessID'];
                        // $term = $key['TermID'];
                        $subject = $key['SubjID'];
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$ID.'" data-scores="'.$key['CaScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                    <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" class="btn btn-danger btn-sm" id="deleteCa"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button></td></tr>'; 
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

public function advancedCaSearch($class,$subject,$session,$term,$schid)
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
                        $printOutput.='<tr>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Session</th>
                        <th>Term</th>
                        <th>Subject</th>
                        <th>CA Title</th>
                        <th>CA Scores</th>
                        <th>Action</th></tr>';
                        //$ci=1;
                        foreach($myResult as $row => $key)
                        {
                        $ID = $key['caRecordid'];
                        $printOutput.='<tr>';
                        //$printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$ID.'" data-scores="'.$key['CaScores'].'" 
                        class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
  <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" data-mysess="'.$session.'" data-myterm="'.$term.'" class="btn btn-danger btn-sm" id="deleteCa"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button></td></tr>'; 
                        //$ci++;
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
public function basicExamSearch($searchVar,$schid)
  {
        //Try and Catch block
   try
    {
    //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT THE FULL REG NUMBER
  		if(is_numeric($searchVar))
  		{
        $activeSession = $this->getActiveSession($schid);
        $termid = $this->getActiveTerm($schid);
          $studentID = $this->getStudentId($searchVar,$schid);
  					$query ="SELECT CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.id AS StudentID, class.class_name AS ClassName,class.id AS ClassID,session.session AS Session,sch_term.term AS Term, subjects.subject_name AS Subject,subjects.sub_id AS SubjID,terminal_exam.exam_score AS ExamScores,terminal_exam.id AS ExamRecordID
             FROM terminal_exam 
             INNER JOIN student_initial ON terminal_exam.exam_stud_id=student_initial.id
             INNER JOIN class ON terminal_exam.exam_class_arm_id=class.id 
             INNER JOIN session ON  terminal_exam.exam_session_id=session.id 
             INNER JOIN sch_term ON terminal_exam.exam_term_id=sch_term.term_id 
             INNER JOIN subjects ON terminal_exam.exam_subj_id=subjects.sub_id
             WHERE exam_stud_id =? && exam_sch_id=? && exam_session_id=? && exam_term_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $studentID, PDO::PARAM_INT);
					          $this->conn->bind(2, $schid, PDO::PARAM_INT);
                    $this->conn->bind(3, $activeSession, PDO::PARAM_INT);
                    $this->conn->bind(4, $termid, PDO::PARAM_INT);
                    $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No such record exist please!");
                        }
                        else{
                        $printOutput = " ";
                        $printOutput.= '<table  class="table">';
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
                        $ID = $key['ExamRecordID'];
                        $class = $key['ClassID'];
                        $subject = $key['SubjID'];
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-recordid="'.$ID.'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" class="btn btn-danger btn-sm" id="deleteExam"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button></td>'; 
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
public function advancedExamSearch($class,$subject,$session,$term,$schid)
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
                        $ID = $key['ExamRecordID'];
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button" data-classid="'.$class.'" data-sessionid="'.$session.'"data-subjectid="'.$subject.'" data-term="'.$term.'" data-recordid="'.$ID.'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" data-mysess="'.$session.'" data-myterm="'.$term.'" class="btn btn-danger btn-sm" id="deleteExam"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button></tr>'; 
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
public function staffProfile($clientid,$staffid)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, gender AS Gender, date_of_birth AS Dob, mobile AS Mobile FROM staff_profile
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


//STAFF PREVIEW METHOD
public function staffProfilePreview($clientid,$staffid)
        {
        try {
                $query ="SELECT id, CONCAT(UPPER(surname), ' ', middle_name, ' ', lastname) AS fullname, gender AS Gender, date_of_birth AS Dob, mobile AS Mobile, religion AS Religion, dateAdded AS DateAdded FROM staff_profile
                WHERE my_school_id=? AND user_id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $this->conn->bind(2, $staffid, PDO::PARAM_INT); 
                    $output = array();
                    $myResult = $this->conn->resultset();
                    $output = $myResult;
                    $printOutput = "";
                    if($output)
                    {

                      foreach($output as $row => $key)
					            {
                        //make the record id of the terminal exam table the key of the array
						            $fullname = $key['fullname'];
                        $sex = $key['Gender'];
                        $Dob = $key['Dob'];
                        $mobile = $key['Mobile'];
                        $added = $key['DateAdded'];
                        //var_dump($arr);
					            }
                      $printOutput.='<div class="">
                      <h6 class="top-header">Personal Information</h6>
                      <h6> <span class="edit-link"><a class="load-url" href="staff-profile-edit.php">Edit <i class="fa fa-pencil" aria-hidden="true"></i></a></span></h6>
                      <ul class="preview-list-container">';
                      $printOutput.='<li class=""> <span class=""> <i class="fa fa-user-o fa-fw" aria-hidden="true"></i>
 Name</span> '.$fullname.'</li>';
                      $printOutput.='<li class=""> <span class=""> <i class="fa fa-female fa-fw" aria-hidden="true"></i>Gender </span>'.$sex.'</li>';
                      $printOutput.='<li class=""> <span class=""> <i class="fa fa-birthday-cake fa-fw" aria-hidden="true"></i>
 Born On </span>' .$Dob.'</li>';
                       $printOutput.='<li class=""> <span class=""> <i class="fa fa-phone fa-fw" aria-hidden="true"></i>
Mobile </span>'.$mobile.'</li>';
                      $printOutput.='<li class=""><span class=""><i class="fa fa-hashtag fa-fw"  aria-hidden="true"></i>
Joined On</span> '.$added.'</li>';
                      $printOutput.='</ul></div>';
                    }
                    else
                    {
                      echo "No Staff profile yet!";
                    }
                    echo $printOutput;
                }//End of try catch block
         catch(Exception $e)
        {
            echo ("Error: Unable to fetch Male Staff");
        }
        }
//END STAFF PREVIEW METHOD



  //Select DISTINCT SUBJECTs OFFERED BY THE Student based on class
public function distinctSubjects($studentid,$schoolid)
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
public function ordinalSuffix($num) {
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
public function print_ca($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
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
      $rowCount = $this->conn->rowCount();
      $arr = "";
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

//Total Terminal Exam Scores per subject
public function subject_ScoresTotal($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
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
      $null='0';
			$arr="";
					if( $output && $this->conn->rowCount() >=1){
					  foreach($output as $row => $key)
					  {
					  $examScores = $key['ExamScore'];
          
					  }	
					//$arr.='</tr><br>';
          return $examScores;
        }
        else{
          return $null;
        }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//End of Terminal Exam

//Subject Average
public function subjectAv($subjectid,$classid,$sessionid,$termid,$schid)
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
      $null ='0';
			$arr="";
          if($output && $this->conn->rowCount() >=1)
          {
					  foreach($output as $row => $key)
					  {
					  $subjectAv = $key['SubjectAv'];
					  //$arr.= '<td>'.$subjectAv.'</td>';
					  }	
					  //$arr.='</tr><br>';
            return $subjectAv;
          }
          else{
          return $null;
          }	
        }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//Subject Average

//Method to get subject position
public function getSubjectPosition($studentID,$subjectid,$classid,$sessionid,$termid,$schid)
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
      $null ='NA';
      $arr="";
      $position="";
          if($this->conn->rowCount() >=1)
          {
              foreach($output as $row => $key)
              {
              $subjectPosition = $key['SubjectPosition'];
              $position = $this->ordinalSuffix($subjectPosition);
              //$arr.= '<td>'.$position.'</td>';
              }	
          return $position;
        }
        else{
          return $null;
        }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//end method to get subject position


//METHOD TO GET STUDENT ANNUAL SUBJECT POSITION
public function getAnnualSubjPosition($studentID,$subjid,$classid,$sessionid,$schid)
	  {
		try{
      $query ="SELECT Annual_Subject_Position AS annualSubjPosition
      FROM  annual_subject_position 
      WHERE student_id=? AND subject_id=? AND 
      class_id=? AND session_id=? AND sch_id=?"; 
      $this->conn->query($query); 
      $this->conn->bind(1, $studentID, PDO::PARAM_INT);
      $this->conn->bind(2, $subjid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT); 
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
      $na = 'NA';
      $c_pos ="";
          if($this->conn->rowCount() >=1)
          {
              foreach($output as $row => $key)
              {
              $annualPosition = $key['annualSubjPosition'];
              $c_pos = $this->ordinalSuffix($annualPosition);
              }	
              return $c_pos;
          }
          else
          {
          return $na;
          }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//END METHOD TO GET STUDENT ANNUAL SUBJECT POSITION


//METHOD TO GET ANNUAL POSITION FOR STUDENTS
public function getAnnualPosition($studentID,$classid,$sessionid,$schid)
	  {
		try{
      $query ="SELECT annual_position AS annualPosition
      FROM  annual_result 
      WHERE student_id=? AND 
      class_id=? AND session_id=? AND sch_id=?"; 
      $this->conn->query($query); 
      $this->conn->bind(1, $studentID, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
			$this->conn->bind(4, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
      $na = 'NA';
      $c_pos ="";
          if($this->conn->rowCount() >=1)
          {
              foreach($output as $row => $key)
              {
              $annualPosition = $key['annualPosition'];
              $c_pos = $this->ordinalSuffix($annualPosition);
              }	
              return $c_pos;
          }
          else
          {
          return $na;
          }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//END METHOD TO GET ANNUAL POSITION

//Method to get class position
public function getClassPosition($studentID,$classid,$sessionid,$termid,$schid)
	  {
		try{
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
      $na = 'NA';
      $c_pos ="";
          if($this->conn->rowCount() >=1)
          {
              foreach($output as $row => $key)
              {
              $classPosition = $key['termPosition'];
              $c_pos = $this->ordinalSuffix($classPosition);
              }	
              return $c_pos;
          }
          else
          {
          return $na;
          }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//end Method to get class position

//Yearly subject totals
public function yearlySubjectTotals($studentid,$subjectid,$classid,$sessionid,$schid)
	  {
		try {
      $query ="SELECT YearlySubjTotal AS AnnualSubjTotal
      FROM  annualsubjecttotals 
      WHERE
      student_id=? AND subject_id=? AND 
      class_id=? AND session_id=? AND sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
			$this->conn->bind(2, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(3, $classid, PDO::PARAM_INT); 
			$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
			$this->conn->bind(5, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
      $null="NA";
      //$subjectTotal="";
      if($this->conn->rowCount() >=1)
      {
					foreach($output as $row => $key)
					{
					$subjectTotal = $key['AnnualSubjTotal'];
					//$arr.= '<td>'.$subjectTotal.'</td>';
					}	
					//return $arr;
          return $subjectTotal;	
      }
        else{
          return $null;
        }
      }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }

//End yearly subject totals


//subject totals scores
public function subjectTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
	  {
		
		try {
      $query ="SELECT subjecttotals.TermTotal AS SubjectTotal
      FROM  subjecttotals 
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
      $null="NA";
      //$subjectTotal="";
      if($this->conn->rowCount() >=1)
      {
					foreach($output as $row => $key)
					{
					$subjectTotal = $key['SubjectTotal'];
					//$arr.= '<td>'.$subjectTotal.'</td>';
					}	
					//return $arr;
          return $subjectTotal;	
      }
        else{
          return $null;
        }
      }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
    //End subject totals

//Get class category based on class id
public function getClassCategoryID($class,$schid)
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
                              exit("No class category available!");
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

//TERMINAL AVERAGE
public function terminalAverage($studentid,$classid,$sessionid,$termid,$schid)
  {
  try {
    /*
    1. find the average of student based on the grand total all scores in subject 
    2. divide by total number of subjects in a particular class
    */
   // SELECT COUNT( DISTINCT exam_subj_id) FROM terminal_exam WHERE `exam_session_id`=? AND `exam_class_arm_id`=? AND `exam_term_id`=? AND exam_sch_id=? AND exam_stud_id=?

      $query = "SELECT ROUND(GrandTermTotal/(SELECT COUNT( DISTINCT exam_subj_id) AS SubjectCount
      FROM terminal_exam WHERE exam_session_id=? AND exam_class_arm_id=? AND exam_term_id=? AND exam_sch_id=? AND exam_stud_id=?),2 ) AS TotalAverage
      FROM termgrandtotal WHERE 
      termgrandtotal.student_id=? 
      AND termgrandtotal.class_id=?
      AND termgrandtotal.term_id=? AND termgrandtotal.session_id=?
      AND termgrandtotal.sch_id=?";
                  $this->conn->query($query);
                  $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(2, $classid, PDO::PARAM_INT); 
                  $this->conn->bind(3, $termid, PDO::PARAM_INT);
                  $this->conn->bind(4, $schid, PDO::PARAM_INT); 
                  $this->conn->bind(5, $studentid, PDO::PARAM_INT);
                  $this->conn->bind(6, $studentid, PDO::PARAM_INT);
                  $this->conn->bind(7, $classid, PDO::PARAM_INT);
                  $this->conn->bind(8, $termid, PDO::PARAM_INT);
                  $this->conn->bind(9, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(10, $schid, PDO::PARAM_INT);
                  $output = $this->conn->resultset();
                  $tav = "";
                  $na = 'NA';
                  if($this->conn->rowCount() >=1){
                  foreach($output as $row => $key)
                  {
                  $tav = $key['TotalAverage'];
                  }	
                  return $tav;
                }else{
                  return $na;
                }
                  
              }//End of try catch block
              catch(Exception $e)
              {
                  echo "Error:". $e->getMessage();
              }
        }
//TERMINAL AVERAGE

//ANNUAL STUDENT AVERAGAE
public function annualAverage($studentid,$classid,$sessionid,$schid)
  {
  try {

      $query = "SELECT ROUND(AnnualTotal/(SELECT COUNT( DISTINCT subject_id)*3 AS SubjectCount
      FROM annualsubjecttotals WHERE session_id=? AND class_id=? AND sch_id=? AND student_id=?),3 ) AS TotalAverage
      FROM annualtotal WHERE 
      annualtotal.student_id=? 
      AND annualtotal.class_id=?
      AND annualtotal.session_id=?
      AND annualtotal.sch_id=?";
                  $this->conn->query($query);
                  $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(2, $classid, PDO::PARAM_INT); 
                  $this->conn->bind(3, $schid, PDO::PARAM_INT); 
                  $this->conn->bind(4, $studentid, PDO::PARAM_INT);
                  $this->conn->bind(5, $studentid, PDO::PARAM_INT);
                  $this->conn->bind(6, $classid, PDO::PARAM_INT);
                  $this->conn->bind(7, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(8, $schid, PDO::PARAM_INT);
                  $output = $this->conn->resultset();
                  $tav = "";
                  $na = 'NA';
                  if($this->conn->rowCount() >=1){
                  foreach($output as $row => $key)
                  {
                  $tav = $key['TotalAverage'];
                  }	
                  return $tav;
                }else{
                  return $na;
                }
                  
              }//End of try catch block
              catch(Exception $e)
              {
                  echo "Error:". $e->getMessage();
              }
        }
//END ANNUAL STUDENT AVERAGE





//Method to find annual subject average
public function annualSubjectAverage($subjectid,$classid,$sessionid,$schid)
	  {		
		try {
      $query ="SELECT ROUND(AnnualSubjAverage/3,3) AS YrlySubjectAv
      FROM  annualsubjectaverage
      WHERE subject_id=? AND 
      class_id=? AND session_id=? AND sch_id=?"; 
      $this->conn->query($query); 
			$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
			$this->conn->bind(4, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
      //echo count($output);
      $null ='0';
			$arr="";
          if($output && $this->conn->rowCount() >=1)
          {
					  foreach($output as $row => $key)
					  {
					  $subjectAv = $key['YrlySubjectAv'];
					  //$arr.= '<td>'.$subjectAv.'</td>';
					  }	
					  //$arr.='</tr><br>';
            return $subjectAv;
          }
          else{
          return $null;
          }	
        }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//End Method Annual Average

 //SELECT GRAND TOTAL
public function grandTotals($studentid,$classid,$sessionid,$termid,$schid)
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
      $grandTotal=0;
      $ndf = "NA";
      if($output && $this->conn->rowCount()==0)
        {
        return $ndf;  
        }else{
          foreach($output as $row => $key)
            {
            $grandTotal = $key['GrandTotal'];
            }	
            return $grandTotal;
        }	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
 //END GRAND TOTAL

//Method to find student annual totals
public function annualTotals($studentid,$classid,$sessionid,$schid)
	  {
		try {
      $query ="SELECT AnnualTotal AS YearlyTotals
      FROM  annualtotal 
      WHERE
      student_id=? AND
      class_id=? AND session_id=? AND
      sch_id=?"; 
      $this->conn->query($query);
      $this->conn->bind(1, $studentid, PDO::PARAM_INT); 
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $sessionid, PDO::PARAM_INT);
			$this->conn->bind(4, $schid, PDO::PARAM_INT);
      $output = $this->conn->resultset();
			//echo count($output);
			$arr="";
      $ndf = "NA";
      if($output && $this->conn->rowCount()==0)
        {
        return $ndf;  
        }else{
          foreach($output as $row => $key)
            {
            $grandTotal = $key['YearlyTotals'];
            //$arr.='td>'.$grandTotal.'</td>';
            }	
            return $grandTotal;
        }	
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	  }
//End  Method to find terminal totals


//ca Totals 
public function caTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schid)
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
      $null ="0";
			$arr="";
        if($output && $this->conn->rowCount() >=1)
        {
					  foreach($output as $row => $key)
					  {
					  $totalca = $key['Total'];
					  //$arr.= '<td>'.$totalca.'</td>';
            }
            return $totalca;
        }
					//$arr.='</tr><br>';
        else{
            return $null;
          }	
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
public function getStudent($searchVar,$schid)
  {
        //get active term
       // $activeSession= $this->getActiveSession($schid);
        
        // Try and Catch block
        try{
        //CHECK IF THE VARIABLE SUPPLIED IS A STUDENT ID NUMBER AND NOT A STRING OF REG NUMBER
  		    if(is_numeric($searchVar))
  		    {
  			//SELECT STUDENT ID FROM THE STUDENT ADMISSION NUMBER TABLE
  					$query ="SELECT admission_number.id AS AdmissionNumID,  CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname FROM student_initial INNER JOIN my_number ON student_initial.id=my_number.stud_id INNER JOIN admission_number ON admission_number.id=my_number.admission_number 
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
    //


    //RESET RESULT SUBMITTED
function resetResultSubmit($termid,$sessionid,$classid,$schid)
      { 
      try
      {
                        $this->lockResult($classid,$schid);
                        $null = "";
                          //Reset terminal_exam  subject postion
                          $updateQuery = "DELETE  FROM classpositionals 
                          WHERE 
                          term_id=?
                          AND session_id=?
                          AND class_id=?
                          AND school_id=?";
                          $this->conn->query($updateQuery); 
                          $this->conn->bind(1, $termid, PDO::PARAM_INT);
                          $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                          $this->conn->bind(3, $classid, PDO::PARAM_INT);
                          $this->conn->bind(4, $schid, PDO::PARAM_INT);
                          $this->conn->execute();
                          //check for the success of the update operation and not end of array
                            if($this->conn->rowCount() >= 1)
                            {
                             echo "ok";
                            }
                            else
                            {
                            exit("Reset failed!");
                            }
        }
        catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
} 
//END RESET RESULT SUBMITTED


//RESET CLASS POSITIONING
public function resetClassPosition($termid,$sessionid,$classid,$schid)
                  { 
                  try
                  {
                                      $this->lockResult($classid,$schid);
                                      $null = "";
                                      //Reset class  postion
                                      $updateQuery = "UPDATE classpositionals SET 
                                      termposition=? WHERE 
                                      term_id=?
                                      AND session_id=?
                                      AND class_id=?
                                      AND school_id=?";
                                      $this->conn->query($updateQuery); 
                                      $this->conn->bind(1, $null, PDO::PARAM_STR);
                                      $this->conn->bind(2, $termid, PDO::PARAM_INT);
                                      $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                                      $this->conn->bind(4, $classid, PDO::PARAM_INT);
                                      $this->conn->bind(5, $schid, PDO::PARAM_INT);
                                      $this->conn->execute();
                                      //check for the success of the update operation and not end of array
                                        if($this->conn->rowCount() >= 1)
                                        {
                                        echo "ok";
                                        }
                                        else
                                        {
                                        exit("Class position Reset failed!");
                                        }
                }
                catch(Exception $e)
                {
                  echo "Error:". $e->getMessage();
                }
}
//END RESET CLASS POSITIONING


//RESET SUBJECT POSITION
public function resetSubjectPosition($subjectid,$termid,$sessionid,$classid,$schid)
        { 
          try
          {
            //check for locked result
            $this->lockResult($classid,$schid);
                            $null = "";
                            //Reset terminal_exam  subject postion
                            $updateQuery = "UPDATE terminal_exam SET 
                              subject_position=? WHERE 
                              exam_subj_id=?
                              AND exam_term_id=?
                              AND exam_session_id=?
                              AND exam_class_arm_id=?
                              AND exam_sch_id=?";
                              $this->conn->query($updateQuery); 
                              $this->conn->bind(1, $null, PDO::PARAM_STR);
                              $this->conn->bind(2, $subjectid, PDO::PARAM_INT);
                              $this->conn->bind(3, $termid, PDO::PARAM_INT);
                              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(5, $classid, PDO::PARAM_INT);
                              $this->conn->bind(6, $schid, PDO::PARAM_INT);
                              $this->conn->execute();
                              //check for the success of the update operation and not end of array
                                if($this->conn->rowCount() >= 1)
                                {
                                 echo "ok";
                                }
                                else
                                {
                                exit("Reset failed!");
                                }
      }
      catch(Exception $e)
      {
          echo "Error:". $e->getMessage();
      }
    } 
    //END RESET SUBJECT POSITION

//Method to return last key of an array
public function endKey($array)
  {
  end($array);
  return key($array);
  }
//End method to return last key of an array

//Function definition to get student subject totals, record id from terminal_exam table and loop through to 
//update the table with the subject position
public function subjectPosition($subjectid,$termid,$sessionid,$classid,$schid)
    { 
      try
      {
        //check for lock result
      $this->lockResult($classid,$schid);
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
              //var_dump($arr);
              $occurences = array_count_values($arr);
              //var_dump($occurences);
              $scores_value = current($arr);
              $studentid = key($arr);
              $subjectPosition =1;
             // echo $frequencyOfValue = $occurences[$scores_value];
             $lastKey = $this->endKey($arr);
              //========================================================
                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                        $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue >= 2)
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
                              //Test for end of array in the if statement
                                if($this->conn->rowCount() == 1)
                                {
                                        //check for end of array
                                    if($lastKey == $studentid)
                                    {
                                      exit("Subject position assigned successfully");
                                    }
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
                                  //$scores_value = next($arr);
                                  //$studentid = key($arr);
                            //check for another occurence of the array occurences of the array value
                                  $frequencyOfValue = $occurences[$scores_value];
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
                                  //check for end of array
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                  exit("Subject position assigned successfully");
                                  }
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                  $subjectPosition+=1;
                                  $frequencyOfValue = $occurences[$scores_value];
                                 
                                }
                                else
                                {
                                exit("Position update failed!");
                                }
                        }
                      
             }
              //============================================================================================

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

//METHOD TO ASSIGN ANNUAL SUBJECT POSITION
public function annualSubjectPosition($classid,$subjid,$sessionid,$schid)
    { 
      try
      {
        //check for unique records
        $query ="SELECT class_id AS ID
		    FROM annual_subject_position  
          WHERE 
          session_id= ? AND 
          class_id=? AND
          subject_id=? AND
          sch_id= ?";
          $this->conn->query($query); 
          $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(2, $classid, PDO::PARAM_INT); 
          $this->conn->bind(3, $subjid, PDO::PARAM_INT);
          $this->conn->bind(4, $schid, PDO::PARAM_INT);
          $chk = $this->conn->resultset();
          if($chk && $this->conn->rowCount() >=1)
          {
            exit("Record exist!");
          }
          
      //check for lock result
      $this->lockResult($classid,$schid);
      $query ="SELECT student_id AS studentID,YearlySubjTotal AS Total
		  FROM annualsubjecttotals  
      WHERE 
      session_id= ? AND 
      class_id=? AND 
      sch_id= ? AND subject_id=? ORDER BY Total DESC";
      $this->conn->query($query); 
			$this->conn->bind(1, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
      $this->conn->bind(3, $schid, PDO::PARAM_INT);
      $this->conn->bind(4, $subjid, PDO::PARAM_INT);
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
              //var_dump($arr);
              $occurences = array_count_values($arr);
              //var_dump($occurences);
              $scores_value = current($arr);
              $studentid = key($arr);
              $subjectPosition =1;
              //Get the last key of the array
              $lastKey = $this->endKey($arr);
             // echo $frequencyOfValue = $occurences[$scores_value];

              //========================================================
                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                        $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue >= 2)
                         {
                            for($k=0; $k < $frequencyOfValue; $k++)
                             {
                              //Insert annual_result record with correct  position
                              $updateQuery = "INSERT INTO annual_subject_position(student_id,subject_id,class_id,session_id,sch_id,Annual_Subject_Position) VALUES (?,?,?,?,?,?)";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                              $this->conn->bind(2, $subjid, PDO::PARAM_INT);
                              $this->conn->bind(3, $classid, PDO::PARAM_INT); 
                              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(5, $schid, PDO::PARAM_INT);
                              $this->conn->bind(6, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->execute();
                              //check for the success of the update operation and not end of array
                              //Test for end of array in the if statement
                                if($this->conn->rowCount() == 1)
                                {
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                    exit("Annual Subject Position Assigned Successfully");
                                  }
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                }
                                else{
                                  exit("Position update failed!");
                                }
                            }
                            /*
                            write a code snippet to check for end of array
                            */
                            //increment the subjetPosition counter
                            $subjectPosition = $subjectPosition + $frequencyOfValue;
                            //$scores_value = next($arr);
                            //$studentid = key($arr);
                            //check for another occurence of the array occurences of the array value
                            $frequencyOfValue = $occurences[$scores_value];
                        }
                        else
                        {
                            //Update terminal_exam record with correct  position
                              $updateQuery = "INSERT INTO annual_subject_position(student_id,subject_id,class_id,session_id,sch_id,Annual_Subject_Position) VALUES (?,?,?,?,?,?)";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                              $this->conn->bind(2, $subjid, PDO::PARAM_INT);
                              $this->conn->bind(3, $classid, PDO::PARAM_INT); 
                              $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(5, $schid, PDO::PARAM_INT);
                              $this->conn->bind(6, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->execute();
                              if($this->conn->rowCount() == 1)
                                {
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                  exit("Annual Subject  Position Assigned Successfully");
                                  }
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                  $subjectPosition+=1;
                                  $frequencyOfValue = $occurences[$scores_value];
                                }
                                else
                                {
                                exit("Position update failed");
                                }
                        }

             }
              //============================================================================================

            }
            else
            {
              exit("No Record is found matching your selection!");
            }
      }//end catch
      catch(Exception $e)
      {
          echo "Error:". $e->getMessage();
      }
    } 
//END METHOD TO ASSIGN ANNUAL SUBJECT POSITION 

//Method to assign annual position
public function annualPosition($classid,$sessionid,$schid)
    { 
      try
      {
        //check for unique records
        $query ="SELECT class_id AS ID
		    FROM annual_result  
          WHERE 
          session_id= ? AND 
          class_id=? AND 
          sch_id= ?";
          $this->conn->query($query); 
          $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(2, $classid, PDO::PARAM_INT); 
          $this->conn->bind(3, $schid, PDO::PARAM_INT);
          $chk = $this->conn->resultset();
          if($chk && $this->conn->rowCount() >=1)
          {
            exit("Record exist!");
          }

      //check for lock result
      $this->lockResult($classid,$schid);
      $query ="SELECT student_id AS studentID,AnnualTotal AS Total
		  FROM annualtotal  
      WHERE 
      session_id= ? AND 
      class_id=? AND 
      sch_id= ? ORDER BY Total DESC";
      $this->conn->query($query); 
			$this->conn->bind(1, $sessionid, PDO::PARAM_INT);
      $this->conn->bind(2, $classid, PDO::PARAM_INT); 
			$this->conn->bind(3, $schid, PDO::PARAM_INT);
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
              //var_dump($arr);
              $occurences = array_count_values($arr);
              //var_dump($occurences);
              $scores_value = current($arr);
              $studentid = key($arr);
              $subjectPosition =1;
              //Get the last key of the array
              $lastKey = $this->endKey($arr);
             // echo $frequencyOfValue = $occurences[$scores_value];

              //========================================================
                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                        $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue >= 2)
                         {
                            for($k=0; $k < $frequencyOfValue; $k++)
                             {
                              //Insert annual_result record with correct  position
                              $updateQuery = "INSERT INTO annual_result(student_id,class_id,session_id,sch_id,annual_position) VALUES (?,?,?,?,?)";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                              $this->conn->bind(2, $classid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(4, $schid, PDO::PARAM_INT);
                              $this->conn->bind(5, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->execute();
                              //check for the success of the update operation and not end of array
                              //Test for end of array in the if statement
                                if($this->conn->rowCount() == 1)
                                {
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                    exit("Annual position assigned successfully");
                                  }
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                }
                                else{
                                  exit("Position update failed!");
                                }
                            }
                            /*
                            write a code snippet to check for end of array
                            */
                            //increment the subjetPosition counter
                            $subjectPosition = $subjectPosition + $frequencyOfValue;
                            //$scores_value = next($arr);
                            //$studentid = key($arr);
                            //check for another occurence of the array occurences of the array value
                            $frequencyOfValue = $occurences[$scores_value];
                        }
                        else
                        {
                            //Update terminal_exam record with correct  position
                              $updateQuery = "INSERT INTO annual_result(student_id,class_id,session_id,sch_id,annual_position) VALUES (?,?,?,?,?)";
                              $this->conn->query($updateQuery);
                              $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                              $this->conn->bind(2, $classid, PDO::PARAM_INT); 
                              $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(4, $schid, PDO::PARAM_INT);
                              $this->conn->bind(5, $subjectPosition, PDO::PARAM_INT);
                              $this->conn->execute();
                              if($this->conn->rowCount() == 1)
                                {
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                  exit("Annual position assigned successfully");
                                  }
                                  $scores_value = next($arr);
                                  $studentid = key($arr);
                                  $subjectPosition+=1;
                                  $frequencyOfValue = $occurences[$scores_value];
                                }
                                else
                                {
                                exit("Position update failed");
                                }
                        }

             }
              //============================================================================================

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
//End method to assign annual position


//RESET ANNUAL SUBJECT POSITION
function resetAnnualSubjPosition($sessionid,$subj,$classid,$schid)
      { 
      try
      {
                        $this->lockResult($classid,$schid);
                        $null = "";
                          //Reset terminal_exam  subject postion
                          $updateQuery = "DELETE  FROM annual_subject_position 
                          WHERE session_id=? AND subject_id=? AND class_id=? AND sch_id=?";
                          $this->conn->query($updateQuery); 
                          $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
                          $this->conn->bind(2, $subj, PDO::PARAM_INT);
                          $this->conn->bind(3, $classid, PDO::PARAM_INT);
                          $this->conn->bind(4, $schid, PDO::PARAM_INT);
                          $this->conn->execute();
                          //check for the success of the update operation and not end of array
                            if($this->conn->rowCount() >= 1)
                            {
                             echo "ok";
                            }
                            else
                            {
                            exit("Reset failed! or no record to delete");
                            }
        }
        catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
} 
//END RESET ANNUAL SUBJECT POSITION

//Method to reset annual Position
function resetAnnualPosition($sessionid,$classid,$schid)
      { 
      try
      {
                        $this->lockResult($classid,$schid);
                        $null = "";
                          //Reset terminal_exam  subject postion
                          $updateQuery = "DELETE  FROM annual_result 
                          WHERE session_id=? AND class_id=? AND sch_id=?";
                          $this->conn->query($updateQuery); 
                          $this->conn->bind(1, $sessionid, PDO::PARAM_INT);
                          $this->conn->bind(2, $classid, PDO::PARAM_INT);
                          $this->conn->bind(3, $schid, PDO::PARAM_INT);
                          $this->conn->execute();
                          //check for the success of the update operation and not end of array
                            if($this->conn->rowCount() >= 1)
                            {
                             echo "ok";
                            }
                            else
                            {
                            exit("Reset failed!");
                            }
        }
        catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
} 
//End Method to reset annual Position

//Highest by subject in a class
public function highestInClass($subjectid,$classid,$termid,$sessionid,$schoolid)
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
        $null="0";
        $printOutput = "";
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
              return $null;
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//end Highest by subject in a class

//Lowest by subject in class
public function lowestInClass($subjectid,$classid,$termid,$sessionid,$schoolid)
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
        $null="0";
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
              return $null;
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }

//end lowest by subject in class

//method to find highest total in class
public function highestYearTotal($classid,$sessid,$schid)
	    {
		  try {
        //check to see if records already exist 
        $query ="SELECT AnnualTotal AS HighestTotal FROM annualtotal WHERE class_id=? AND  session_id=? AND sch_id=? ORDER BY HighestTotal DESC LIMIT 1";
        $this->conn->query($query);
        //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $sessid, PDO::PARAM_INT); 
				$this->conn->bind(3, $schid, PDO::PARAM_INT);
        $output = $this->conn->resultset();
        $null="NA";
        $printOutput = "";
        if($output && $this->conn->rowCount() >=1)
        {
          	foreach($output as $row => $key)
					{
            $highesttotal = $key['HighestTotal'];
					}
          return $highesttotal;
        }
            else
            {
              return $null;
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
//end method to find highest term total


//Method to find lowest term total
public function lowestYearTotal($classid,$sessid,$schid)
	    {
		  try {
        //check to see if records already exist 
        $query ="SELECT AnnualTotal AS LowestTotal FROM annualtotal WHERE  class_id=? AND session_id=? AND sch_id=? ORDER BY LowestTotal ASC LIMIT 1";
        $this->conn->query($query);
        //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $sessid, PDO::PARAM_INT); 
				$this->conn->bind(3, $schid, PDO::PARAM_INT);
        $output = $this->conn->resultset();
        $null="NA";
        $printOutput = "";
        if($output && $this->conn->rowCount() >=1)
        {
          	foreach($output as $row => $key)
					  {
            $lowesttotal = $key['LowestTotal'];
					  }
          return $lowesttotal;
        }
            else
            {
              return $null;
            }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
//end method to find lowest term total

//Scoresheet method
public function scoreSheet($subjectid,$classid,$termid,$sessionid,$schoolid)
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
        <a href="classAssessmentSheetPrint.php?subjectid='.$subjectid.'&class='.$classid.'&session='.$sessionid.'&term='.$termid.'&schoolid='.$schoolid.'" target="_blank" class="btn btn-info" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print Sheet</a>
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
          <TH>CA Total '.$totalCA.' %</th>
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

public function scoreSheetHeaderInformation($subjectid,$classid,$termid,$sessionid,$schoolid)
	    {
		 try {
			
        $query ="SELECT DISTINCT student_initial.id AS studentID,
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
					
          //ouput table headers below here
          $null="No Header Information Available Yet";
          $printOutput = " ";
          if($output && $this->conn->rowCount() >=1)
          {
          
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
              $printOutput.='<li><span class="scoresheet-header-title">Class</span><span class="scoresheet-header-sub">'.$ClassName.'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Subject</span><span class="scoresheet-header-sub">'.$subjectName.'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Term</span><span class="scoresheet-header-sub">'.$termName.'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Session</span><span class="scoresheet-header-sub">'.$sessionName.'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Subject Teacher</span><span class="scoresheet-header-sub">'.$this->staffSign($classid,$subjectid,$schoolid).'</span></li></ul></div>';
          echo $printOutput;
      }else{
        echo $null;
      }
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
    //End scoresheet Header Information


    //method to write annual result header Information
public function annualResultHeader($classid,$termid,$sess,$schid)
	    {
        $printOutput="";
        $printOutput.='<div class="student-profile">
        <h5>Terminal/Annual Result Summary</h5>
        <ul class="scoresheet-header">';
              $printOutput.='<li><span class="scoresheet-header-title">Class</span><span class="scoresheet-header-sub">'.$this->getClassName($schid,$classid).'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Term</span><span class="scoresheet-header-sub">'.$this->getTermName($schid,$termid).'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Session</span><span class="scoresheet-header-sub">'.$this->getSessionName($schid,$sess).'</span></li></ul></div>';
          echo $printOutput;
	    }
    //end method to write annual result header information

//Yearly result header
public function yearlyResultHeader($classid,$sess,$schid)
	    {
        $printOutput="";
        $printOutput.='<div class="student-profile">
        <h5>Annual Result Summary</h5>
        <ul class="scoresheet-header">';
              $printOutput.='<li><span class="scoresheet-header-title">Class</span><span class="scoresheet-header-sub">'.$this->getClassName($schid,$classid).'</span></li>';
              //$printOutput.='<li><span class="scoresheet-header-title">Term</span><span class="scoresheet-header-sub">'.$this->getTermName($schid,$termid).'</span></li>';
              $printOutput.='<li><span class="scoresheet-header-title">Session</span><span class="scoresheet-header-sub">'.$this->getSessionName($schid,$sess).'</span></li></ul></div>';
          echo $printOutput;
	    }
//end yearly result header

//Class result summary Sheet
public function classResultHeader($classid,$termid,$sessionid,$schoolid)
                {
                try {

                  $query ="SELECT 
                  class.class_name AS ClassName,
                  session.session AS SessionName,
                  sch_term.term AS TermName
                  FROM classpositionals
                  INNER JOIN class ON class.id=classpositionals.class_id
                  INNER JOIN session ON session.id=classpositionals.session_id
                  INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
                  WHERE 
                  classpositionals.class_id=? AND classpositionals.session_id=?
                  AND classpositionals.term_id=?  AND classpositionals.school_id=?";
                  $this->conn->query($query);
                  $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                  $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(3, $termid, PDO::PARAM_INT); 
                  $this->conn->bind(4, $schoolid, PDO::PARAM_INT);
                  $output = $this->conn->resultset(); 
                    
                    //ouput table headers below here
                    $null="No Header Information Available Yet";
                    $printOutput = " ";
                    if($output && $this->conn->rowCount() >=1)
                    {
                    
                    foreach($output as $row => $key)
                    {
                      $ClassName = $key['ClassName'];
                      $sessionName = $key['SessionName'];
                      $termName = $key['TermName'];
                    }

                  $printOutput.='<div class="student-profile">
                  <h5>Class Assessment Sheet</h5>
                  <ul class="scoresheet-header">';
                        $printOutput.='<li><span class="scoresheet-header-title">Class</span><span class="scoresheet-header-sub">'.$ClassName.'</span></li>';
                        $printOutput.='<li><span class="scoresheet-header-title">Term</span><span class="scoresheet-header-sub">'.$termName.'</span></li>';
                        $printOutput.='<li><span class="scoresheet-header-title">Session</span><span class="scoresheet-header-sub">'.$sessionName.'</span></li>';
                        $printOutput.='<li><span class="scoresheet-header-title">Class Teacher</span><span class="scoresheet-header-sub">'.$this->classTeacher($classid,$schoolid).'</span></li></ul></div>';
                    echo $printOutput;
                }else{
                  echo $null;
                }
                  }//End of try catch block
                  catch(Exception $e)
                  {
                      echo "Error:". $e->getMessage();
                  }
}
//end class result summary


//View result summary
public function viewResultSummary($classid,$termid,$sessionid,$schoolid)
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
          $printOutput.= "<table class='table'>";
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
            $av = $this->terminalAverage($studentID,$classid,$sessionid,$termid,$schoolid);
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
            $printOutput.='<td><a href="resultSheet.php?studentid='.$studentID.'&class='.$classid.'&session='.$sessionid.'&term='.$termid.'&schoolid='.$schoolid.'" target="_blank" class="btn btn-success" id="result-link"><i class="fa fa-print" aria-hidden="true"></i> Print Result</a></td>';
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

//RESULT SHEET BY CLASS
public function classResultSheet($classid,$termid,$sessionid,$schoolid)
   {
    try {
        $query ="SELECT classpositionals.student_id AS StudentID,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
        FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=? ORDER BY Fullname";
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
            echo '<p class="printAssessment">
            <a href="classResultSheetPrint.php?class='.$classid.'&session='.$sessionid.'&term='.$termid.'&schoolid='.$schoolid.'" target="_blank" class="btn btn-info" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print Sheet</a>
            <hr></p>';
            $printOutput = " ";
            $printOutput.= "<table class='table'>";
            $printOutput.="<tr>
            <th>Student Name</th>
            <TH>Term Grand Total</th>
            <TH>Maximum Scores</th>
            <TH>Student Average</th>
            <TH>Position In Class</th>
            </tr>";
            foreach($output as $row => $key)
            {
              //Promotional status
              $studentID = $key['StudentID'];
              $studentName = $key['Fullname'];
              $cumTotal = $this->grandTotals($studentID,$classid,$sessionid,$termid,$schoolid);
              $av = $this->terminalAverage($studentID,$classid,$sessionid,$termid,$schoolid);
              //check promotion status                  
              $printOutput.='<tr>';
              $printOutput.='<td>'.$studentName.'</td>';
              $printOutput.='<td>'.$cumTotal.'</td>';
              $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
              $printOutput.='<td>'.$av.'</td>';
              $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
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
// END RESULT SHEET BY CLASS


public function promotionSummarySheet($classid,$sessionid,$schoolid)
	    {
		  try {
			
        $query ="SELECT annual_result.id AS ID, annual_result.student_id AS StudentID,
        annual_result.promotion_status AS PromotionStatus,
        class.class_name AS ClassName,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
	      FROM annual_result INNER JOIN student_initial ON student_initial.id=annual_result.student_id
        INNER JOIN class ON class.id=annual_result.class_id
	      WHERE annual_result.class_id=? AND annual_result.session_id=?
        AND annual_result.sch_id=?";
        $this->conn->query($query);
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $sessionid, PDO::PARAM_INT); 
				$this->conn->bind(3, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
					//echo count($output);
            $sessOutput ='';
            $classOutput = '';
          //output elements to help select session and class to be promoted to
          //ouput table headers below here
          echo '<p  class="mb-3" ><a id="loadClassSettings" href="promotedClassSettings.php" class="btn btn-info"><i class="fa fa-bars" aria-hidden="true"></i> Choose Promotion Information </a></p>
          <p id="promotionSettings"></p>';
					$printOutput = " ";
          $printOutput.= "<table class='table'>";
          $printOutput.="<tr>
          <th>Student Name</th>
          <th>Current Class</th>
          <TH>Annual Total</th>
          <TH>Annual Average</th>
          <TH>Annual Position</th>
          <TH>Promote</th>
          <TH>Print</th>
          </tr>";
					foreach($output as $row => $key)
					{
            //Promotional status
            $studentID = $key['StudentID'];
            $studentName = $key['Fullname'];
            $className = $key['ClassName'];
            $cumTotal = $this->annualTotals($studentID,$classid,$sessionid,$schoolid);
            $av = $this->annualAverage($studentID,$classid,$sessionid,$schoolid);
            //check promotion status
                        if($key['PromotionStatus'] =='On'){
                        $promotion_status = '<button type="button" data-studentid="'.$key['StudentID'].'" data-recordid="'.$key['ID'].'" class="approvedBtn" id="unpromote">Unpromote</button>';
                        }else{
                        $promotion_status= '<button type="button" data-studentid="'.$key['StudentID'].'"  data-recordid="'.$key['ID'].'" class="not-approvedBtn" id="promote">Promote</button>';
                        }
						$printOutput.='<tr>';
            $printOutput.='<td>'.$studentName.'</td>';
            $printOutput.='<td>'.$className.'</td>';
            $printOutput.='<td>'.$cumTotal.'</td>';
            //$printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
            $printOutput.='<td>'.$av.'</td>';
            $printOutput.='<td>'.$this->getAnnualPosition($studentID,$classid,$sessionid,$schoolid).'</td>';
            $printOutput.='<td>'.$promotion_status.'</td>';
            $printOutput.='<td><a href="annualResultSheet.php?studentid='.$studentID.'&class='.$classid.'&session='.$sessionid.'&schoolid='.$schoolid.'" target="_blank" class="btn btn-success" id="result-link"><i class="fa fa-print" aria-hidden="true"></i> Print</a></td>';
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
public function insertPromotionDetails($studid,$class,$sessionid,$staffid,$schid)
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
public function removePromotionDetails($studentid,$class,$session,$schid)
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
public function promoteStudent($studentid,
  $recordid,$class,$sessionid,$schid,
  $staffid,$promotionStatus="On")
  {
      
        try {
                            $query ="SELECT * FROM student_class WHERE student_id =?
                            AND stud_sess_id=? AND stud_class=? AND stud_school_id=?";
                            $this->conn->query($query);
                            $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                            $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $class, PDO::PARAM_INT);
                            $this->conn->bind(4, $schid, PDO::PARAM_INT);
                            $output = $this->conn->resultset();
                            if($output && $this->conn->rowCount()>=1){
                              exit("This student exist in this class");
                            }else{
                              $query ="SELECT * FROM student_class WHERE student_id =?
                              AND stud_sess_id=?  AND stud_school_id=?";
                              $this->conn->query($query);
                              $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                              $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                              $this->conn->bind(3, $schid, PDO::PARAM_INT);
                              $output = $this->conn->resultset();
                                      if($output && $this->conn->rowCount()>=1){
                                        exit("This student has promotion for this session already");

                                      }else{
                                          
                                            $sqlStmt = "UPDATE annual_result SET promotion_status=? WHERE id=? AND sch_id=?";
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
public function unpromoteStudent($studentid,$recordid,$class,
  $sessionid,$schid,$staffid,
  $promotionStatus="Off")
  {
      
        try {

                        $sqlStmt = "UPDATE annual_result SET promotion_status=? WHERE id=? AND sch_id=?";
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

public function submitSummary($classid,$termid,$sessionid,$schoolid)
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
public function classPosition($termid,$sessionid,$classid,$schid)
    { 
      try
      {
        //check for locked result

        //TODO: 
        //1 DO NOT SELECT TERM TOTAL FROM TEMP TABLES BUT SUM AGGREGATE FROM PHYSICAL TABLE
        //2. SELECT AND GROUP TOTAL SCORES BY STUDENT ID
        //3. ORDER RESULT BY TOTAL IN DESC
      $this->lockResult($classid,$schid);
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
              $lastKey = $this->endKey($arr);

                    for($i=0; $i < count($arr); $i++)
                    {
                    //check for initial occurences of the array value
                    $frequencyOfValue = $occurences[$scores_value];
                        if($frequencyOfValue >= 2)
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
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                    exit("Class position assigned successfully");
                                  }
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
                            //$scores_value = next($arr);
                            //$studentid = key($arr);
                            $frequencyOfValue = $occurences[$scores_value];
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
                                  //check for end of array
                                  if($lastKey == $studentid)
                                  {
                                    exit("Class position assigned successfully");
                                  }
                                $scores_value = next($arr);
                                $studentid = key($arr);
                                $classPosition+=1;
                                $frequencyOfValue = $occurences[$scores_value];
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
public function gradingScores($num)
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

//SINGLE GRADE EG A
public function singleGrade($num)
  {
    // if(!is_int($num) || !is_double($num) || !is_float($num))
    // {
    //   return $printOutput ="NA";
    // }
    // else{
    $put =" ";
    //Grades
    $a = "A";
    $b = "B";
    $c = "C";
    $d = "D";
    $e = "E";
    //Rating
    // $good = "Good";
    // $poor = "Poor";
    // $fair ="Fair";
    // $vgood = "Very Good";
    // $excellent = "Excellent";
    $notdefined = "NA";
    switch(TRUE)
    {
      case($num <= 39):
      return $put=$e;
      break;

      case($num >= 40 && $num <=54.9):
      return $put=$d;
      break;

      case($num >= 55 && $num <=64.9):
      return $put=$c;
      break;

      case($num >= 65 && $num <=74.9):
      return $put=$b;
      break;

      case($num >= 75 && $num <=100):
      return $put=$a;
      break;

      default:
      return $put=$notdefined;
      break;
    }
  //}
}
//END SINGLE GRADE

//Subject Compare method

public function subjectCmp($string)
  {
    $notdefined="NA";
    $printOutput =" ";
    switch(TRUE)
    {
      case(strcasecmp($string,'English Language')==0):
      return $printOutput='ENG';
      break;

      case(strcasecmp($string,'Mathematics')==0):
      return $printOutput='MATHS';
      break;

      case(strcasecmp($string,'Basic Science & Technology')==0):
      return $printOutput='BST';
      break;

      case(strcasecmp($string,'Pre-Vocational Studies')==0):
      return $printOutput='PVS';
      break;

      case(strcasecmp($string,'Cultural & Creative Arts')==0):
      return $printOutput='CCA';
      break;

      //
      case(strcasecmp($string,'French')==0):
      return $printOutput='FR';
      break;

      case(strcasecmp($string,'Business Studies')==0):
      return $printOutput='BUS STD';
      break;

      case(strcasecmp($string,'Religion & National Values')==0):
      return $printOutput='RNV';
      break;

      case(strcasecmp($string,'Computer Studies')==0):
      return $printOutput='CMP SC';
      break;

      case(strcasecmp($string,'Christian Religious Studies')==0):
      return $printOutput='CRS';
      break;
      //
      case(strcasecmp($string,'Civic Education')==0):
      return $printOutput='CE';
      break;

      case(strcasecmp($string,'Animal Husbandry')==0):
      return $printOutput='AH';
      break;

      case(strcasecmp($string,'Physics')==0):
      return $printOutput='PHY';
      break;

      case(strcasecmp($string,'Chemistry')==0):
      return $printOutput='CHEM';
      break;

      case(strcasecmp($string,'Biology')==0):
      return $printOutput='BIO';
      break;
      //
      case(strcasecmp($string,'Agricultural Science')==0):
      return $printOutput='AGRIC';
      break;

      case(strcasecmp($string,'Economics')==0):
      return $printOutput='ECONS';
      break;

      case(strcasecmp($string,'Government')==0):
      return $printOutput='GVT';
      break;

      case(strcasecmp($string,'Commerce')==0):
      return $printOutput='COMM';
      break;

      case(strcasecmp($string,'Financial Accounting')==0):
      return $printOutput='FIN ACCT';
      break;
      //
      case(strcasecmp($string,'Literature-in-English')==0):
      return $printOutput='LIT';
      break;

      case(strcasecmp($string,'Further Mathematics')==0):
      return $printOutput='F MATHS';
      break;

      case(strcasecmp($string,'Geography')==0):
      return $printOutput='GEO';
      break;

    
      default:
      return $printOutput=$notdefined;
      break;
    }
  //}
}
//end subject compare method

//Method to print school Profile
public function schoolProfileHeader($clientid)
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
          INNER JOIN city ON institutional_signup.inst_city_id = city.id
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
                      $Web = strtolower($key['WebAddress']);
                      $Email= strtolower($key['Email']);
                      //$streetAdd = $key['StreetAdd'];
                      $mailBox = ucwords($key['PostOffice']);
                      $cityStateCountry = ucwords($key['CityStateCountry']);
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
  
              // if(empty($streetAdd)){
  
              // }else{
              //   $printOutput.='<span><i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>
              //     '.$streetAdd.'</span>';
              // }  
  
              if(empty($mailBox)){
  
              }else{
                $printOutput.='<span><i class="fa fa-fax" aria-hidden="true"></i>
              '.$mailBox.'</span>';
              }
  
              if(empty($cityStateCountry)){
  
              }else{
                $printOutput.='<span><i class="fa fa-globe fa-fw" aria-hidden="true"></i>
              '.$cityStateCountry.'</span>';
              }
  
              if(empty($Mobile)){
  
              }else{
                $printOutput.='<span><i class="fa fa-phone fa-fw" aria-hidden="true"></i>
  
            '.$Mobile.'</span>';
              }
              if(empty($Email)){
  
              }else{
              $printOutput.='<span><i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
              '.$Email.'</span>';
              }
              
              if(empty($Web)){
  
              }else{
                $printOutput.='<span><i class="fa fa-link fa-fw" aria-hidden="true"></i>
              '.$Web.'</span>';
              }
  
            echo $printOutput;
          }//End of try catch block
           catch(Exception $e)
          {
              echo "Error:". $e->getMessage();
          }
        }

        //END SCHOOL LOGO ONLY
//Staff subject sign
public function staffSign($classid,$subjectid,$schid)
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
      $null ="Error";
          if($output && $this->conn->rowCount() >=1)
          {
					foreach($output as $row => $key)
					{
					$fullname = $key['Fullname'];
					//$arr.= '<td>'.$fullname.'</td>';
          $arr = $fullname;
					}	
					//$arr.='</tr><br>';
          return $arr;
        }
        else{
            return $null;
        }	
          }//End of try catch block
         catch(Exception $e)
          {
            echo "Error:". $e->getMessage();
          }
	  }
//End staff subject sign

//Staff profile card method used on the staff profile page
public function staffProfileCard($clientid,$userid)
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
                                $printOutput.='<div class="card">
                                <div class="img-div">
                                  <img src="../images/bg.jpg" alt="background image" style="width:100%">';
                                  $printOutput.=$logoPrint;
                                  $printOutput.='</div>';
                                  $printOutput.='<div class="card-container">';
                                  $printOutput.='<h5>'.$fullname.'</h5>';
                                  $printOutput.='<p class="title">'.$role.'</p>';
                                  $printOutput.='</div></div>';
                              }
                         else{

                                  $fullname = 'ScoreSheet';
                                  $printOutput.='<div class="card">
                                  <div class="img-div">
                                  <img src="../images/bg.jpg" alt="background image" style="width:100%">';
                                  $printOutput.='<img src="../images/profile-icon.png" alt="Staff Avatar" class="bg-image"></>';
                                  $printOutput.='</div>';
                                  $printOutput.='<div class="card-container">';
                                    $printOutput.='<h6 class="staff-profile-header">'.$fullname.'</h6>';
                                    $printOutput.='<p class="title">Staff</p>';
                                    $printOutput.='</div></div>';

                    }
                    echo $printOutput;
            }// End of try catch block
         catch(Exception $e)
            {
            echo ("Error: Unable to fetch staff Profile");
            }
        }


//EDIT EXAMS  SCORES
public function editTerminalExam($score,$subj,$class,$staffid,$recordid,$schid)
  {
      // always use try and catch block to write code
       //validate scores
       $this->validateScores($score);
      //check for locked result
      $this->lockResult($class,$schid);
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
public function reloadExam($class,$subject,$schid)
  {
        //Try and Catch block
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
                        $ID = $key['ExamRecordID'];
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['ExamScores'].'</td>';
                        $printOutput.='<td><button type="button" data-classid="'.$class.'" data-sessionid="'.$sessionid.'"data-subjectid="'.$subject.'" data-term="'.$termid.'" data-examrecordid="'.$ID.'" data-scores="'.$key['ExamScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" class="btn btn-danger btn-sm" id="deleteExam"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button>
                        </td>'; 
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
public function reloadCa($class,$subject,$schid)
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
             && ass_subject_id=? ORDER BY Fullname,Subject,caTitle,Term";
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
                          $ID = $key['caRecordid'];
                        $printOutput.='<tr>';
                        $printOutput.='<td>'.$ci.'</td>';
                        $printOutput.='<td>'.$key['Fullname'].'</td>';
                        $printOutput.='<td>'.$key['ClassName'].'</td>';
                        $printOutput.='<td>'.$key['Session'].'</td>';
                        $printOutput.='<td>'.$key['Term'].'</td>';
                        $printOutput.='<td>'.$key['Subject'].'</td>';
                        $printOutput.='<td>'.$key['caTitle'].'</td>';
                        $printOutput.='<td>'.$key['CaScores'].'</td>';
                        $printOutput.='<td><button type="button"  data-CAid="'.$ID.'" data-scores="'.$key['CaScores'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</button>
                        <button type="button"  data-deleteid="'.$ID.'" data-myclass="'.$class.'"  data-mysubj="'.$subject.'" class="btn btn-danger btn-sm" id="deleteCa"><i class="fa fa-trash" aria-hidden="true"></i>Remove</button>     </td></tr>'; 
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
public function editCa($score,$subj,$class,$staffid,$recordid,$schid)
  {
      // always use try and catch block to write code
      //Check for approved

      //validate scores
      $this->validateScores($score);
      //lock result
      $this->lockResult($class,$schid);
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
       //check for locked results
      $this->lockResult($classid,$schoolid);
      $termid = $this->getActiveTerm($schoolid);
      $sessionid = $this->getActiveSession($schoolid);
         
        $query ="SELECT classpositionals.student_id AS StudentID,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
        FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=? ORDER BY Fullname";
        $this->conn->query($query);
        //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
        $this->conn->bind(1, $classid, PDO::PARAM_INT); 
        $this->conn->bind(2, $termid, PDO::PARAM_INT);
        $this->conn->bind(3, $sessionid, PDO::PARAM_INT); 
        $this->conn->bind(4, $schoolid, PDO::PARAM_INT);
        $output = $this->conn->resultset(); 
        if($this->conn->rowCount() >= 1)
            {
          $printOutput = " ";
        
          $printOutput.= "<table class='table'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <TH>Obtained Scores</TH>
          <TH>Max Scores</th>
          <TH>Avg</th>
          <TH>Position</th>
          <TH>Action</th>
          </tr>";
				  $ci=1;
          foreach($output as $row => $key)
          {
                   
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          
              $studentID = $key['StudentID'];
              $studentName = $key['Fullname'];
              $cumTotal = $this->grandTotals($studentID,$classid,$sessionid,$termid,$schoolid);
              $av = $this->terminalAverage($studentID,$classid,$sessionid,$termid,$schoolid);
              //check promotion status                  
              //$printOutput.='<tr>';
              $printOutput.='<td>'.$studentName.'</td>';
              $printOutput.='<td>'.$cumTotal.'</td>';
              $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
              $printOutput.='<td>'.$av.'</td>';
              $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
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
public function newAffectiveDomain($domain,$rating,$studentid,$schid,$staffid,$date)
  {
  // always use try and catch block to write code
       try {  
         //check for locked result
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    $query ="SELECT  id  FROM stud_affective_skills WHERE domain_id =?
                    AND termid=? AND sessionid=? AND studentid=? AND schid=?";
                    $this->conn->query($query);
										$this->conn->bind(1, $domain, PDO::PARAM_INT);
										$this->conn->bind(2, $termid, PDO::PARAM_INT);
                    $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(4, $studentid, PDO::PARAM_INT);
                    $this->conn->bind(5, $schid, PDO::PARAM_INT);
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
public function newPsychomotorSkills($domain,$rating,$studentid,$schid,$staffid,$date)
  {
  // always use try and catch block to write code
       try {

                    //ADD MAX OF THREE CA'S PER SUBJECT
                    $termid = $this->getActiveTerm($schid);
                    $sessionid = $this->getActiveSession($schid);
                    //Check for the number of CA added
                    $query ="SELECT  id  FROM stud_psychomotor_skills WHERE psycho_domain=?
                    AND termid=? AND sessionid=? AND studentid=? AND schid=?";
                    $this->conn->query($query);
										$this->conn->bind(1, $domain, PDO::PARAM_INT);
										$this->conn->bind(2, $termid, PDO::PARAM_INT);
                    $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                    $this->conn->bind(4, $studentid, PDO::PARAM_INT);
                    $this->conn->bind(5, $schid, PDO::PARAM_INT);
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
public function studentDaysAttended($classid,$days,$studentid,$schid,$staffid,$date)
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
public function reloadAffectiveTraits($studentid,$schid)
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
             stud_affective_skills.studentid=? AND stud_affective_skills.termid=? AND stud_affective_skills.sessionid=?
             AND stud_affective_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
          $this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $termid, PDO::PARAM_INT);
          $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(4, $schid, PDO::PARAM_INT);
          $myResult= $this->conn->resultset();

                        //loop through the result
                       if($this->conn->rowCount() == 0)
                        {
                        exit("No added affective traits seen!");
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
public function reloadEnrolledStudents($class,$schid)
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


//REMOVE CA ITEM FROM DB
public function deleteCaItem($id)
   {
                 try {
          					     //Remove student when supplied with class id
                            $sqlStmt = "DELETE  FROM assessment WHERE id=?";
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
                        		echo "Error removing CA item";
                      			}

                    		}

        catch(Exception $e)
        {
        echo "Error:". $e->getMessage();
      }
    }
//END REMOVE CA ITEM FROM DB


//REMOVE EXAM
public function deleteExamItem($id)
   {
                 try {
          					     //Remove student when supplied with class id
                            $sqlStmt = "DELETE  FROM terminal_exam WHERE id=?";
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
                        		echo "Error removing EXAM item";
                      			}

                    		}

        catch(Exception $e)
        {
        echo "Error:". $e->getMessage();
      }
    }
//END REMOVE EXAM



//REMOVE ENROLLED STUDENT
public function deleteEnrolledStudent($id)
   {
      
                 try {

          					     //Remove student when supplied with class id
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

//Reload psychomotor skills added for a particular student
public function reloadPsychomotorSkills($studentid,$schid)
  {
  //Try and Catch block
   try
        {
           $termid = $this->getActiveTerm($schid);
           $sessionid = $this->getActiveSession($schid);
  			   $query ="SELECT stud_psychomotor_skills.id AS Skills_ID,psychomotor_skills.description AS Description, rating_system.description AS Rating
             FROM stud_psychomotor_skills 
             INNER JOIN psychomotor_skills ON psychomotor_skills.id=stud_psychomotor_skills.psycho_domain
             INNER JOIN rating_system ON rating_system.id=stud_psychomotor_skills.rating
             WHERE 
             stud_psychomotor_skills.studentid=? AND stud_psychomotor_skills.termid=? AND stud_psychomotor_skills.sessionid=?
             AND stud_psychomotor_skills.schid=?";
          $this->conn->query($query);
          $this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $termid, PDO::PARAM_INT);
          $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(4, $schid, PDO::PARAM_INT);
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
public function deleteAffectiveTraits($id)
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


//Remove student Psycho skills
public function deletePsychoSkills($id)
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
public function newStaffComment($studentid,$comment,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
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





//Add Head teacher's comment
public function newAdminComment($studentid,$comment,$schid)
  {
      $studentClass = $this->studentClassID($studentid,$schid);
      $this->lockResult($studentClass,$schid);
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      
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
public function commentSummary($classid,$termid,$sessionid,$schoolid)
	    {
		 try {
       //check for locked result
      $this->lockResult($classid,$schoolid);
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
          $printOutput.= "<table class='table table-responsive'>";
          $printOutput.="<tr>
          <th>S/NO</th>
          <th>Student Name</th>
          <th>Class</th>
          <th>Term</th>
          <TH>Session</th>
          <TH>Cum</th>
          <TH>Avg</th>
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
            $myStudID = $key['recordID'];
          $av = $this->terminalAverage($myStudID,$classid,$sessionid,$termid,$schoolid);
          $printOutput.='<tr>';
          $printOutput.='<td>'.$ci.'</td>';
          $printOutput.='<td>'.$key['Fullname'].'</td>';
          $printOutput.='<td>'.$key['ClassName'].'</td>';
          $printOutput.='<td>'.$key['TermName'].'</td>';
          $printOutput.='<td>'.$key['SessionName'].'</td>';
          $printOutput.='<td>'.$key['cumTotal'].'</td>';
          $printOutput.='<td>'.$av.'</td>';
          $printOutput.='<td>'.$this->ordinalSuffix($key['Position']).'</td>';
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
public function isAffectiveDomain($studentid,$schid)
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
public function isPsychomotorSkills($studentid,$schid)
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

//RESET PUBLISH FINAL RESULT
public function undoPublishFinalResult($class,$term,$session,$schid)
    {
      //check locked  reult
      $this->lockResult($class,$schid);
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);

      try {
        $null="";

                        $sqlStmt = "UPDATE classpositionals SET published_status=? WHERE class_id=? AND term_id=? AND session_id=? AND school_id=?";
                          $this->conn->query($sqlStmt);
                          $this->conn->bind(1, $null, PDO::PARAM_STR,12);
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
                          echo "Error reset published result";
                          }

                      }

      catch(Exception $e)
      {
      //echo error here
      //this get an error thrown by the system
      echo "Error:". $e->getMessage();
      
    }
}
//END RESET PUBLISH FINAL RESULT

//Publish Final Result by staff
public function publishFinalResult($class,$term,$session,$schid,$status="Yes")
  {
    //Check for locked result
    $this->lockResult($class,$schid);
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
public function resultDetails($studentid,$classid,$termid,$sessionid,$schoolid)
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
          $caMaxScore = $this->getMaxCaScores($classid,$schoolid);
          $examMaxScore = $this->getMaxExamScores($classid,$schoolid);
          $totalCA = 3*$caMaxScore;
          $totalExam = $totalCA + $examMaxScore;
            
          $printOutput.= "<table class='examtable-print'>";
          $printOutput.='<tr>
          <th>Subject Name</th>
          <th>1st CA '.$caMaxScore.'%</th>
          <th>2nd CA '.$caMaxScore.'%</th>
          <TH>3rd CA '.$caMaxScore.'%</th>
          <TH>CA Total '.$totalCA.'%</th>
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
// End of result details method

//METHOD TO LIST SUBJECT BASED ON STUDENT  CLASS
/**
 * This method list ssubjects headers for the termly summary Result Sheet
 */
public function listSubjectSummary($classid,$termid,$sessionid,$schoolid){
  try {
    $query ="SELECT DISTINCT 
    subjects.subject_name AS subjectName,
    subjects.sub_id AS SubjectID
    FROM subjects INNER JOIN subjecttotals ON subjecttotals.subject_id=subjects.sub_id
    WHERE 
    subjecttotals.class_id=? AND subjecttotals.session_id=?
    AND subjecttotals.term_id=?  AND subjecttotals.sch_id=? ORDER BY SubjectID ASC";
    
    $this->conn->query($query);
    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
    $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
    $this->conn->bind(3, $termid, PDO::PARAM_INT); 
    $this->conn->bind(4, $schoolid, PDO::PARAM_INT);
    $output = $this->conn->resultset();
    $secondRowContent = $output;
    if($this->conn->rowCount()>=1)
    {
      //loop through thr result and  display column headers
      $returnOuput="";
      $returnOuput.='<tr>';
      $returnOuput.='<th></th>';
      foreach($output as $row => $key)
      {
        $subjectName = $key['subjectName'];
        $returnOuput.='<th colspan="3">'.$this->subjectCmp($subjectName).'</th>'; 
      }
      $returnOuput.='<th colspan="4">Summary</th></tr>'; 
        //create a second row based on the number of subjects available
        $returnOuput.='<tr>';
        $returnOuput.='<th>Name</th>';
          foreach($secondRowContent as $row => $key){
            $returnOuput.='<th>T</th>';
            $returnOuput.='<th>P</th>';
            $returnOuput.='<th>G</th>';
            }
            $returnOuput.='<th>Total</th>';
            $returnOuput.='<th>Av</th>';
            $returnOuput.='<th>Pos</th>';
            $returnOuput.='<th>Rmks</th></tr>';
      return $returnOuput;
    }
  }
  catch(Exception $e)
      {
        echo "Error:". $e->getMessage();
      }
}
//END METHOD TO LIST SUBJECT BASED ON STUDENT CLASS

//STUDENT ANNUAL SUMMARY  RESULT
public function studentAnnualResultSummary($studentid,$classid,$sessid,$schid)
  {
  try {
    $query ="SELECT DISTINCT 
    subjects.subject_name AS subjectName,
    subjects.sub_id AS SubjectID
    FROM subjects INNER JOIN subjecttotals ON subjecttotals.subject_id=subjects.sub_id
    WHERE 
    subjecttotals.class_id=? AND subjecttotals.student_id=?
    AND subjecttotals.sch_id=? ORDER BY SubjectID ASC";
    $this->conn->query($query);
    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
    $this->conn->bind(2, $studentid, PDO::PARAM_INT);
    $this->conn->bind(3, $schid, PDO::PARAM_INT);
    $output = $this->conn->resultset();
    if($this->conn->rowCount()>=1)
    {
      //loop through the result and  display column headers
      $returnOuput="";
      $returnOuput.='<table class="asstable-print">';
      $returnOuput.='<tr>';
      $returnOuput.='<th>Subject</th>';
      $returnOuput.='<th>First Term</th>';
      $returnOuput.='<th>Second Term</th>';
      $returnOuput.='<th>Third Term</th>';
      $returnOuput.='<th>Total</th>';
      $returnOuput.='<th>class Average</th>';
      $returnOuput.='<th>Subject Position</th></tr>'; 
      //create a second row based on the number of subjects available

          foreach($output as $row => $key)
          {
            $subjName = $key['subjectName'];
            $subjID = $key['SubjectID'];
            $subj_Total_1 = $this->subjectTotals($studentid,$subjID,$classid,$sessid,1,$schid);
            $subj_Total_2 = $this->subjectTotals($studentid,$subjID,$classid,$sessid,2,$schid);
            $subj_Total_3 = $this->subjectTotals($studentid,$subjID,$classid,$sessid,3,$schid);
            $yrlySubjTotal = $this->yearlySubjectTotals($studentid,$subjID,$classid,$sessid,$schid);
            $yrlyAv = $this->annualSubjectAverage($subjID,$classid,$sessid,$schid);
            $yrlySubjPos = $this->getAnnualSubjPosition($studentid,$subjID,$classid,$sessid,$schid);
            //$grade = $this->singleGrade($yrlySubjTotal);
            
            $returnOuput.='<tr>';
            $returnOuput.='<td>'.$subjName.'</td>';
            $returnOuput.='<td>'.$subj_Total_1.'</td>';
            $returnOuput.='<td>'.$subj_Total_2.'</td>';
            $returnOuput.='<td>'.$subj_Total_3.'</td>';
            $returnOuput.='<td>'.$yrlySubjTotal.'</td>';
            $returnOuput.='<td>'.$yrlyAv.'</td>';
            $returnOuput.='<td>'.$yrlySubjPos.'</td></tr>';
          }
          $returnOuput.='</table>';
      echo $returnOuput;
    }
  }
  catch(Exception $e)
      {
        echo "Error:". $e->getMessage();
      }
}
//END STUDENT ANNUAL SUMMARY RESULT

//Retrieve Affecctive ratings
public function resultAffectiveTraits($studentid,$schid)
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
             stud_affective_skills.studentid=? AND stud_affective_skills.termid=? AND stud_affective_skills.sessionid=?
             AND stud_affective_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $termid, PDO::PARAM_INT);
          $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(4, $schid, PDO::PARAM_INT);
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
public function resultPsychomotorSkills($studentid,$schid)


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
             stud_psychomotor_skills.studentid=? AND stud_psychomotor_skills.termid=? AND stud_psychomotor_skills.sessionid=?
             AND stud_psychomotor_skills.schid=?";
          $this->conn->query($query);
          //$this->conn->bind(1, $studentID, PDO::PARAM_INT);
					$this->conn->bind(1, $studentid, PDO::PARAM_INT);
          $this->conn->bind(2, $termid, PDO::PARAM_INT);
          $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
          $this->conn->bind(4, $schid, PDO::PARAM_INT);
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
public function keyToRatings()
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



//Student Avatar generator
public function studentAvatar($studentid,$schid)
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
					
					$printOutput = " ";
					foreach($output as $row => $key)
					{
            $studentName = $key['Fullname'];
            $initial = strtoupper(substr($studentName, 0, 1));
            $Image = $key['Image'];
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
public function schoolAvatar($schid)
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
          <h5><img src="'.$Image.'" alt="" class="logo-img"></h5>
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
public function isSubjectTeacher($staff_id,$subjectid,$class_id,$schid)
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
                      exit("Sorry! You don't have access to work on the selected class/subject");
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

    //Test whether a student is a member of a class 
    function isStudentClass($studid,$class_id,$schid)
    {
    //always use try and catch block to write code
    try{
    //find the subject teacher
      $sessionid = $this->getActiveSession($schid);
                  $query ="SELECT id FROM student_class 
                  WHERE student_id=? 
                  AND stud_class=? 
                  AND stud_sess_id=? 
                  AND stud_school_id=?";
                  $this->conn->query($query);
                   $this->conn->bind(1, $studid, PDO::PARAM_INT);
                  $this->conn->bind(2, $class_id, PDO::PARAM_INT);
                  $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(4, $schid, PDO::PARAM_INT);
                  $this->conn->execute();
                  //$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  if ($this->conn->rowCount() == 0)
                  {
                    exit("Sorry! This student is not a member of this class or has not been enrolled in class yet");
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
  //




//View Published results
function findPublishedResult($classid,$schoolid,$status='Yes')
	    {
		 try {
      $termid = $this->getActiveTerm($schoolid);
      $sessionid = $this->getActiveSession($schoolid);
        $query ="SELECT classpositionals.student_id AS StudentID,
        CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname,
        class.class_name AS ClassName,
        sch_term.term AS TermName
        FROM classpositionals INNER JOIN student_initial ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id 
        WHERE classpositionals.class_id=? AND 
        classpositionals.term_id=? AND classpositionals.session_id=?
        AND classpositionals.school_id=? AND classpositionals.published_status=? ORDER BY Fullname";
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
          <TH>Cum Total</th>
          <TH>Avg</th>
          <TH>Position</th>
          <TH>Action</th>
          </tr>";
				  $ci=1;
          foreach($output as $row => $key)
          {
          
              $studentID = $key['StudentID'];
              $studentName = $key['Fullname'];
              $classname = $key['ClassName'];
              $termname = $key['TermName'];
              $cumTotal = $this->grandTotals($studentID,$classid,$sessionid,$termid,$schoolid);
              $av = $this->terminalAverage($studentID,$classid,$sessionid,$termid,$schoolid);
              //check promotion status                  
              $printOutput.='<tr>';
              $printOutput.='<td>'.$ci.'</td>';
              $printOutput.='<td>'.$studentName.'</td>';
              $printOutput.='<td>'.$classname.'</td>';
              $printOutput.='<td>'.$termname.'</td>';
              $printOutput.='<td>'.$cumTotal.'</td>';
              $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
              $printOutput.='<td>'.$av.'</td>';
              $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
          $printOutput.='<td><button type="button"  data-recordid="'.$key['StudentID'].'" class="btn btn-info btn-sm" id="newbtn"><i class="fa fa-plus" aria-hidden="true"></i>Add comments</button></td>';
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

public function resultForApproval($classid,$termid,$sessionid,$schoolid)
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
public function approveResult($class,$term,$session,$schid,$approve="Yes")
  {
      //always use try and catch block to write code
      //$termid = $this->getActiveTerm($schid);
      //$sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);
        try {

                          $sqlStmt = "UPDATE classpositionals SET approval_status=? WHERE class_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $approve, PDO::PARAM_STR);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $term, PDO::PARAM_INT);
                            $this->conn->bind(4, $session, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() >= 1)
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
public function disapproveResult($class,$term,$session,$schid,$approve="")
  {
        try {

                          $sqlStmt = "UPDATE classpositionals SET approval_status=? WHERE class_id=? AND term_id=? AND session_id=? AND school_id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $approve, PDO::PARAM_INT);
                            $this->conn->bind(2, $class, PDO::PARAM_INT);
                            $this->conn->bind(3, $term, PDO::PARAM_INT);
                            $this->conn->bind(4, $session, PDO::PARAM_INT);
                            $this->conn->bind(5, $schid, PDO::PARAM_INT);
                            $this->conn->execute();
                        		if ($this->conn->rowCount() >= 1)
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

public function maxScoresAvailable($classid,$schid)
	{
		
		try {

			/*
			1. Find the total number of subjects offered by a particular class
      2. Multiply the number by 100 to have the total maximum scores available 

      NOTE: USE THE NEW TABLES CREATED FOR class_category_subject AND class
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
public function classTeacher($classid,$schid)
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
//Display  the generated list on select
public function activeSession($clientid,$status="Active")
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


//Method to get active term name
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
public function adminUser($userid,$schid)
  {
    
    switch(TRUE)
    {
      case($userid == 2 || $userid == 3):
    
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
public function staffUser($userid,$schid)
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
public function clientUser($userid,$schid)
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
     foreach ($myResult as $row => $key) 
      {
      $ID = $key['ID'];
      }
     return $ID;
     }// End of try catch block
     catch(Exception $e)
     {
    echo "Error: Unable to load class teacher ID";
      }
    }
//END METHOD TO GET CLASS TEACHER'S CLASS ID

//GET STUDENT CLASS ID
public function studentClassID($studentid,$schid)
      {
        try {
          $sessionid = $this->getActiveSession($schid);
              $query ="SELECT stud_class AS ID FROM student_class
              WHERE student_id=? AND stud_sess_id=? AND stud_school_id=?";
                  $this->conn->query($query);
                  $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                  $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
                  $this->conn->bind(3, $schid, PDO::PARAM_INT);
                  $myResult = $this->conn->resultset();
                $output =" "; 
          foreach ($myResult as $row => $key) 
            {
            $ID = $key['ID'];
            }
          return $ID;
          }// End of try catch block
          catch(Exception $e)
          {
          echo "Error: Can not fetch student ID";
          }
      }
//END GET STUDENT CLASS ID


//METHOD TO LIST NEWLY ADMITTED STUDENTS FOR ENROLLMENT
public function enrollmentRoll($staffid,$clientid)
  {
      try {
        $classid = $this->classTeacherClassID($staffid,$clientid);
        $sessionid = $this->getActiveSession($clientid);
        $query ="SELECT student_initial.id AS ID, CONCAT(UPPER(student_initial.surname), ' ', student_initial.firstName) AS fullname, class.class_name AS ClassName, session.session AS SessionName FROM 
        student_initial
        INNER JOIN class ON student_initial.classAdmitted=class.id
        INNER JOIN session ON student_initial.sessionAdmitted=session.id
        WHERE student_initial.stud_sch_id=? AND student_initial.sessionAdmitted=? AND student_initial.classAdmitted=? AND student_initial.id NOT IN 
        (SELECT student_id FROM student_class WHERE stud_class=? AND stud_sess_id=? AND stud_school_id=?)";

            $this->conn->query($query);
            $this->conn->bind(1, $clientid, PDO::PARAM_INT); 
            $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
            $this->conn->bind(3, $classid, PDO::PARAM_INT);
            $this->conn->bind(4, $classid, PDO::PARAM_INT);
            $this->conn->bind(5, $sessionid, PDO::PARAM_INT);
            $this->conn->bind(6, $clientid, PDO::PARAM_INT);
            $output=" ";
            $myResult = $this->conn->resultset();
            $output.="<h5 class='top-header mt-2'>All New Students</h5><br/>";
            $output .='<table class="table">';
            $output .='<thead>
            <tr><th>FullName</th><th>Class</th><th>Session</th<th>Action</th></tr>
            </thead>
            <tbody>';
            if($myResult){
                //CONCAT(staff_profile.surname, ', ', staff_profile.middle_name, ' ', staff_profile.lastname) AS FullName,
            foreach ($myResult as $row => $key) 
              {
                 
                  $fullname = $key['fullname'];
                  $class = $key['ClassName'];
                  $session = $key['SessionName'];
                  $output.= '<tr>';
                  $output.='<td>'.$fullname.'</td>';
                  $output.='<td>'.$class.'</td>';
                  $output.='<td>'.$session.'</td>';
                  $output.='<td><button type="button" data-studentid="'.$key['ID'].'" class="btn btn-info btn-sm" id="mystud-enroll"><i class="fa fa-user fa-fw" aria-hidden="true"></i> Enroll</button></td>';
                  $output.='</tr>';
            }
            $output.=' </tbody></table>';
            echo $output;
            }
            else{
                echo "No new student yet!";
            }
            
          }// End of try catch block
          catch(Exception $e)
          {
              echo ("Error: Unable to fetch  new students!");
          }
}
//END METHOD TO LIST NEWLY ADMITTED STUDENT FOR ENROLLMENT


//
//METHOD TO GET SESSION NAME
public function getSessionName($schid,$sess)
        {
          //always use try and catch block to write code
          try{
                //SELECT THE ID OF THE ACTIVE SESSION BASED ON THE INSTITUTION
                  $sqlStmt = "SELECT session.session AS SessionName FROM session WHERE sess_inst_id=? AND id=?";
                  $this->conn->query($sqlStmt);
                  $this->conn->bind(1, $schid, PDO::PARAM_INT);
                  $this->conn->bind(2, $sess, PDO::PARAM_INT);
                  $myResult = $this->conn->resultset();
                      if ($this->conn->rowCount() == 1)
                        {
                          //loop through the result set
                          foreach ($myResult as $row => $key)
                          {
                              $sessName = $key['SessionName'];
                          }
                          // retrun the ID  OF THE STUDENT
                          return $sessName;
                      }
                                else
                                {
                                exit("No session Selected");
                                }
              }

                catch(Exception $e)
                {
                //echo error here
                //this get an error thrown by the system
                echo "Error:". $e->getMessage();
                }
        }

        ///

        //METHOD TO GET TERM NAME

public function getTermName($schid,$termid)
        {
          //always use try and catch block to write code
          try{
                //SELECT THE ID OF THE ACTIVE SESSION BASED ON THE INSTITUTION
                  $sqlStmt = "SELECT term AS TermName FROM sch_term WHERE term_inst_id=? AND term_id=?";
                  $this->conn->query($sqlStmt);
                  $this->conn->bind(1, $schid, PDO::PARAM_INT);
                  $this->conn->bind(2, $termid, PDO::PARAM_INT);
                  $myResult = $this->conn->resultset();
                      if ($this->conn->rowCount() == 1)
                        {
                          //loop through the result set
                          foreach ($myResult as $row => $key)
                          {
                              $termName = $key['TermName'];
                          }
                          // retrun the ID  OF THE STUDENT
                          return $termName;
                      }
                                else
                                {
                                exit("No Term Selected");
                                }
              }

                catch(Exception $e)
                {
                //echo error here
                //this get an error thrown by the system
                echo "Error:". $e->getMessage();
                }
        }

        ///

        ///METHOD NAME TO GET CLASS NAME
public function getClassName($schid,$classid)
        {
          //always use try and catch block to write code
          try{
                //SELECT THE ID OF THE ACTIVE SESSION BASED ON THE INSTITUTION
                  $sqlStmt = "SELECT class_name AS ClassName FROM class WHERE my_inst_id=? AND id=?";
                  $this->conn->query($sqlStmt);
                  $this->conn->bind(1, $schid, PDO::PARAM_INT);
                  $this->conn->bind(2, $classid, PDO::PARAM_INT);
                  $myResult = $this->conn->resultset();
                      if ($this->conn->rowCount() == 1)
                        {
                          //loop through the result set
                          foreach ($myResult as $row => $key)
                          {
                              $ClassName = $key['ClassName'];
                          }
                          // retrun the ID  OF THE STUDENT
                          return $ClassName;
                      }
                                else
                                {
                                exit("No Classname Selected");
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
//end of class













































































