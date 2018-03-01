<?php
require_once('functions.php');
require_once('index_header.php');
check_session();
?>
<div class="container-fluid padded">
    <div class="row">
        <div class="col-sm-8 blog">
            <section id="update_details">
            
			</section>
		</div>
        <div class="col-sm-4 sidebar well2">
            <section>
               <?php echo $_SESSION['Admin']; ?>
            </section>
            <section>
            	
            </section>
		</div>
	</div>
</div>
</body>
</html>