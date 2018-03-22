<?php
require_once('functions.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CareerHub</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/institute_style.css">
  <link rel="stylesheet" href="css/customcss.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/angular.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/inst_history_and_inbox.js"></script>
  <style type="text/css">
    .w3-sidebar a{
    text-decoration: none;
    }
   
    
  </style>
 
</head>
<body>


<div class="w3-sidebar w3-red w3-bar-block w3-card w3-animate-left" style="display:none;" id="mySidebar">
  <button type="button" style="margin-right:0px;color:#000000;background-color:#D3CCCA;height:52px;" class="w3-bar-item w3-button w3-large"
  onclick="w3_close()">&times;</button>
  <a href="institute_profile.php" class="w3-bar-item w3-button">Institute Profile</a>
  <a href="institute_jobpost.php" class="w3-bar-item w3-button">Post new Job</a>
  <a href="institute_manage_jobs.php" class="w3-bar-item w3-button">Manage Jobs</a>
  <a href="#" class="w3-bar-item w3-button">View applications</a>
  <a href="#" class="w3-bar-item w3-button">Search Candidates</a>
  <a href="#" class="w3-bar-item w3-button">Track Profile Visits</a>
  <a href="institute_inbox.php" class="w3-bar-item w3-button">Inbox</a>
</div>

<div id="main">
<nav class="navbar navbar-default navbar-static-top navcust myBar">
<button id="openNav" class="w3-button w3-teal" onclick="w3_open()" style="float: left;height:42px;margin-top:2px;margin-left:0px;">&#9776;</button>
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" height="40px" style="margin-top:2px;margin-right:0px;">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      
       <a href="careerhub.php"><img src="Images/career-hub-logo.png" class="img-responsive" style="margin-bottom: 5px; margin-top:5px;width:200px;height:44px;float:left;filter:drop-shadow(0px 0px 3px #ffffff);"/></a>
   
    </div>
	  <div class="brij" id="<?php echo $institute_id; ?>"> </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li style="padding-top: 15px;
    padding-bottom: 15px;color:#9d9d9d;">&nbsp;&nbsp; Welcome, 
    <?php echo $institute_name; ?>!</li>
        <li></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="institute_profile.php">Home</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="logout.php">Sign Out</a></li>
        
      </ul>
    </div>
  </div>
</nav>



