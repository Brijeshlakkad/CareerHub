<!DOCTYPE html>
<html>
<head>
	<title></title>

</head>
<body>
	<?php 
require_once('institute_functions.php');
require_once('functions.php');
@session_start();
get_details_from_institute();
if(isset($_POST['action']) && isset($_POST['application_id'])){
	$action=$_POST['action'];
	$application_id=$_POST['application_id'];
	if($action=='accept')
	{	
	$q1="update applications set status_bit='1' where application_id=$application_id and institute_id='$institute_id'";
	$ex1=mysqli_query($con,$q1);
	if($ex1)
	{
		$forcandidateid="select job_id,candidate_id from applications where application_id=$application_id";
		$forcandidateid_ex=mysqli_query($con,$forcandidateid);
		$candidate_array=mysqli_fetch_array($forcandidateid_ex);
		$candidate_id=$candidate_array['candidate_id'];
		$job_id=$candidate_array['job_id'];
		$success=1;

		/* candidate rank inc. start */
		$apply_type='applyfromuser';
		$check_already_rank="select * from applications where `candidate_id`='$candidate_id' and `job_id`='$job_id' and `rank_allocated`=1";
		$ex_already_rank=mysqli_query($con,$check_already_rank);
		$count_already=mysqli_num_rows($ex_already_rank);
		
		if($count_already>0)
		{

		}
		else
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

		$set_rank_allocated="update applications set `rank_allocated`='1' where `application_id`='$application_id' and `candidate_id`='$candidate_id'";
		$ex_set_rank_allocated=mysqli_query($con,$set_rank_allocated);

		
		}
		/* candidate rank ends */
	}
	else
	{
		//echo "00";
	}

	}
	else if($action=='reject')
	{
	$q1="update applications set status_bit='0' where application_id=$application_id and institute_id='$institute_id'";
	$ex1=mysqli_query($con,$q1);
	if($ex1){
		//echo "11";
	}
	else{
		//echo "00";
	}
	}
	
}
?>
</body>

<!--
<script type="text/javascript">

	var successvar=<?php // echo $success;?>;
	if(successvar==1){
		$.ajax({
			url: 'candidate_rank_inc.php',
			type: 'POST',
			data:{ 
			'candidate_id': <?php // echo $candidate_id; ?>,
			'application_id': <?php // echo $application_id; ?>,
			'application_type': 'applyfromuser'
			},
			success: function(result){
				
			}
		});
	}

</script>
-->
</html>

