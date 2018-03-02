<?php
include_once("config.php");
if(isset($_POST['s_user']) && isset($_POST['s_email']) && isset($_POST['s_mobile']) && isset($_POST['s_password']))
{
	$name=$_POST['s_user'];
	$email=$_POST['s_email'];
	$mobile=$_POST['s_mobile'];
	$pass=$_POST['s_password'];
	$sql="Update Candidates SET Name='$name',Phone='$mobile',Password='$pass' Where Email='$email'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		echo "1";
	}
	else
		echo "0";
}
?>