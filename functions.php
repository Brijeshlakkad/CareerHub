<?php
session_start();
function protect_anything($str)
{
	$str = addslashes($str);
	$str = stripslashes($str);
	return $str;
}
function check_session()
{
	if((!isset($_SESSION['Userid'])) && (!isset($_SESSION['Admin'])))
	{
		if(!isset($_SESSION['Admin']))
			header("Location:index.php");
		header("Location:index.php");
	}
}
?>