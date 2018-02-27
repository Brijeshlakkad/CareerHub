<?php
include_once("config.php");
include_once("functions.php");
check_session();
$email=protect_anything($_POST['l_email']);
$password=protect_anything($_POST['l_password']);
$sql="SELECT * FROM Institutes WHERE Email='$email' AND Password='$password'";
$result=mysqli_query($con,$sql);
$r=mysqli_num_rows($result);
$row=mysqli_fetch_assoc($result);
if($r==1)
{
	$_SESSION['BUserid']=$email;
	echo "1";
	return;
}
else
{
	echo "0";
	return;
}

?>