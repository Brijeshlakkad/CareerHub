<?php
require_once('index_header.php');
require_once('functions.php');
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
                <h3 class="tpad">Search</h3>
                <div class="input-group input-group-lg tpad">
                    <span class="input-group-addon glyphicon glyphicon-search"></span>
                   <form onsubmit="search_form_submit()" name="search_form" method="post"> <input type="text" class="form-control input-lg" onKeyUp="search(this.value)" name="searchField" placeholder="Search"><input type="submit" value="" onsubmit="search_form_submit()" hidden/></form>
                   <span class="input-group-btn">
                        <input class="btn btn-default" type="button" value="Go!" onClick="search_form_submit()">
                    </span>
                </div>
                <p class="table table-condensed" id="found"></p>
                <hr>
            </section>
		</div>
	</div>
</div>
</body>
</html>