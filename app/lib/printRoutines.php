<?php
namespace ScoreSheet;
use \PDO;
class printRoutines extends \ScoreSheet\staff{

//next session
public function NextSession($clientid)
    {
        try {
                $query ="SELECT id,session FROM session WHERE sess_inst_id=? order by id DESC LIMIT 1";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                    foreach ($myResult as $row => $key) 
                    {
                        $session = $key['session'];         
                    }
                    return $session;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Retrieving session";
        }
    }
//next session

    //Method to get current session
    public function CurrentSession($sessid,$clientid)
    {
        try {
                $query ="SELECT session FROM session WHERE sess_inst_id=? AND id=?";
                    $this->conn->query($query);
                    $this->conn->bind(1, $clientid, PDO::PARAM_INT);
                    $this->conn->bind(2, $sessid, PDO::PARAM_INT);
                    $myResult = $this->conn->resultset();
                    foreach ($myResult as $row => $key) 
                    {
                        $session = $key['session'];         
                    }
                    return $session;
        }// End of try catch block
         catch(Exception $e)
        {
            echo "Error: Retrieving session";
        }
    }
    //End method to get current session 
    //COUNT OF STUDENTS

function studentCount($classid,$sessionid,$termid,$schid)
    {
    try{
    $query =  "SELECT COUNT( classpositionals.student_id ) AS StudCount
    FROM classpositionals WHERE classpositionals.class_id=? 
    AND classpositionals.session_id=?
    AND classpositionals.term_id=?
    AND classpositionals.school_id=?";
    $this->conn->query($query);
    $this->conn->bind(1, $classid, PDO::PARAM_INT);
    $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
    $this->conn->bind(3, $termid, PDO::PARAM_INT);
    $this->conn->bind(4, $schid, PDO::PARAM_INT);

    $output = $this->conn->resultset(); 
    $null ="No Student Count";
        if($output)
        { 
            foreach($output as $row => $key)
            {
                $myCount = $key['StudCount'];
            }
            return $myCount;
            
        }
        else{
            return $null;
        }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }

        }
//end student count

//annual distinct students counts
function annualStudentCount($classid,$sessionid,$schid)
    {
    try{
    $query =  "SELECT DISTINCT COUNT(student_id) AS StudCount
    FROM annual_result WHERE class_id=? 
    AND session_id=? AND sch_id=?";
    $this->conn->query($query);
    $this->conn->bind(1, $classid, PDO::PARAM_INT);
    $this->conn->bind(2, $sessionid, PDO::PARAM_INT);
    $this->conn->bind(3, $schid, PDO::PARAM_INT);

    $output = $this->conn->resultset(); 
    $null ="NA";
        if($output)
        { 
            foreach($output as $row => $key)
            {
                $myCount = $key['StudCount'];
            }
            return $myCount;
            
        }
        else{
            return $null;
        }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }

        }
//end annual distinct students counts

function studentBio($studentid,$schid)
    {
    try{
    $query =  " SELECT student_initial.id AS MyID, CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname, student_initial.gender AS Sex

    FROM student_initial WHERE id=? 
    AND stud_sch_id=?
    ";
    $this->conn->query($query);
    $this->conn->bind(1, $studentid, PDO::PARAM_INT);
    $this->conn->bind(2, $schid, PDO::PARAM_INT);
    // $this->conn->bind(3, $termid, PDO::PARAM_INT);
    // $this->conn->bind(4, $schid, PDO::PARAM_INT);
    $printOutput="";
    $output = $this->conn->resultset(); 
    $null ="No";
        if($output)
        { 
            foreach($output as $row => $key)
            {
                $f = $key['Fullname'];
                $s = $key['Sex'];
            }
            $printOutput.='<h5>'.$f.' '.'<span class="stud-details-sub-item">'.$s.'</span></h5>';
            return $printOutput;
        }
        else{
            return $null;
        }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }

}

function academicInfo($studentid,$classid,$sessionid,$termid,$schid)
    {
    try{
    $query =  " SELECT classpositionals.student_id AS ClassStudID,
    class.class_name AS MyClass, session.session AS MySess, sch_term.term AS Term

    FROM classpositionals INNER JOIN class ON class.id = classpositionals.class_id
    INNER JOIN session ON session.id=classpositionals.session_id
    INNER JOIN sch_term ON sch_term.term_id=classpositionals.term_id
     WHERE classpositionals.student_id=?  AND classpositionals.class_id=? AND classpositionals.session_id=? AND classpositionals.term_id=? AND classpositionals.school_id=?";
    $this->conn->query($query);
    $this->conn->bind(1, $studentid, PDO::PARAM_INT);
    $this->conn->bind(2, $classid, PDO::PARAM_INT);
    $this->conn->bind(3, $sessionid, PDO::PARAM_INT);
    $this->conn->bind(4, $termid, PDO::PARAM_INT);
    $this->conn->bind(5, $schid, PDO::PARAM_INT);
    // $this->conn->bind(3, $termid, PDO::PARAM_INT);
    // $this->conn->bind(4, $schid, PDO::PARAM_INT);
    $printOutput="";
    $output = $this->conn->resultset(); 
    $null ="No";
        if($output)
        { 
            foreach($output as $row => $key)
            {
                $class = $key['MyClass'];
                $sess = $key['MySess'];
                $term = $key['Term'];
                
            }
            $printOutput.='<div class="student-item colm"><h6>Class</h6><span>'.$class.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Term</h6><span>'.$term.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Session</h6><span>'.$sess.'</span></div>';
            return $printOutput;
        }
        else{
            return $null;
        }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }

}
//Method to get student user details and scores details For Result Sheet

//promoted student academic info

function promotedAcademicInfo($studentid,$schid)
    {
    try{
        
    $query =  "SELECT student_class.student_id AS StudID, class.class_name AS MyClass,class.id AS ClassID, session.session AS MySess FROM student_class INNER JOIN class ON student_class.stud_class=class.id INNER JOIN session ON session.id=student_class.stud_sess_id WHERE student_class.student_id=? AND student_class.stud_school_id=? ORDER BY ClassID DESC LIMIT 1 ";
    $this->conn->query($query);
    $this->conn->bind(1, $studentid, PDO::PARAM_INT);
    $this->conn->bind(2, $schid, PDO::PARAM_INT);
    
    $printOutput="";
    $output = $this->conn->resultset(); 
    $null ="No";
        if($output)
        { 
            foreach($output as $row => $key)
            {
                $class = $key['MyClass'];          
            }
            $sess = $this->NextSession($schid);
            $printOutput.='<div class="student-item colm"><h6>Next Class</h6><span>'.$class.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Next Session</h6><span>'.$sess.'</span></div>';
            return $printOutput;
        }
        else{
            return $null;
        }
    }
    catch(Exception $e)
    {
        echo "Error:". $e->getMessage();
    }

}
//end promoted student academic Info

//Method to get student user details and scores details For Result Sheet
function userScoresDetails($studentid,$classid,$sessionid,$termid,$schid)
	    {
                    $printOutput="";
                    $cumTotal = $this->grandTotals($studentid,$classid,$sessionid,$termid,$schid);
                    //$av = $this->terminalAverage($studentid,$classid,$sessionid,$termid,$schid);
                    $pos= $this->getClassPosition($studentid,$classid,$sessionid,$termid,$schid);

                    $prefix = $this->schoolPrefix($schid);

                    $info = $this->studentBio($studentid,$schid);
                    $acadeInfo = $this->academicInfo($studentid,$classid,$sessionid,$termid,$schid);
                    $count = $this->studentCount($classid,$sessionid,$termid,$schid);
                    $yearAdmitted = $this->yearAdmitted($studentid,$schid);
                    $studSerial = $this->studentSerialNumber($studentid,$schid);
                    $attendance = $this->studentAttendanceScores($studentid,$classid,$termid,$sessionid,$schid);
                    $terminalAv = $this->terminalAverage($studentid,$classid,$sessionid,$termid,$schid);
                    $resumeDate = $this->getResumptionDate($schid);
                    //bind values to html
                    // $printOutput.='<h5>'.$studentName.' '.'<span class="stud-details-sub-item">'.$gender.'</span></h5>';
                    $printOutput.=$info;
                    $printOutput.='<h4 class="stud-details-sub-item">'.$prefix.'/'.$yearAdmitted.'/'.$studSerial.'</h4>';
                    $printOutput.='<div class="item-container">';
                    $printOutput.=$acadeInfo;
                    $printOutput.='<div class="student-item colm"><h6>Students</h6><span>'.$count.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Scores</h6><span>'.$cumTotal.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Average</h6><span>'.$terminalAv.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Position</h6><span>'.$pos.'</span></div>';
                    // $printOutput.='<div class="student-item colm"><h6>Gender</h6><span>'.$gender.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Attendance</h6><span>'.$attendance.'</span></div>';
                    $printOutput.='<div class="student-item colm"><h6>Next Term Begins</h6><span>'.$resumeDate.'</span></div>
                    </div>';
					                   
                echo $printOutput;
        
	}
//End userScoresDetails


//METHOD TO COMPUTE STUDENT ANNUAL SCORES DETAILS
function annualScoresDetails($studentid,$classid,$sessionid,$schid)
	    {
            $printOutput="";
            $currentSess = $this->CurrentSession($sessionid,$schid);
            $cumTotal = $this->annualTotals($studentid,$classid,$sessionid,$schid);
            
            $pos= $this->getAnnualPosition($studentid,$classid,$sessionid,$schid);

            $prefix = $this->schoolPrefix($schid);

            $info = $this->studentBio($studentid,$schid);
            $acadeInfo = $this->promotedAcademicInfo($studentid,$schid);
            $count = $count = $this->annualStudentCount($classid,$sessionid,$schid);
            $yearAdmitted = $this->yearAdmitted($studentid,$schid);
            $studSerial = $this->studentSerialNumber($studentid,$schid);
            
            $terminalAv = $this->annualAverage($studentid,$classid,$sessionid,$schid);
           
            $printOutput.=$info;
            $printOutput.='<h4 class="stud-details-sub-item">'.$prefix.'/'.$yearAdmitted.'/'.$studSerial.'</h4>';
            $printOutput.='<div class="item-container">';
            $printOutput.=$acadeInfo;
            $printOutput.='<div class="student-item colm"><h6> Session</h6><span>'.$currentSess.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Students</h6><span>'.$count.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Annual Total</h6><span>'.$cumTotal.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Annual Average</h6><span>'.$terminalAv.'</span></div>';
            $printOutput.='<div class="student-item colm"><h6>Annual Position</h6><span>'.$pos.'</span></div></div>';
        echo $printOutput;
	}
//END METHOD TO COMPUTE STUDENT ANNUAL SCORES DETAILS

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

//Method to display terminal result summary
public function terminalSummaryResult($classid,$sessid,$termid,$schid)
    {
        try
        {
            //write query to select students id and name here
            $query ="SELECT DISTINCT subjecttotals.student_id AS StudentID,
            CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
            FROM subjecttotals INNER JOIN student_initial ON student_initial.id=subjecttotals.student_id
            WHERE subjecttotals.class_id=? AND 
            subjecttotals.term_id=? AND subjecttotals.session_id=?
            AND subjecttotals.sch_id=?";
            $this->conn->query($query);
            //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $termid, PDO::PARAM_INT);
            $this->conn->bind(3, $sessid, PDO::PARAM_INT); 
            $this->conn->bind(4, $schid, PDO::PARAM_INT);
            //display print button if result set is greater than one 1
            $nameOut = $this->conn->resultset();
            $na = 'NA';
            $Table="";
            if($this->conn->rowCount()){
                echo '<p class="printAssessment">
                   <a href="terminalAnnualSheetPrint.php?class='.$classid.'&session='.$sessid.'&term='.$termid.'&schoolid='.$schid.'" target="_blank" class="btn btn-info" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print </a>
                   <hr></p>';
                }
            echo $header=$this->annualResultHeader($classid,$termid,$sessid,$schid);
            
            $Table.= '<table class="asstable-print">';
            $Table.=$this->listSubjectSummary($classid,$termid,$sessid,$schid);
            if($nameOut && $this->conn->rowCount() >=1)
            {
                $ci = 1;
                foreach($nameOut as $row => $key)
                {

                    $studentID =$key['StudentID'];
                    $fullname = $key['Fullname'];
                    $Table.='<tr>';
                    $Table.='<td>'.$ci.'</td>';
                    $Table.='<td>'.$fullname.'</td>';
                    //select distinct subjects from subject totals
                    //SQL QUERY 
                    $query = "SELECT DISTINCT ass_subject_id AS subjID FROM assessment WHERE ass_class_id=? AND ass_term_id=? AND ass_session_id=? AND ass_sch_id=? ORDER BY subjID ASC";
                    // $query="SELECT DISTINCT subject_id AS subjID
                    // FROM  subjecttotals
                    // WHERE class_id=? AND term_id=? 
                    // AND session_id=? AND sch_id=? 
                    // ORDER BY subjID ASC";
                    $this->conn->query($query);
                    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $termid, PDO::PARAM_INT);
                    $this->conn->bind(3, $sessid, PDO::PARAM_INT); 
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $subjOut = $this->conn->resultset();
                    if($subjOut && $this->conn->rowCount() >=1)
                    {
                        foreach($subjOut as $row => $key)
                        {
                        //loop and print details
                        
                        $sID = $key['subjID'];
                        $subjTotals = $this->subjectTotals($studentID,$sID,$classid,$sessid,$termid,$schid);
                        $subjpos = $this->getSubjectPosition($studentID,$sID,$classid,$sessid,$termid,$schid);
                        $grade = $this->singleGrade($subjTotals);
                        $Table.='<td>'.$subjTotals.'</td>';
                        $Table.='<td>'.$subjpos.'</td>';
                        $Table.='<td>'.$grade.'</td>';
                        }
                    }
                    else
                    {
                        //no subject totals available
                        exit("No Subject Records Available");
                    }
                    $gtotal = $this->grandTotals($studentID,$classid,$sessid,$termid,$schid);
                    $termAverage=  $this->terminalAverage($studentID,$classid,$sessid,$termid,$schid);
                    
                    $myPos = $this->getClassPosition($studentID,$classid,$sessid,$termid,$schid);
                    $Table.='<td>'.$gtotal.'</td>';
                    $Table.='<td>'.$termAverage.'</td>';
                    $Table.='<td>'.$myPos.'</td>';
                    $Table.='<td>'.$na.'</td>';
                    $Table.='</tr>';
                    $ci+=1;
                }
                $Table.='</table>';
                echo $Table;
            }
            else{
                //No student found in this class
                exit("No Students Record(s) Available To Fulfil Your Criteria");
            }
        }
        catch(Exception $e)
        {
            echo "Error". $e->getMessage();
        }

    }
