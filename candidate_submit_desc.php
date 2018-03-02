<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$b_desc=$_POST['desc'];
$q1=set_progress('desc');
$q2=set_bits('desc');
$q3=check_appr();
date_default_timezone_get("Asia/Kolkata");
$q4 = date("Y-m-d H:i:s");
$sql="UPDATE Candidates SET Progress='$q1',Status_bits='$q2',isUpdated='$q3',Upd_desc='$q4' where Email='$login_email'";
$result2=mysqli_query($con,$sql);

$sql="UPDATE Candidates SET Description='$b_desc' where Email='$login_email'";
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