<?php
include_once("config.php");
include_once("functions.php");
check_session();
$senderid=$_POST['parid'];
$title=$_POST['title'];
$course=$_POST['course'];
$subjects=$_POST['subjects'];
$sql="Insert into Tests(Title,Course,Subjects,PostedBy) values('$title','$course','$subjects','$senderid')";
$result=mysqli_query($con,$sql);
if($result)
{
	$sql="Select ID from Tests Where Title='$title'";
	$re=mysqli_query($con,$sql);
	if($re)
	{
		$row=mysqli_fetch_array($re);
		$id=$row['ID'];
		echo $id."";
	}
	else
		echo "-11";
}
else
	echo "-1";
?>