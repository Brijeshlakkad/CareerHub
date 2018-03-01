<?php
include_once("functions.php");
include_once("config.php");
check_session();
$bits=array();
$login_id="";
$login_email="";
$login_name="";
$login_mno="";
$login_image="";
$row="";
function connect_with_row()
{
	global $con;
	global $row;
	$user_check=$_SESSION['Userid'];
	$r="select * from Candidates where Email='$user_check' ";
	$ses_sql=mysqli_query($con,$r);
	$row=mysqli_fetch_assoc($ses_sql);
}
function get_details_from_candidate()
{
	connect_with_row();
	global $row;
	global $login_id;
	global $login_name;
	global $login_email;
	global $login_mno;
	global $login_image;
	global $sbit;
	global $bits;
	global $barV;
	global $squali;
	global $qualis;
	global $course;
	global $college;
	global $p_year;
	global $intern;
	global $postal_add;
	global $perm_add;
	global $per_pin;
	global $dob;
	global $gender;
	$login_id=$row['ID'];
	$login_name=$row['Name'];
	$login_email=$row['Email'];
	$login_mno=$row['Phone'];
	$login_image=$row['Image'];
	
	$sbit=$row['Status_bits'];
	$bits=explode(",/,",$sbit);
	
	$barV=$row['Progress'];
	
	$squali=$row['Quali'];
	$qualis=explode(",/,",$squali);
	
	$course=$row['Course'];
	$p_year=$row['Passing_year'];
	$intern=$row['Intern'];
	$college=$row["College"];
	
	$postal_add=$row['Postal_Add'];
	$perm_add=$row['Perm_Add'];
	$per_pin=$row['Per_pincode'];
	$dob= date('d/m/Y', strtotime($row['DOB']));
	$gender=$row['Gender'];
}
function set_progress($f)
{
	global $course;
	global $qualis;
	global $gender;
	global $barV;
	get_details_from_candidate();
	if($f=="skills")
	{
		if($qualis[0]=='0')
		{
				$barV+=15;
		}
		return $barV;
	}
	else if($f=="gra")
	{
		if($course == '-99')
		{
				$barV+=15;
		}
		return $barV;
	}
	else if($f=="per")
	{
		if($gender == '-99')
		{
				$barV+=15;
		}
		return $barV;
	}
}
function set_bits($f)
{
	global $course;
	global $qualis;
	global $gender;
	global $bits;
	get_details_from_candidate();
	if($f=="skills")
	{
		if($qualis[0]=='0')
		{
			$bits[0]+=1;
		}
		return implode(",/,",$bits);
	}
	else if($f=="gra")
	{
		if($course=='-99')
		{
			$bits[0]+=1;
		}
		return implode(",/,",$bits);
	}
	else if($f=="per")
	{
		if($gender == '-99')
		{
			$bits[0]+=1;
		}
		return implode(",/,",$bits);
	}
}
?>