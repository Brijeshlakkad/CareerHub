<?php
include_once('functions.php');
include_once('index_header.php');
include_once('candidate_details.php');
check_session();

get_details_from_candidate();

?>
<body>
<div class="container well">
   <form id="myForm" name="myForm" method="post">
    <div class="row">
        <div align="center">
			<table class="myTable">
			<div class="form-group">
			<tr>
				<td><label for="quali">You can add maximum 15 Skills</label></td>
				<td><input class="form-control btn btn-primary" type="button" name="quali" id="add" value="Add Your Skills" /></td>
				<td><p id="quali"></p></td>
			</tr>
			
			<tr>
			<td id="status"></td>
			<td><input type="button" class="btn btn-success" id="submit"  value="Add to Skills"/></td>
			<td></td>
			</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4 col-sm-offset-4" >
		<ol id="fields_container">
			<?php
						get_details_from_candidate();
						if($qualis[0]!="0")
						{
							$len=count($qualis);
							for($i=1;$i<=$len;$i++)
							{
								?>
								<div class="form-group">
								<li><input class="form-control" type="text" name="skills[]" onblur="analyze(this.value,'<?php echo $i.'xx'; ?>')" onkeyup="analyze(this.value,'<?php echo $i.'xx'; ?>)'" id="<?php echo $i.'xxx'; ?>" value="<?php echo $qualis[$i-1]; ?>" /><a href="#" class="remove_field" style="margin-left:10px;">Remove</a>
									<span id="<?php echo $i.'xx'; ?>"></span></li>
								</div>
								<?php
							}
						}
					?>
		</ol></div>
	</div>
	</form>
</div>

<script>
	var xcounter;
	var check='<?php echo $qualis[0]; ?>';
	if(check!='0')
		xcounter='<?php echo count($qualis); ?>';
	else
		xcounter=0;
	var xcounter2=xcounter;
	
	$(document).ready(function() {
    var max_fields_limit= 15; 
    var x = 0;
    $('#add').click(function(){
		if(x>=max_fields_limit){ 
		$("#quali").append("<b style='color:red'>max 15 skills</b>");
		}
        if(xcounter < max_fields_limit){ 
            xcounter++;
			xcounter2++;
			var in_id=xcounter2+'xxx';
			var f_id=xcounter2+'xx';
			var fun="analyze(this.value,'"+xcounter2+"xx')";
            $('#fields_container').append('<div class="form-group"><li><input type="text" name="skills[]" id="'+in_id+'" class="form-control"  onblur="'+fun+'" onkeyup="'+fun+'" /><a href="#" class="remove_field" style="margin-left:10px;">Remove</a><br/><span id="'+f_id+'" ></span></li></div>'); 
			
        }
    });  
    $('#fields_container').on("click",".remove_field", function(){ 
		$(this).parent('li').remove(); 
		xcounter--;
    });
	$("#submit").click(function(){
		if(xcounter!=0)
			{
				var flag=0;
				for(i=1;i<=xcounter2;i++)
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
						
						var skillarr= $('input[name="skills[]"]').serialize();
							$.ajax({
							type:'POST',
							url:'candidate_submit_skills.php',
							data: skillarr,
							success: function(result) {
									if(result==1)
										$("#status").html("<span style='color:green;'>Skills added</span>");
									else
										$("#status").html("<span style='color:red;'>Please, try again!</span>");
								}
							});
					}
				else
				{
					$("#status").html("<span style='color:red;'>please enter valid information</span>");
				}
				
			}
		else{
			$("#status").html("<span style='color:red;'>please enter at least one skill</span>");
		}
	});
	});
	function analyze(val,f)
	{
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
	
	</script>
	</body>
</html>