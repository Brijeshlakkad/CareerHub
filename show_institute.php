<?php
include_once('functions.php');
include_once("config.php");
include_once("candidate_details.php");
include_once("get_institute_and_job.php");
include_once("index_header.php");
check_session();
if(isset($_POST['inst_id']) && isset($_POST['job_id']))
{
	$id=$_POST['inst_id'];
	$jobid=$_POST['job_id'];
	get_institute($id);
	get_job($id,$jobid);
?>
<script src="js/angular.js"></script>
<script language="JavaScript">
   function helper()
   {
      var head= document.getElementsByTagName('head')[0];
      var script= document.createElement('script');
      script.type= 'text/javascript';
      script.src= 'js/admin_inst.js';
      head.appendChild(script);
   }
helper();
   </script>
 
<div class="container-fluid well">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-6">
            <div>
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">
			  <br/>
					<a class="btn btn-link" id="get_inst"><h3><?php 
						if($bits_inst[1]==1)
			{
				$institute_name.=' <span style="color:green;"><span class="glyphicon glyphicon-ok"></span></span>';
				
			}
						echo $institute_name;
						?>
			</h3></a>
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
			
		?>
		<button id="accept_offer" class="btn btn-primary">Accept offer <span class="glyphicon glyphicon-thumbs-up"></span></button>
		<button id="confirmed_offer" class="btn btn-primary disabled">Accepted <span class="glyphicon glyphicon-thumbs-up"></span></button>
		
		</div><br/><br/>
		<div class="row pull-right"><h4><b>Closing date : </b><?php echo $job_close; ?></h4></div>
			
		</div>
		</div>
	</div>
  <hr style="border-width: 1px;border-color: rgba(180,180,180,1.00)"/>
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
  			<?php echo $job_skills;?></p>
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
$(document).ready(function(){
	$("#confirmed_offer").hide();
	var inst_id="<?php echo $institute_id; ?>";
	var job_id="<?php echo $jobid; ?>";
	var cand_id="<?php echo $login_id; ?>";
	var status;
	$.ajax({
			type: 'POST',
			url:'accept_offer.py',
			data:"count_id="+cand_id+"&inst_id="+inst_id+"&job_id="+job_id,
			success:function(data){
				status=data;
				if(status==0)
					{
						start_functions();
						
					}
				else
					{
						$("#accept_offer").hide();
						$("#confirmed_offer").show();
					}
			}
		});
	
	
	var start_functions=function(){
		$("#accept_offer").click(function(){
			var accept=confirm("You are accepting a job offer");
			if(accept==true)
				{
					$.ajax({
					type: 'POST',
					url:'accept_offer.py',
					data:"cand_id="+cand_id+"&inst_id="+inst_id+"&job_id="+job_id,
					success:function(data){
						if(data==1)
							{
								$("#accept_offer").hide();
								$("#confirmed_offer").show();
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
		});	
	};
});
</script>
<?php
}
?>