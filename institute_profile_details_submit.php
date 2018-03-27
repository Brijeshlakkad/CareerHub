<?php 
require('functions.php');
require('institute_functions.php');

check_session();
get_details_from_institute();

if(isset($_POST['description']))
{
	$description=protect_anything($_POST['description']);
	if($description=='')
	{
		echo '<span style="color:red">Error:Please enter description</span>';
	}
	else
	{
		$ins_desc="update institutes set `institute_descr`='$description' where `ID`='$institute_id'";
		$ins_desc_exe=mysqli_query($con,$ins_desc);
		if($ins_desc_exe)
		{
			echo '<span style="color:green">Description added</span>';
		}
		else
		{
			echo '<span style="color:red">Please try again later</span>';
		}
	}
}
if(isset($_POST['details']))
{
	$type=protect_anything($_POST['type']);
	$address=protect_anything($_POST['address']);
	$country=protect_anything($_POST['country']);
	$zip=protect_anything($_POST['zip']);
	if($type==''||$address==''||$country==''||$zip=='')
	{
		echo '<span style="color:red">Error:Please enter all details</span>';
	}
	else
	{
		$ins_details="update institutes set `institute_type`='$type',`institute_address`='$address',`institute_country`='$country',`institute_zip`='$zip' where `ID`='$institute_id'";
		$ins_details_exe=mysqli_query($con,$ins_details);
		if($ins_details_exe)
		{
			echo '<span style="color:green">Details added</span>';
		}
		else
		{
			echo '<span style="color:red">Please try again later</span>';
		}
	}
}
?>