//end method to display terminal result summary

//Method to print terminal result summary
public function printTerminalSummaryResult($classid,$sessid,$termid,$schid)
    {
        try
        {
            //write query to select students id and name here
            $query ="SELECT DISTINCT subjecttotals.student_id AS StudentID,
            CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
            FROM subjecttotals INNER JOIN student_initial ON student_initial.id=subjecttotals.student_id
            WHERE subjecttotals.class_id=? AND 
            subjecttotals.term_id=? AND subjecttotals.session_id=?
            AND subjecttotals.sch_id=?";
            $this->conn->query($query);
            //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $termid, PDO::PARAM_INT);
            $this->conn->bind(3, $sessid, PDO::PARAM_INT); 
            $this->conn->bind(4, $schid, PDO::PARAM_INT);
            //display print button if result set is greater than one 1
            $nameOut = $this->conn->resultset();
            $na = 'NA';
            $Table="";
            
            echo $header=$this->annualResultHeader($classid,$termid,$sessid,$schid);
            $Table.= '<table class="asstable-print">';
            $Table.=$this->listSubjectSummary($classid,$termid,$sessid,$schid);
            if($nameOut && $this->conn->rowCount() >=1)
            {
                $ci = 1;
                foreach($nameOut as $row => $key)
                {

                    $studentID =$key['StudentID'];
                    $fullname = $key['Fullname'];
                    $Table.='<tr>';
                    $Table.='<td>'.$ci.'</td>';
                    $Table.='<td>'.$fullname.'</td>';
                    //select distinct subjects from subject totals
                    //SQL QUERY 
                    $query="SELECT DISTINCT subject_id AS subjID
                    FROM  subjecttotals
                    WHERE class_id=? AND term_id=? 
                    AND session_id=? AND sch_id=? 
                    ORDER BY subjID ASC";
                    $this->conn->query($query);
                    $this->conn->bind(1, $classid, PDO::PARAM_INT); 
                    $this->conn->bind(2, $termid, PDO::PARAM_INT);
                    $this->conn->bind(3, $sessid, PDO::PARAM_INT); 
                    $this->conn->bind(4, $schid, PDO::PARAM_INT);
                    $subjOut = $this->conn->resultset();
                    if($subjOut && $this->conn->rowCount() >=1)
                    {
                        foreach($subjOut as $row => $key)
                        {
                        //loop and print details
                        
                        $sID = $key['subjID'];
                        $subjTotals = $this->subjectTotals($studentID,$sID,$classid,$sessid,$termid,$schid);
                        $subjpos = $this->getSubjectPosition($studentID,$sID,$classid,$sessid,$termid,$schid);
                        $grade = $this->singleGrade($subjTotals);
                        $Table.='<td>'.$subjTotals.'</td>';
                        $Table.='<td>'.$subjpos.'</td>';
                        $Table.='<td>'.$grade.'</td>';
                        }
                    }
                    else
                    {
                        //no subject totals available
                        exit("No Subject Records Available");
                    }
                    $gtotal = $this->grandTotals($studentID,$classid,$sessid,$termid,$schid);
                    $termAverage=  $this->terminalAverage($studentID,$classid,$sessid,$termid,$schid);
                    
                    $myPos = $this->getClassPosition($studentID,$classid,$sessid,$termid,$schid);
                    $Table.='<td>'.$gtotal.'</td>';
                    $Table.='<td>'.$termAverage.'</td>';
                    $Table.='<td>'.$myPos.'</td>';
                    $Table.='<td>'.$na.'</td>';
                    $Table.='</tr>';
                    $ci+=1;
                }
                $Table.='</table>';
                echo $Table;
            }
            else{
                //No student found in this class
                exit("No Students Record(s) Available To Fulfil Your Criteria");
            }
        }
        catch(Exception $e)
        {
            echo "oops".$e->getMessage();
        }

    }

