<?php
include_once("config.php");
include_once("functions.php");
if(isset($_SESSION['BUserid']))
{
	$user_check=$_SESSION['BUserid'];
	$r="select * from Institutes where Email='$user_check' ";
	$ses_sql=mysqli_query($con,$r);

	$row=mysqli_fetch_assoc($ses_sql);
	$login_name=$row['Name'];
	$login_email=$row['Email'];
	$login_password=$row['Password'];
	$login_mno=$row['Phone'];
	$sbits=$row['Status_bits'];
	$bits=explode(",",$sbits);
	
	mysqli_close($con);
}
?>