<?
namespace ScoreSheet;
use \PDO;
class manager extends \ScoreSheet\staff {

//EDIT EXAMS  SCORES
function editTerminalExam($score,$subj,$class,$staffid,$recordid,$schid)
  {
      // always use try and catch block to write code
      $termid = $this->getActiveTerm($schid);
      $sessionid = $this->getActiveSession($schid);
      //$student_id = $this->getStudentId($stud_no,$schid);

        try {

          					//EDIT EXAM RECORD
                            $sqlStmt = "UPDATE terminal_exam SET exam_score=?,exam_subj_id=?,
                            exam_class_arm_id=?,tutor_id=? WHERE terminal_exam.id=?";
                            $this->conn->query($sqlStmt);
                            $this->conn->bind(1, $score, PDO::PARAM_INT,100);
                            $this->conn->bind(2, $subj, PDO::PARAM_INT,100);
                            //$this->conn->bind(3, $termid, PDO::PARAM_INT,100);
                            //$this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                            $this->conn->bind(3, $class, PDO::PARAM_INT);
                            $this->conn->bind(4, $staffid, PDO::PARAM_INT);
                            $this->conn->bind(5, $recordid, PDO::PARAM_INT);
                            //$this->conn->bind(7, $schid, PDO::PARAM_INT);
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







































































































































































































































































}