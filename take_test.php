<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
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
		?>
<div class="container-fluid well">
	<div class="row">
		<div id="getting-started"></div>
	</div>
</div>
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
<script type="text/javascript">
 function startTimer(duration, display1, display2, display3) {
    var timer = duration, minutes, seconds,hours;
    setInterval(function () {
		hours = parseInt(timer / (60*60), 10)
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
		
 		hours = minutes < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display1.textContent = hours;
		display2.textContent=minutes;
		display3.textContent=seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

window.onload = function () {
    var fiveMinutes = 60*60,
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