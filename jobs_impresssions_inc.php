<?php
include_once('functions.php');
include_once("config.php");

include_once('candidate_details.php');
check_session();
get_details_from_candidate();

if(isset($_POST['job_id']) && isset($_POST['application_type'])) 
{
	$jobid=$_POST['job_id'];
	$apply_type=$_POST['application_type'];
	$check_already_impression="select * from applications where `job_id`='$jobid' and `candidate_id`='$login_id'";
		$ex_already_impression=mysqli_query($con,$check_already_impression);
		$count_already=mysqli_num_rows($ex_already_impression);
		if($count_already==1)
		{

		$inc_impress="select * from jobs where `job_id`='$jobid'";
		$ex_inc_impress=mysqli_query($con,$inc_impress);
		$impress_array=mysqli_fetch_array($ex_inc_impress);
		$impressions=$impress_array['job_impressions'];
			if($apply_type=='applyfromuser')
			{
				$incr=20;
			}
			else if($apply_type=='offeracceptfromuser')
			{
				$incr=10;
			}
			else
			{
				die('try again');
			}
		$impressions=$impressions+$incr;
		$apply_impress="update jobs set `job_impressions`='$impressions' where `job_id`='$jobid'";
		$ex_apply=mysqli_query($con,$apply_impress);
		
		}
}
?>