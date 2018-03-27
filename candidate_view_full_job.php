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
	{?>

	<div class="w3-container">
	<section class="content" >

        <div class="container-fluid" >

        <div id="AllContent">
            
            <div class="well" style="background-color:white;margin:auto;max-width:900px;margin-top:25px;margin-bottom:10px;min-height:85vh;box-shadow: 5px 5px 5px #aaaaaa;">

            	<p style="font-size:20px;color:hsl(0, 0%, 24%);margin-top:5px;"><b><?php echo $res1['job_title'];?></b></p><p>
				by <span style="font-size:17px;color:green;"><?php echo $res1['Bname'];?></p></span>
				<hr>
				<p style="font-size:17px;"><b><?php echo ucfirst($res1['job/training']); ?> Summary</b></p>
				<p><div class="row" style="padding-left:15px;">
				<div class="col-md-1" style="padding-left:0px;"><span class="glyphicon glyphicon-user"></span><span> <b>Role: </b></span><br/></div> 
				<div class="col-md-11" style="padding-left:0px;"><span><?php echo strtoupper($res1['role']); ?></span></div>
				</div>
				</p>
				<p><span class="glyphicon glyphicon-briefcase"></span> <b>Experience Required: </b> <?php if($res1['experience']>0){
					echo $res1['experience']." Years"; } else { echo "Not required";} ?></p>
				<p><span class="glyphicon glyphicon-map-marker"></span> <b>Location: </b> <?php echo strtoupper($res1['city'])." ".strtoupper($res1['state'])." ".strtoupper($res1['country']); ?> </p>
				  	
				<div class="row" style="padding-left:10px;">
				<div class="col-md-2" style="padding-left:0px;"><span><b>Key skills: </b></span></div> 
				<div class="col-md-10" style="padding-left:0px;"><span><?php echo strtoupper($res1['required_skills']); ?></span><br/></div>
				</div>
				<br/>
				<br/>

				<div class="row" style="padding-left:15px;margin-top:5px;">
				<div class="col-md-10" style="padding-left:0px;"><span>
				<?php echo $res1['description'];?>
				 </span><br/></div>
				</div>
				
				<br/><br/>
				<p style="text-align:center;"><button class="btn btn-warning" style="width:90px;">Apply</button></p>

            </div>
        </div>
        </div>
    </section>
    </div>
	<?php 
	}

}


?>