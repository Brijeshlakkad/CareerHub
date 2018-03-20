<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
function save_result_to_database($testid,$right,$attained,$total,$duration)
{
	global $login_email,$con;
	$sql="Select * from Results where CandID='$login_email' AND TestID='$testid'";
	$result=mysqli_query($con,$sql);
	$num=mysqli_num_rows($result);
	if($num==0)
	{
		$sql2="Insert into Results(CandID,TestID,Rightt,Attained,Total,Left_time) values('$login_email','$testid','$right','$attained','$total','$duration')";
		$result2=mysqli_query($con,$sql2);
		if($result2)
		{
			return "11";
		}
		else
		{
			return "00";
		}
	}
	else
	{
		$sql2="Update Results SET Rightt='$right',Attained='$attained',Left_time='$duration' where CandID='$login_email' and TestID='$testid'";
		$result2=mysqli_query($con,$sql2);
		if($result2)
		{
			return "11";
		}
		else
		{
			return "00";
		}
	}
}
if(isset($_POST['test_id']))
{
	$testid=protect_anything($_POST['test_id']);
	$sql_for_dur="Select * from Visited_test where CandID='$login_email' AND TestID='$testid'";
	$result_for_dur=mysqli_query($con,$sql_for_dur);
	if($result_for_dur)
	{
		$row_for_dur=mysqli_fetch_array($result_for_dur);
		$remained_dur=$row_for_dur['Left_time'];
	}
	$sql_for_test="Select * from tests where Id='$testid'";
	$result_for_test=mysqli_query($con,$sql_for_test);
	if($result_for_test)
	{
		$row_for_test=mysqli_fetch_array($result_for_test);
		$total_dur=$row_for_test['Duration'];
	}
	$duration=$total_dur-$remained_dur;
	$sql="Select * from Tests where ID='$testid'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$title=$row['Title'];
		$total_que=$row['Total_num'];
		$sql2="Select * from Questions where TestID='$testid'";
		$result2=mysqli_query($con,$sql2);
		$right=0;
		$wrong=0;
		$attained=0;
		$remained_que=0;
		$total=mysqli_num_rows($result2);
		while($row2=mysqli_fetch_array($result2))
		{
			$a=$row2['ID'];
			if(isset($_POST[''.$a]))
			{
				$ans_by=$_POST[''.$a];
				if($row2['Ans']==$ans_by)
				{
					$right++;
				}
				else
				{
					$wrong++;
				}
				$attained++;
			}
			else
			{
				$remained_que++;
			}
			
		}
		$xx=save_result_to_database($testid,$right,$attained,$total,$duration);
		if($xx!="11")
		{
			
		}
	}
}
?>
<div class="container-fluid well">
	<div class="row">
		<div id="caption" class="row"><div class="col-lg-offset-2 col-lg-8 col-lg-offset-2"><h3><strong>Test : </strong><?php echo $title; ?></h3><small>(by <?php  echo '<b>'.$login_name."</b>"; ?>)</small></div></div>
		<div id="show_result" class="row">
		<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
			<table class="table">
				<tr>
					<th class="success">Right</th>
					<th class="danger">Wrong</th>
					<th class="info">Attained</th>
					<th class="warning">Remained</th>
					<th class="active">Total Questions</th>
				</tr>
				<tr>
					<td class="success"><?php echo $right; ?></td>
					<td class="danger"><?php echo $wrong; ?></td>
					<td class="info"><?php echo $remained_que; ?></td>
					<td class="warning"><?php echo $attained; ?></td>
					<td class="active"><?php echo $total; ?></td>
				</tr>
			</table>
			<div style="background-color: black;color: white;font-size: 15px;">Solved in  <?php echo $duration." seconds"; ?></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>