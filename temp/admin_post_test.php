<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
?>
<div class="container-fluid well" id="show_here">
<div class="row" align="center" id="entry_panel">
	<label><h3>Add a Test</h3></label>
	<form ng-app="myapp" name="TestForm" ng-controller="BrijController" method="post" novalidate>
	<table class="myTable">
	<div class="form-group">
		<tr>
			<td><label for="t_title">Enter Title</label></td>
			<td><input type="text" class="form-control" ng-model="t_title" name="t_title" id="t_title" ng-style="onlyChar" ng-change="analyze1(t_title)" required title-dir/></td>
			<td>
				<span style="color:red" id="s_t_title" ng-show="TestForm.t_title.$dirty && TestForm.t_title.$invalid">
				<span ng-show="TestForm.t_title.$error.required">Title is required.</span>
				<span ng-show="!TestForm.t_title.$error.required && TestForm.t_title.$error.titlelengthvalid">Enter minimum 4 characters.</span>
				<span ng-show="!TestForm.t_title.$error.required && TestForm.t_title.$error.onlycharvalid">Only alphabets and numbers are allowed.</span>
				</span>
			</td>
		</tr>
	</div>
	<div class="form-group">
		<tr>
			<td><label for="t_course">Enter Course</label></td>
			<td><select class="form-control" name="t_course" id="t_course" ng-model="t_course" required>
				<option
				ng-repeat="x in t_courseOptions" 
				ng-value="x.val">{{x.name_c}}</option>
				</select>
			</td>
			<td>
				<span style="color:red" id="s_t_course" ng-show="TestForm.t_course.$dirty && TestForm.t_course.$invalid">
				<span ng-show="TestForm.t_course.$error.required">Course is required</span>
				</span>
			</td>
		</tr>
	</div>
	<div class="form-group">
		<tr>
			<td><label for="t_subjects">Enter Subjects</label></td>
			<td><input type="text" class="form-control" ng-model="t_subjects" name="t_subjects" id="t_subjects" ng-style="subjectStyle" ng-change="analyze2(t_subjects)" required/></td>
			<td>
				<a class="badge my_badge" data-toggle="tooltip" data-placement="top" title="Enter subject names seperated by | character">?</a>
				<span style="color:red" id="s_t_subjects" ng-show="TestForm.t_subjects.$dirty && TestForm.t_subjects.$invalid">
				<span ng-show="TestForm.t_subjects.$error.required">At least one subject is required</span>
				</span>
			</td>
		</tr>
	</div>
		<tr>
			<td><input type="submit" ng-click="submit_part1()" id="submit_btn" value="Submit" class="btn btn-primary" ng-disabled="TestForm.t_title.$invalid ||  TestForm.t_course.$invalid ||  TestForm.t_subjects.$invalid" /></td>
			<td id="status"</td>
			<td></td>
		</tr>

	</table>
	</form>
</div>
<div class="row" align="center" id="questions_panel">
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
<div class="modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip(); 
	$("#entry_panel").show();
	$("#questions_panel").hide();
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
});
	
	
	var myApp = angular.module("myapp",[]);
	myApp.controller("BrijController",function($scope,$http){
		$scope.t_courseOptions=[
		{val:"Information Technology",name_c:"Information Technology"},
		{val : "Computer Science", name_c : "Computer Science"},
		{val : "Mechanical Engineering", name_c : "Mechanical Engineering"},
		{val : "Civil Engineering", name_c : "Civil Engineering"}
		];
		var patt;
		$scope.onlyChar = {
			"border-width":"1.45px"
		};
		$scope.analyze1 = function(value) {
			if(/^[0-9a-zA-Z ]+$/.test(value) && value.length>3) {
				$scope.onlyChar["border-color"] = "green";
			}else {
				$scope.onlyChar["border-color"] = "red";
			}
		};
		$scope.subjectStyle = {
			"border-width":"1.45px"
		};
		$scope.analyze2 = function(value) {
			if(value.length>0) {
				$scope.subjectStyle["border-color"] = "green";
			}else {
				$scope.subjectStyle["border-color"] = "red";
			}
		};
		$scope.submit_part1=function()
		{
		var parid=$("div.brij").attr("id");
		var title=$("#t_title").val();
		var course=$scope.t_course;
		var subjects=$("#t_subjects").val();
		var x=new XMLHttpRequest();
		x.onreadystatechange=function(){
			
			if(x.readyState==4 && x.status==200)
			{
				var data=this.responseText;
				if(data!="-1")
				{
					$("#status").empty();
					$("#entry_panel").hide(1000);
					$("#questions_panel").show(1000);
				}
				else
					$("#status").html("<span style='color:red;'>Error! Try agian..</span>");
							
			}
		};
		x.open("POST","post_test_part1.php",true);
		x.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		x.send("title="+title+"&parid="+parid+"&course="+course+"&subjects="+subjects);
		}
	});
myApp.directive("titleDir",function(){
	return {
		require: 'ngModel',
		link: function(scope, element, attr, mCtrl) {
			function myValidation(value) 
			{
				var patt = new RegExp("^[0-9a-zA-Z ]+$");
				if(patt.test(value)) {
					mCtrl.$setValidity('onlycharvalid', true);
				}
				else {
					mCtrl.$setValidity('onlycharvalid', false);
				}
				if(value.length>3) {
					mCtrl.$setValidity('titlelengthvalid', true);
				}
				else {
					mCtrl.$setValidity('titlelengthvalid', false);
				}
				return value;
			}
			mCtrl.$parsers.push(myValidation);
		}
	};
});
	



</script>
</body>
</html>