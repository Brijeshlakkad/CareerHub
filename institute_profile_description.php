<?php 
require_once('functions.php');
require_once('institute_functions.php');

check_session();
get_details_from_institute();
$add_type=$_POST['add_type'];

?>
<?php if($add_type=='add_description' || $add_type=='edit_description') { ?>

<div class="container-fluid">
	
	<form name="myForm1" id="myForm1"  method="post" novalidate>
    <div class="row">
        
         <h3 class="heading"><label>Add Description</label></h3>
         
			<div class="form-group">
			
			
				<textarea class="form-control" name="description" 
				placeholder="Description can contain 40-400 characters and can only use special characters like ,  /  .  and carrige return character only." id="description" cols="40" rows="15" required><?php if($add_type=='edit_description'){ echo $institute_descr; } ?></textarea>
				<a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Description can contain 40-400 characters and can only use special characters like ,  /  .  and carrige return character only. ">?</a>
				<span id="desc-error"></span>
			</div>		
					
			
			<br/>
			<input type="button" id="Add_descr" class="btn btn-success" value="Submit"/>
			<p id="desc-result"></p>
		</div>
	
	</form>
	
</div>

<?php 
} 
// end if('description')
?>


<script type="text/javascript">
	$(document).ready(function(){
		var descval;
		$('#Add_descr').click(function(){
			descval=$('#description').val();

			if(descval==''){
				$('#desc-error').html('<span style="color:red">Please enter desciption</span>');
			}
			else
			{
				$('#desc-error').html('');
				$.fn.submitdesc();
			}
		});
		$.fn.submitdesc=function()
		{
				
				$.ajax({
                url:'institute_profile_details_submit.php',
                type:'POST',
                data:{
                    'description':descval    
                    },
                success:function(result)
                {

                    $('#desc-result').html(result);
                }
                });    
		}
		
	});
</script>