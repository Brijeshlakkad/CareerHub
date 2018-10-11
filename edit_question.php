<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
check_session();
?>
<style>
input.ng-touched.ng-invalid {
	border-width: 1.45px;
    border-color: red;
}
input.ng-touched.ng-valid {
    border-width: 1.45px;
    border-color: green;
}
</style>
<div class="container well">
<div class="row login_block" id="questions_panel">
<div class="col-lg-2">
	<button class="btn btn-primary" onclick="javascript:history.back()"><span class="glyphicon glyphicon-arrow-left"></span> Back</button>
</div>
<?php
if(isset($_POST['que_id']))
{
	$queid=$_POST['que_id'];
	$sql="Select Question,A1,A2,A3,A4,Ans,Time from Questions where ID='$queid'";
	$result=mysqli_query($con,$sql);
	if($result)
	{
		$row=mysqli_fetch_array($result);
		$que=$row[0];
		$a1=$row[1];
		$a2=$row[2];
		$a3=$row[3];
		$a4=$row[4];
		$ans=$row[5];
		$time=$row[6];
			?>

<div class="col-lg-8" ng-app="myapp" ng-controller="BrijController">
	<form name="QueForm" method="post" id="QueForm" novalidate>
	<label><h3>Edit Question</h3></label>
	<table class="myTable">
			<div class="form-group">
			<tr>
				<td><label for="question">Question?</label></td>
				<td>
				<textarea class="form-control" ng-model="que" name="que" id="que" ng-style="queStyle" ng-change="que_analyze(que)" cols="300" rows="2" required placeholder="Enter a question" ></textarea></td>
				<td>
					<span style="color:red" id="s_que" ng-show="QueForm.que.$dirty && QueForm.que.$invalid">
					<span ng-show="QueForm.que.$error.required">Question is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq1">MCQ 1</label></td>
				<td>
				<input class="form-control" ng-model="mcq1" name="mcq1" id="mcq1" ng-style="mcq1Style" ng-change="mcq1_analyze(mcq1)" required placeholder="Enter mcq1" /></td>
				<td>
					<span style="color:red" id="s_mcq1" ng-show="QueForm.mcq1.$dirty && QueForm.mcq1.$invalid">
					<span ng-show="QueForm.mcq1.$error.required">mcq1 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq2">MCQ 2</label></td>
				<td>
				<input class="form-control" ng-model="mcq2" name="mcq2" id="mcq2" ng-style="mcq2Style" ng-change="mcq2_analyze(mcq2)" required placeholder="Enter mcq2" /></td>
				<td>
					<span style="color:red" id="s_mcq2" ng-show="QueForm.mcq2.$dirty && QueForm.mcq2.$invalid">
					<span ng-show="QueForm.mcq2.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq3">MCQ 3</label></td>
				<td>
				<input class="form-control" ng-model="mcq3" name="mcq3" id="mcq3" ng-style="mcq3Style" ng-change="mcq3_analyze(mcq3)" required placeholder="Enter mcq3" /></td>
				<td>
					<span style="color:red" id="s_mcq3" ng-show="QueForm.mcq3.$dirty && QueForm.mcq3.$invalid">
					<span ng-show="QueForm.mcq3.$error.required">mcq3 is required</span>
					</span>
				</td>
			</tr>
			</div>

			<div class="form-group">
			<tr>
				<td><label for="mcq4">MCQ 4</label></td>
				<td>
				<input class="form-control" ng-model="mcq4" name="mcq4" id="mcq4" ng-style="mcq4Style" ng-change="mcq4_analyze(mcq4)" required placeholder="Enter mcq4" /></td>
				<td>
					<span style="color:red" id="s_mcq4" ng-show="QueForm.mcq4.$dirty && QueForm.mcq4.$invalid">
					<span ng-show="QueForm.mcq4.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="ans">Answer</label></td>
				<td>
				<select class="form-control" ng-model="ans" name="ans" id="ans" required>
				<option
				ng-repeat="x in ansOptions"
				ng-value="x.val">{{x.name_c}}</option>
				</select></td>
				<td>
					<span style="color:red" id="s_ans" ng-show="QueForm.ans.$dirty && QueForm.ans.$invalid">
					<span ng-show="QueForm.ans.$error.required">answer is required</span>
					</span>
				</td>
			</tr>
			</div>
			<tr>
			<td id="status_que"></td>
			<td></td>
			<td></td>
			</tr>
			<tr>
			<td></td>
			<td><input type="submit" ng-click="update_question()" id="update_que" value="Update question" class="btn btn-success" ng-disabled="QueForm.que.$invalid ||  QueForm.mcq1.$invalid ||  QueForm.mcq2.$invalid ||  QueForm.mcq3.$invalid ||  QueForm.mcq4.$invalid ||  QueForm.ans.$invalid" /></td>
			<td></td>
			</tr>

	</table>
	</form>
</div>
<div class="col-lg-2">
</div>

<script>
var myApp = angular.module("myapp",[]);
	myApp.controller("BrijController",function($scope,$http){
		$scope.ansOptions=[
		{val : "1",name_c:"MCQ1"},
		{val : "2", name_c : "MCQ2"},
		{val : "3", name_c : "MCQ3"},
		{val : "4", name_c : "MCQ4"}
		];
		$scope.que="<?php echo $que; ?>";
		$scope.mcq1="<?php echo $a1; ?>";
		$scope.mcq2="<?php echo $a2; ?>";
		$scope.mcq3="<?php echo $a3; ?>";
		$scope.mcq4="<?php echo $a4; ?>";
		$scope.ans="<?php echo $ans; ?>";
		var patt;
		$scope.queStyle = {
			"border-width":"1.45px"
		};
		$scope.que_analyze = function(value) {
			if(value.length===0 || typeof $scope.que === 'undefined') {
				$scope.queStyle["border-color"] = "red";
			}else {
				$scope.queStyle["border-color"] = "green";
			}
		};
		$scope.update_question=function(){
			var question=$("#que").val();
			var mcq1=$("#mcq1").val();
			var mcq2=$("#mcq2").val();
			var mcq3=$("#mcq3").val();
			var mcq4=$("#mcq4").val();
			var ans=$scope.ans;
			var queid="<?php echo $queid; ?>";
			$.ajax({
				type: 'POST',
				url: 'submit_test_and_questions.py',
				data: 'que_id='+queid+'&update_que='+question+'&mcq1='+mcq1+'&mcq2='+mcq2+'&mcq3='+mcq3+'&mcq4='+mcq4+'&ans='+ans,
				success  : function (data)
				{
					if(data==1)
						{
							$("#status_que").html("<span style='color:green;'>Question updated...</span>");
						}
					else
						$("#status_que").html("<span style='color:red;'>Error! Try agian..</span>");
				}
			});

		};
	});
</script>
<?php
	}
}
else if(isset($_POST['test_id']))
{
	$testid=$_POST['test_id'];
	?>


<div class="col-lg-8" ng-app="myapp2" ng-controller="BrijController">
	<form name="QueForm" method="post" id="QueForm" novalidate>
	<label><h3>Add Question</h3></label>
	<table class="myTable">
			<div class="form-group">
			<tr>
				<td><label for="question">Question?</label></td>
				<td>
				<textarea class="form-control" ng-model="que" name="que" id="que" ng-style="queStyle" ng-change="que_analyze(que)" cols="300" rows="2" required placeholder="Enter a question" ></textarea></td>
				<td>
					<span style="color:red" id="s_que" ng-show="QueForm.que.$dirty && QueForm.que.$invalid">
					<span ng-show="QueForm.que.$error.required">Question is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq1">MCQ 1</label></td>
				<td>
				<input class="form-control" ng-model="mcq1" name="mcq1" id="mcq1" ng-style="mcq1Style" ng-change="mcq1_analyze(mcq1)" required placeholder="Enter mcq1" /></td>
				<td>
					<span style="color:red" id="s_mcq1" ng-show="QueForm.mcq1.$dirty && QueForm.mcq1.$invalid">
					<span ng-show="QueForm.mcq1.$error.required">mcq1 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq2">MCQ 2</label></td>
				<td>
				<input class="form-control" ng-model="mcq2" name="mcq2" id="mcq2" ng-style="mcq2Style" ng-change="mcq2_analyze(mcq2)" required placeholder="Enter mcq2" /></td>
				<td>
					<span style="color:red" id="s_mcq2" ng-show="QueForm.mcq2.$dirty && QueForm.mcq2.$invalid">
					<span ng-show="QueForm.mcq2.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq3">MCQ 3</label></td>
				<td>
				<input class="form-control" ng-model="mcq3" name="mcq3" id="mcq3" ng-style="mcq3Style" ng-change="mcq3_analyze(mcq3)" required placeholder="Enter mcq3" /></td>
				<td>
					<span style="color:red" id="s_mcq3" ng-show="QueForm.mcq3.$dirty && QueForm.mcq3.$invalid">
					<span ng-show="QueForm.mcq3.$error.required">mcq3 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="mcq4">MCQ 4</label></td>
				<td>
				<input class="form-control" ng-model="mcq4" name="mcq4" id="mcq4" ng-style="mcq4Style" ng-change="mcq4_analyze(mcq4)" required placeholder="Enter mcq4" /></td>
				<td>
					<span style="color:red" id="s_mcq4" ng-show="QueForm.mcq4.$dirty && QueForm.mcq4.$invalid">
					<span ng-show="QueForm.mcq4.$error.required">mcq2 is required</span>
					</span>
				</td>
			</tr>
			</div>
			<div class="form-group">
			<tr>
				<td><label for="ans">Answer</label></td>
				<td>
				<select class="form-control" ng-model="ans" name="ans" id="ans" required>
				<option
				ng-repeat="x in ansOptions"
				ng-value="x.val">{{x.name_c}}</option>
				</select></td>
				<td>
					<span style="color:red" id="s_ans" ng-show="QueForm.ans.$dirty && QueForm.ans.$invalid">
					<span ng-show="QueForm.ans.$error.required">answer is required</span>
					</span>
				</td>
			</tr>
			</div>
			<tr>
			<td id="status_que"></td>
			<td></td>
			<td></td>
			</tr>
			<tr>
			<td></td>
			<td><input type="submit" ng-click="add_next()" id="add_next" value="Add another question" class="btn btn-primary" ng-disabled="QueForm.que.$invalid ||  QueForm.mcq1.$invalid ||  QueForm.mcq2.$invalid ||  QueForm.mcq3.$invalid ||  QueForm.mcq4.$invalid ||  QueForm.ans.$invalid" /></td>
			<td></td>
			</tr>

	</table>
	</form>
</div>
<div class="col-lg-2">
</div>

<script>
var myApp = angular.module("myapp2",[]);
	myApp.controller("BrijController",function($scope,$http){
		$scope.ansOptions=[
		{val : "1",name_c:"MCQ1"},
		{val : "2", name_c : "MCQ2"},
		{val : "3", name_c : "MCQ3"},
		{val : "4", name_c : "MCQ4"}
		];
		$scope.queStyle = {
			"border-width":"1.45px"
		};
		$scope.que_analyze = function(value) {
			if(value.length===0 || typeof $scope.que === 'undefined') {
				$scope.queStyle["border-color"] = "red";
			}else {
				$scope.queStyle["border-color"] = "green";
			}
		};
		$scope.add_next=function(){
			var question=$("#que").val();
			var mcq1=$("#mcq1").val();
			var mcq2=$("#mcq2").val();
			var mcq3=$("#mcq3").val();
			var mcq4=$("#mcq4").val();
			var ans=$scope.ans;
			var testid="<?php echo $testid; ?>";
			$.ajax({
				type: 'POST',
				url: 'submit_test_and_questions.py',
				data: 'testid='+testid+'&add_que='+question+'&mcq1='+mcq1+'&mcq2='+mcq2+'&mcq3='+mcq3+'&mcq4='+mcq4+'&ans='+ans,
				success  : function (data)
				{
					if(data==1)
						{
							$("#QueForm")[0].reset();
							$("#status_que").empty();
							$("#entry_panel").hide();
							$("#questions_panel").show();
							$scope.QueForm.$setPristine();
							$("#status_que").html("<span style='color:green;'>Question added</span>");
						}
					else
						$("#status_que").html("<span style='color:red;'>Error! Try agian..</span>");
				}
			});

		};

	});
</script>
	<?php
}
?>

</div>
</div>
</body>
</html>