//end  method to print terminal result summary

//Method to display annual summary result
public function yearlyResultSummary($classid,$sessid,$schid)
    {
        try
        {
            //write query to select students id and name here
            $query ="SELECT DISTINCT annualtotal.student_id AS StudentID,
            CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
            FROM annualtotal INNER JOIN student_initial ON student_initial.id=annualtotal.student_id
            WHERE annualtotal.class_id=? AND annualtotal.session_id=?
            AND annualtotal.sch_id=?";
            $this->conn->query($query);
            //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $sessid, PDO::PARAM_INT); 
            $this->conn->bind(3, $schid, PDO::PARAM_INT);
            //display print button if result set is greater than one 1
            $nameOut = $this->conn->resultset();
            $na = 'NA';
            $Table="";
            if($this->conn->rowCount()){
                echo '<p class="printAssessment">
                   <a href="AnnualSheetPrint.php?class='.$classid.'&session='.$sessid.'&schoolid='.$schid.'" target="_blank" class="btn btn-info" id="print-link"><i class="fa fa-print" aria-hidden="true"></i> Print </a>
                   <hr></p>';
                }
            echo $header=$this->yearlyResultHeader($classid,$sessid,$schid);
            $Table.= '<table class="asstable-print">';
            $Table.='<tr>';
            $Table.='<th></th>';
            $Table.='<th>'.'Name'.'</th>';
            $Table.='<th colspan="3">'.'Term Totals'.'</th>';
            $Table.='<th colspan="6">'.'Summary'.'</th></tr>';
            $Table.='<tr>';
            $Table.='<td>'.'#'.'</td>';
            $Table.='<td>'.'Name'.'</td>';
            $Table.='<td>'.'1st Term'.'</td>';
            $Table.='<td>'.'2nd Term'.'</td>';
            $Table.='<td>'.'3rd Term'.'</td>';
            $Table.='<td>'.'Grand Total'.'</td>';
            $Table.='<td>'.'Avg'.'</td>';
            $Table.='<td>'.'Class Highest'.'</td>';
            $Table.='<td>'.'Class Lowest'.'</td>';
            $Table.='<td>'.'Position'.'</td>';
            $Table.='<td>'.'Rmks'.'</td></tr>';

            //$Table.=$this->listSubjectSummary($classid,$termid,$sessid,$schid);
            $ci=1;
            if($nameOut && $this->conn->rowCount() >=1)
            {
                foreach($nameOut as $row => $key)
                {
                    $studentID =$key['StudentID'];
                    $fullname = $key['Fullname'];
                    $gtotal_1 = $this->grandTotals($studentID,$classid,$sessid,1,$schid);
                    $gtotal_2 = $this->grandTotals($studentID,$classid,$sessid,2,$schid);
                    $gtotal_3 = $this->grandTotals($studentID,$classid,$sessid,3,$schid);
                    $annual_Totals = $this->annualTotals($studentID,$classid,$sessid,$schid);
                    $annualAverage=  $this->annualAverage($studentID,$classid,$sessid,$schid);
                    $myPos = $this->getAnnualPosition($studentID,$classid,$sessid,$schid);
                    $highest = $this->highestYearTotal($classid,$sessid,$schid);
                    $lowest = $this->lowestYearTotal($classid,$sessid,$schid);

                    $Table.='<tr>';
                    $Table.='<td>'.$ci.'</td>';
                    $Table.='<td>'.$fullname.'</td>';
                    $Table.='<td>'.$gtotal_1.'</td>';
                    $Table.='<td>'.$gtotal_2.'</td>';
                    $Table.='<td>'.$gtotal_3.'</td>';
                    $Table.='<td>'.$annual_Totals.'</td>';
                    $Table.='<td>'.$annualAverage.'</td>';
                    $Table.='<td>'.$highest.'</td>';
                    $Table.='<td>'.$lowest.'</td>';
                    $Table.='<td>'.$myPos.'</td>';
                    $Table.='<td>'.$na.'</td>';
                    $Table.='</tr>';
                    $ci+=1;
                }
                $Table.='</table>';
                echo $Table;
            }
            else{
                //No student found in this class
                exit("No Students Record(s) Available To Fulfil Your Criteria");
            }
        }
        catch(Exception $e)
        {
            echo "Error". $e->getMessage();
        }

    }
