<?php
$q=$_GET['q'];
$f=$_GET['f'];
	if($f=="s_password")
	{
		if($q=="")
			echo "Password is required";
		else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$q))
			echo "Check your password";
	}
else if($f=="s_mobile")
	{
		if($q=="")
			echo "Phone number is required";
		else if(!preg_match("/^[0-9]{10}$/",$q))
			echo "Check your Phone number";
	}
else if($f=="s_email")
	{
		if($q=="")
			echo "Email is required";
		else if(!filter_var($q,FILTER_VALIDATE_EMAIL)==false)
			echo "Check your email";
	}
else if($f=="s_user")
	{
		if($q=="")
			echo "Phone number is required";
		else if(!preg_match("/^[0-9]{10}$/",$q))
			echo "Check your Username";
	}

?>