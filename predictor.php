<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
get_details_from_candidate();
if(isset($_POST['job_id']))
{
	$job_id=$_POST['job_id'];
?>
<div class="container-fluid well job_id" id="<?php echo $job_id; ?>">
    <div class="row"><div class="col-lg-offset-4 col-lg-4 col-lg-offset-4"><center><h2 class="heading">Career Predictor</h2></center></div></div>
    <div class="row" id="result_of_prediction">
    	
    </div>
</div>
<div class="please_wait_modal"></div>

<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});

</script>
<?php
}
?>
</body>
</html>