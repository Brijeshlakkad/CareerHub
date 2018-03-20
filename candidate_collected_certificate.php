<?php
include_once('functions.php');
include_once("config.php");
include_once('index_header.php');
include_once('candidate_details.php');
check_session();
?>
<div class="container-fluid well">
	<div class="row">
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8 certficate_header" id="<?php echo $login_email; ?>">
			<h3>Collected Certificates <span class="badge" id="certificate_show_total"></span> :</h3>
			</div>
			<div class="col-lg-2">
				<button class="btn btn-primary"  id="certificate_refresh"><span class="glyphicon glyphicon-refresh"></span></button>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-offset-2 col-lg-8 col-lg-offset-2" id="your_certificates">
				<div id="certificate_output">
					
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>