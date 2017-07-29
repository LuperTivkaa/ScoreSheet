<?php 
$clientObj = new client();
$clientid = $_SESSION['sess_info'][0];

$result = $clientObj->schHeader($clientid);
foreach ($result as $row => $key) 
         {
            $schName = ucfirst($key['institution_name']);
			$image= $key['inst_logo'];
            		 }

?>
<h5 class="right-menu-header">

	<?php if (empty($schName) || empty($image))
	{
		echo "No School Profile Added Yet!";
		}
		else
			{
				echo $schName;
				} ?>

</h5>
<hr>