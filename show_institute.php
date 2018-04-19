<?php
include_once('functions.php');
include_once("config.php");
include_once("candidate_details.php");
include_once("get_institute_and_job.php");
include_once("index_header.php");
check_session();
if(isset($_POST['inst_id']) && isset($_POST['job_id']) && isset($_POST['role_type']))
{
	$inst_id=$_POST['inst_id'];
	$jobid=$_POST['job_id'];
	$role_type=$_POST['role_type'];
	get_institute($inst_id);
	get_job($inst_id,$jobid);
	if($bits_inst[1]==1)
	{
		$institute_name.=' <span style="color:green;"><span class="glyphicon glyphicon-ok"></span></span>';		
	}
	$institute_name="<a id='inst_profile_link' style='cursor: pointer;' onclick='get_institute_profile(".$institute_id.")' class='div_link'>"."<h3>".$institute_name."</h3>"."</a>";
	
?>
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
		<div><h4><?php echo $isJob; ?></h4></div>
			  <br/>
				<br/>
				</div>
			  </div>
            </div>
		</div>
		<div class="col-sm-2"></div>
		<div class="col-sm-3" >
		<div class="row" style="margin-right: 10px;">
		<div class="row pull-right" >
		<?php 
			if($role_type=="Offer")
			{
		?>
		<button class="btn btn-primary offer_status">Accept offer <span class="glyphicon glyphicon-thumbs-up"></span></button>
		<?php
			}
		?>
		</div><br/><br/>
		<div class="row pull-right"><h4><b>Closing date : </b><?php echo $job_close; ?></h4></div>
			
		</div>
		</div>
	</div>
  <hr style="border-width: 1px;border-color: rgba(180,180,180,1.00)"/>
<?php
if($role_type=="Request_accepted")
			{
				?>
<div class="row alert alert-success">
	<center><h3>Congratulation, You have got this job.</h3></center>
</div>
				<?php
			}
?>
<div class="row">
<div class="col-sm-offset-1 col-sm-6">
 	<div class="row" style="border-bottom: 1px solid rgba(180,180,180,1.00);">
 		 <h4><b>Job Details </b></h4>
 	</div><br/>
  	<div class="row">
  		<div class="col-sm-5">
			<b>Job Title:</b> 
		</div>
		<div class="col-sm-5">
			<?php echo $job_title;?>
 		</div>
		<div class="col-sm-2"></div>
	</div>
	<br/>
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
	</div>
	
</div>
<div class="col-sm-2"></div>
<div class="col-sm-3" style="border-left: 2px solid rgba(180,180,180,1.00);">
	<p><h4><b>Institute Details</b></h4></p>
	<p><b>Institute Type:</b> <?php echo $institute_type;?></p>
    <p><b>Business Email:</b> <?php echo $institute_email;?></p>
    <p><b>Business Contact:</b> <?php echo  $institute_contact;?></p>
    <p><b>Institute Address:</b> <?php echo $institute_address;?></p>
    <p><b>Country: </b><?php echo $institute_country;?></p>
    <p><b>ZIP: </b><?php echo $institute_zip;?></p>
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
function get_institute_profile(inst_id)
{
	$("#inst_profile_link").parent().hide().append("<form method='post' id='myForm' action='show_institute_profile.php'><input type='hidden' name='inst_id' value='"+inst_id+"' /></form>");
	$("#myForm").submit();
}
</script>
<?php
	if($role_type=="Offer")
	{
		?>
<script>
$(document).ready(function(){
	var inst_id="<?php echo $institute_id; ?>";
	var job_id="<?php echo $jobid; ?>";
	var cand_id="<?php echo $login_id; ?>";
	var status;
	var check_status=function(){
		$.ajax({
			type: 'POST',
			url:"candidate_interface.py",
			data:"check_offer="+cand_id+"&inst_id="+inst_id+"&job_id="+job_id,
			success:function(data){
				if(data!="-1x")
					{
						data=data.trim();
						if(data=="1x")
							{
								document.location="candidate_inbox.php";
							}
						else if(data=="Offer")
							{ 
								$("button.offer_status").attr("id","accept_offer");
								$("#accept_offer").html('<b>Accept Offer</b> <span class="glyphicon glyphicon-thumbs-up"></span>');
								$("#accept_offer").removeClass("btn-default").addClass("btn-primary");
							}
						else if(data=="Accepted")
							{
								$("button.offer_status").attr("id","accepted_offer");
								$("#accepted_offer").html('<b>Offer Accepted</b> <span class="glyphicon glyphicon-thumbs-up"></span>');
								$("#accepted_offer").removeClass("btn-primary").addClass("btn-default");
								$("#accepted_offer").addClass("disabled");
							}
					}
				else
					{
						$("#errorModal").modal("toggle");
					}
			}
		});	
	};
	check_status();
	$("button.offer_status").click(function(){
		var bid=$(this).attr("id");
		if(bid=="accept_offer")
			{
			var accept=confirm("You are accepting a job offer");
			if(accept==true)
				{
					$.ajax({
					type: 'POST',
					url:'candidate_interface.py',
					data:"cand_id="+cand_id+"&inst_id="+inst_id+"&job_id="+job_id,
					success:function(data){
						if(data==1)
							{
								check_status();
							}
						else
							{
								$("#errorModal").modal("toggle");
							}
					}
				});	
				}
			else
				{
					
				}
			}
	});	
});
</script>
		<?php
	}
}
?>