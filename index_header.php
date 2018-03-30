<?php
$filename=basename($_SERVER['PHP_SELF']);
if($filename!="index.php")
{
include_once('candidate_details.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to CareerHub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/customcss2.css" rel="stylesheet">
	<link href="css/please_wait_3.css" rel="stylesheet">
	<link href="css/search.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<script src="js/angular.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/test_details.js"></script>
	<script src="js/history_and_inbox.js"></script>
	<script src="js/get_certificates.js"></script>
	<script type="text/javascript" src="js/admin_cand.js"></script>
	<script type="text/javascript" src="js/admin_inst.js"></script>
	<script type="text/javascript" src="js/bootstrap-show-password.min.js"></script>
	<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	
	<link href="css/jquery_countdown.css" rel="stylesheet">
	
	<link href = "css/jquery-ui.css" rel = "stylesheet">
    
</head>


<?php 
if($filename=="index.php")
{
	?>
	<body scroll="yes" style="overflow: hidden">
	<?php
}else
		{
	?>
	<body>
	<?php 	
			
		}
?>
<nav class="navbar navbar-default navbar-static-top navcust myBar">
<div class="container-fluid">	
		
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" style="margin-top:25px;float:right;background-color:black;" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>
        <span class="icon-bar" style="background-color:white;"></span>    
      </button>
		
    <a href="careerhub.php"><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-bottom: 5px; margin-top:5px;width:250px;height:60px;float:left;filter:drop-shadow(0px 0px 3px #ffffff);"/></a>

    </div>
	<?php
	global $set;
	if(isset($_SESSION['Userid']))
	{
		get_details_from_candidate();
		$set=$login_id;
	}
	else if(isset($_SESSION['BUserid']))
	{
		$set="";
	}
	else if((isset($_SESSION['Admin'])))
	{
		$set="-99";
	}
	?>
  
    <div class="collapse navbar-collapse brij" id="<?php echo $set; ?>">	
    	<ul class="nav navbar-nav navbar-right">
      	
       
       	<?php
       	if(isset($_SESSION['Userid']))
       	{
			
       		?>
       	<li>
			  <div class="box" style="padding-top: 10px;">
				  <div class="container-1">
					  <span class="icon"><i class="fa fa-search"></i></span>
					  <input type="search" id="search" placeholder="Search CareerHub" />
				  </div>
				</div>
       	</li>
       	
		<li><a href="candidate_profile.php" >Profile</a></li>
      	<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Work
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="candidate_findwork.php">Find Work!</a></li>
          <li><a href="candidate_certificate.php">Get Certified</a></li>
          <li><a href="candidate_collected_certificate.php">Your Certificates</a></li>
        </ul>
      	</li>
        <li><a href="candidate_inbox.php">Inbox <span class="badge" id="mess_show_total"></span></a></li>
       	
		<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="candidate_history.php">History &amp; Activity Log <span class="badge" id="hist_show_total"></span></a></li>
          <li><a href="candidate_edit.php">Edit Profile</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      	</li>
      	<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Help
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="careerhub_support.php">Get Support</a></li>
          <li><a href="careerhub_feedback.php">Feedback</a></li>
          <li><a href="careerhub.php">About Us</a></li>
        </ul>
      	</li>	
			<?php
		}
		
		else if(isset($_SESSION['Admin']))
       	{
       		?>
       	<li>
			  <div class="box" style="padding-top: 10px;">
				  <div class="container-1">
					  <span class="icon"><i class="fa fa-search"></i></span>
					  <input type="search" id="search" placeholder="Search CareerHub" />
				  </div>
				</div>
       	</li>
       	<li>&nbsp;&nbsp;&nbsp;</li>
       	<li><button class="btn btn-primary btn-sm navbar-btn" style="padding: 10px;" id="refresh">Refresh <span class="glyphicon glyphicon-refresh"></span></button></li>
       	<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Candidates
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a id="admin_all_cand">See all candidates</a></li>
          <li><a id="admin_wait_cand">Waiting candidates</a></li>
          <li><a id="admin_appr_cand">Approved candidates</a></li>
          <li><a id="admin_decl_cand">Declined candidates</a></li>
          <li><a id="admin_updated_cand">Updated candidates</a></li>
        </ul>
      	</li>
		
       	<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Institutes
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a id="admin_all_inst">See all institutes</a></li>
          <li><a id="admin_wait_inst">Waiting institutes</a></li>
          <li><a id="admin_appr_inst">Approved institutes</a></li>
          <li><a id="admin_decl_inst">Declined institutes</a></li>
          <li><a id="admin_updated_inst">Updated institutes</a></li>
        </ul>
      	</li>
       	<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Test Details
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="post_test.php">Post a Test!</a></li>
          <li><a href="see_tests.php">See all tests</a></li>
        </ul>
      	</li>
		<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin_history.php">History &amp; Activity Log</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      	</li>
			<?php
		}
		else
		{ 
			?>
			
			<li><a href="index.php">Home</a></li>
			<li><a href="">Find Work!</a></li>
			<li><a href="">Hire candidate!</a></li>
			<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Help
			<span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="careerhub_support.php">Get Support</a></li>
			  <li><a href="careerhub_feedback.php">Feedback</a></li>
			  <li><a href="careerhub.php">About Us</a></li>
			</ul>
			</li>
			<li><a href="candidate.php">Login/Signup</a></li>
			<?php
		  }
	     ?>
    	
    	</ul>
      </div>
</div>	
</nav>