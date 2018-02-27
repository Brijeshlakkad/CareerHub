<!DOCTYPE html>
<html>
<head>
<script src="../js/jQuery.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/brij.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div> 
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
		    <li class="active"><a href="index.php" style="text-transform:uppercase;">Admin Login</a></li>
		    <li><a href="upload_event.php">Upload Event</a></li>
			<li><a href="show_all_events.php">Events</a></li>
			<li> <a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<center>
<div class="container padded">
<form name="i_form" method="post" enctype="multipart/form-data" action="submit_img.php">
<table cellpadding="10px" cellspacing="10px">
	<tr>
	<div class="form-group">
		<td><label for="a_image" class="control-label">Image of Event</label></td>
		<td><input class="form-control" type="file" id="file" name="image" /></td>
		<td><p id="a_img"></p></td>
	</tr>
	<tr>
	<div class="form-group">
		<td></td>
		<td><input class="form-control" type="button" id="uploadimage" value="Upload Pic" onclick="check()"/></td>
	</tr>
</table>
</form>
	
<div id="image_preview">
	<img id="previewing" src="../images/noimage.png" alt="no image" />
</div>
</div>
</center>
<script>
	function check()
	{
		var a = document.getElementById("a_img").innerHTML;
		if(a=="")
			document.i_form.submit();
	}
$(document).ready(function (e) {
$(function() {
$("#file").change(function() {
$("#a_img").empty();
var file = this.files[0];
var match= ["image/jpeg","image/png","image/jpg"];
if(!((file.type==match[0]) || (file.type==match[1]) || (file.type==match[2])))
{
$('#previewing').attr('src','../images/noimage.png');
$("#a_img").html("<p style='color:red;'>Please select a valid Image File <br> Only jpeg, jpg and png images type allowed </p>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '200px');
$('#previewing').attr('height', '180px');
};
});
</script>
</body>
</html>