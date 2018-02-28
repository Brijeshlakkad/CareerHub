<?php
require_once('index_header.php');
if(isset($_SESSION['Userid']))
{
	header("Location:candidate_profile.php");
}
else if(isset($_SESSION['BUserid']))
{
	header("Location:institute_profile.php");
}
?>
<!-- for background image and two buttons -->

	<div class="jumbotron well blurclass" style="padding:0px;height:700px;width:100%;">
		
	</div>
	<div align="center" style="margin:400px;">
			<button type="button"  class="btn btn-info btn-lg mybtn1" onclick="window.location='institute.php';">I want to hire!
			</button>
			<button type="button" style="margin-top:5px;" class="btn btn-info btn-lg mybtn2" onclick="window.location='candidate.php';">I want to work!
			</button>
	</div>
</body>
</html>