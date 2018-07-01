<?php
namespace ScoreSheet;
use \PDO;
class printRoutines extends \ScoreSheet\staff{

//Method to get student user details and scores details For Result Sheet
function userScoresDetails($studentid,$classid,$sessionid,$termid,$schid)
	    {
		try {     	
        $query ="SELECT CONCAT(student_initial.surname, ', ', LOWER(student_initial.firstName), '  ', IFNULL(LOWER(student_initial.lastName),'') ) AS Fullname, student_initial.gender AS Sex,
        class.class_name AS ClassName, 
        sch_term.term AS Term,
        session.session AS session, (SELECT COUNT( classpositionals.student_id )
        FROM classpositionals WHERE classpositionals.class_id=? 
        AND classpositionals.session_id=?
        AND classpositionals.term_id=?
        AND classpositionals.school_id=?) AS studentCount,
        -- (SELECT FORMAT(GrandTermTotal/(SELECT COUNT( DISTINCT class_category_subject.subject_id ) AS SubjectCount
        --  FROM class INNER JOIN class_category_subject
        --  ON class.class_categoryid=class_category_subject.class_category_id 
        --  WHERE class.id=? AND class.my_inst_id=?),2 ) AS TotalAverage
        --  FROM termgrandtotal WHERE 
        --  termgrandtotal.student_id=? 
        --  AND termgrandtotal.class_id=?
        --  AND termgrandtotal.term_id=? AND termgrandtotal.session_id=?
        --  AND termgrandtotal.sch_id=?) AS Average,
         termgrandtotal.GrandTermTotal AS Total,
         classpositionals.termposition AS TermPosition
	    FROM student_initial 
        INNER JOIN classpositionals ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN sch_term ON classpositionals.term_id=sch_term.term_id
        INNER JOIN session ON session.id=classpositionals.session_id
        INNER JOIN termgrandtotal ON termgrandtotal.student_id=classpositionals.student_id
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
            $null ="No User Details Available Yet!";
            if($output && $this->conn->rowCount())
            {
					//echo count($output);
          //ouput table headers below here
					$printOutput = " ";
					foreach($output as $row => $key)
					{
                    $studentName = $key['Fullname'];
                    $gender = $key['Sex'];
                    $className = $key['ClassName'];
                    $term = $key['Term'];
                    $session = $key['session'];
                    $studentCount = $key['studentCount'];
                    $total = $key['Total'];
                    $classPosition = $this->ordinalSuffix($key['TermPosition']);
                    $prefix = $this->schoolPrefix($schid);
                    $yearAdmitted = $this->yearAdmitted($studentid,$schid);
                    $studSerial = $this->studentSerialNumber($studentid,$schid);
                    $attendance = $this->studentAttendanceScores($studentid,$classid,$termid,$sessionid,$schid);
                    $terminalAv = $this->terminalAverage($studentid,$classid,$sessionid,$termid,$schid);
                    $resumeDate = $this->getResumptionDate($schid);
                    //bind values to html
                    $printOutput.='<h5>'.$studentName.' '.'<span class="stud-details-sub-item">'.$gender.'</span></h5>';
                    $printOutput.='<h4 class="stud-details-sub-item">'.$prefix.'/'.$yearAdmitted.'/'.$studSerial.'</h4>';
                    $printOutput.='<div class="item-container">
                    <div class="student-item colm"><h6>Class</h6><span>'.$className.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Term</h6><span>'.$term.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Session</h6><span>'.$session.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Students</h6><span>'.$studentCount.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Scores</h6><span>'.$total.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Average</h6><span>'.$terminalAv.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Postion</h6><span>'.$classPosition.'</span></div>';
                    // $printOutput.='<div class="student-item colm"><h6>Gender</h6><span>'.$gender.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Attendance</h6><span>'.$attendance.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Next Term Begins</h6><span>'.$resumeDate.'</span></div>
                    </div>';
					}                    
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
        //End userScoresDetails

        //METHOD TO GET GRAND TERM TOTAL
public function termCumulative($stdID,$termID,$classID,$sessID,$schID){
        try{
            $query = "SELECT GrandTermTotal AS Total from termgrandtotal WHERE student_id=? AND class_id=? AND session_id=? AND term_id=? AND sch_id=?";
            $this->conn->query($query);
            $this->conn->bind(1, $stdID, PDO::PARAM_INT);
            $this->conn->bind(2, $classID, PDO::PARAM_INT);
            $this->conn->bind(3, $sessID, PDO::PARAM_INT);
            $this->conn->bind(4, $termID, PDO::PARAM_INT);
            $this->conn->bind(5, $schID, PDO::PARAM_INT);

            $resultset = $this->conn->resultset();
            if($this->conn->rowCount() >=1){
                //loop through thr result set
                foreach($output as $row => $key)
					{
                        return $cumulativeTermTotal = $key['Total'];
                    }
                }
                else{
                    return $cumulativeTermTotal ='NA';
                }
         }
            catch(Exception $e)
            {
            echo "Error". $e->getMessage();
            }
    }
        //END METHOD TO GET GRAND TERM TOTAL

        //METHOD TO GET TERMINAL POSITION FOR A STUDENT
public function studentClassPosition($stdID,$termID,$classID,$sessID,$schID){
    try
    {
        $query = "SELECT termpostion AS myPosition FROM classpositionals
        WHERE student_id=? 
        AND class_id=? 
        AND term_id=? 
        AND session_id=? 
        AND school_id=? ";
        $this->conn->query($query);
        $this->conn->bind(1, $stdID, PDO::PARAM_INT);
        $this->conn->bind(2, $classID, PDO::PARAM_INT);
        $this->conn->bind(3, $termID, PDO::PARAM_INT);
        $this->conn->bind(4, $sessID, PDO::PARAM_INT);
        $this->conn->bind(5, $schID, PDO::PARAM_INT);
        $resultset = $this->conn->resultset();

            if($this->conn->rowCount() >=1)
            {
                //loop through the result
                foreach($resultset as $row => $key)
                    {
                        return $myPosition = $this->ordinalSuffix($key['myPosition']);
                    }
            }
            else{
                return $myPosition = 'NA';
            }

    }
        catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
    }
//END METHOD TO GET TERMINAL POSITION FOR A STUDENT

//Assessment Sheet Printout
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
        $null ="No Assessment Record (s) Yet!";
        $printOutput ="";
		 $caMaxScore = $this->getMaxCaScores($classid,$schoolid);
          $examMaxScore = $this->getMaxExamScores($classid,$schoolid);
          $totalCA = 3*$caMaxScore;
          $totalExam = $totalCA + $examMaxScore;
          $ci=1;

        if($output && $this->conn->rowCount() >=1)
          {
            
          $printOutput.= "<table class='asstable-print'>";
          $printOutput.='<tr>
          <th>#</th>
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
            $printOutput.='<td>'.$ci.'</td>';
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
            $ci++;
		}
          $printOutput.='</table>';
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
        //end of print method

        //Method to return  serial admission number of student
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
//End method to get serial admission number of  student

//Method to get school admission number prefix
function schoolPrefix($clientid)
    {
        try {
                $query ="SELECT
                prefix_name AS Prefix
                FROM admission_number_prefix
                WHERE prefix_sch_id=?";
                $this->conn->query($query);
                //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="Null";
                if($myResult && $this->conn->rowCount() >=1)
                { 
                    foreach ($myResult as $row => $key) 
                    {
                        $Prefix = $key['Prefix'];
                    }
                    return $Prefix;
                }else{
                    return $output;
                }
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get school prefix";
        }
    }
//end method to get school admision number prefix


//Method to get year of admission for student
function yearAdmitted($studentid,$clientid)
    {
        try {
            $query ="SELECT  session.session AS AdmittedSession 
            FROM session 
            INNER JOIN student_initial ON student_initial.sessionAdmitted=session.id
            WHERE student_initial.id=? AND student_initial.stud_sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(2, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="Null";
                    if($myResult && $this->conn->rowCount() >=1)
                    { 
                        foreach ($myResult as $row => $key) 
                        {
                        $admittedSess = $key['AdmittedSession'];
                        }
                        return $admittedSess;
                }else{
                    return $output;
                }
            }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get year of admission";
        }
    }

//End method to get year of admission for student

//final registration number
function finalRegistrationNumber($studentid,$clientid){

        $prefix = $this->schoolPrefix($clientid);
        $yearAdmitted = $this->yearAdmitted($studentid,$clientid);
        $serialNo = $this->studentSerialNumber($studentid,$clientid);

        $myReg = $prefix.'/'.$yearAdmitted.'/'.$serialNo;

        return $myReg;
    }

//End final registration number


//Get staff comments
function getStaffComment($studentid,$classid,$termid,$sessionid,$clientid)
    {
        try {
                $query ="SELECT class_teacher_comm AS teacherComments 
                FROM classpositionals  
                WHERE student_id=? AND class_id=? AND term_id=? AND session_id=? AND school_id=?";
                $this->conn->query($query);
                //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $this->conn->bind(3, $termid, PDO::PARAM_INT);
                $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                $this->conn->bind(5, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="No Comment!";
                
                if($myResult && $this->conn->rowCount() >=1)
                    {
                    foreach ($myResult as $row => $key) 
                    {
                        $teacherComments = $key['teacherComments'];
                    }
                    return $teacherComments;
                }else
                {
                    return $output;
                }
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get class teacher comments";
        }
    }
//End get staff 

//Get heade teacher comments
function getHeadTeacherComment($studentid,$classid,$termid,$sessionid,$clientid)
    {
        try {
                $query ="SELECT head_teacher_comm AS HeadTeacherComments 
                FROM classpositionals  
                WHERE student_id=? AND class_id=? AND term_id=? AND session_id=? AND school_id=?";
                $this->conn->query($query);
                //$this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $this->conn->bind(3, $termid, PDO::PARAM_INT);
                $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                $this->conn->bind(5, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="No Comment!";
                if($myResult && $this->conn->rowCount() >=1){ 
                foreach ($myResult as $row => $key) 
                {
                $headTeacherComments = $key['HeadTeacherComments'];
                }
                return $headTeacherComments;
            }else{
                return $output;
            }
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get head teacher comments";
        }
    }
//End get staff comment

//Get student attendnce
function studentAttendanceScores($studentid,$classid,$termid,$sessionid,$clientid)
    {
        try {
                $query ="SELECT student_attendance.days_attended AS DaysPresent, school_attendance.days_open AS DaysOpen FROM student_attendance 
                INNER JOIN school_attendance ON student_attendance.termid=school_attendance.termid
                WHERE student_attendance.studentid=?
                 AND student_attendance.classid=? 
                 AND student_attendance.termid=? 
                 AND student_attendance.sessionid=?
                 AND student_attendance.sch_id=?";
                $this->conn->query($query);
                $this->conn->bind(1, $studentid, PDO::PARAM_INT);
                $this->conn->bind(2, $classid, PDO::PARAM_INT);
                $this->conn->bind(3, $termid, PDO::PARAM_INT);
                $this->conn->bind(4, $sessionid, PDO::PARAM_INT);
                $this->conn->bind(5, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="Null"; 
                if($myResult && $this->conn->rowCount() >=1)
                {
                    foreach ($myResult as $row => $key) 
                    {
                    $Present = $key['DaysPresent'];
                    $Open = $key['DaysOpen'];
                    }
                    $days = $Present.' of '. $Open;
                    return $days;
            }else{
                return $output;
            }
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get student attedance";
        }
    }

//end get student attendance



//Get resumption date

function getResumptionDate($clientid)
    {
        try {
                $currentTerm = $this->getActiveTerm($clientid);
                $currentSession = $this->getActiveSession($clientid);
                $query ="SELECT resumptionDate AS ResumeDate FROM
                term_begins
                WHERE  
                termid=? 
                 AND sessionid=?
                 AND schoolid=?";
                $this->conn->query($query);
                $this->conn->bind(1, $currentTerm, PDO::PARAM_INT);
                $this->conn->bind(2, $currentSession, PDO::PARAM_INT);
                $this->conn->bind(3, $clientid, PDO::PARAM_INT);
                $myResult = $this->conn->resultset();
                $output ="No Date";
                if($myResult && $this->conn->rowCount()>=1)
                { 
                foreach ($myResult as $row => $key) 
                {
                    $resumptionDate = $key['ResumeDate'];
                }
                return $resumptionDate;
            }else{
                return $output;
            }
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Unable to get student attedance";
        }
    }

//end get resumption date



//class result sheet print out
function printClassResultSheet($classid,$termid,$sessionid,$schoolid)
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
     $this->classResultHeader($classid,$termid,$sessionid,$schoolid);
     //echo count($output);
     $null ='No record(s) available';
     $classOutput = '';

     //output elements to help select session and class to be promoted to
     //ouput table headers below here
         $printOutput = " ";
         $ci=1;
         
        if($output && $this->conn->rowCount() >=1)
        {
         $printOutput.= "<table class='asstable-print'>";
         $printOutput.="<tr>
         <th>#</th>
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
                    $printOutput.='<td>'.$ci.'</td>';
                    $printOutput.='<td>'.$studentName.'</td>';
                    $printOutput.='<td>'.$cumTotal.'</td>';
                    $printOutput.='<td>'.$this->maxScoresAvailable($classid,$schoolid).'</td>';
                    $printOutput.='<td>'.$av.'</td>';
                    $printOutput.='<td>'.$this->getClassPosition($studentID,$classid,$sessionid,$termid,$schoolid).'</td>';
                    $printOutput.='</tr>';
                    $ci++;
                    }
                    $printOutput.='</table>';
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
//end class result sheet print out


//terminal subject summary method
public function terminalSubjectSummary($studentid= "null", $classid,$termid,$sessionid,$schoolid){
    try {
      $query ="SELECT DISTINCT 
      subjects.subject_name AS subjectName,
      subjects.sub_id AS SubjectID
      FROM subjects INNER JOIN assessment ON assessment.ass_subject_id=subjects.sub_id
      WHERE 
      assessment.ass_class_id=? AND assessment.ass_session_id=?
      AND assessment.ass_term_id=?  AND assessment.ass_sch_id=? ORDER BY subjectName DESC";
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
                foreach($output as $row => $key)
                {
                $subjectid = $key['SubjectID'];
                $returnOuput.='<td>'.$this->subjectTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schoolid).'</td>'; 
                $returnOuput.='<td>'.$this->getSubjectPosition($studentid,$subjectid,$classid,$sessionid,$termid,$schoolid).'</td>';
                $returnOuput.='<td>'.$this->singleGrade($this->subjectTotals($studentid,$subjectid,$classid,$sessionid,$termid,$schoolid)).'</td>';
                }
                //add summary details
                   
                    $returnOuput.='<td>'.$this->termCumulative($studentid,$termid,$classid,$sessionid,$schoolid).'</td>';
                    $returnOuput.='<td>'.$this->terminalAverage($studentid,$classid,$sessionid,$termid,$schoolid).'</td>';
                    $returnOuput.='<td>'.$this->getClassPosition($studentid,$classid,$sessionid,$termid,$schoolid).'</td>';
                    $returnOuput.='<td>'.NA.'</td>';
                return $returnOuput;
            }
    }
    catch(Exception $e)
        {
          echo "Error:". $e->getMessage();
        }
  }
//end terminal subject summary method

//method to display yearly result summary
public function annualResultSummary($classID,$termID,$sessID,$schID)
    {
    try{
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
     $null ='No record(s) available';
     $printTable.= '<table class="asstable-print">';
     $printTable.=$this->listSubjectSummary($classID,$termID,$sessID,$schID);

         $ci=1;
         if($this->conn->rowCount() >=1)
         {
             foreach($output as $row =>$key)
             {
                 //loop through the subjects for each name
                 $studentId = $key['StudentID'];
                 $tudentName = $key['Fullname'];
                 $printTable.='<tr>';
                 $printTable.='<td>'.$studentName.'</td>';
                 $printTable.=$this->terminalSubjectSummary($studentid,$classid,$termid,$sessionid,$schoolid);
                 $printTable.='</tr>';
             }
             $printTable.='</table>';
             echo $printTable;
         }
         else{
             echo $null;
         }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }
    }

//end method to display yearly result summary

















































































































































































































































































    
}
//end of class