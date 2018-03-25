<?php
require_once('functions.php');
require_once('institute_header.php');
require_once('institute_functions.php');
check_session(); 
get_details_from_institute();
if($bits[0]==0)
{
	header("Location:institute_upload_img.php");
}
?>
<div class="w3-container">
	<section class="content" style="box-shadow: 5px 5px 5px #aaaaaa;">
        <div class="container-fluid well" >

        <div id="AllContent">
            <div style="height:80vh;">
            <div class="media">
				<div class="media-left">
				  <img class="img-circle" style="height:150px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
				<div class="media-body" style="line-height: 25px;">BRijesh</div>
           </div>
            </div>
        </div>
    </section>
</div>
<?php require_once('institute_footer.php');?>