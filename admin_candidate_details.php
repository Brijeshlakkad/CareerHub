<?php
include_once('functions.php');
include_once("config.php");
include_once("admin_single_cand_details.php");

check_session();
?>
<script>
var myScript = document.createElement('script'); 
myScript.src = 'js/admin_cand.js';
myScript.onload = function() { 
  console.log('jQuery loaded.');
};

document.head.appendChild(myScript);
</script>
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
            <div>
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
	</div>
  <hr class="hr-primary" size='30'/>
   <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
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
		<div class="row" align="center" id="<?php echo $id; ?>">
			<button type="button" class="btn btn-success" id="approve_cand" >Approve <span class="glyphicon glyphicon-ok"></span></button>
			<button type="button" class="btn btn-danger" id="decline_cand" >Decline <span class="glyphicon glyphicon-remove"></span></button>
		</div>
</div>
