<?php
include_once('functions.php');
include_once("config.php");
check_session();
if(isset($_POST['query']))
{
	$id=$_POST['query'];
	$sql="select * from Institutes where ID='$id'";
	$result=mysqli_query($con,$sql);
	if(!$result)
		die("Server is down.");
	$row=mysqli_fetch_array($result);
	
	$im=base64_encode($row['Image']);
	$bits=explode(",/,",$row['Status_bits']);
	$login_name=ucwords($row['Name']);
	$login_bname=ucwords($row['Bname']);
	$updated=$row['isUpdated'];
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
    <div class="row">
        <div class="col-sm-offset-1 col-sm-7">
            <div>
           		<div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">
			  <br/>
				  <h4><b><?php echo $login_name; ?></b></h4>
				  <br/>
					<br/>
				</div>
			  </div>
            </div>
		</div>
		<div class="col-sm-4" >
		<div class="row" align="center" id="<?php echo $id; ?>">
		<?php
		if(!(count($bits)>1))
		{
			?>
		
		<form>
			<input type="hidden" name="flag" />
			<button type="button" class="btn btn-success" id="approve_inst" >Approve <span class="glyphicon glyphicon-ok"></span></button>
			<button type="button" class="btn btn-danger" id="decline_inst" >Decline <span class="glyphicon glyphicon-remove"></span></button>
		</form>
		
		<?php
		}else if((count($bits)>1) && $updated==1 && $bits[1]==1)
		{
			?>
		
		<form>
			<input type="hidden" name="flag" />
			<button type="button" class="btn btn-success" id="approve_inst" >Approve <span class="glyphicon glyphicon-ok"></span></button>
			<button type="button" class="btn btn-danger" id="decline_inst" >Decline <span class="glyphicon glyphicon-remove"></span></button>
		</form>
		
		<?php
		}
		else
		{
			if($bits[1]==0)
			{
				?>
				<h2><span style="color:red;">Disapproved <span class="glyphicon glyphicon-remove"></span></span></h2>
				<?php
			}
			else if($bits[1]==1)
			{
				?>
				<h2><span style="color:green;">Approved <span class="glyphicon glyphicon-ok"></span></span></h2>
				<?php
			}
		}
		?>
		</div>
		</div>
	</div>
  <hr class="hr-primary" size='30'/>
<div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
   <hr size='30'/>
</div>
<?php
}
?>