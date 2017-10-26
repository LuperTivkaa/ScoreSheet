<?php
namespace ScoreSheet;
use \PDO;
class printRoutines extends \ScoreSheet\staff{

//Method to get student user details and scores details For Result Sheet
function userScoresDetails($studentid,$classid,$sessionid,$termid,$schid)
	    {
		try {     	
        $query ="SELECT CONCAT(student_initial.surname, ', ', LOWER(student_initial.firstName), '  ',LOWER(student_initial.lastName) ) AS Fullname,
        class.class_name AS ClassName, 
        sch_term.term AS Term,
        session.session AS session, (SELECT COUNT( classpositionals.student_id )
        FROM classpositionals WHERE classpositionals.class_id=? 
        AND classpositionals.session_id=?
        AND classpositionals.term_id=?
        AND classpositionals.school_id=?) AS studentCount,
        (SELECT FORMAT(GrandTermTotal / (SELECT COUNT( subjects.sub_id )
        FROM subjects INNER JOIN class_subject
        ON subjects.sub_id=class_subject.subject_id 
        WHERE class_subject.class_id=? AND class_subject.school_id=?),2 ) 
        FROM termgrandtotal WHERE 
        termgrandtotal.student_id=? 
        AND termgrandtotal.class_id=?
        AND termgrandtotal.term_id=? 
        AND termgrandtotal.session_id=?
        AND termgrandtotal.sch_id=?) AS Average,
        classpositionals.termgrandtotal AS Total,
        classpositionals.termposition AS TermPosition
	    FROM student_initial 
        INNER JOIN classpositionals ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN sch_term ON classpositionals.term_id=sch_term.term_id
        INNER JOIN session ON session.id=classpositionals.session_id
	    WHERE classpositionals.student_id=? 
        AND classpositionals.class_id=? 
        AND classpositionals.session_id=?
        AND classpositionals.term_id=?
        AND classpositionals.school_id=?";
        $this->conn->query($query);
        $this->conn->bind(1, $classid, PDO::PARAM_INT);
        $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(3, $termid, PDO::PARAM_INT);
        $this->conn->bind(4, $schid, PDO::PARAM_INT);
        $this->conn->bind(5, $classid, PDO::PARAM_INT);
        $this->conn->bind(6, $schid, PDO::PARAM_INT);
        $this->conn->bind(7, $studentid, PDO::PARAM_INT);
        $this->conn->bind(8, $classid, PDO::PARAM_INT);
        $this->conn->bind(9, $termid, PDO::PARAM_INT);
        $this->conn->bind(10, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(11, $schid, PDO::PARAM_INT);
        $this->conn->bind(12, $studentid, PDO::PARAM_INT);
        $this->conn->bind(13, $classid, PDO::PARAM_INT);
        $this->conn->bind(14, $sessionid, PDO::PARAM_INT);
        $this->conn->bind(15, $termid, PDO::PARAM_INT);
        $this->conn->bind(16, $schid, PDO::PARAM_INT);
        
        $output = $this->conn->resultset(); 
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
                    $studentName = $key['Fullname'];
                    $className = $key['ClassName'];
                    $term = $key['Term'];
                    $session = $key['session'];
                    $studentCount = $key['studentCount'];
                    $average = $key['Average'];
                    $total = $key['Total'];
                    $classPosition = $this->ordinalSuffix($key['TermPosition']);
                    //bind values to html
                    $printOutput.='<h5>'.$studentName.'</h5>';
                    $printOutput.='<div class="item-container">
                    <div class="student-item colm"><h6>Class</h6><span>'.$className.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Term</h6><span>'.$term.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Session</h6><span>'.$session.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Students</h6><span>'.$studentCount.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Scores</h6><span>'.$total.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Average</h6><span>'.$average.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Postion</h6><span>'.$classPosition.'</span></div></div>';
					}
                    
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	     }
        //End userScoresDetails


//Assessment Sheet Prinout
function printScoreSheet($subjectid,$classid,$termid,$sessionid,$schoolid)
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
		$this->scoreSheetHeaderInformation($subjectid,$classid,$termid,$sessionid,$schoolid);
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
          <TH>Grade</th>
          <TH>Comment</th>
          <th>Sign</th>
          </tr>";
					foreach($output as $row => $key)
					{
            $studentID = $key['studentID'];
			$studentName = $key['Fullname'];
            $subjectID = $key['SubjectID'];
            $terminalSUbjectTotals= $this->subjectTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
			$printOutput.='<tr>';
			$printOutput.='<td>'.$studentName.'</td>';
			$printOutput.=$this->print_ca($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->caTotals($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->subject_ScoresTotal($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.='<td>'.$terminalSUbjectTotals.'</td>';
            $printOutput.=$this->subjectAv($subjectID,$classid,$sessionid,$termid,$schoolid);
            $printOutput.=$this->getSubjectPosition($studentID,$subjectID,$classid,$sessionid,$termid,$schoolid);
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
        






















    
}