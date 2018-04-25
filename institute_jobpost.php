<?php require_once('institute_header.php');?>
<?php $disable_submit=0; ?>
<div class="w3-container">
	<section class="content" style="background-color:#f5f5f5;box-shadow: 5px 5px 5px #aaaaaa;">
        <div class="container-fluid">

        <div id="AllContent">

            <div ng-app="jobsvalidation" ng-controller="jobsvalid">
          
			<div class="well" style="background-color:#188FBC;margin:auto;max-width:700px;margin-top:10px;margin-bottom:10px;">
				<p style="text-align:center;font-size:27px;color:#FBFBFB;margin-bottom:5px;font-family:Trebuchet MS;"> <b>Post here!</b></p>
			
				<hr style="border-color:#9D471E;background-color:black;">
				
				<form name="Jobform" method="post" novalidate>
				
				<div>
				Job/Training:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="radio-inline">
				<input type="radio" ng-model="jobtraining" name="jobtraining" value="job" ng-required="!jobtraining"/> Job</label>
				<label class="radio-inline">
				<input type="radio" ng-model="jobtraining" name="jobtraining" value="training" ng-required="!jobtraining" /> Training</label>
				&nbsp;&nbsp;				
				<span style="color:#c4071d" ng-show="(Jobform.jobtraining.$touched && Jobform.jobtraining.$invalid)
				|| (submitclicked && Jobform.jobtraining.$invalid)
				">Please select Job/training.</span>
				<br>
				<br>
				</div>
				
				<div class="form-group">
				Job/Training title:
				<input type="text" ng-model="jobtitle" class="form-control" name="jobtitle" id="jobtitle" placeholder="Enter title" ng-change="checktitle()" ng-style="titlecolor" required/>
				<span style="color:#c4071d" ng-show="(Jobform.jobtitle.$touched && Jobform.jobtitle.$invalid) || (submitclicked && Jobform.jobtitle.$invalid)">Please enter job/training title<br></span>
			

				</div>

				<div>	
				Category:
				<select class="form-control" ng-model="category" name="category" id="category" required>
					<option value="IT/Software">IT/Software</option>
					<option value="Civil Engineering">Civil Engineering</option>
					<option value="Mechanical Engineering">Mechanical Engineering</option>
					<option value="Electrical Engineering">Electrical Engineering</option>
					<option value="Electronics Engineering">Electronics Engineering</option>
					<option value="Production Engineering">Production Engineering</option>
					<option value="Other">Other</option>
				</select>
				<p id="otherhideshow">
				<input type="text" ng-model="othercategory" class="form-control" name="othercategory" id="othercategory" placeholder="Mention other category here" required>
				<span style="color:#c4071d" ng-show="(Jobform.othercategory.$touched &&Jobform.othercategory.$error.required) || (submitclicked && Jobform.othercategory.$error.required)">(Please enter other category)<br></span>
				</span>
				</p>

				<span style="color:#c4071d" ng-show="(Jobform.category.$touched && Jobform.category.$error.required) || (submitclicked && Jobform.category.$error.required)">(Please select category)<br></span>
				

				<br>
				</div>

				<!-- div "role_salary" starts -->
				<div id="role_salary">
				<div class="row">
				<div class="col-md-4">
				Role
				<input type="text" style="min-width:110px;" name="role[]" class="form-control" id="role1" ng-model="role1" placeholder="Enter job role" required />
				<p id="roleerror1"></p>
				</div>
				<div class="col-md-2">
					Vacancy: <input type="number" class="form-control" name="vacancy[]" placeholder="Enter vacancy" id="vacancy1" required/>
				<p id="vacancyerror1"></p>
				</div>
				<div class="col-md-4">
				Expected Salary(in INR)<br>
				<input type="number" name="salary[]" id="salary1" placeholder="you can add salary" class="form-control" />

				<input type="checkbox" id="salary_checkbox1" class="salary-checked" checked="checked">
				<span id="salaryerror1"></span>
				</div>
				<div class="col-md-2">
				<br>
				<button type="button" onclick="rolesalarycheck();" class="btn btn-warning" id="Add_more">
				<span>Add more</span></button>

				<a href="#" data-toggle="tooltip" style="color:#78706F;" data-placement="top" title="You can add similar type of roles which have similar types of required skills.">(?)</a>
				</div>

				</div>
				<table id="mytable">
					<!-- new content will be appended here on add button-->
				</table>
				</div>	
				<!-- div "role_salary" ends	-->	

				<!-- Qualification starts -->
				<br>
				<div class="row">
				<div class="col-md-12">
				Qualification:<br>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.E." >B.E.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.Tech.">B.Tech.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="M.E.">M.E.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="M.Tech.">M.Tech.</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="BCA">BCA</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="MCA">MCA</label>
					<label class="checkbox-inline"><input type="checkbox" name="qualification" value="B.Sc.">B.Sc.</label>
					<p id="quali-error"></p>
				</div>
				
				</div>
				<!-- Qualification ends -->
				<br/>
				
				<!-- Part/full time starts

				<p><span>Employment type:</span></p>
				<input type="radio" name="part_or_full_time" ng-model="part_or_full_time" value="part_time" id="part_or_full_time1" ng-required="!part_or_full_time"/>Part time
				&nbsp;&nbsp;
				<input type="radio" name="part_or_full_time" ng-model="part_or_full_time" value="full_time" id="part_or_full_time2" ng-required="!part_or_full_time"/>Full time
				<p id="part_full_error"></p>
				<span style="color:#c4071d" ng-show="(Jobform.part_or_full_time.$touched && Jobform.part_or_full_time.$invalid)
				|| (submitclicked && Jobform.part_or_full_time.$invalid)
				">Please select Employment type.</span>
				-->
			
				<!-- Part/full time ends -->


				<!-- required_skills starts -->
				<div>
				<br>
				Required skills:
				<div>

				<div class="row" >
				<div class="col-md-9">
				<div id="skills_input">
					<input type="textbox" class="form-control" name="skill[]" id="skill1" placeholder="Enter required skill">
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
						<input type="number" ng-model="experience" class="form-control" name="experience" id="experience" placeholder="required experience for job" required />
						<span class="input-group-btn"><button type="button" class="btn btn-danger" id="disable-exper">No</button>
						</span>
					</div> 
					
					<span id="exper-error" style="color:#c4071d;" ng-show="(Jobform.experience.$touched && Jobform.experience.$error.required)||(submitclicked && Jobform.experience.$invalid)">
					Enter experience</span>

				</div>
				<br>
				<div class="row">
					<div class="col-md-4">Country:<input type="textbox" ng-model="country" class="form-control" name="country" id="country" placeholder="Country for job" required />
					<span style="color:#c4071d;" id="countryerror" ng-show="(Jobform.country.$touched && Jobform.country.$error.required) || (submitclicked && Jobform.country.$invalid)">Please enter country</span>
					</div>
					<div class="col-md-4">
					State:<input type="textbox" ng-model="state" class="form-control" name="state" id="state" placeholder="State for job" required/>
					<span style="color:#c4071d;" ng-show="(Jobform.state.$touched && Jobform.state.$error.required)||(submitclicked && Jobform.state.$invalid)">Please enter state</span>
					</div>
					<div class="col-md-4">
					City:<input type="textbox" ng-model="city" class="form-control" name="city" id="city" placeholder="City for job" required/>
					<span style="color:#c4071d;" ng-show="(Jobform.city.$touched && Jobform.city.$error.required)||(submitclicked && Jobform.city.$invalid)">Please enter city</span>
					</div>
				</div>
				<br/>
				<div>
				Closing date:
				<div style="width:100%;
				height:100%;max-width:100px;"> 
				<div class="input-group" >
				<input type="date" class="form-control" ng-model="closing_date" style="max-width:153px;" name="closing_date" id="closing_date" required>
				<span class="input-group-btn"><button type="button" class="btn btn-success" style="height:32px;width:34px;padding-left:10px;"> <span class="glyphicon glyphicon-calendar" ></span> </button>
				</span>
				</div>
				</div>
				<span style="color:#c4071d;" ng-show="(Jobform.closing_date.$touched && Jobform.closing_date.$error.required)||(submitclicked && Jobform.closing_date.$invalid)">Select application closing date</span>
				</div>
				<br/>

				<div>
				Maximum Age:
			   
			    <div class="input-group" style="max-width:185px;">
			      <input type="number" ng-model="max_age" class="form-control" name="max_age" id="max_age" placeholder="Maximum age" required>
			      <span class="input-group-btn"><button type="button" class="btn btn-danger" id="disable-age">No</button>
				  </span>
			    </div>

			    <span id="age-error" style="color:#c4071d;" ng-show="(Jobform.max_age.$touched && (Jobform.max_age.$error.required))
			    ||(submitclicked && Jobform.max_age.$invalid)">
					Enter experience</span>
			    </div>
			    <br/>
			    <div>
			    	Description:
			    	<textarea class="form-control" ng-model="desc" name="desc" rows="5" id="desc" required></textarea>

			    	<span style="color:#c4071d;" ng-show="(Jobform.desc.$touched && Jobform.desc.$error.required)||(submitclicked && Jobform.desc.$invalid)">Please enter description about job/training</span>
			    </div>

			    <br>
			    <br>
				<p style="text-align:center;">
				<button type="button" id="submit" class="btn btn-success" ng-click="submitclicked=true">Submit </button>
				</p>

				</form>


				<p id="result" style="color:green;"></p>


			</div>
			<!-- end angular -->
		

            </div>
        </div>

    </section>

