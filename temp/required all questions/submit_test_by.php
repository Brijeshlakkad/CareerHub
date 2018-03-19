<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
if(isset($_POST['test_id']))
{
	
	$testid=protect_anything($_POST['test_id']);
	$sql="Select * from Tests where ID='$testid'";
	$result=mysqli_query($con,$sql);
	
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$total_que=$row['Total_num'];
		$sql2="Select * from Questions where TestID='$testid'";
		$result2=mysqli_query($con,$sql2);
		$i=0;
		$remained_que=0;
		while($row2=mysqli_fetch_array($result2))
		{
			$a=$row2['ID'];
			if(isset($_POST[''.$a]))
			{
				$ans_by=$_POST[''.$a];
				if($row2['Ans']==$ans_by)
				{
					$i++;
				}
			}
			else
			{
				$remained_que++;
			}
			
		}
		$re_taken="<div>".$i." out of ".$total_que."</div>";
	}
}
?>
<div class="container-fluid well">
	<div class="row">
		<div id="show_result">
			<h2><?php echo $re_taken; ?></h2>
			<h3><?php echo $remained_que; ?></h3>
		</div>
	</div>
</div>
</body>
</html>