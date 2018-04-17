<?php 
require('institute_functions.php');

@session_start();
if(!isset($_POST['updateid']))
{
	header('location:index.php');
}
else
{

	$con=mysqli_connect("localhost","root","","mini_project");
	$email=$_SESSION['Userid'];
	$ch="select * from institutes where Email='$email'";
	$q=mysqli_query($con,$ch);
	$count=mysqli_num_rows($q);
	$r1=mysqli_fetch_array($q);
	if($count>0)
	{
				$institute_id=$r1['ID'];
	}

	$updateid=$_POST['updateid'];
	$q1="select * from jobs where institute_id='$institute_id' and job_id='$updateid'";
	$exq1=mysqli_query($con,$q1);
	$result=mysqli_fetch_array($exq1);
	
	$quali_array=explode(',', $result['qualification']);
	$skills_array=explode(',', $result['required_skills']);
		
	$categoryvals="SELECT DISTINCT `category` FROM jobs";
	$uniqcategories=mysqli_query($con,$categoryvals);



}
?>

<div class="well" style="background-color:#188FBC;margin:auto;max-width:700px;margin-top:10px;margin-bottom:10px;">
				<p style="text-align:center;font-size:27px;color:#FBFBFB;margin-bottom:5px;font-family:Trebuchet MS;"> <b>Update here!</b></p>
			
				<hr style="border-color:#9D471E;background-color:black;">
				
				<form name="Jobform" method="post" novalidate>
				
				<div>
				Job/Training:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="radio-inline">
				<input type="radio" name="jobtraining" value="job" <?php if($result['job/training']=="job") { ?> checked <?php } ?>/> Job</label>
				<label class="radio-inline">
				<input type="radio" name="jobtraining" value="training"  <?php if($result['job/training']=="training") { ?> checked <?php } ?> /> Training</label>
				&nbsp;&nbsp;				
				<br>
				<p id="jobtraining-error"></p>
				<br>
				</div>
				
				<div class="form-group">
				Job/Training title:
				<input type="text" class="form-control" name="jobtitle" id="jobtitle" placeholder="Enter title" value="<?php echo $result['job_title']; ?>"/>
				<p id="title-error"></p>
				</div>

				<div>	
				Category:
				
		        <select class="form-control" id="category" id="category">    
		        <?php while ($row1=mysqli_fetch_array($uniqcategories)){?>
		          <option value="<?php echo $row1['category'];?>" <?php if($result['category']==$row1['category']) { ?> selected <?php } ?>><?php echo $row1['category'];?></option>
		        <?php } ?>
		        </select>
		       	<p id="category-error"></p>
				<br>
				</div>

				<!-- div "role_salary" starts -->
				<div id="role_salary">
				<div class="row">
				<div class="col-md-4">
				Role
				<input type="text" style="min-width:110px;" name="role" class="form-control" id="role"  placeholder="Enter job role" value="<?php echo $result['role']; ?>"/>
				<p id="role-error"></p>
				</div>
				<div class="col-md-2">
					Vacancy: <input type="number" min="1" class="form-control" name="vacancy" placeholder="Enter vacancy" id="vacancy" value="<?php echo $result['vacancy']; ?>" />
				<p id="vacancy-error"></p>
				</div>
				<div class="col-md-4">
				Expected Salary(in INR)<br>
				<input type="number" name="salary" min="1" id="salary" placeholder="you can add salary" class="form-control" value="<?php echo $result['expected_salary']; ?>"/>

				<input type="checkbox" id="salary_checkbox1" class="salary-checked" checked="checked">

				<span id="salary-error"></span>
				</div>
			
				</div>
				</div>	
				<!-- div "role_salary" ends	-->	

				<!-- Qualification starts -->
				<br>
				<div class="row">
				<div class="col-md-12">
				Qualification:<br>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.E." <?php if(in_array("B.E.",$quali_array)) { ?> checked <?php } ?> >B.E.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.Tech." <?php if(in_array("B.Tech.",$quali_array)) { ?> checked <?php } ?> >B.Tech.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="M.E." <?php if(in_array("M.E.",$quali_array)) { ?> checked <?php } ?> >M.E.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="M.Tech." <?php if(in_array("M.Tech.",$quali_array)) { ?> checked <?php } ?> >M.Tech.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="BCA" <?php if(in_array("BCA",$quali_array)) { ?> checked <?php } ?> >BCA</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="MCA" <?php if(in_array("MCA",$quali_array)) { ?> checked <?php } ?> >MCA</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.Sc." <?php if(in_array("B.Sc.",$quali_array)) { ?> checked <?php } ?> >B.Sc.</label>
					
					<p id="quali-error"></p>
				</div>
				
				</div>
				<!-- Qualification ends -->

				<!-- required_skills starts -->
				<div>
				<br>
				Required skills:
				<div>

				<div class="row" >
				<div class="col-md-9">
				<div id="skills_input">
					<input type="textbox" class="form-control" name="skill[]" id="skill1" placeholder="Enter required skill" value="<?php echo $skills_array[0]; ?>">
					<span id="skillerror1"></span>
				</div>
				</div>
				<div class="col-md-3">
					<button type="button" class="btn btn-warning" id="Add_more_skill">Add more</button>
				</div>
				</div>
				</div>

				</div>
				<!-- required_skills ends -->
				<br/>
				
				<div>
					Experience required(in years):
					<div class="input-group" style="max-width:185px;">
						<input type="number"  class="form-control" min="0" max="100" name="experience" id="experience" <?php if($result['experience']==0) { ?> placeholder="Not required" disabled <?php } else { ?> value="<?php echo $result['experience']; ?>" <?php } ?>  />
						<span class="input-group-btn"><button type="button" class="btn btn-danger" id="disable-exper"><?php if($result['experience']==0) { ?> Yes <?php } else { ?> No <?php } ?></button>
						</span>
					</div> 
					
					<span id="experience-error"></span>

				</div>
				<br>
				<div class="row">
					<div class="col-md-4">Country:<input type="textbox" class="form-control" name="country" id="country" placeholder="Country for job" value="<?php echo $result['country']; ?>" />

					<span id="country-error"></span>

					</div>
					<div class="col-md-4">
					State:<input type="textbox" class="form-control" name="state" id="state" placeholder="State for job" value="<?php echo $result['state']; ?>" />

					<span id="state-error"></span>
					
					</div>
					<div class="col-md-4">
					City:<input type="textbox" class="form-control" name="city" id="city" placeholder="City for job" value="<?php echo $result['city']; ?>" />
					
					<span id="city-error"></span>

					</div>
				</div>
				<br/>
				<div>
				Closing date:
				<div style="width:100%;
				height:100%;max-width:100px;"> 
				<div class="input-group" >
				
				<input type="date" class="form-control" style="max-width:153px;" min="<?php echo date('Y-m-d');?>" value="<?php echo $result['closing_date']; ?>" name="closing_date" id="closing_date" >
				<span class="input-group-btn"><button type="button" class="btn btn-success" style="height:32px;width:34px;padding-left:10px;"> <span class="glyphicon glyphicon-calendar" ></span> </button>
				</span>
				</div>

				<span id="closingdate-error"></span>
				</div>

				<br/>

				<div>
				Maximum Age:
			   
			    <div class="input-group" style="max-width:185px;">
			      <input type="number" min="0" class="form-control" name="max_age" id="max_age" <?php if($result['max_age']==0) { ?> placeholder="Not required" disabled <?php } else { ?> value="<?php echo $result['max_age']; ?>" <?php } ?>  >
			      <span class="input-group-btn"><button type="button" class="btn btn-danger" id="disable-age"><?php if($result['max_age']==0) { ?> Yes <?php } else { ?> No <?php } ?></button>
				  </span>
			    </div>

			    <span id="age-error"></span>
			    </div>

			    <br/>
			    <div>
			    	Description:
			    	<textarea class="form-control" name="desc" rows="5" id="desc" ><?php echo $result['description']; ?></textarea>
			    	<span id="desc-error"></span>
			    </div>

			    <br>
			    <br>
				<p style="text-align:center;">
				<button type="button" id="update" class="btn btn-success">Update </button>
				</p>

				</form>


				<p id="result" style="color:green;"></p>


			</div>


			<!-- end div="well" -->


		
