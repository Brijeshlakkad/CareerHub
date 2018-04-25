<?php 
include_once('functions.php');
include_once("config.php");

include_once('candidate_details.php');
check_session();
get_details_from_candidate();
if(isset($_POST['jobid']))
{

	$jobid=protect_anything($_POST['jobid']);
	$q1="SELECT jobs.*, institutes.* from jobs JOIN institutes ON jobs.institute_id=institutes.ID where `job_id`='$jobid'";
	$exq1=mysqli_query($con,$q1);
	$res1=mysqli_fetch_array($exq1);
	$total=mysqli_num_rows($exq1);
	if($total<1)
	{
		echo '<br/><p style="color:red;text-align:center;font-size:25px;">job not found</p>';
	}
	else
	{

		$check_already_applied="select * from applications where `job_id`='$jobid' and `candidate_id`='$login_id' and `status_bit`!='0'";
		$ex_already_applied=mysqli_query($con,$check_already_applied);
		$count=mysqli_num_rows($ex_already_applied);
		if($count!=0)
		{
			echo "<script>document.getElementById('apply').innerHTML='Already Applied';document.getElementById('apply').style.backgroundColor ='#D2501B';document.getElementById('apply').disabled = true;</script>";
		}
	?>
<script src="js/predictor_cal.js"></script>
	<div class="w3-container">
	<section class="content" >

        <div class="container-fluid" >

        <div id="AllContent">
            
            <div class="well" style="background-color:white;margin:auto;max-width:900px;margin-top:25px;margin-bottom:10px;min-height:85vh;box-shadow: 5px 5px 5px #aaaaaa;">
			<div class="row">
           	<div class="col-lg-6">
            	<p style="font-size:20px;color:#633C2C;margin-top:5px;"><b><?php echo $res1['job_title'];?></b></p><p>
            </div>
            <div class="col-lg-6"><div class="pull-right job_id" id="<?php echo $res1['job_id'];?>"><button class="btn btn-primary" id="use_predictor">Use Predictor</button></div></div>
			</div>
				by <span style="font-size:17px;color:green;"><a class="inst_profile_id" id="<?php echo $res1['institute_id']; ?>"><?php echo $res1['Bname'];?></a></p></span>
				
				<hr style="border: 1px solid #7E7675;">
				<p style="font-size:18px;margin-bottom:20px;"><b><?php echo ucfirst($res1['job/training']); ?> Summary</b></p>
				
				<p><div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-user"></span><span><b> Role: </b></span><span><?php echo strtoupper($res1['role']); ?></span></div>				
				</div>
				</p>

				<p><span class="glyphicon glyphicon-briefcase"></span> <b>Experience Required: </b> <?php if($res1['experience']>0){
					echo $res1['experience']." Years"; } else { echo "Not required";} ?></p>
				<p><span class="glyphicon glyphicon-map-marker"></span> <b>Location: </b> <?php echo strtoupper($res1['city'])." ".strtoupper($res1['state'])." ".strtoupper($res1['country']); ?> </p>
				  	
				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-th-list"></span><span><b> Key skills: </b></span><span><?php echo strtoupper($res1['required_skills']); ?></span>
				</div>				
				</div> 
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-ok"></span><span><b> Vacancy: </b></span><span><?php echo strtoupper($res1['vacancy']); ?></span>
				</div>				
				</div>
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-education"></span><span><b> Qualifications: </b></span><span><?php echo strtoupper($res1['qualification']); ?></span>
				</div>				
				</div>
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-calendar"></span><span><b> Opening date: </b></span><span><?php echo strtoupper($res1['opening_date']); ?></span>
				</div>				
				</div>
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-calendar"></span><span><b> Closing date: </b></span><span><?php echo strtoupper($res1['closing_date']); ?></span>
				</div>				
				</div>
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span style="font-size:18px;"> &#8377;</span><span><b> &nbsp;Expected Salary: </b></span>
					<span><?php echo strtoupper($res1['expected_salary']); ?> (P.M. in INR)</span>
				</div>				
				</div>				
				</p>

				<p>
				<div class="row">
				<div class="col-md-8"><span class="glyphicon glyphicon-ok"></span>    
				<span><b> Maximum age: </b></span>
					<span><?php echo strtoupper($res1['max_age']); ?> years</span>
				</div>				
				</div>				
				</p>
				<br/>
				<br/>

				<p style="font-size:16px;"><b><u>Description:</u></b></p>
				<div class="row" style="padding-left:15px;margin-top:5px;">
				<div class="col-md-10" style="padding-left:0px;"><span>
				<?php echo nl2br($res1['description']);?>
				 </span><br/></div>
				</div>
				
				<br/><br/>
				<p style="text-align:center;"><button class="btn btn-warning" style="min-width:100px;" id="apply">Apply</button></p>

            </div>
        </div>
        </div>
    </section>
    </div>
	<?php 
	}

}

?>

<script type="text/javascript">


	$('.inst_profile_id').click(function(){
		var institute_id=$(this).attr('id');

		var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", "show_institute_profile.php");
            var field = $('<input></input>');
            field.attr("type", "hidden");
            field.attr("name", "inst_id");
            field.attr("value", institute_id);
            form.append(field);
        $(form).appendTo('body').submit();

	});

	$('#apply').click(function(){
		
		$.ajax({
			url: 'candidate_apply_job.php',
			type: 'POST',
			data:{ 'jobid': <?php echo $jobid; ?> },
			success: function(result){
				
				$('#apply').html(result);
				$('#apply').css({'background-color':'green','border-color':'green'});

			}
		});
	});
</script>
