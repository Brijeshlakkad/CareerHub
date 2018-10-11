<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
if(isset($_POST['test_id']))
{
	$testid=protect_anything($_POST['test_id']);
	$sql_test="select Title from tests where ID='$testid'";
	$result_test=mysqli_query($con,$sql_test);
	if(!$result_test)
		die();
	$row_test=mysqli_fetch_array($result_test);
	$title=$row_test[0];
	$sql="select Rightt,Attained,Total,Left_time,Total_time from results where ID='$testid'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$right=$row[0];
		$attained=$row[1];
		$total=$row[2];
		$left_dur=$row[3];
		$total_dur=$row[4];
		$duration=intval($total_dur-$left_dur);
		$wrong=$total-$right;
		$remained_que=$total-$attained;
		$right=$row[0];

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
<?php
		}
}
?>
