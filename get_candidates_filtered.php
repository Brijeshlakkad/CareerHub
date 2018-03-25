<?php
require_once('functions.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
get_job_details();
function get_job($jobid)
{
	global $con,$institute_id,$row_job;
	$sql="select * from jobs where job_id='$jobid' and institute_id='$institute_id'";
	$res=mysqli_query($con,$sql);
	$row_job=mysqli_fetch_array($res);
}
function find_cand_quali($jobid)
{
		global $con,$institute_id,$matched_quali,$row_job;
		get_job($jobid);
		$arr_job_quali=explode(",",$row_job['required_skills']);
		$sql="select * from candidates";
		$res=mysqli_query($con,$sql);
		$str="";
		$t=0;
		while($row=mysqli_fetch_array($res))
		{
			$sbits=$row['Status_bits'];
			$bits=explode(",/,",$sbits);
			if(count($bits)>1 && $bits[1]==1)
			{
				$arr_cand_quali=explode(",/,",$row['Quali']);
				$counter=0;
				for($i=0;$i<count($arr_job_quali);$i++)
				{
					for($j=0;$j<count($arr_cand_quali);$j++)
					{
						$comp1=strtolower($arr_job_quali[$i]);
						$comp2=strtolower($arr_cand_quali[$j]);
						if($comp1==$comp2)
						{
							$counter++;
							break;
						}
					}
				}
				if(count($arr_job_quali)==$counter)
				{
					$matched_quali[$t]=$row['ID'];
					$t++;
				}
			}
		}
}
function find_cand_experience($jobid)
{
	global $con,$institute_id,$row_job,$matched_exp;
	get_job($jobid);
	$sql="select * from candidates";
	$res=mysqli_query($con,$sql);
	$i=0;
	while($row=mysqli_fetch_array($res))
	{
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		if(count($bits)>1 && $bits[1]==1)
		{
			$j_exp=$row_job['experience'];
			if(intval($j_exp)==0 || $row['Intern']=='No')
			{
				$matched_exp[$i]=$row['ID'];
				$i++;
			}
			else
			{
				if($row['Experience']==$j_exp)
				{
					$matched_exp[$i]=$row['ID'];
					$i++;
				}
			}
		}
	}
}
function find_cand_location($jobid)
{
	global $con,$institute_id,$row_job,$matched_location;
	get_job($jobid);
	$sql="select * from candidates";
	$res=mysqli_query($con,$sql);
	$i=0;
	while($row=mysqli_fetch_array($res))
	{
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		if(count($bits)>1 && $bits[1]==1)
		{
			$j_country=strtolower(trim($row_job['country']));
			$j_state=strtolower(trim($row_job['state']));
			$j_city=strtolower(trim($row_job['city']));
			if($j_country==strtolower(trim($row['Country'])))
			{
				if($j_state==strtolower(trim($row['State'])))
				{
					if($j_city==strtolower(trim($row['City'])))
					{
						$matched_location[$i]=$row['ID'];
						$i++;
					}
				}
			}
		}
	}
}
if(isset($_POST['flag']))
{
	$flag=$_POST['flag'];
	if($flag=="best_match" && isset($_POST['job_id']))
	{
		$jobid=$_POST['job_id'];
		find_cand_quali($jobid);
		find_cand_experience($jobid);
		find_cand_location($jobid);
	}
}
?>