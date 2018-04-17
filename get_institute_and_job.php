<?php 
include_once("functions.php");
include_once("config.php");
function get_institute($inst_id)
{
	global $con,$institute_id,$institute_name,$institute_email,$institute_contact,$bits_inst,$inst_im;
	global $institute_type,$institute_descr,$institute_address,$institute_country,$institute_zip;
	$sql="select * from Institutes where ID='$inst_id'";
	$result=mysqli_query($con,$sql);
	if(!$result)
		die("Server is down.");
	$row_inst=mysqli_fetch_array($result);
	$inst_im=base64_encode($row_inst['Image']);
	$institute_id=$row_inst['ID'];
	$institute_name=$row_inst['Bname'];
	$institute_email=$row_inst['Bemail'];
	$institute_contact=$row_inst['Phone'];
	$sbit_inst=$row_inst['Status_bits'];
	$bits_inst=explode(",/,",$sbit_inst);
	$institute_type=$row_inst['institute_type'];
	$institute_descr=$row_inst['institute_descr'];
	$institute_address=$row_inst['institute_address'];
	$institute_country=$row_inst['institute_country'];
	$institute_zip=$row_inst['institute_zip'];
}
function get_all_jobsid($id)
{
	global $con;
	$sql="select job_id from jobs where institute_id='$id'";
	$res=mysqli_query($con,$sql);
	if(!$res)
		die("Server is down.");
	$i=0;
	while($row_j=mysqli_fetch_array($res))
	{
		$job_arr[$i]=$row_j['job_id'];
		$i++;
	}
	return $job_arr;
}
function get_job($id,$jobid)
{
	global $con;
	global $job_title,$isJob,$job_cata,$job_skills,$job_role,$job_vacancy,$job_quali,$job_exp,$job_close,$job_salary;
	$sql="select * from jobs where job_id='$jobid' and institute_id='$id'";
	$res=mysqli_query($con,$sql);
	if(!$res)
		die("Server is down.");
	$row_job=mysqli_fetch_array($res);
	$job_title=ucwords($row_job['job_title']);
	$isJob=ucwords($row_job['job/training']);
	$job_cata=ucwords($row_job['category']);
	
	$job_skills=trim(str_replace(",",", ",$row_job['required_skills']));
	
	$job_role=ucwords($row_job['role']);
	$job_vacancy=$row_job['vacancy'];
	$job_quali=str_replace(",","/ ",ucwords($row_job['qualification']));
	$job_exp=$row_job['experience'];
	$j_close=strtotime($row_job['closing_date']);
	$job_close=date("d-m-Y",$j_close);
	$job_salary="INR ".$row_job['expected_salary'];
}
?>