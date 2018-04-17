<?php
include_once('functions.php');
include_once("config.php");
include_once("institute_header.php");
include_once("institute_functions.php");
check_session();
if(isset($_POST['cand_id']) && isset($_POST['job_id']))
{
	$id=$_POST['cand_id'];
	$jobid=$_POST['job_id'];
	$sql="select * from jobs where job_id='$jobid' and institute_id='$institute_id'";
	$res=mysqli_query($con,$sql);
	$row_job=mysqli_fetch_array($res);
	$sql2="select * from Candidates where ID='$id'";
	$result=mysqli_query($con,$sql2);
	if(!$result)
		die("Server is down.");
	$row=mysqli_fetch_array($result);
	$bits=explode(",/,",$row['Status_bits']);
	
	$im=base64_encode($row['Image']);
	$login_name=ucwords($row['Name']);
	$barV=$row['Progress'];
	$qualis=explode(",/,",$row['Quali']);
	$degree=$row['Degree'];
	$exp_year=$row['Experience'];
	$course=$row['Course'];
	$p_year=$row['Passing_year'];
	$intern=$row['Intern'];
	$college=$row["College"];
	$col_pin=$row['College_pincode'];
	$postal_add=$row['Postal_Add'];
	$perm_add=$row['Perm_Add'];
	$per_pin=$row['Per_pincode'];
	$country=$row['Country'];
	$state=$row['State'];
	$city=$row['City'];
	$dob= date('d/m/Y', strtotime($row['DOB']));
	$gender=$row['Gender'];
	$updated=$row['isUpdated'];
	$desc=$row['Description'];
?>
<div class="container well">
    <div class="row">
       <div class="col-sm-1">
       	
       </div>
        <div class="col-sm-7">
            <h3><b>Job Title : <?php echo $row_job["job_title"]; ?></b></h3>
		</div>
		<div class="col-sm-4" >
		
		</div>
	</div>
	<hr style="border-width: 2px;border-color:rgba(180,180,180,1.00)"/>
	<div class="row">
       <div class="col-sm-1">
       <button class="btn btn-sm btn-primary" onclick="javascript:history.back()"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
       </div>
        <div class="col-sm-7">
            <div class="candidate_id" id="<?php echo $id; ?>">
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">
			  <br/>
				  <h4><b><?php echo $login_name; ?></b></h4>
				  <br/>
					<div class="progress" style="width:60%">
					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $barV; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $barV.'%'; ?>"><?php echo $barV.'%'; ?>
					</div>
				  	</div><br/>
				</div>
			  </div>
            </div>
		</div>
		<div class="col-sm-4" >
		<div class="row" align="center" id="<?php echo $id; ?>">
		<?php 
				if(isset($_POST['app_id']))
				{
					$app_id=$_POST['app_id'];
					$q1="select status_bit from applications where application_id='$app_id' and institute_id='$institute_id'";
					$ex1=mysqli_query($con,$q1);
					$row1=mysqli_fetch_array($ex1);
					$status_bit=$row1['status_bit'];
					?><?php if($status_bit==-99){?>
					<button class="btn btn-success Accept" id="<?php echo $app_id;?>">Accept</button><?php  } else if($status_bit=='1'){ ?><button class="btn btn-success Accepted" readonly="true" disabled>Accepted</button><?php  } ?>
                	<button class="btn btn-danger Reject" id="<?php echo $$app_id;?>">Reject</button>
					<?php
				}
				else
				{
		?>
			<button class="btn btn-primary offer_status" id="send_offer" >Send a offer <span class="glyphicon glyphicon-send"></span></button>
			<?php
				}
			?>
		</div>
		</div>
	</div>
  <hr class="hr-primary" size='30'/>
   <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
   <div class="row">
        <div id="heading_desc">
        <?php
				if($qualis[0]!='0')
				{
					?>
        <label>Description</label>
        </div>
        <div id="show_desc">
        
		<?php 
					echo $desc;
				}
		?>
		</div>
	</div>
   <hr size='30'/>
    <div class="row">
        <div id="heading_skills">
        <?php
				if($qualis[0]!='0')
				{
					?>
        <label>Qualification Details</label>
        </div>
        <div id="show_skills">
        <table class="myTable">
        	<?php
					$len=count($qualis);
					for($i=1;$i<=$len;$i++)
					{
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $qualis[$i-1]; ?></td>
						</tr>
						<?php
					}
				?>
		</table>
		<?php 
					}
		?>
		</div>
	</div>
	 <hr size='30'/>
		 <div class="row">
			 <div id="heading_gra">
			<?php
					if($course!='-99')
					{
						?>
			<label>Graduation Details</label>
			</div>
			<div id="show_gra">
			<table class="myTable">
							<tr>
								<td>Degree</td>
								<td><?php echo $degree; ?></td>
							</tr>
							<tr>
								<td>Course</td>
								<td><?php echo $course; ?></td>
							</tr>
							<tr>
								<td>College</td>
								<td><?php echo $college; ?></td>
							</tr>
							<tr>
								<td>College Pincode</td>
								<td><?php echo $col_pin; ?></td>
							</tr>
							<tr>
								<td>Passing Year</td>
								<td><?php echo $p_year; ?></td>
							</tr>
							<tr>
								<td>Internship/Experience</td>
								<td><?php echo $intern; ?></td>
							</tr>
							<tr>
								<td>Experience Year</td>
								<td><?php echo $exp_year; ?></td>
							</tr>
			</table>
			<?php 
						}
			?>
			</div>
		</div>
		<hr size='30'/>
		<div class="row">
			<div id="heading_per">
			<?php
					if($gender!='-99')
					{
						?>
			<label>Personal Details</label>
			</div>
			<div id="show_per">
			<table class="myTable">
							<tr>
								<td>Postal Address</td>
								<td><?php echo $postal_add; ?></td>
							</tr>
							<tr>
								<td>Permanent Address</td>
								<td><?php echo $perm_add; ?></td>
							</tr>
							<tr>
								<td>Country</td>
								<td><?php echo $country; ?></td>
							</tr>
							<tr>
								<td>State</td>
								<td><?php echo $state; ?></td>
							</tr>
							<tr>
								<td>City</td>
								<td><?php echo $city; ?></td>
							</tr>
							<tr>
								<td>Pincode</td>
								<td><?php echo $per_pin; ?></td>
							</tr>
							<tr>
								<td>DOB</td>
								<td><?php echo $dob; ?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $gender; ?></td>
							</tr>
			</table>
			<?php 
						}
			?>
			</div>
			<hr class="hr-primary" />
		</div>
		
</div>
</div>
<div class="modal fade" id="errorModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content alert alert-danger alert-dismissable fade in">
        <div class="modal-body">
        <div><a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>Try again!</div>
		</div>
	</div>
 </div> 
</div>
<div class="modal fade" id="offerModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content alert alert-success alert-dismissable fade in">
        <div class="modal-body">
        <div><a href="#" class="close" data-dismiss="modal" aria-label="close">&times;</a>Offer sent, Successfully!</div>
		</div>
	</div>
 </div> 
</div>
<script>
	 $(".Accept").click(function(){
        var acceptappid=$(this).attr('id');
        $.ajax({
            url:'institute_application_accept_deny.php',
            type:'POST',
            data: {
                'action':'accept',
                'application_id':acceptappid
            },
            success:function(result){
                if(result=="11")
					$("button.Accept").addClass("disabled").html("Accepted");
            }
        });
    });
    $(".Reject").click(function(){
        var rejectappid=$(this).attr('id');
        $.ajax({
            url:'institute_application_accept_deny.php',
            type:'POST',
            data: {
                'action':'reject',
                'application_id':rejectappid
            },
            success:function(result){
                alert('Rejected');
            }
        });
    });

$(document).ready(function(){
	var cand_id=$("div.candidate_id").attr("id");
	var inst_id=$("div.brij").attr("id");
	var j_id="<?php echo $jobid; ?>";
	var check_status=function(){
		$.ajax({
			type: 'POST',
			url:"send_offer.py",
			data:"check_offer="+cand_id+"&inst_id="+inst_id+"&job_id="+j_id,
			success:function(data){
				if(data!="-1x")
					{
						data=data.trim();
						if(data=="1x")
							{
								$("button.offer_status").attr("id","send_offer");
								$("#send_offer").html('Send a offer <span class="glyphicon glyphicon-send"></span>').removeClass("btn-default").addClass("btn-primary");
							}
						else if(data=="Offer")
							{ 
								$("button.offer_status").attr("id","requested_offer")
								$("#requested_offer").html("<b>Offer requested</b>");
								$("#requested_offer").removeClass("btn-primary").addClass("btn-default");
							}
						else if(data=="Accepted")
							{
								$("button.offer_status").attr("id","accepted_offer");
								$("#accepted_offer").html('Offer Accepted').removeClass("btn-default").addClass("btn-primary");
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
	$("button.offer_status").click(function(){
		var bid=$(this).attr("id");
		if(bid=="requested_offer")
			{
				$.ajax({
					type: 'POST',
					url:"send_offer.py",
					data:"delete_offer="+cand_id+"&inst_id="+inst_id+"&job_id="+j_id,
					success:function(data){
						if(data==11)
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
		else if(bid=="send_offer")
			{
				$.ajax({
					type: 'POST',
					url:"send_offer.py",
					data:"send_offer="+cand_id+"&inst_id="+inst_id+"&job_id="+j_id,
					success:function(data){
						if(data==11)
							{
								$("#offerModal").modal("toggle");
								check_status();
							}
						else
							{
								$("#errorModal").modal("toggle");
							}
					}
				});
			}
	});
	
	check_status();
});
</script>
<?php
}
?>
<?php 
include_once("institute_footer.php");
?>