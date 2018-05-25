<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
get_details_from_candidate();


$categoryvals="SELECT DISTINCT `category` FROM jobs";
$uniqcategories=mysqli_query($con,$categoryvals);

$rolevals="SELECT DISTINCT `role` FROM jobs";
$uniqroles=mysqli_query($con,$rolevals);

?>
<style>
.fixed-nav-bar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1;
    width: 100%;
    height: 50px;
    background-color: #FFFFFF;
}
#filter_inst
	{
		font-size: 15px; 
		font-family: Lucida Grande, Lucida Sans Unicode, Lucida Sans, DejaVu Sans, Verdana,' sans-serif';
		margin-top: 10px;
	}
</style>
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="css/suggestion-box.min.css"/>
<script src="js/suggestion-box.min.js"></script>

<div id="findwork">

<div class="w3-container">
	<section class="content" style="background-color:#f5f5f5;box-shadow: 5px 5px 5px #aaaaaa;">
    <div class="container-fluid">
    	
    	<div ng-app="myapp" ng-init="inputtype='text';searchfor='all'" ng-controller="BrijController">


        <div class="row result" style="background-color:DodgerBlue;padding-top:15px;">
        	
        	<div class="col-md-5">
	        	<div class="form-group col-md-4"><br/>
							<label for="job"> Job </label>
							<input type="checkbox" name="job-training" ng-model="job" id="job-training" value="job" />&nbsp;&nbsp; <label for="training">Training </label>
							<input type="checkbox" name="job-training" ng-model="training" id="job-training" value="training" />
							<p id="job_training_error"></p>
				</div>

		 		<div class="form-group col-md-8">
		 		<span>
			    <label for="amount">Salary range:</label>
				</span><div id="slider"></div>
				<p style="margin-top:5px;">Selected range:<span id="range"></span></p>
				   						        
				</div>

			</div>


			<div class="col-md-6">

				<div class="form-group col-md-3">
						<label for="Same as your skills"> Select skills:</label><br/>
						<input type="button" class="btn btn-default" data-toggle="modal" value="Select skills" data-target="#mySkills" id="select_skills" />
						<p id="skills_error"></p>
				</div>

        	
				<div class="col-md-3">
 					<label for="searchfortypes">Search for: </label>
 			        <select id="searchfor" style="max-width:100px;" ng-model="searchfor" class="form-control">
		        	<option value="all">All</option>
		        	<option value="category">Category</option>
		        	<option value="role">Role</option>
		        	<option value="location">Location</option>
		        	<option value="experience">Experience(years)</option>
		        	</select>	
		        
  				</div>

		      	<div class="col-md-5" style="top:5px;">
		      	<br/>


		        <div class="input-group" id="searchcombo">
		        <input type="{{inputtype}}" id="searchbox" placeholder="Search here" name="searchbox" class="form-control" />
		        <span class="input-group-btn"><button type="button" class="btn btn-danger" disabled><span class="glyphicon glyphicon-search"></span></button></span>
		        </div>



		        <div id="categories">
		        <select class="form-control" id="categoryval">    
		        <?php while ($row1=mysqli_fetch_array($uniqcategories)){?>
		          <option value="<?php echo $row1['category'];?>"><?php echo $row1['category'];?></option>
		        <?php } ?>
		        </select>
		        </div>
		            

		        <div id="roles">
		        <select class="form-control" id="roleval">    
		        <?php while ($row1=mysqli_fetch_array($uniqroles)){?>
		          <option value="<?php echo $row1['role'];?>"><?php echo $row1['role'];?></option>
		        <?php } ?>
		        </select>
		        </div>

		        <p id="searchfield-error"></p>


		        </div>

		        <div class="col-md-1" style="top:5px;">
		        <br/>
		        
		        <button class="btn btn-info" id="searchbtn">
		          <span class="glyphicon glyphicon-search"></span> Search 
		        </button>
		        <br/>
		        <br/>
		        </div>
			
		</div>
			
        </div>
     
       
        </div>

	</div>
	</section>