<script type="text/javascript">

	$(document).ready(function(){

	$('#update').click(function(){
	checkAll();
	});


	var skillcount=1;
	
	<?php 
	$startfrom=1;
	foreach ($skills_array as $i=>$key): if($startfrom==1){ $startfrom=2; continue; }?>

	skillcount++;
    		$('#skills_input').append('<div class="row skillrow'+skillcount+'"><div class="col-md-12"><div class="input-group"><input type="textbox" class="form-control" name="skill[]" id="skill'+skillcount+'" placeholder="Enter one more skill" value="<?php echo $key; ?>"><span class="input-group-btn"><button type="button" class="btn btn-danger skillclose" id="deleteskill'+skillcount+'">X</button></span></div></div><div class="col-md-3"><span id="skillerror'+skillcount+'"></span></div></div>');
    <?php endforeach; ?>
	
	function checkskills()
    {
    	var returnskillscheck='false';
    	for(q=1;q<=skillcount;q++)
    	{
    		var skillj=$('#skill'+q+'').val();

    		if(skillj=='')
    		{
    				$('#skillerror'+q+'').html('<span style="color:#c4071d">Enter skill</span>');
					returnskillscheck='true';
   			}
   			else
   			{
   				$('#skillerror'+q+'').html('');
   			}
   		}		    			
   		if(returnskillscheck=='true')
   		{
  				return false;
   		}
   		else
   		{
   			return true;
   		}	
	}

	var i=1;
	function checkAll()
	{

		var flag=0;
		var fields = $("input[name='qualification']").serializeArray(); 
	    if (fields.length === 0) 
	    { 
	       $('#quali-error').html('<span style="color:#c4071d;">Please select required qualifications.</span>');
	       flag=1;
	    } 
	    else
	    {
	    	$('#quali-error').html('');
	    }

	    
	   	var type='';
	   	type=$('input[name=jobtraining]:checked').val();
	   	if(type=='')
	   	{
	   		$('#jobtraining-error').html('<span style="color:#c4071d;">Please select job/training.</span>');
	   		flag=1;
	   	}
	   	else
	   	{

	   		$('#jobtraining-error').html('');
	   	}

	    var jobtitle=$('#jobtitle').val();
	    if(jobtitle=='')
	   	{
	   		$('#title-error').html('<span style="color:#c4071d;">Please enter job/training title</span>');
	   		flag=1;
	   	}
	   	else
	   	{

	   		$('#title-error').html('');
	   	}
	    
	    var category=$('#category').val();
	    if(category=='')
	   	{
	   		$('#category-error').html('<span style="color:#c4071d;">Please enter job/training category</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#category-error').html('');
	   	}

	    var experience=$('#experience').val();
	    var isAgeDisabled = $('#experience').prop('disabled');
	    if(isAgeDisabled==false && experience=='')
	   	{
	   		$('#experience-error').html('<span style="color:#c4071d;">Please enter experience required.</span>');
	   		flag=1;
	   	}
	   	else if(isAgeDisabled==true)
	   	{
	   		experience=0;
	   		$('#experience-error').html('');
	   	}
	   	else
	   	{
	   		$('#experience-error').html('');
	   	}

	   	var country=$('#country').val();

	   	if(country=='')
	   	{
	   		$('#country-error').html('<span style="color:#c4071d;">Please enter job/training country</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		
	   		$('#country-error').html('');
	   	}

	    var state=$('#state').val();
	     if(state=='')
	   	{
	   		$('#state-error').html('<span style="color:#c4071d;">Please enter job/training state</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#state-error').html('');
	   	}

	    var city=$('#city').val();
	    if(city=='')
	   	{
	   		$('#city-error').html('<span style="color:#c4071d;">Please enter job/training city</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#city-error').html('');
	   	}

	    var closing_date=$('#closing_date').val();

	    if(closing_date=='')
	   	{
	   		
	   		$('#closingdate-error').html('<span style="color:#c4071d;">Please enter job/training closingdate</span>');
	   		flag=1;
	   	}
	   	else
	   	{

	   		$('#closingdate-error').html('');
	   	}


	   	var role=$('#role').val();
	    if(role=='')
	   	{
	   		$('#role-error').html('<span style="color:#c4071d;">Please enter job/training role</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#role-error').html('');
	   	}

	   	var vacancy=$('#vacancy').val();
	    if(vacancy=='')
	   	{
	   		$('#vacancy-error').html('<span style="color:#c4071d;">Please enter job/training vacancy</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#vacancy-error').html('');
	   	}

	   	var salary=$('#salary').val();
	    var isSalaryDisabled = $('#salary').prop('disabled');
	    if(isSalaryDisabled==false && salary=='')
	   	{
	   		$('#salary-error').html('<span style="color:#c4071d;">Please enter job/training salary</span>');
	   		flag=1;
	   	}
	   	else if(isSalaryDisabled==true)
	   	{
	   		salary=0;
	   		$('#salary-error').html('');
	   	}
	   	else
	   	{
	   		$('#salary-error').html('');
	   	}


	    var description=$('#desc').val();
	    if(description=='')
	   	{
	   		$('#desc-error').html('<span style="color:#c4071d;">Please enter job/training description</span>');
	   		flag=1;
	   	}
	   	else
	   	{
	   		$('#desc-error').html('');
	   	}


	    var max_age=$('#max_age').val();
	    var isAgeDisabled = $('#max_age').prop('disabled');
	    if(isAgeDisabled==false && max_age=='')
	   	{
	   		$('#age-error').html('<span style="color:#c4071d;">Please enter maximum age</span>');
	   		flag=1;
	   	}
	   	else if(isAgeDisabled==true)
	   	{
	   		max_age=0;
	   		$('#age-error').html('');
	   	}
	   	else
	   	{
	   		$('#age-error').html('');
	   	}


	   

	    var skillsval=checkskills();
	    var skillsarr=[];
	    var skills='';
	    if(skillsval==true)
	    {
	    	skillsarr = document.getElementsByName('skill[]');
	    	var p=0;
	    	skills=skillsarr[0].value; 

	    	for(p=1;p<skillsarr.length;p++)
	    	{
	    		skills+=','+skillsarr[p].value;
	    	}
	    	
	    }
	    if(skills==''){
	    	flag=1;
	    }
	    

	    var qualiarray = [];
            $.each($("input[name='qualification']:checked"), function(){
                qualiarray.push($(this).val());
            });
        qualiarray.join(", ");
        if(qualiarray=='')
        {
        	$('#quali-error').html('<span style="color:#c4071d;">Please select qualification(s) required</span>');
        	flag=1;
        }
        else
        {
        	$('#quali-error').html('');
        }
        var updateid=<?php echo $_POST['updateid'];?>;
        
        if(flag==0)
        {
     			
        		$.ajax({
				url:'jobpostdata.php',
				
				type:'POST',
				data:{
					'action':'update',
					'updateid':updateid,
					'type': type,
					'title': jobtitle,
					'category': category,
					'role':role ,
					'vacancy': vacancy,
					'salary': salary,
					'qualifications':qualiarray,
					'skills': skills,
					'experience': experience,
					'country': country,
					'state':state,
					'city': city,
					'closing_date': closing_date,
					'max_age': max_age,
					'description':description
					},
				success:function(result)
				{
					alert(result);
				}
				});

        }
	}	

		
		$(document).on('click','.Remove_row',function(){
			var removebtnid=$(this).attr("id");
			$('.row'+removebtnid+'').remove();
			
		});
		
		$(document).on('click','.salary-checked',function(){
			salaryid='';
			var checkboxid=$(this).attr("id");
			
			var salaryid=$('#salary').attr('id');
             
			var isDisabled = $('#'+salaryid+'').prop('disabled');

			if(isDisabled==false)
			{
			$('#'+salaryid+'').prop('value','');
			$('#'+salaryid+'').attr("placeholder","Not_mentioned");
			$('#'+salaryid+'').prop('disabled', true);	
			
			$('#salary-error').html('');

			}
			else
			{
			$('#'+salaryid+'').attr("placeholder","you can add salary");
		
			$('#'+salaryid+'').prop('disabled', false);
			}
		});

    	/* adding more skills */
    	
    	$("#Add_more_skill").click(function(){
 			
    		var check=checkskills();
    		if(check==true)
    		{
    		
    		skillcount++;
    		$('#skills_input').append('<div class="row skillrow'+skillcount+'"><div class="col-md-12"><div class="input-group"><input type="textbox" class="form-control" name="skill[]" id="skill'+skillcount+'" placeholder="Enter one more skill"><span class="input-group-btn"><button type="button" class="btn btn-danger skillclose" id="deleteskill'+skillcount+'">X</button></span></div></div><div class="col-md-3"><span id="skillerror'+skillcount+'"></span></div></div>');
    		
    		}
    	});
    	$(document).on('click','.skillclose',function(){
    		var skillcloseid=$(this).attr("id");
    		var remove='deleteskill';
   			var digitlen= skillcloseid.length-remove.length;
    		var getdigit=skillcloseid.slice(skillcloseid.length-digitlen,skillcloseid.length);
    		$('.skillrow'+getdigit+'').remove();
    	});

    	/* for experience validation */
    	$('#disable-exper').click(function(){

    		var isExpDisabled=$('#experience').prop('disabled');
    		var exp=$('#experience').val();
    		if(isExpDisabled==false)
    		{

    		$('#experience').prop('disabled', true);
    		if(exp!='')
    		{
    			$('#experience').prop('value', '');
    		}
    		$('#experience').prop('placeholder','no age restriction')
			$('#disable-exper').text('Yes');
			$('#experience-error').html('');
    		}
    		else
    		{
    		$('#experience').prop('disabled', false);
			$('#experience').text('No');
				if(exp!='')
				{

				}
				else
				{
				$('#experience-error').html('<span style="color:#c4071d">Please enter experience.</span>');
				}
    		}

    	});

    	$('#disable-age').click(function(){

    		var isAgeDisabled=$('#max_age').prop('disabled');
    		var maxage=$('#max_age').val();
    		if(isAgeDisabled==false)
    		{

    		$('#max_age').prop('disabled', true);
    		if(maxage!='')
    		{
    			$('#max_age').prop('value', '');
    		}
    		$('#max_age').prop('placeholder','no age restriction')
			$('#disable-age').text('Yes');
			$('#age-error').html('');
    		}
    		else
    		{
    		$('#max_age').prop('disabled', false);
			$('#disable-age').text('No');
				if(maxage!='')
				{

				}
				else
				{
				$('#age-error').html('<span style="color:#c4071d">Please enter maximum age</span>');
				}
    		}
    	});

    	/* end of jquery */
	});

</script>