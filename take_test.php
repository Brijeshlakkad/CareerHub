<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
include_once('visit_test.php');
check_session();
function delete_visited_test($candid,$testid)
{
	global $con;
	$sql="delete from visited_test where TestID='$testid' and CandID='$candid'";
	$result=mysqli_query($con,$sql);
	if($result)
		return "11";
	else
		return "00";
}
function save_result_to_database($testid,$right,$attained,$total,$remained,$total_dur)
{
	global $login_email,$con;
	$sql="Select * from Results where CandID='$login_email' AND TestID='$testid'";
	$result=mysqli_query($con,$sql);
	$num=mysqli_num_rows($result);
	if($num==0)
	{
		$sql2="Insert into Results(CandID,TestID,Rightt,Attained,Total,Left_time,Total_time,Attempt) values('$login_email','$testid','$right','$attained','$total','$remained','$total_dur','1')";
		$result2=mysqli_query($con,$sql2);
		if($result2)
		{
			$status=delete_visited_test($login_email,$testid);
			return $status;
		}
		else
		{
			return "00";
		}
	}
	else
	{
		$row_result=mysqli_fetch_array($result);
		$attempt=$row_result['Attempt'];
		$attempt++;
		$sql2="Update Results SET Rightt='$right',Attained='$attained',Left_time='$remained',Total_time='$total_dur',Attempt='$attempt' where CandID='$login_email' and TestID='$testid'";
		$result2=mysqli_query($con,$sql2);
		if($result2)
		{
			$status=delete_visited_test($login_email,$testid);
			return $status;
		}
		else
		{
			return "00";
		}
	}
}
if(isset($_POST['test_completed']))
{
	$testid=protect_anything($_POST['test_completed']);
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
		$xx=save_result_to_database($testid,$right,$attained,$total,$remained_dur,$total_dur);
		if($xx!="00")
		{
			show_result($testid);
		}
		else
		{
		}
	}
}
function show_result($test_id)
{
	$xyz="<form name='test_submit' method='post' action='submit_test_by.php'><input type='hidden' name='test_id' value='$test_id'></form>";
	?>
<script>
	var fields="<?php echo $xyz; ?>";
	$("body").append(fields);
	document.test_submit.submit();
</script>
	<?php
}
global $test_started;
if(isset($_POST['test_id']))
{
	$testid=$_POST['test_id'];
	$sql="Select * from Tests where ID='$testid'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$title=$row['Title'];
		$course=$row['Course'];
		$subjects=$row['Subjects'];
		$duration=$row['Duration'];
		$total_que=$row['Total_num'];
		$sub_arr=explode("|",$subjects);
		for($i=0;$i<count($subjects);$i++)
		{
			$sub_arr[$i]=trim($sub_arr[$i]);
		}
		$str_sub=implode(", ",$sub_arr);
		$res_y="0";
		
		$res_y=find_test($login_email,$testid);
		if($res_y=="0")
			{
				$res_x=add_test_to_table($login_email,$testid,$duration);
				if($res_x!="1")
					die("Error!");
			}
		$left_dur=get_detail_of_test($login_email,$testid);
		?>
<div class="container-fluid well">
	<div class="row">
		<div class="col-lg-8">
			<div class="row">
			<div class="test_header col-lg-8" id="<?php echo $testid; ?>"><h3><?php echo $title; ?></h3>
			</div>
			
			</div>
			<div class="row" id="taken_test_panel">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<form name="myForm" method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
					<input type="hidden" name="test_completed" value="<?php echo $testid; ?>"/>
					<div class="questions_of_test" id="-99">
						<div class="row" id="info_about_test" style="padding: 10px;">
						<br/>
						<div class="header"><label>Information : </label></div>
						<table class="myTable table table-hover">
						<tr>
							<td>Total Questions</td>
							<td><?php echo $total_que; ?></td>
						</tr>
						<tr>
							<td>Course</td>
							<td><?php echo $course; ?></td>
						</tr>
						<tr>
							<td>Subjects</td>
							<td><?php echo $str_sub; ?></td>
						</tr>
						</table>
						</div>
					</div>
					
					<div id="status_test">
						
					</div>
				</form>
			</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div id="countdown" class="countdownHolder">
				<span class="countHours">
					<span class="position">
						<span class="digit static" id="time_hour"></span>
					</span>
				</span>

				<span class="countDiv countDiv1"></span>

				<span class="countMinutes">
					<span class="position">
						<span class="digit static" id="time_min"></span>
					</span>
				</span>

				<span class="countDiv countDiv2"></span>

				<span class="countSeconds">
					<span class="position">
						<span class="digit static" id="time_sec"></span>
					</span>
				</span>
			</div>
			<br/>
			
			<div class="pull-right">
			<?php 
		if($res_y=="0"){
			?>
			<button class="btn btn-primary" onClick="start_time()" id="start_test" >Start Test</button>
			<?php
		}
			?></div>
		</div>
	</div>
</div>
<script>
var test_started="<?php echo $res_y; ?>";
if(test_started!="0")
{
	$("countdown").show();
}
function check_answers()
	{
		$("#status_test").empty();
		var check=confirm("Are you sure?");
		if(check==true)
			{
				document.myForm.submit();
			}
		else
			{
				
			}
	}
function delete_visited_test()
{
	var testid=$("div.test_header").attr('id');
		$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'delete_visited_test='+testid,
				success  : function (data)
				{
					if(data==11)
						{
							
						}
					else
						{
							
						}
				}
				});
}
var queOutput = $("div.questions_of_test");
var retrieveQuestions=function() {
			var testid=$("div.test_header").attr('id');
			var currentid=$("div.questions_of_test").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: 'que_reload='+testid+"&current_id="+currentid,
				success  : function (data)
				{
					queOutput.html(data);
				}
				});
};
		
$("#start_test").click(function(){
	retrieveQuestions();
	$("#countdown").show();
});
var dur_time="<?php echo $left_dur; ?>";
function startTimer(duration, display1, display2, display3) {
    var timer = duration, minutes, seconds,hours;
    setInterval(function () {
		hours = parseInt(timer / (60*60), 10)
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
		
 		hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display1.textContent = hours;
		display2.textContent=minutes;
		display3.textContent=seconds;
		var c_id="<?php echo $login_email; ?>";
		var t_id="<?php echo $testid; ?>";
		var left_dur=timer;
		if (timer >= 0)
			{
		$.ajax({
				type: 'POST', 
				url: 'visit_test.php',
				data: "c_id="+c_id+"&t_id="+t_id+"&left_dur="+left_dur,
				success  : function (data)
				{
					if (--timer < 0) {
			
						document.myForm.submit();
					}
				}
			});
			}
    }, 1000);
}
window.onload=function(){
	var check="<?php echo $res_y; ?>";
	if(check=="1")
	{
		start_time();
		retrieveQuestions();
	}
};
function start_time() {
	$("#start_test").hide();
	<?php $test_started=1; ?>
    var fiveMinutes = parseInt(dur_time),
        display1 = document.querySelector('#time_hour');
	display2 = document.querySelector('#time_min');
	display3 = document.querySelector('#time_sec');
    startTimer(fiveMinutes, display1, display2, display3);
}
</script>
</body>
</html>
		<?php
	}
}
?>