</div>
<div  id="result">
        
</div>


<div class="modal fade" id="mySkills" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Your added Skills</h4>
        </div>
        <div class="modal-body">
          <div ng-show="same_as_skills">
						<?php
							get_details_from_candidate();
							if($qualis[0]!='0')
							{
								?>
							<table class="myTable" id="allskillcheckboxes">
						<?php
								$len=count($qualis);
								for($i=1;$i<=$len;$i++)
								{
									?>
									<tr>
										<td><input type="checkbox" name="skills"  value="<?php echo $qualis[$i-1]; ?>" id="skill" /></td>
										<td><?php echo $qualis[$i-1]; ?></td>
									</tr>
									<?php
								}
							?>
							<tr id="appendtextbox">
							<td><input type="checkbox" id="selectotherskill" /></td>
							<td>Other</td>
							</tr>
							<tr id="textboxtoappend">
							</tr>

							</table>
							<?php
								}
							?>
			</div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" id="searchskills" onClick="save_change_skills()" data-dismiss="modal">Select Skills</button>
          <button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</div>

<div class="please_wait_modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
</script>
<script>
var currentpage=1;
var limit=2;
var initialst='yes';
	
function initialfilters(cur_page)
{
		var skillsarr='';
		var lowsalary=15000;
		var highsalary=500000;
		var searchfor='all';
		var search='';
		//alert(skillsarr+lowsalary+highsalary+cur_page+limit);
		$.ajax({
                url:'candidate_jobs_initial_data.php',
                type:'POST',
                data:{
                	'initial_state':'yes',
                    'page':cur_page,
                    'limit': limit,
                    'job_training':'both',
                    
                    'lowsalary':lowsalary,
                    'highsalary':highsalary,
                    'searchfor':searchfor,
                    'search':search,
                   	
                    },
                success:function(result)
                {  
                   $('#result').html(result);
                }
                });
	}


	 $(document).ready(function () {
	 	 
	 	$('#otherskill').hide();
	 	$("#selectotherskill").change(function() {
    	if(this.checked==true) {
        	$('#appendtextbox').append('<tr id="otherskillrow"><td><input type="text" name="otherskill" placeholder="Mention skill here" style="max-width:150px;" id="otherskill"/></td></tr>');
        	
   		}
   		else
   		{
   			$('#otherskillrow').remove();
   		}
		});	
	 	
	 	$('#categories').hide();
        $('#roles').hide();

       	
       	/*$.fn.initialfilters=function(cur_page)
    	{
    		alert('hello');
    	}*/
        $('#searchfor').on('change',function(){
            var searchfor=$('#searchfor').val();
            
            if(searchfor=='category'){

               $('#categories').show();
               $('#searchcombo').hide();
               $('#roles').hide();

            }
            else if(searchfor=='role'){

               $('#categories').hide();
               $('#searchcombo').hide();
               $('#roles').show();
          
            }
            else
            {
                $('#categories').hide();
                $('#roles').hide();
                $('#searchcombo').show();
             
            }
        });

      
	 	/* for range */
	 	$('#slider').slider({
 			range:true,
		    min: 5000,
		    max: 500000,
		    values:[15000,500000],
		    slide:function(event,ui){
		    	$('#range').html(ui.values[0]+' - '+ui.values[1]+' INR');
		    }
 		});
 		/* initiallly displays values from array */
 		$('#range').html($( "#slider" ).slider("values",0) + "-" + $("#slider").slider("values",1)+ " INR");


        var suggestionBox = $('#search_location').suggestionBox({
            url: 'inst_location.php',
            results: 5
        });


    });

	var skillsarr = [];
	$('#searchskills').click(function(){
		$.fn.checkskills();
	});	
	$('#close_modal').click(function(){
		skillsarr = [];
		
		/* it unchecks all the checkboxes which are in id="allskillcheckboxes" region */
		var $tblChkBox = $("#allskillcheckboxes input:checkbox");
		$($tblChkBox).prop('checked', false);
		/* unchecking ends */

		if(skillsarr.length==0)
	    {
	        	$('#skills_error').html('<span style="color:#c4071d;">Please Select skills.</span>');
	    }
	    else
	    {
	        	$('#skills_error').html('');
	    }
	});

	$.fn.checkskills=function(){
		skillsarr = [];
		$.each($("input[name='skills']:checked"), function(){
                skillsarr.push($(this).val());
            });
		skillsarr.join(", ");

		if(skillsarr.length==0)
	    {
	        	$('#skills_error').html('<span style="color:#c4071d;">Please Select skills.</span>');
	        	return false;
	    }
	    else
	    {
	        	$('#skills_error').html('');
	        	return true;
	    }
	}

    $("#searchbtn").click(function(){
        initialst='no';
        $.fn.filters(currentpage);
    });

    initialfilters(1);

    $.fn.filters=function(cur_page)
    {

        	var current_page_no=cur_page;
        	var flag=0;
        	var job_training = [];
            $.each($("input[name='job-training']:checked"), function(){
                job_training.push($(this).val());
 
            });
	        job_training.join(",");
	        
	        if(job_training=='')
	        {
	        	$('#job_training_error').html('<span style="color:#c4071d;">Please select job/training.</span>');
	        	flag=1;
	        }
	        else
	        {
	        	$('#job_training_error').html('');
	        }
	        var send_job_training='';
	        if(job_training.length==1)
	        {
	        	send_job_training=job_training[0];
	        }
	        else
	        {
	        	send_job_training='both';
	        }

	        var skillsflag=$.fn.checkskills();
	        if(skillsflag==false)
	        {
	        	flag=1;
	        }

	        var searchfor=$('#searchfor').val();

            var search='';
           
            if(searchfor=='all')
            {
            	search=$('#searchbox').val();

            }
            else if(searchfor=='location')
	        {
	            search=$('#searchbox').val();
	            if(search=='')
            	{
            		$('#searchfield-error').html('<span style="color:#c4071d;">Please enter some text.</span>');
            		flag=1;
            	}
	            
	        }
	        else if(searchfor=='experience')
	        {
	            search=$('#searchbox').val();
	            if(search=='')
            	{
            		$('#searchfield-error').html('<span style="color:#c4071d;">Please enter some text.</span>');
            		flag=1;
            	}
	        }

            else
            {

	            if(searchfor=='category'){
	               search=$('#categoryval').val();
	            	
	            }
	            else if(searchfor=='role')
	            {
	                search=$('#roleval').val();
	            }

        	}
        	//alert(currentpage);
            if(search!='')
        	{
        		$('#searchfield-error').html('');
        	}
        	
     		if(flag==0)
     		{

     			var lowsalary=$( "#slider" ).slider("values",0);
     			var highsalary=$( "#slider" ).slider("values",1);
     			//alert(currentpage+limit+send_job_training+skillsarr+searchfor+lowsalary+search+highsalary);
     			$.ajax({
                url:'candidate_jobs_find_data.php',
                type:'POST',
                data:{
                	'initial_state':'false',
                    'page':current_page_no,
                    'limit': limit,
                    'job_training':send_job_training,
                    'skills':JSON.stringify(skillsarr),
                    'lowsalary':lowsalary,
                    'highsalary':highsalary,
                    'searchfor':searchfor,
                    'search':search,
                   	
                    },
                success:function(result)
                {  
                   $('#result').html(result);
                }
                });
     		}

     	
    }



	/* angular part starts */
	var skillarr;

	var myApp = angular.module("myapp", []);

	myApp.controller("BrijController", function($scope,$http) {

		$scope.$watch('searchfor',function(){
       		if($scope.searchfor=="experience"){
       			$scope.inputtype="number";
       		}
       		else
       		{
       			$scope.inputtype="text";
       		}
        });


		$scope.catagoryOptions = [
				{val : "Job", name_c : "Job"},
				{val : "Training", name_c : "Training"}
			];

			
	});
	
	
</script>


<script src = "js/jquery-ui.js"></script>



</body>
</html>