<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
include_once('visit_test.php');
check_session();

if(isset($_POST['test_id']) && isset($_POST['visited']))
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
			<div class="test_header" id="<?php echo $testid; ?>"><h3><?php echo $title; ?></h3></div>
			<div class="row">
			<div class="col-lg-offset-4 col-lg-4 col-lg-offset-4">
				<form name="myForm" method="post" action="submit_test_by.php">
					<input type="hidden" name="test_id" value="<?php echo $testid; ?>"/>
					<div class="questions_of_test" id="-99">
						
					</div>
					<div id="controls">
						<button class="btn btn-sm btn-primary" type="button" onclick="check_answers('0')">Submit</button>
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
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
	});
function check_answers(bit)
	{
		if(bit=="0")
			{
				var i=0,flag=0;
				var total_que="<?php echo $total_que; ?>";
				for(i=1;i<=total_que;i++)
					{
						var xx=validate_radio(i);
						if(xx=="false")
							{
								$("#error"+i).html("<span style='color:red;'>Please select</span>");
								flag=1;
							}
						else
							{
							$("#error"+i).empty();
							}
					}
				if(flag==1)
					{
						$("#status_test").html("<span style='color:red;'>Please select all answers.</span>");
					}
				else
					{
						$("#status_test").empty();
						document.myForm.submit();
						flag=0;
					}
			}
			else
				{
					
				}
	}
function validate_radio(ii)
	{
				var radios = $('#question'+ii+"").find(":radio");

				for (var i = 0; i < radios.length; i++) {
					if (radios[i].checked) {
					return "true";
				}
				};

				return "false";
	}
</script>
<script type="text/javascript">
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
			
						alert("Game over!");
					}
				}
			});
			}
    }, 1000);
}

window.onload = function () {
    var fiveMinutes = parseInt(dur_time),
        display1 = document.querySelector('#time_hour');
	display2 = document.querySelector('#time_min');
	display3 = document.querySelector('#time_sec');
    startTimer(fiveMinutes, display1, display2, display3);
};
</script>
</body>
</html>
		<?php
	}
}
?>