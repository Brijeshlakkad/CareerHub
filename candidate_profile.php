<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
get_details_from_candidate();
if($bits[0]==0)
{
	header("Location:candidate_upload_img.php");
}

//for image
$im=base64_encode($login_image);
?>
<div class="container-fluid well">
    <div class="row">
        <div class="col-sm-8">
            <div>
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">
				  <h4 class="media-heading"><b><?php echo $login_name; ?></b></h4>
				  <br/>
					<div class="progress" style="width:60%">
					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $barV; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $barV.'%'; ?>"><?php echo $barV.'%'; ?>
					</div>
				  	</div><br/>
				  	<?php
					if($qualis[0]=='0')
						echo "<a href='candidate_add_quali.php'>+ Add Qualification Details</a>";
					if($course=='-99' || $college=='-99' || $intern== '-99' || $p_year=='-99')
						echo "<br/><a href='candidate_add_gra.php'>+ Add Graduation Details</a>";
					if($gender=='-99')
						echo "<br/><a href='candidate_add_per.php'>+ Add Personal Details</a>";
					?>
				</div>
			  </div>
            </div>
		</div>
        <div class="col-sm-4">
        <section class="row">
        <div id="heading_skills">
        <?php
				get_details_from_candidate();
				if($qualis[0]!='0')
				{
					?>
        <label>Qualification Details <span id="edit_btn"><a id="edit" href="candidate_add_quali.php">Edit <span class="glyphicon glyphicon-pencil"></span></a></span></label>
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
		
		</section>
		<section class="row">
			 <div id="heading_gra">
			<?php
					get_details_from_candidate();
					if($course!='-99')
					{
						?>
			<label>Graduation Details <span id="edit_btn"><a id="edit" href="candidate_add_gra.php">Edit <span class="glyphicon glyphicon-pencil"></span></a></span></label>
			</div>
			<div id="show_gra">
			<table class="myTable">
							<tr>
								<td>Course</td>
								<td><?php echo $course; ?></td>
							</tr>
							<tr>
								<td>College</td>
								<td><?php echo $college; ?></td>
							</tr>
							<tr>
								<td>Passing Year</td>
								<td><?php echo $p_year; ?></td>
							</tr>
							<tr>
								<td>Internship/Experience</td>
								<td><?php echo $intern; ?></td>
							</tr>
			</table>
			<?php 
						}
			?>
			</div>
		</section>
		<section class="row">
			<div id="heading_per">
			<?php
					get_details_from_candidate();
					if($gender!='-99')
					{
						?>
			<label>Personal Details <span id="edit_btn"><a id="edit" href="candidate_add_per.php">Edit <span class="glyphicon glyphicon-pencil"></span></a></span></label>
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
		</section>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#edit_skills").hide();
		$("#edit").click(function(){
			
			
		});
	});
</script>
</body>
</html>