//end method to display annual summary result

//method to print annual result summary
public function printYearlyResultSummary($classid,$sessid,$schid)
    {
        try
        {
            //write query to select students id and name here
            $query ="SELECT DISTINCT annualtotal.student_id AS StudentID,
            CONCAT(student_initial.surname, ' ', student_initial.firstName) AS Fullname
            FROM annualtotal INNER JOIN student_initial ON student_initial.id=annualtotal.student_id
            WHERE annualtotal.class_id=? AND annualtotal.session_id=?
            AND annualtotal.sch_id=?";
            $this->conn->query($query);
            //$this->conn->bind(1, $subjectid, PDO::PARAM_INT);
            $this->conn->bind(1, $classid, PDO::PARAM_INT); 
            $this->conn->bind(2, $sessid, PDO::PARAM_INT); 
            $this->conn->bind(3, $schid, PDO::PARAM_INT);
            //display print button if result set is greater than one 1
            $nameOut = $this->conn->resultset();
            $na = 'NA';
            $Table="";
            
            echo $header=$this->yearlyResultHeader($classid,$sessid,$schid);
            $Table.= '<table class="asstable-print">';
            $Table.='<tr>';
            $Table.='<th></th>';
            $Table.='<th>'.'Name'.'</th>';
            $Table.='<th colspan="3">'.'Term Totals'.'</th>';
            $Table.='<th colspan="6">'.'Summary'.'</th></tr>';
            $Table.='<tr>';
            $Table.='<td>'.'#'.'</td>';
            $Table.='<td>'.'Name'.'</td>';
            $Table.='<td>'.'1st Term'.'</td>';
            $Table.='<td>'.'2nd Term'.'</td>';
            $Table.='<td>'.'3rd Term'.'</td>';
            $Table.='<td>'.'Grand Total'.'</td>';
            $Table.='<td>'.'Avg'.'</td>';
            $Table.='<td>'.'Class Highest'.'</td>';
            $Table.='<td>'.'Class Lowest'.'</td>';
            $Table.='<td>'.'Position'.'</td>';
            $Table.='<td>'.'Rmks'.'</td></tr>';
            //$Table.=$this->listSubjectSummary($classid,$termid,$sessid,$schid);
            $ci  =1;
            if($nameOut && $this->conn->rowCount() >=1)
            {
                foreach($nameOut as $row => $key)
                {
                    $studentID =$key['StudentID'];
                    $fullname = $key['Fullname'];
                    $gtotal_1 = $this->grandTotals($studentID,$classid,$sessid,1,$schid);
                    $gtotal_2 = $this->grandTotals($studentID,$classid,$sessid,2,$schid);
                    $gtotal_3 = $this->grandTotals($studentID,$classid,$sessid,3,$schid);
                    $annual_Totals = $this->annualTotals($studentID,$classid,$sessid,$schid);
                    $annualAverage=  $this->annualAverage($studentID,$classid,$sessid,$schid);
                    $myPos = $this->getAnnualPosition($studentID,$classid,$sessid,$schid);
                    $highest = $this->highestYearTotal($classid,$sessid,$schid);
                    $lowest = $this->lowestYearTotal($classid,$sessid,$schid);

                    $Table.='<tr>';
                    $Table.='<td>'.$ci.'</td>';
                    $Table.='<td>'.$fullname.'</td>';
                    $Table.='<td>'.$gtotal_1.'</td>';
                    $Table.='<td>'.$gtotal_2.'</td>';
                    $Table.='<td>'.$gtotal_3.'</td>';
                    $Table.='<td>'.$annual_Totals.'</td>';
                    $Table.='<td>'.$annualAverage.'</td>';
                    $Table.='<td>'.$highest.'</td>';
                    $Table.='<td>'.$lowest.'</td>';
                    $Table.='<td>'.$myPos.'</td>';
                    $Table.='<td>'.$na.'</td>';
                    $Table.='</tr>';
                    $ci+=1;
                }
                $Table.='</table>';
                echo $Table;
            }
            else{
                //No student found in this class
                exit("No Students Record(s) Available To Fulfil Your Criteria");
            }
        }
        catch(Exception $e)
        {
            echo "Error". $e->getMessage();
        }

    }
//method to print annual result summary
































}