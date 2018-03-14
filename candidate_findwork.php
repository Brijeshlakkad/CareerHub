<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
get_details_from_candidate();
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
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Filter :</a>
    <a class="navbar-brand" href="#"><span class="fa fa-filter" aria-hidden="true"></span></a>
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <div id="filter_inst" class="row">
        	  <form name="myForm" id="myForm"  ng-app="myapp" ng-controller="BrijController" method="post" novalidate>
						<div class="form-group col-lg-3">
						<label for="job">Job </label>
						<input type="checkbox" name="job-training" ng-model="job" id="job-training" /><br/>
						<label for="training">Training </label>
						<input type="checkbox" name="job-training" ng-model="training" id="job-training" />
				 		</div>
				 		<div class="form-group col-lg-3">
				 		<span>
						  <label for="amount">Salary range:</label>
						  <input type="text" id="amount" readonly ng-model="salary" style="border:0; color:#119C48; font-weight:bold;">
						</span>

						<div id="slider-range"></div>
       					</div>
       					<div class="form-group col-lg-3">
						<label for="Experience/Intership">Experience/Intership </label>
						<input type="checkbox" name="Experienceintership" ng-model="Experienceintership" id="Experienceintership" />
						<label for="Same as your skills"> </label>
						<input type="button" class="btn btn-default" data-toggle="modal" value="Select skills" data-target="#mySkills" id="select_skills" />
				 		</div>
				 		<div class="form-group col-lg-3" >
						<p><label for="search">Search: </label>
   						 <input type="text" id="search_location" ng-model="search_location" name="search_location"></p>
				  </div>
       		</form>
        </div>
      </ul>
    </div>

  </div>
</nav>
<div class="modal fade" id="mySkills" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Skills</h4>
        </div>
        <div class="modal-body">
          <div ng-show="same_as_skills">
						<?php
							get_details_from_candidate();
							if($qualis[0]!='0')
							{
								?>
							<table class="myTable">
						<?php
								$len=count($qualis);
								for($i=1;$i<=$len;$i++)
								{
									?>
									<tr>
										<td><input type="checkbox" name="skills[]"  value="<?php echo $qualis[$i-1]; ?>" id="skill" /></td>
										<td><?php echo $qualis[$i-1]; ?></td>
									</tr>
									<?php
								}
							?>
							</table>
							<?php
								}
							?>
			</div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" onClick="save_change_skills()" data-dismiss="modal">Add Skills</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
        
        </div>
        <div class="col-lg-8">
        	  
        </div>
	</div>
</div>
<script>
	 $(document).ready(function () {
        var suggestionBox = $('#search_location').suggestionBox({
            url: 'inst_location.php',
            results: 5
        });
    });
	var skillarr;
	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
		$scope.catagoryOptions = [
				{val : "Job", name_c : "Job"},
				{val : "Training", name_c : "Training"}
			];
		$scope.salary="" + $( "#slider-range" ).slider( "values", 0 ) +" - " + $( "#slider-range" ).slider( "values", 1 )+" INR";
	});
		function save_change_skills()
		{
			skillarr= $('input[name="skills[]"]').serialize();
		}
	 $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 5000,
      max: 500000,
      values: [ 10000, 30000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ]+" INR" );
      }
    });
    $( "#amount" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +" - " + $( "#slider-range" ).slider( "values", 1 )+" INR");
  } );
</script>
</body>
</html>