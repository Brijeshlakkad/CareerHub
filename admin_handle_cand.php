<?php
include_once("config.php");
$sbits="";
function check_already($cid)
{
		global $con,$sbits;
		$sql="select * from Candidates where ID='$cid'";
		$result=mysqli_query($con,$sql);
		if(!$result)
			echo "00";
		$row=mysqli_fetch_array($result);
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		return count($bits);
}
if(isset($_POST['id']) && isset($_POST['flag']))
{
	$id=$_POST['id'];
	$flag=$_POST['flag'];
	if($flag==1)
	{
		if(check_already($id)==1)
		{
			$sbits.=",/,"."1";
			$sql="Update Candidates SET Status_bits='$sbits' where ID='$id'";
			$result=mysqli_query($con,$sql);
			if($result)
				echo "11";
			else
				echo "10";
		}
		else
			echo "01";
	}
	else if($flag==0)
	{
		if(check_already($id)==1)
		{
			$sbits.=",/,"."0";
			$sql="Update Candidates SET Status_bits='$sbits' where ID='$id'";
			$result=mysqli_query($con,$sql);
			if($result)
				echo "11";
			else
				echo "10";
		}
		else
			echo "01";
	}
}
?>