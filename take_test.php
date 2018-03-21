<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
include_once('visit_test.php');
check_session();
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
		
		if(isset($_POST['retest']))
		{
			$up_bit=update_table($login_email,$testid,$duration);
			if($up_bit!="1")
					die("Error!");
		}
		else
		{
			$res_y=find_test($login_email,$testid);
			if($res_y=="0")
			{
				$res_x=add_test_to_table($login_email,$testid,$duration);
				if($res_x!="1")
					die("Error!");
			}
		}
		$left_dur=get_detail_of_test($login_email,$testid);
		?>
<div class="container-fluid well">
	<div class="row">
		<div class="col-lg-8">
			<div class="row">
			<div class="test_header col-lg-8" id="<?php echo $testid; ?>"><h3><?php echo $title; ?></h3>
			</div>
			<div class="col-lg-4 pull-right"><?php 
		if($res_y=="0"){
			?>
			<button class="btn btn-primary" onClick="start_time()" id="start_test" >Start Test</button>
			<?php
		}
			?></div>
			</div>
			<div class="row" id="info_about_test" style="padding: 10px;">
			<br/>
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
			<div class="row" id="taken_test_panel">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2">
				<form name="myForm" method="post" action="submit_test_by.php">
					<input type="hidden" name="test_id" value="<?php echo $testid; ?>"/>
					<div class="questions_of_test" id="-99">
						
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
		</div>
	</div>
</div>
<script>
var test_started="<?php echo $test_started; ?>";
if(test_started=="1")
{
	alert(""+test_started);
	start_time();
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

var queOutput = $("div.questions_of_test");
var retrieveQuestions=function() {
			var testid=$("div.test_header").attr('id');
			var currentid=$("div.questions_of_test").attr('id');
			$.ajax({
				type: 'POST', 
				url: 'test_running.py',
				data: 'que_reload='+testid+"&current_id="+currentid,
				success  : function (data)
				{
					queOutput.html(data);
				}
				});
};
		
$("#start_test").click(function(){
	retrieveQuestions();
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