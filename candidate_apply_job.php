<?php
include_once('functions.php');
include_once("config.php");

include_once('candidate_details.php');
check_session();
get_details_from_candidate();

if(isset($_POST['jobid']))
{
	$jobid=$_POST['jobid'];
	$q_inst_id="select institute_id from jobs where `job_id`='$jobid'";
	$ex_q_inst_id=mysqli_query($con,$q_inst_id);
	if($ex_q_inst_id)
	{
		$row=mysqli_fetch_array($ex_q_inst_id);
		$inst_id=$row['institute_id'];			
	}

	$check_already_applied="select * from applications where `job_id`='$jobid' and `candidate_id`='$login_id'";
	$ex_already_applied=mysqli_query($con,$check_already_applied);
	$count=mysqli_num_rows($ex_already_applied);
	if($count!=0)
	{
		echo "Already Applied";
	}
	else
	{

	$apply="insert into applications(`candidate_id`,`institute_id`,`job_id`)values('$login_id','$inst_id','$jobid')";
	$ex_apply=mysqli_query($con,$apply);
	if($ex_apply)
	{
		echo "Applied";
	}
	else
	{
		echo "Failed";
	}

	}

}
?>