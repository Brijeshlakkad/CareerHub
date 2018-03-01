<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$b_course=protect_anything($_POST['course']);

$b_college=protect_anything($_POST['college']);
$b_year=protect_anything($_POST['year']);
$b_intern=protect_anything($_POST['intern']);
$b_colpin=protect_anything($_POST['col_pin']);

$q1=set_progress('gra');
$q2=set_bits('gra');
$sql="UPDATE Candidates SET Progress='$q1',Status_bits='$q2' where Email='$login_email'";
$result2=mysqli_query($con,$sql);

$sql="UPDATE Candidates SET Course='$b_course',College='$b_college',Passing_year='$b_year',Intern='$b_intern',College_pincode='$b_colpin' where Email='$login_email'";
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