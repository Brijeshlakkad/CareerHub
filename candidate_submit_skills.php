<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$skills=$_POST['skills'];
$strskils=implode(",/,",$skills);

$q1=set_progress('skills');
$q2=set_bits('skills');
$q3=check_appr();
date_default_timezone_get("Asia/Kolkata");
$q4 = date("Y-m-d H:i:s");
$sql="UPDATE Candidates SET Progress='$q1',Status_bits='$q2',isUpdated='$q3',Upd_Qua='$q4' where Email='$login_email'";
$result2=mysqli_query($con,$sql);

$sql="UPDATE Candidates SET Quali='$strskils' where Email='$login_email'";
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