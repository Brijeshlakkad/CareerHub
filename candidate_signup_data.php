<?php
include_once("config.php");
include_once("functions.php");
$name=protect_anything($_POST['s_user']);
$mobile=protect_anything($_POST['s_mobile']);
$email=protect_anything($_POST['s_email']);
$password=protect_anything($_POST['s_password']);
$sql2="select * from Candidates where Email='$email'";
$result=mysqli_query($con,$sql2);
$r=mysqli_num_rows($result);

if($r==1)
{
	echo "<p style='color:blue;'>please login You have already submitted from once.</a>";
	return;
}
$sql="INSERT INTO Candidates (Name,Email,Phone,Password) values('$name','$email','$mobile','$password')";

if(mysqli_query($con,$sql))
{
	header("location:signup_mail.py");
}
else
{
	echo "<p style='color:blue;'>Error in submitting</p><a href='index.php'>try again</a>";
}

mysqli_close($con);
?>