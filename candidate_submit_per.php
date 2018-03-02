<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$b_postaladd=protect_anything($_POST['postal_add']);
$b_permadd=protect_anything($_POST['perm_add']);
$b_pin=protect_anything($_POST['per_pin']);
$b_gender=protect_anything($_POST['gender']);
$b_dob =$_POST['dob'];

$q1=set_progress('per');
$q2=set_bits('per');
$q3=check_appr();
date_default_timezone_get("Asia/Kolkata");
$q4 = date("Y-m-d H:i:s");
$sql="UPDATE Candidates SET Progress='$q1',Status_bits='$q2',isUpdated='$q3',Upd_Per='$q4' where Email='$login_email'";
$result2=mysqli_query($con,$sql);


$sql="UPDATE Candidates SET Postal_Add='$b_postaladd',Perm_Add='$b_permadd',Per_Pincode='$b_pin',Gender='$b_gender',DOB='$b_dob' where Email='$login_email'";
$result1=mysqli_query($con,$sql);

if($result1 && $result2)
{
	echo "1";
}
else
{
	echo "0";
}
?>