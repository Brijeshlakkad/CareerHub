<?php
include_once("config.php");

function select_cands_from_db();
{
		global $con,$sbits,$result,$row;
		$sql="select * from Candidates";
		$result=mysqli_query($con,$sql);
		if(!$result)
			echo "<span style='color:red;'>Please, try again, later.</span>";
		$row=mysqli_fetch_array($result);
		$sbits=$row['Status_bits'];
		$bits=explode(",/,",$sbits);
}
if(isset($_POST['id']) && isset($_POST['flag']))
{
	global $bits;
	$id=$_POST['id'];
	$flag=$_POST['flag'];
	select_cands_from_db();
	while($row)
	{
		if($flag=="all")
		{
			$len=mysqli_num_rows($result);
			
		}
	}
}
?>