<?php
require_once('functions.php');
require_once('institute_header.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
?>
<div class="container-fluid well" >
<div class="row" ng-app="myapp" ng-controller="BrijController">
	<div class="col-md-4">
		
	</div>
</div>
</div>
<script>
var myApp=angular.module("myapp",[]);
myApp.controller("BrijController", function($scope,$http) {
	
});
</script>
<?php require_once('institute_footer.php');?>