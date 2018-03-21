<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$b_postaladd=$_POST['postal_add'];
$b_permadd=$_POST['perm_add'];
$b_pin=$_POST['per_pin'];
$b_gender=$_POST['gender'];
$b_dob =$_POST['dob'];
$for_cmp1=strtotime($b_dob);
$for_cmp2=strtotime($dob);
$q1=set_progress('per');
$q2=set_bits('per');
$q3=check_appr();
date_default_timezone_get("Asia/Kolkata");
$q4 = date("Y-m-d H:i:s");
$history="";
$changed=0;
if($b_postaladd!=$postal_add)
{
	$history="Postal Address";
	enter_history();
}
if($b_permadd!=$perm_add)
{
	$history="Permanent Address";
	enter_history();
}
if($b_pin!=$per_pin)
{
	$history="Pincode";
	enter_history();
}
if($b_gender!=$gender)
{
	$history="Gender";
	enter_history();
}

$sql2="UPDATE Candidates SET Progress='$q1',Status_bits='$q2',isUpdated='$q3',Upd_Per='$q4' where Email='$login_email'";
$result2=mysqli_query($con,$sql2);

$sql="UPDATE Candidates SET Postal_Add='$b_postaladd',Perm_Add='$b_permadd',Per_Pincode='$b_pin',Gender='$b_gender',DOB='$b_dob' where Email='$login_email'";
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