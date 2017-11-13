<?php // You need to add server side validation and better error handling here
session_start();
require '../../vendor/autoload.php';
use ScoreSheet\dbConnection;
use ScoreSheet\client;
use ScoreSheet\student;
use ScoreSheet\staff;
//use \PDO;
$dbConnection = new dbConnection();
$student = new student($dbConnection);
$staff = new staff($dbConnection);
$client = new client($dbConnection);
$clientid = $_SESSION['user_info'][4];
//$newStaff = new student();
$userid = $_SESSION['user_info'][0];
$myroleid = $_SESSION['user_info'][2];
$staff->staffUser($myroleid,$clientid);
$data = array();

//function to get file extension
 function getExtension($str){
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

 //function to get random file name
 function rand_string($l){ 
  $rand="";
  $s= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; 
  srand((double)microtime()*1000000); 
  for($i=0; $i<$l; $i++) { 
  $rand.= $s[rand()%strlen($s)]; 
  } 
  return $rand; 
 }

 $l = 9;
$name= rand_string($l);

//get the files from the cclient
if(isset($_GET['files']))
{	
	$error = false;
	$files = array();

	$uploaddir = './galleryUploads/';
	foreach($_FILES as $file)
	{

			$fileName = basename($file['name']);
			$extension = strtolower(getExtension($fileName));
			$size = $file['size'];
			$sizeKb = $size/1024;

			//check file size limitations
			if($sizeKb<=100)
			{
				//true the process the file and check for appropriate file extensions
				if(($extension == "jpg") || ($extension == "jpeg") || ($extension =="png") || ($extension == "gif"))
				{
					
					//process the whole file, it is safe
					 $image_name=time().$name.'.'.$extension;
            		//the new name will be containing the full path where will be stored (images folder)
            		$newname=$uploaddir.$image_name;
					
					if(move_uploaded_file($file['tmp_name'], $newname))
						{
							
								include'classes/db.php';
					            //upload image in the database
					            		$query ="UPDATE client_signup SET client_img =? WHERE id= ?";
					                    $stmt= $db->prepare($query);
					                    $stmt->bindParam(1, $newname, PDO::PARAM_STR);
					                    $stmt->bindParam(2, $id, PDO::PARAM_STR);
					                    $stmt->execute();
							                  if ($stmt->rowCount() == 1)
							                  {
							                  	echo json_encode("ok");
							                    //echo json_encode("Your school logo is uploaded");
							                    }
					              			else
					              		{
					              			  echo json_encode("Aha! logo not saved");
								            }

						}

						else
						{
						    echo json_encode("Your image can not be copied to disk, if this persist call support team!");
						}
				}
				else
				{
					//throw a message about file extension
					echo json_encode("Your image has a wrong file extension. Your image has" . " " . $extension . " file extension ");
				}
			}
			else
			{
				//send error about file size
				echo json_encode("Your image is too large with a size of" . " " . $sizeKb . ", " ." please choose a size in KB less than or equal to 100.");
		
			}

			//echo json_encode("Your image is uploaded successfully, but return message is in json format". 
			//" ". $fileName. " , ". 
			//$extension. " and the size is". " " . $size);
	}
}
else
{
	echo json_encode("Select an image to upload");
}
//code from old sript
//echo json_encode($data);

?>