<?php 
require_once('functions.php');
require_once('institute_functions.php');

check_session();
get_details_from_institute();
$add_type=$_POST['add_type'];

?>
<?php if($add_type=='add_details' || $add_type=='edit_details') { ?>

<div class="container-fluid">
	
	<form name="myForm2" id="myForm2"  method="post" novalidate>
	 <h3 class="heading" style="text-align:center;"><label>Add Details</label></h3>
	 		<br/><br/>
			
				
				<div class="form-group">
				Institute type:
				<input type="text" class="form-control" name="institute_type" id="institute_type" placeholder="Enter institute type" value="<?php if($add_type=='edit_details'){ echo $institute_type; }?>" required/>
				<span id="type-error" style="color:red"></span>
			
				</div>

				<div class="form-group">
				Headquarter Address:
				<textarea class="form-control" name="institute_address" id="institute_address" cols="40" rows="3" required><?php if($add_type=='edit_details'){ echo $institute_address; }?></textarea>
				<span id="address-error" style="color:red"></span>
				
				</div>

				
				<div class="form-group">
				Country:
				<input type="text" class="form-control" name="institute_country" id="institute_country" placeholder="Enter country of institute's Headquarter" value="<?php if($add_type=='edit_details'){ echo $institute_country; }?>" required/>
				<span id="country-error" style="color:red"></span>
				</div>

				<div class="form-group">
				Zip:
				<input type="text" class="form-control" name="institute_zip" id="institute_zip" placeholder="Enter zip code of institute's Headquarter" value="<?php if($add_type=='edit_details'){ echo $institute_zip; }?>" required/>
				<span id="zip-error" style="color:red"><br></span>
				</div>


			<br/>
			<input type="button" id="Add_details" class="btn btn-success" value="Submit"/>
			<p id="details-result"></p>
	
	</form>
	
</div>
<?php
}
?>





<script type="text/javascript">
	$(document).ready(function(){
		var inst_type;
		var inst_address;
		var inst_country;
		var inst_zip;

		$('#Add_details').click(function(){
			inst_type=$('#institute_type').val();
			inst_address=$('#institute_address').val();
			inst_country=$('#institute_country').val();
			inst_zip=$('#institute_zip').val();
			var flag=0;
			if(inst_type=='')
			{
				flag=1;
				$('#type-error').html('Please enter type of institute.');
			}
			if(inst_address==''){
				flag=1;
				$('#address-error').html('Please enter Headquarter address.');
			}
			if(inst_country=='')
			{
				flag=1;
				$('#country-error').html('Please enter country.');
			}
			if(inst_zip==''){
				flag=1;
				$('#zip-error').html('Please enter Headquarter zip.');
			}
			
			if(flag!=1)
			{
			$.fn.submitdetails();
			}
		});
		$.fn.submitdetails=function()
		{
			
			
				$('#desc-error').html('');
				$.ajax({
                url:'institute_profile_details_submit.php',
                type:'POST',
                data:{
                    'details':'details',
                    'type':inst_type,
                    'address':inst_address,
                    'country':inst_country,
                    'zip':inst_zip
                    },
                success:function(result)
                {
                    $('#details-result').html(result);
                }
                });
            
		}
	});
</script>