</div>


















<script type="text/javascript">

	$(document).ready(function(){

	$('#submit').click(function(){
		checkAll();
	});


	var skillcount=1;
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
	function checkrvs()
	{
		var j;
			var returncheck=' ';
			for(j=1;j<=i;j++)
			{
				var rolej=$('#role'+j+'').val();
				var vacj=$('#vacancy'+j+'').val();
				var isDisabled = $('#salary'+j+'').prop('disabled');
				var salaryj=$('#salary'+j+'').val();
				
				if(rolej=='')
				{
					$('#roleerror'+j+'').html('<span style="color:#c4071d;">Please enter role</span>');
					returncheck='true';
				}
				else { $('#roleerror'+j+'').html('');}
				if(vacj=='')
				{
					$('#vacancyerror'+j+'').html('<span style="color:#c4071d;">Enter vacancy</span>');
					returncheck='true';
				}
				else { $('#vacancyerror'+j+'').html('');}
				if(isDisabled==false && salaryj=='')
				{
					$('#salaryerror'+j+'').html('<span style="color:#c4071d;">Please mention salary</span>');
					returncheck='true';
				}
				else { $('#salaryerror'+j+'').html('');}
			}
			if(returncheck=='true')
			{
				return false;
			}
			else
			{
				return true;
			}
	}

	function checkAll()
	{
		var flag=0;
		var fields = $("input[name='qualification']").serializeArray(); 
	    if (fields.length === 0) 
	    { 
	       $('#quali-error').html('<span style="color:#c4071d;">Please select qualifications required.</span>');
	       flag=1;
	    } 
	    else
	    {
	    	$('#quali-error').html('');
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

	   	var type='';
	   	type=$('input[name=jobtraining]:checked').val();

	    var jobtitle=$('#jobtitle').val();
	    
	    var category=$('#category').val();
	    
	   	var othercategory='dummy';
	    if(category=='Other')
	    {
	    	othercategory=$('#othercategory').val();
	    }

	    var experience='';
	    var isExpDisabled=$('#experience').prop('disabled');
	    if(isExpDisabled==false)
	    {
	    experience=$('#experience').val();

		}
		else if(isExpDisabled==true)
		{
			experience='null';
		}
		if(experience=='')
		{
			flag=1;
		}
	    var closing_date=$('#closing_date').val();
	    var max_age=$('#max_age').val();
	    var description=$('#desc').val();
	    
	    var country=$('#country').val();
	    var state=$('#state').val();
	    var city=$('#city').val();
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
	    var rvsval=checkrvs();
	    if(rvsval==true)
	    {
	    	var roleinparr = document.getElementsByName('role[]');
	    	var vacancyinparr = document.getElementsByName('vacancy[]');
	    	var salaryinparr = document.getElementsByName('salary[]');
	    }

	    var qauliarray = [];
            $.each($("input[name='qualification']:checked"), function(){
                qauliarray.push($(this).val());
            });
        qauliarray.join(", ");
        if(qauliarray=='')
        {
        	flag=1;
        }

        if(type=='' || jobtitle=='' || category=='' ||closing_date=='' || max_age=='' || description=='' || country=='' || state=='' || city=='')
        {
        	flag=1;
        }
        if(flag==0)
        {
     
        	var loop=roleinparr.length;

        	var x;
        	for(x=0;x<loop;x++)
        	{
	        	$.ajax({
				url:'jobpostdata.php',
				
				type:'POST',
				data:{
					
					'type': type,
					
					'title': jobtitle,
					'category': category,
					'role':roleinparr[x].value ,
					'vacancy': vacancyinparr[x].value ,
					'salary': salaryinparr[x].value,
					'qualifications':qauliarray ,
					
					'skills': skills,
					
					'experience': experience,

					'country': country,
					'state':state,
					'city': city,
					'closing_date': closing_date,
					'max_age': max_age,
					'description':description ,
					},
				success:function(result)
				{
					$('#result').html(result);
				}
				});
			}//end for
        }



	}	

		/* for role-salary start*/
		
		$("#Add_more").click(function(){
			
			var rvscheck=checkrvs();
			
			if(rvscheck==true)
			{

			i++;
			$("#mytable").append('<div class="row'+i+'">					   <div class="col-md-4">Role<input type="text" style="min-width:110px;" id="role'+i+'" name="role[]" class="form-control" placeholder="Enter job role" /><p id="roleerror'+i+'"></p></div>						   <div class="col-md-2">	Vacancy: <input type="number" class="form-control" id="vacancy'+i+'" name="vacancy[]" placeholder="Enter vacancy""/><p id="vacancyerror'+i+'"></p></div>    			  							  <div class="col-md-4">Expected Salary(in INR)<br><input type="number" id="salary'+i+'" name="salary[]" placeholder="you can add salary" class="form-control" placeholder=""/><input type="checkbox" class="salary-checked" id="salary_checkbox'+i+'" checked="checked"><span id="salaryerror'+i+'"></span></div>									  <div class="col-md-2" style="padding-left:0px;"><br><button type="button" class="btn btn-danger Remove_row" id="'+i+'">Remove</button></div>											<br></div>');
		
			}
		});

		$(document).on('click','.Remove_row',function(){
			var removebtnid=$(this).attr("id");
			$('.row'+removebtnid+'').remove();
			
		});
		
		$(document).on('click','.salary-checked',function(){
			salaryid='';
			var checkboxid=$(this).attr("id");
			var checkboxidnamecut='salary_checkbox';
			var digitlength=checkboxid.length-checkboxidnamecut.length;
			var lastdigits=checkboxid.slice(checkboxid.length-digitlength,checkboxid.length );

			//it gives '1' from 'salary-checked1', '19' from 'salary-checked19'
			var salaryid='salary'+lastdigits+'';
             
			var isDisabled = $('#'+salaryid+'').prop('disabled');

			if(isDisabled==false)
			{
		
			$('#'+salaryid+'').attr("placeholder","Not_mentioned");
			$('#'+salaryid+'').prop('disabled', true);	
			$('#'+salaryid+'').attr("value","0");
			$('#salaryerror'+lastdigits+'').html('');

			}
			else
			{
			$('#'+salaryid+'').attr("placeholder","you can add salary");
		
			$('#'+salaryid+'').prop('disabled', false);
			}
		});


		/* onselect 'Other' in category, it gives textbox */ 
		$('#otherhideshow').hide();
    	$('#category').change(function(){
        if($('#category').val() == 'Other') {
            $('#otherhideshow').show(); 
        } else {
            $('#otherhideshow').hide(); 
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

    		var isDisabled = $('#experience').prop('disabled');
			if(isDisabled==false)
			{
			$('#experience').attr("placeholder","Not required");
			$('#experience').prop('disabled', true);
			$('#disable-exper').text('Yes');
			$('#exper-error').html('');
			}
			else
			{
			$('#experience').attr("placeholder","required experience for job");
			$('#experience').prop('disabled', false);
			$('#disable-exper').text('No');
			var exp= $('#experience').val();
			if(exp=='')
			{
				$('#exper-error').html('<span style="color:#c4071d">Enter experience</span>');
			}

			}
    	});

    	$('#disable-age').click(function(){

    		var isAgeDisabled=$('#max_age').prop('disabled');

    		if(isAgeDisabled==false)
    		{

    		$('#max_age').prop('disabled', true);
			$('#disable-age').text('Yes');
			$('#age-error').html('');
    		}
    		else
    		{
    		$('#max_age').prop('disabled', false);
			$('#disable-age').text('No');
			$('#age-error').html('<span style="color:#c4071d">Enter maximum age</span>');
    		}
    	});

    	/* end of jquery */
	});

</script>
<script>
	var app=angular.module('jobsvalidation',[]);
	app.controller('jobsvalid',function($scope){
		$scope.checktitle=function()
		{
			$scope.titlecolor["border-color"] = "red";
		};
	});
</script>
<?php require_once('institute_footer.php');?>