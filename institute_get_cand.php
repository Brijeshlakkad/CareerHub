<?php
include_once('functions.php');
include_once("config.php");
include_once("institute_header.php");
check_session();
if(isset($_POST['cand_id']))
{
	$id=$_POST['cand_id'];
	$sql="select * from Candidates where ID='$id'";
	$result=mysqli_query($con,$sql);
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
			<button class="btn btn-primary" id="send_offer" >Send a offer <span class="glyphicon glyphicon-send"></span></button>
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
<script>
$(document).ready(function(){
	var cand_id=$("div.candidate_id").attr("id");
	var inst_id=$("div.brij").attr("id");
	var j_id=$("")
	$("#send_offer").click(function(){
		$.ajax({
			type: 'POST',
			url:"send_offer.py",
			data:"send_offer="+cand_id+"&inst_id="+inst_id,
			success:function(data){
				alert(" "+data);
			}
		});
	});
});
</script>
<?php
}
?>