<?php
include_once('functions.php');
include_once("config.php");
include_once("candidate_details.php");
include_once("get_institute_and_job.php");
include_once("index_header.php");
check_session();
if(isset($_POST['inst_id']))
{
	$id=$_POST['inst_id'];
	get_institute($id);
	$job_arr=get_all_jobsid($id);
	if($bits_inst[1]==1)
	{
		$institute_name.=' <span style="color:green;"><span class="glyphicon glyphicon-ok"></span></span>';		
	}
	$institute_name="<a id='inst_profile_link' onclick='get_institute_profile(".$institute_id.")' class='div_link'>"."<h3>".$institute_name."</h3>"."</a>";
	
?>
<script src="js/read_more.js"></script>

 
<div class="container-fluid well">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-6">
            <div>
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $inst_im; ?>" />
				</div>
				<div class="media-body" style="">
					<?php echo $institute_name;?>
		
			  <br/>
				<br/>
				<div class="description_first">
					<?php echo $institute_descr; ?>
				</div>
				</div>
			  </div>
            </div>
		</div>
		<div class="col-sm-2"></div>
		<div class="col-sm-3" >
		<div style="border-left: 2px solid rgba(180,180,180,1.00);">
			<div style="margin-left: 10px;">
				<p><h4><b>Institute Details</b></h4></p>
				<p><b>Institute Type:</b> <?php echo $institute_type;?></p>
				<p><b>Business Email:</b> <?php echo $institute_email;?></p>
				<p><b>Business Contact:</b> <?php echo  $institute_contact;?></p>
				<p><b>Institute Address:</b> <?php echo $institute_address;?></p>
				<p><b>Country: </b><?php echo $institute_country;?></p>
				<p><b>ZIP: </b><?php echo $institute_zip;?></p>	
			</div>
		</div><br/><br/>
		</div>
	</div>
  <hr style="border-width: 1px;border-color: rgba(180,180,180,1.00)"/>
<div class="row" style="margin: 20px;">
 	<div style="border-bottom: 1px solid rgba(180,180,180,1.00);">
 		 <h4><b>Job(s)/Training(s)</b></h4>
 	</div><br/>
 	<div style="margin-left: 20px;">
 	<?php 
	for($i=0;$i<count($job_arr);$i++)
	{
		get_job($institute_id,$job_arr[$i]);
	?>
 	<br/>
 	
  	<div class="row">
		<div class="col-sm-8" style="border-bottom: 1px solid rgba(180,180,180,1.00);border-top: 1px solid rgba(180,180,180,1.00);">
			<h4><?php echo ucwords($job_title)." details";?></h4>
 		</div>
		<div class="col-sm-4" ></div>
	</div>
	<br/>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Job or Training</b> 
		</div>
		<div class="col-sm-5">
			<?php echo $isJob;?>
 		</div>
 		<div class="col-sm-2"></div>
	</div><br/>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Role:</b> 
		</div>
		<div class="col-sm-5">
			<?php echo $job_role;?>
 		</div>
 		<div class="col-sm-2"></div>
	</div>
	<br/><?php if($job_exp!=0)
		{
			?>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Experience year:</b>  
		</div>
		<div class="col-sm-5">
			<?php echo $job_exp;?>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<br/>
	<?php
			
			}
	?>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Qualification:</b>  
		</div>
		<div class="col-sm-5">
			<?php echo $job_quali;?>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<br/>
 	<div class="row">
  		<div class="col-sm-5">
  			<b>Required Skills:</b>
		</div> 
  		<div class="col-sm-5">
  			<?php echo $job_skills;?>
 		</div>
 		<div class="col-sm-2"></div>
	</div>
 	<br/>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Vacancy:</b>  
		</div>
		<div class="col-sm-5">
			<?php echo $job_vacancy;?>
		</div>
		<div class="col-sm-2"></div>
	</div><br/>
	<div class="row">
  		<div class="col-sm-5">
  			<b>Closing date : </b>  
		</div>
		<div class="col-sm-5">
			<?php echo $job_close; ?>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-5">
		</div>
		<div class="col-sm-5">
		<?php 
		?>
		<button class="btn btn-primary">Apply for job</button>
		<button class="btn btn-primary disabled">Applied</button>
		<?php
		?>
		</div>
		<div class="col-sm-2"></div>
	</div>
	<div class="row"></div>
	<?php
	}
		?>
	</div>
</div>
</div>
<div class="modal fade" id="errorModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content alert alert-danger alert-dismissable fade in">
        <div class="modal-body">
        <div><a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>try again!</div>
		</div>
	</div>
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