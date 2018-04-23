<?php
require_once('institute_functions.php');
require_once('functions.php');
@session_start();
get_details_from_institute();

//header('Location:institute_view_applications.php');

if(isset($_POST['candidate_id']) && isset($_POST['application_id']) && isset($_POST['application_type'])) 
{

	$candidate_id=$_POST['candidate_id'];
	$apply_type=$_POST['application_type'];
	$application_id=$_POST['application_id'];
	$check_already_rank="select * from applications where `candidate_id`='$candidate_id' and `application_id`='$application_id' and `status_bit`=1";
		$ex_already_rank=mysqli_query($con,$check_already_rank);
		$count_already=mysqli_num_rows($ex_already_rank);
		
		if($count_already==1)
		{

		$inc_rank="select Candidate_rank from candidates where `ID`='$candidate_id'";
		$ex_inc_rank=mysqli_query($con,$inc_rank);
		$rank_array=mysqli_fetch_array($ex_inc_rank);
		$rank=$rank_array['Candidate_rank'];
			if($apply_type=='applyfromuser')
			{
				$incr=50;
			}
			else if($apply_type=='offertouser')
			{
				$incr=100;
			}
			else
			{
				die('try again');
			}
		$new_rank=$rank+$incr;
		$apply_rank="update candidates set `Candidate_rank`='$new_rank' where `ID`='$candidate_id'";
		$ex_apply=mysqli_query($con,$apply_rank);
		
		}
}

?>