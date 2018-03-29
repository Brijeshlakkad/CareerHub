<?php
include_once('functions.php');
include_once("config.php");
include_once("index_header.php");
include_once("candidate_details.php");
check_session();
if(isset($_POST['inst_id']) && isset($_POST['job_id']))
{
	$id=$_POST['inst_id'];
	$jobid=$_POST['job_id'];
	$sql="select * from Institutes where ID='$id'";
	$result=mysqli_query($con,$sql);
	if(!$result)
		die("Server is down.");
	$row_inst=mysqli_fetch_array($result);
	
	$im=base64_encode($row_inst['Image']);
	$bits_inst=explode(",/,",$row_inst['Status_bits']);
	$institute_id=$row_inst['ID'];
	$institute_name=$row_inst['Bname'];
	$institute_email=$row_inst['Bemail'];
	$institute_contact=$row_inst['Phone'];
	$sbit_inst=$row_inst['Status_bits'];
	$bits_inst=explode(",/,",$sbit_inst);
	$inst_image=$row_inst['Image'];
	$im=base64_encode($inst_image);
	$institute_type=$row_inst['institute_type'];
	$institute_descr=$row_inst['institute_descr'];
	$institute_address=$row_inst['institute_address'];
	$institute_country=$row_inst['institute_country'];
	$institute_zip=$row_inst['institute_zip'];
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
        <div class="col-sm-offset-1 col-sm-7">
            <div>
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">
			  <br/>
			  		<h3><b><?php echo $institute_name; ?></b></h3>
				  <br/>
				<br/>
				</div>
			  </div>
            </div>
		</div>
		<div class="col-sm-4" >
		<div class="row" align="center">
		<?php
			if($bits_inst[1]==0)
			{
				?>
				<h2><span style="color:red;">Disapproved <span class="glyphicon glyphicon-remove"></span></span></h2>
				<?php
			}
			else if($bits_inst[1]==1)
			{
				?>
				<h2><span style="color:green;">Approved <span class="glyphicon glyphicon-ok"></span></span></h2>
				<?php
			}
		
		?>
		</div>
		</div>
	</div>
  <hr style="border-width: 1px;border-color: rgba(180,180,180,1.00)"/>
<div class="row">
<div class="col-sm-offset-1 col-sm-6">
   <h4>Job Title </h4>
</div>
<div class="col-sm-5">
	<h4><b>Institute Details</b></h4>
</div>
</div>
<hr style="border-width: 1px;border-color: rgba(180,180,180,1.00)"/>
<div class="row">
<div class="col-sm-offset-1 col-sm-6">
  	
</div>
<div class="col-sm-5">
	<p><b>Institute Type:</b> <?php echo $institute_type;?></p>
    <p><b>Business Email:</b> <?php echo $institute_email;?></p>
    <p><b>Business Contact:</b> <?php echo  $institute_contact;?></p>
    <p><b>Institute Address:</b> <?php echo $institute_address;?></p>
    <p><b>Country: </b><?php echo $institute_country;?></p>
    <p><b>ZIP: </b><?php echo $institute_zip;?></p>
</div>
</div>
</div>
<?php
}
?>