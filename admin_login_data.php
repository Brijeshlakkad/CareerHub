<?php
include_once("functions.php");
include_once("config.php");
check_session();
$email=protect_anything($_POST['l_email']);
$password=protect_anything($_POST['l_password']);
$email1="lakkadbrijesh@gmail.com";
$pass1="123456bB";
if($email==$email1 && $password==$pass1)
{
	$_SESSION['Admin']=$email;
	echo "1";
}
else
{
	echo "0";
}

?>