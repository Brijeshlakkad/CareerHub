<?php 
require_once('institute_functions.php');
require_once('functions.php');
@session_start();
get_details_from_institute();
if(isset($_POST['action']) && isset($_POST['application_id']) && isset($_POST['cand_id'])){
	$action=$_POST['action'];
	$application_id=$_POST['application_id'];
	$cand_id=$_POST['cand_id'];
	if($action=='accept')
	{	
	$q1="update applications set status_bit='1' where application_id=$application_id and institute_id='$institute_id'";
	$ex1=mysqli_query($con,$q1);
	if($ex1)
	{
		echo "11";
	}
	else
		echo "00";
	}
	else if($action=='reject')
	{
	$q1="update applications set status_bit='0' where application_id=$application_id and institute_id='$institute_id'";
	$ex1=mysqli_query($con,$q1);
	if($ex1)
		echo "11";
	else
		echo "00";
	}
	
}
?>