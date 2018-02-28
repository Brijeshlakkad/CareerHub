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
				  <?php
					if($qualis[0]==0)
						echo "<a href='candidate_add_quali.php'>Add Qualification Details</a>";
					?>
					<div class="progress" style="width:60%">
					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $barV; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $barV.'%'; ?>"><?php echo $barV.'%'; ?>
					</div>
				  </div>
				</div>
			  </div>
            </div>
		</div>
        <div class="col-sm-4">
        <?php
				get_details_from_candidate();
				if($qualis[0]!='0')
				{
					?>
        <label>Qualification Details <span id="edit_btn"><a id="edit">Edit <span class="glyphicon glyphicon-pencil"></span></a></span></label>
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
		</div>
		<?php 
					}
		?>
		<div id="edit_skills">
			<form method="post" name="myform" id="myform" action="candidate_submit_skills.php">
				<table class="myTable">
					<?php
						get_details_from_candidate();
						if(count($qualis)!=0)
						{
							$len=count($qualis);
							for($i=1;$i<=$len;$i++)
							{
								?>
								<div class="form-group">
								<tr>
									<td><?php echo $i."."; ?></td>
									<td><input class="form-control" type="text" name="skills[]" onblur="analyze(this.value,'<?php echo $i.'xx'; ?>')" onkeyup="analyze(this.value,'<?php echo $i.'xx'; ?>)'" id="<?php echo $i.'xxx'; ?>" value="<?php echo $qualis[$i-1]; ?>" /></td>
									<td id="<?php echo $i.'xx'; ?>"></td>
								</tr>
								</div>
								<?php
							}
						}
					?>
					<tr>
						<td id="status"></td>
						<td><button type="button" class="btn btn-sm btn-primary" onclick="check()" >Lock <span  class="glyphicon glyphicon-lock"></span></button></td>
						<td></td>
					</tr>
				</table>
			</form>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#edit_skills").hide();
		$("#edit").click(function(){
			$("#show_skills").hide();
			$("#edit").hide();
			$("#edit_skills").show();
			
		});
	});
	function analyze(val,f)
	{
		$("status").html("hii");
		if(val=="")
			{
				$("#"+f+"").html("<span style='color:red;'>Don't leave empty</span>");
				$("#"+f+"x").css({"border-color": "red", "border-width": "1.45px"});
			}
		else
			{
				$("#"+f+"").empty();
				$("#"+f+"x").css({"border-color": "green", "border-width": "1.45px"});
			}
	}
	function check()
	{
		var xcounter=<?php echo count($qualis); ?>;
		if(xcounter!=0)
			{
				var flag=0;
				for(i=1;i<=xcounter;i++)
					{
						var xx=$("#"+i+"xxx").val();
						if(xx=="")
							{
								$("#"+i+"xx").html("<span style='color:red;'>Don't leave empty</span>");
								$("#"+i+"xxx").css({"border-color": "red", "border-width": "1.45px"});
								flag=1;
							}
						else
						{
							$("#"+i+"xx").empty();
							$("#"+i+"xxx").css({"border-color": "green", "border-width": "1.45px"});
						}
					}
				if(flag==0)
					{
						$("#myform").submit();
						$("#edit_skills").hide();
						$("#show_skills").show();
						$("#edit").show();
					}
				else
				{
					$("#status").html("<span style='color:red;'>please enter valid information</span>");
				}
				
			}
		else{
			$("#status").html("<span style='color:red;'>please enter at least one skill</span>");
		}
	}
</script>
</body>
</html>