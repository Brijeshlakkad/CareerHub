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
function get_details_from_candidate()
{
if(isset($_SESSION['Userid']))
{
	global $con;
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
	$user_check=$_SESSION['Userid'];
	$r="select * from Candidates where Email='$user_check' ";
	$ses_sql=mysqli_query($con,$r);
	$row=mysqli_fetch_assoc($ses_sql);
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
}
}

?>