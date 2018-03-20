<?php 
include_once("functions.php");
include_once("config.php");
function get_details_from_institute()
{
	global $con,$email,$institute_id,$institute_name,$bits,$im;

$email=$_SESSION['Userid'];
$ch="select * from institutes where Email='$email'";
$q=mysqli_query($con,$ch);
$count=mysqli_num_rows($q);
$r1=mysqli_fetch_array($q);
if($count>0)
{
	$institute_id=$r1['ID'];
	$institute_name=$r1['Bname'];
	$sbit=$r1['Status_bits'];
	$bits=explode(",/,",$sbit);
	$login_image=$r1['Image'];
	$im=base64_encode($login_image);
}
}

?>