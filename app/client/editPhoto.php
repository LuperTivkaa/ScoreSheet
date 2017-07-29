<?php 
ob_start();
include'inc/regSession.php';
$reg = $_SESSION['ID'];
//end of session code
  include'classes/db.php';
	$selQuery = "SELECT image FROM app_info WHERE App_No='$reg'";
		$result = $db->prepare($selQuery);
 		$result->bindParam(1, $reg, PDO::PARAM_STR,12);
 		$result->execute();
		
            if ($result->rowCount() >=1)
			{

			foreach ($result as $row => $key) 
			{
            //$ID = $key['ID'];
            $image = $row['image'];
			} 
			}
			else
			{
			$alert = "Image not found";
			header("location:editPhoto.php?msg=$alert");
			exit();   
			}
//define allowed characters in $s and length for the string in $l
function rand_string($l){ 
$rand="";
  $s= "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"; 
  srand((double)microtime()*1000000); 
  for($i=0; $i<$l; $i++) { 
  $rand.= $s[rand()%strlen($s)]; 
  } 
  return $rand; 
 }
//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","50"); 

//This function reads the extension of the file. It is used to determine if the
// file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

//This variable is used as a flag. The value is initialized with 0 (meaning no 
// error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
//checks if the form has been submitted
$l = 9;
$name= rand_string($l);
 if(isset($_POST['upload'])) 
 {
 	//reads the name of the file the user submitted for uploading
 	$image=$_FILES['image']['name'];
 	//if it is not empty
 	if ($image) 
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
	//otherwise we will do more tests
 				if (($extension != "jpg") && ($extension != "jpeg") && ($extension !="png") && ($extension != "gif")) 
 				{
				//print error message
				$alert = "Wrong file extension";
 				header("location:editPicture.php?msg=$alert");
				exit();
 				}
 				else
 				{
				//get the size of the image in bytes
 				//$_FILES['image']['tmp_name'] is the temporary filename of the file
 				//in which the uploaded file was stored on the server
 				$size=filesize($_FILES['image']['tmp_name']);
				//compare the size with the maxim size we defined and print error if bigger
						if ($size > MAX_SIZE*1024)
						{
						$alert = "You have exceeded the picture size limit, please resize your picture in the region of 45kb-50kb";
						header("location:editPhoto.php?msg=$alert");
						exit();
						}
						else
						{
						//we will give an unique name, for example the time in unix time format
						$image_name=time().$name.'.'.$extension;
						//the new name will be containing the full path where will be stored (images folder)
						$newname="applicationImages/".$image_name;
						//we verify if the image has been uploaded, and print error instead
						$copied = copy($_FILES['image']['tmp_name'], $newname);
						if ($copied) 
						{
					$query ="UPDATE app_info SET image ='$newname' WHERE App_No= '$reg'";
                    $stmt= $db->prepare($query);
                    $stmt->bindParam(1, $reg, PDO::PARAM_STR);
                    $stmt->execute();
                    if ($stmt->rowCount() == 1)
                    {
					unlink("$image");
                    $alert = "Photo updated!";
                    header("Location:editPhoto.php?msg=$alert");
                    exit();
                    }
					else
					{
					$alert = "Unable to save update photo!";
					header("Location:editPhoto.php?msg=$alert");
					exit();
					}
						}
		 								else
		 								{
										$alert ="Image could not be uploaded into the database successfully, try again later";
		 								header("location:editPhoto.php?msg=$alert");
		 								exit();
		 								}
								
						}
					}
			}
			else
			{
			$alert ="You must select an image to upload";
		 	header("location:editPhoto.php?msg=$alert");
		 	exit();
			}
	}
	else
	{}
//include autoload
include 'inc/autoload.php';
include 'inc/topHeader.php';
ob_end_flush();	
?>
<title>Upload Image</title>
<?php include'inc/userProfileHeader.php'; ?>


<div  class="container mt-3">
<h5><i class="fa fa-wifi" aria-hidden="true"></i>
 Online Application <small class="text-muted"> It's smarter</small></h5>
<hr>

<div class="row">

<!-- include side menu -->
<?php include'inc/sidemenu.php';?>
<!--end of  side menu include-->
    
<!--    div for main content-->
<div class="col-md-9">

<!-- row for main content and side menu -->
<!--    display out and message-->
    <div id="output" class="alert">
    <?php echo $_GET['msg'];?>
    </div>
<!--  end of output class-->
<!--    form-->
    <form action="editPhoto.php"  method="post" enctype="multipart/form-data">
		<h2>Edit Passport</h2>
        <fieldset>
		<div class="row">
            <div class="form-group">
        
              <input type="file" name="image" class="form-control" id="image">
                </div>
        </div>
        <input type="submit" name="upload" class="btn btn-info" id="upload" value="Edit Photo" />
        <!-- <button type="button" class="btn btn-info" onclick="login()">Upload</button> -->
        </fieldset>
	</form>
<!--    form ends here-->
</div>
<!--    end of div for main content-->
</div>
</div>
  <!-- include footer -->
<?php include 'inc/footer.php'; ?>