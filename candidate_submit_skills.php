<?php
include_once("functions.php");
include_once("config.php");
include_once("candidate_details.php");
check_session();
get_details_from_candidate();
$skills=$_POST['skills'];
$strskils=implode(",/,",$skills);
if($qualis[0]=='0')
{
	$barV+=20;
}

$sql="UPDATE Candidates SET Progress='$barV',Quali='$strskils' where Email='$login_email'";
$result=mysqli_query($con,$sql);
if($result)
{
	header("location:candidate_profile.php");
}
else
{
	$q=mcrypt_encrypt("Set");
	header("location:candidate_add_quali.php?q='$q'");
}
?>