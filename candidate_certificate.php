<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
get_details_from_candidate();
?>
<style>
.style_prevu_kit
{
    border:0;
    position: relative;
    -webkit-transition: all 50ms ease-in;
    -webkit-transform: scale(1); 
    -ms-transition: all 50ms ease-in;
    -ms-transform: scale(1); 
    -moz-transition: all 50ms ease-in;
    -moz-transform: scale(1);
    transition: all 50ms ease-in;
    transform: scale(1);   

}
.style_prevu_kit:hover
{
    box-shadow: 0px 0px 100px #000000;
    z-index: 2;
    -webkit-transition: all 50ms ease-in;
    -webkit-transform: scale(1.01);
    -ms-transition: all 50ms ease-in;
    -ms-transform: scale(1.01);   
    -moz-transition: all 50ms ease-in;
    -moz-transform: scale(1.01);
    transition: all 50ms ease-in;
    transform: scale(1.01);
}
</style>

<nav class="navbar navbar-default" ng-app="myapp" ng-controller="BrijController" >
  <div class="container-fluid">
    <div id="test_filter" class="row" style="padding-top: 10px;">
					<form name="myForm" id="myForm" method="post" novalidate>
						<div class="col-lg-3">
				  		</div>
						<div class="form-group col-lg-3">
						<label for="Same_as_your_skills"> </label>
						<input type="button" class="btn btn-default" data-toggle="modal" value="Select skills" data-target="#mySkills" id="select_skills" />
				 		</div>
				 		<div class="col-lg-3">
				  		</div>
					</form>
	</div>
  </div>
</nav>
<div class="modal fade" id="mySkills" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Skills <small>(for filteration)</small></h4>
        </div>
        <div class="modal-body">
         <h5><a href="candidate_add_quali.php">want to add skills?</a></h5>
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
							<tr>
								<td id="status_skills"></td>
								<td></td>
							</tr>
							</table>
							<?php
								}
							?>
			</div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" id="add_skills_to_filter">Add Skills</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="container-fluid well">
	<div class="row" id="filter_panel" style="margin:10px;padding: 50px;">
    <div class="row" align="center" style="margin-top: 80px;">
	<div id="no_found"><img src="Images/not-found2.png" width="100px" alt="no found" /></div>
	<br/>
	<div style="color:gray;">Please select your skills to proceed...</div>
	</div>
	</div>
</div>
<div class="please_wait_modal"></div>
<script>
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});

	var myApp = angular.module("myapp", []);
	myApp.controller("BrijController", function($scope,$http) {
	
	});
	$(document).ready(function(){
		
		var skillarr="random_tests";
		$("#add_skills_to_filter").click(function()
		{
			skillarr= $('input[name="skills[]"]').serialize();
			if(skillarr=="")
				{
					$("#status_skills").html("<span style='color:red;'>Select at least one skill from your special skills.</span>");
				}
			else
				{
					$("#status_skills").empty();
					$("#mySkills .close").click();
					update_filter_certificate(skillarr);
				}
		});
		var update_filter_certificate = function(skills){
			var candid="<?php echo $login_email; ?>";
			if(skills=="random_tests")
				{
					skills="random_tests="+candid;
					skills=skills.toString();
				}
			$.ajax({
				type: 'POST', 
				url: 'candidate_interface.py',
				data: skills+"&cand_id="+candid,
				success  : function (data)
				{
					if(data!=-1)
						{
							$("#filter_panel").html(data);
						}
					else
						$("#status_skills").html("<span style='color:red;'>Error! Try again..</span>");
				}
			});
		};
		update_filter_certificate("random_tests");
	});
</script>
</body>
</html>