<?php
require_once('functions.php');
require_once('index_header.php');
check_session();
?>


<div class="container well" id="show_here">
<center>
	<h2>
		Welcome to Admin Panel
	</h2>
</center>
</div>
<div class="please_wait_modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
</script>
</body>
</html>