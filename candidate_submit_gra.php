<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$b_course=$_POST['course'];
$b_college=$_POST['college'];
$b_year=$_POST['year'];
$b_intern=$_POST['intern'];
$b_colpin=$_POST['col_pin'];

$q1=set_progress('gra');
$q2=set_bits('gra');
$q3=check_appr();
date_default_timezone_get("Asia/Kolkata");
$q4 = date("Y-m-d H:i:s");
$history="";
$changed=0;
if($b_course!=$course)
{
	$history="Course";
	enter_history();
}
if($b_college!=$college)
{
	$history="College";
	enter_history();
}
if(($b_year."")!=($p_year.""))
{
	$history="Passing Year";
	enter_history();
}
if($b_intern!=$intern)
{
	$history="Internship/Experience";
	enter_history();
}
if($b_colpin!=$col_pin)
{
	$history="College Pincode";
	enter_history();
}


$sql2="UPDATE Candidates SET Progress='$q1',Status_bits='$q2',isUpdated='$q3',Upd_Gra='$q4' where Email='$login_email'";
$result2=mysqli_query($con,$sql2);

$sql="UPDATE Candidates SET Course='$b_course',College='$b_college',Passing_year='$b_year',Intern='$b_intern',College_pincode='$b_colpin' where Email='$login_email'";
$result1=mysqli_query($con,$sql);


if($result1 && $result2 && $changed<=1)
{
	echo "1";
}
else
{
	echo "0";
}
function enter_history()
{
	global $con,$result3,$login_id,$history,$changed;
	$sql3="Insert into History(Field,UserID,role) values('$history','$login_id','Candidate')";
	$result3=mysqli_query($con,$sql3);
	if($result3)
		$changed=1;
	else
		$changed=2;
	$history="";
}
?>