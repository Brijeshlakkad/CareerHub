<?php
include_once("config.php");

function check_already($cid)
{
		global $con,$sbits,$updated,$bits;
		$sql="select * from Candidates where ID='$cid'";
		$result=mysqli_query($con,$sql);
		if(!$result)
			echo "00";
		$row=mysqli_fetch_array($result);
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
		$updated=$row['isUpdated'];
		return count($bits);
}
if(isset($_POST['id']) && isset($_POST['flag']))
{
	$id=$_POST['id'];
	$flag=$_POST['flag'];
	if($flag==1)
	{
		if(check_already($id)==1 ||(check_already($id)>=1 && $bits[1]==1 && $updated==1))
		{
			if(check_already($id)>=1 && $bits[1]==1 && $updated==1){
				
			}else{
				$sbits.=",/,"."1";
			}
			$sql="Update Candidates SET Status_bits='$sbits',isUpdated='0' where ID='$id'";
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
		if(check_already($id)==1 ||(check_already($id)>=1 && $bits[1]==1 && $updated==1))
		{
			$sbits.=",/,"."0";
			$sql="Update Candidates SET Status_bits='$sbits',isUpdated='0' where ID='$id'";
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