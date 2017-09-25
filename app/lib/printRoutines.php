<?php
namespace ScoreSheet;
use \PDO;
class printRoutines extends \ScoreSheet\staff{

    //Method to print school Profile
    function schoolProfileHeader($clientid)
	    {
		 try {
			
        $query ="SELECT institutional_signup.institution_name AS SchoolName,
         institutional_signup.inst_add AS Address, 
        CONCAT(nationality.nationality, ' - ', states.state_name) AS CountryState,
        institutional_signup.inst_mobile AS Mobile, 
        institutional_signup.inst_logo AS Logo
	    FROM institutional_signup 
        INNER JOIN nationality ON institutional_signup.country_id=nationality.id
        INNER JOIN states ON institutional_signup.state_id=states.id
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
                    $Address = $key['Address'];
                    $countryState = $key['CountryState'];
                    $Mobile = $key['Mobile'];
                    $Logo = $key['Logo'];
					}
                    if($Logo)
                    {
                    $printOutput.='<h5><img src="'.$Logo.'" alt="School Logo" class="logo-img"></h5>';
                    $printOutput.='<h5>'.$schoolName.'</h5>';
                    $printOutput.='<p>'.$countryState.'</p>';
                    $printOutput.='<p>'.$Mobile.'</p>';
                    }
                    else
                    {
                    $printOutput.='<h5><img src="../images/avatar.jpg" alt="School Logo" class="logo-img"></h5>';
                    $printOutput.='<h5>'.$schoolName.'</h5>';
                    $printOutput.='<p>'.$countryState.'</p>';
                    $printOutput.='<p>'.$Mobile.'</p>';
                    }
          echo $printOutput;
        }//End of try catch block
         catch(Exception $e)
        {
            echo "Error:". $e->getMessage();
        }
	    }
        //End school profile method

//Method to get user details and scores details
function userScoresDetails($studentid,$classid,$sessionid,$termid,$schid)
	    {
		 try {
			
        $query ="SELECT CONCAT(student_initial.surname, ', ', LOWER(student_initial.firstName), '  ',LOWER(student_initial.lastName) ) AS Fullname,
        class.class_name AS ClassName, 
        sch_term.term AS Term,
        session.session AS session, (SELECT COUNT( classpositionals.student_id )
    FROM classpositionals WHERE classpositionals.class_id=1 
        AND classpositionals.session_id=7
        AND classpositionals.term_id=1
        AND classpositionals.school_id=2) AS studentCount,
        (SELECT FORMAT(GrandTermTotal / (SELECT COUNT( subjects.sub_id )
    FROM subjects INNER JOIN class_subject
    ON subjects.sub_id=class_subject.subject_id 
    WHERE class_subject.class_id=1 AND class_subject.school_id=2),2 ) 
    FROM termgrandtotal WHERE 
    termgrandtotal.student_id=2 
    AND termgrandtotal.class_id=1
    AND termgrandtotal.term_id=1 
    AND termgrandtotal.session_id=7
    AND termgrandtotal.sch_id=2) AS Average,
        classpositionals.termgrandtotal AS Total,
        classpositionals.termposition AS TermPosition
	    FROM student_initial 
        INNER JOIN classpositionals ON student_initial.id=classpositionals.student_id
        INNER JOIN class ON class.id=classpositionals.class_id
        INNER JOIN sch_term ON classpositionals.term_id=sch_term.term_id
        INNER JOIN session ON session.id=classpositionals.session_id
	    WHERE classpositionals.student_id=2 
        AND classpositionals.class_id=1 
        AND classpositionals.session_id=7
        AND classpositionals.term_id=1
        AND classpositionals.school_id=2";
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


        






















    
}