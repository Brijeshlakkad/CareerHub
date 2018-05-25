<?php 
require_once('institute_header.php');
require_once('institute_functions.php');

$categoryvals="SELECT DISTINCT `category` FROM jobs";
$uniqcategories=mysqli_query($con,$categoryvals);

$rolevals="SELECT DISTINCT `role` FROM jobs";
$uniqroles=mysqli_query($con,$rolevals);
?>

<div class="w3-container" style="margin-top: 25px; ">
	<section class="content" style="background-color:#f5f5f5;box-shadow: 5px 5px 5px #aaaaaa;">
    <div class="container-fluid" id="replace_by_update">
    	<div ng-app="mySearch" ng-init="inputtype='text';sortby='posted';orderby='desc';searchfor='all'" ng-controller="searchCtrl">


        <div class="row" style="background-color:#F1765B;">
        <div class="col-md-1">
        Limit:<input type="number" min="1" id="limit" value="10" class="form-control" />
        </div>
        <div class="col-md-2">
        Sort by:<select id="sortby" ng-model="sortby" class="form-control">
        	<option value="job_id">ID</option>
            <option value="posted">Posting date</option>
        	<option value="opening_date">Opening Date</option>
        	<option value="closing_date">Closing Date</option>
        	<option value="expected_salary">Salary</option>
        	<option value="vacancy">Vacancy</option>
        </select>
        <br/>
        </div>

        <div class="col-md-2">
        	Order by:<select id="orderby" ng-model="orderby" class="form-control">
        	<option value="asc">Ascending</option>
        	<option value="desc">Descending</option>
        	</select>
        	<br/>
        </div>
        
        <div class="col-md-2">
        Search for:<select id="searchfor" ng-model="searchfor" class="form-control">
        	<option value="all">All</option>
        	<option value="job_id">ID</option>
        	<option value="job/training">Job/Training</option>
        	<option value="category">Category</option>
        	<option value="role">Role</option>
        	<option value="required_skills">Skill</option>
        	<option value="opening_date">Opening Date</option>
        	<option value="closing_date">Closing Date</option>
        	<option value="posted">Posting Date</option>
        	<option value="expected_salary">Salary</option>
        	<option value="qualification">Qualification</option>
        	<option value="job_title">Job Title</option>
        	<option value="vacancy">Vacancy</option>
        	<option value="country">Country</option>
        	<option value="state">State</option>
        	<option value="city">City</option>
        	<option value="max_age">Age</option>
        	<option value="experience">Experience</option>
        	<option value="description">Description</option>
        	</select>
        <br/>
    	</div>
      	
      	<div class="col-md-3">
      	<br/>

        
        <div class="input-group" id="searchcombo">
        <input type="{{inputtype}}" id="search" placeholder="Search here" name="search" class="form-control" />
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

        <div id="types">
                <label class="radio-inline">
                <input type="radio" name="jobtraining" value="job" checked="checked" /> Job
                </label>
                <label class="radio-inline">
                <input type="radio" name="jobtraining" value="training"/> Training
                </label>
        </div>

        <br/>
        </div>
        
        <div class="col-md-1">
        <br/>
        <button class="btn btn-info" id="filter">
          <span class="glyphicon glyphicon-filter"></span> Filter 
        </button>
        <br/>
        </div>

        </div>
        <br/>

        <div  id="result">

                
		</div>

        
        </div>

	</div>
	</section>
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
       


		var app=angular.module('mySearch',[]);
		app.controller("searchCtrl", function($scope) {
		$scope.searchfor='';
    	$scope.$watch('searchfor',function(){
    		if($scope.searchfor=="job/training"||$scope.searchfor=="category"||$scope.searchfor=="role" || $scope.searchfor=="required_skills" || $scope.searchfor=="qualification"||$scope.searchfor=="job_title" || $scope.searchfor=="country" || $scope.searchfor=="state" || $scope.searchfor=="city" || $scope.searchfor=="all" || $scope.searchfor=="description" )
    		{
    			$scope.inputtype="text";
    		}
    		else if($scope.searchfor=="opening_date" || $scope.searchfor=="closing_date" || $scope.searchfor=="posted")
    		{
    			$scope.inputtype="date";
    		}
    		else if($scope.searchfor=="job_id"||$scope.searchfor=="expected_salary"||$scope.searchfor=="vacancy"||$scope.searchfor=="max_age"||$scope.searchfor=="experience")
    		{
    			$scope.inputtype="number";
    		}

    	});
    	
		});

	$(document).ready(function(){

        $('#categories').hide();
        $('#roles').hide();
        $('#types').hide();

        var limit=$('#limit').val();
        var sortby=$('#sortby').val();
        var orderby=$('#orderby').val();
        var searchfor=$('#searchfor').val();
        var search=$('#search').val();
        var currentpage=1;
        var deljobid=0;

        $("#filter").click(function(){
        $.fn.filters(1);
        });

        /* document on load showing data */
          $.ajax({
                url:'institute_jobs_data.php',
                
                type:'POST',
                data:{
                    'page':currentpage,
                    'limit': limit,
                    'sortby': sortby,
                    'orderby': orderby,
                    'searchfor':searchfor,
                    'search':search,
                    'deljobid':deljobid
                    },
                success:function(result)
                {
                    deljobid=0;
                    $('#result').html(result);
                }
                });

          /* document onload showing data ends */



        $('#searchfor').on('change',function(){
            var searchfor=$('#searchfor').val();
            
            if(searchfor=='category'){

               $('#categories').show();
               $('#searchcombo').hide();
               $('#roles').hide();
               $('#types').hide();
            }
            else if(searchfor=='role'){

               $('#categories').hide();
               $('#searchcombo').hide();
               $('#roles').show();
               $('#types').hide();
            }
            else if(searchfor=='job/training')
            {
               $('#categories').hide();
               $('#searchcombo').hide();
               $('#roles').hide();
               $('#types').show();
            }
            else
            {
                $('#categories').hide();
                $('#roles').hide();
                $('#searchcombo').show();
                $('#types').hide();
            }
        });
       
        $.fn.deletejob=function(delid, page)
        {
            deljobid=delid;
          
            $.fn.filters(page);
        }

        $.fn.filters=function(page)
        {
            currentpage=page;
            
            var limit=$('#limit').val();
            var sortby=$('#sortby').val();
            var orderby=$('#orderby').val();
            var searchfor=$('#searchfor').val();
            var search=$('#search').val();
            if(searchfor=='category'){
                search=$('#categoryval').val();
            }
            else if(searchfor=='role')
            {
                search=$('#roleval').val();
            }
            else if(searchfor=='job/training')
            {
                search=$('input[name=jobtraining]:checked').val();

            }
           
            
            //alert(limit+sortby+orderby+searchfor+search);
            
            $.ajax({
                url:'institute_jobs_data.php',
                
                type:'POST',
                data:{

                    'page':currentpage,
                    'limit': limit,
                    'sortby': sortby,
                    'orderby': orderby,
                    'searchfor':searchfor,
                    'search':search,
                    'deljobid':deljobid
                    },
                success:function(result)
                {
                    deljobid=0;
                    $('#result').html(result);
                }
                });
         
        }
        

	});
</script>
<?php 
require_once('institute_footer.php');
?>

