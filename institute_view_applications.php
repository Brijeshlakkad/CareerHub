<?php 
require_once('institute_header.php');
?>
<div class="w3-container" id="Container" style="margin-top:10px;margin-bottom:10px;">
	<div class="content" style="background-color:#188FBC;box-shadow: 5px 5px 5px #aaaaaa;">
        
        <div class="container-fluid"> <!--- contains header only -->

        <div class="row" style="text-align:center;margin-top:10px;">
        
        <div class="col-md-1">
        Limit:<input type="number" min="1" id="limit" value="10" class="form-control" />
        <br/>
        </div>
        <div class="col-md-2">
        Sort by:
        <select id="sortby" class="form-control">
            <option value="apply_datetime">Application date</option>
            <option value="job_id">Job id</option>
        </select>
        <br/>
        </div>
        <div class="col-md-2">
            Order by:<select id="orderby" class="form-control">
            <option value="asc">Ascending</option>
            <option value="desc" selected>Descending</option>
            </select>
            <br/>
        </div>
        <div class="col-md-2">
        Search for:<select id="searchfor"  class="form-control">
            <option value="all">(none)</option>
            <option value="job_id">Job id</option>
            <option value="candidate_id">Candidate id</option>
            <option value="candidate_rank">(>=) Candidate rank</option>
            </select>
        <br/>
        </div>

        <div class="col-md-3">
        <br/>
        <div class="input-group" id="searchcombo">
        <input type="number" id="search" min="1" placeholder="Search here" name="search" class="form-control" />
        <span class="input-group-btn"><button type="button" class="btn btn-danger" disabled><span class="glyphicon glyphicon-search"></span></button></span>
        </div>
        </div>

        <div class="col-md-1">
        <br/>
        <button class="btn btn-warning" id="filter">
          <span class="glyphicon glyphicon-filter"></span> Filter 
        </button>
        <br/>
        </div>

        </div> <!-- end row -->


        </div>
       
        </div>
         <div id="result">

        </div>
    </div>
        
</div>

<div class="please_wait_modal"></div>
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
</script>
<script>
	function get_candidate_profile(cand_id,job_id,app_id,status_bit){
	$("#result").hide().append("<form method='post' id='myForm_cand' action='institute_get_cand.php'><input type='hidden' name='cand_id' value='"+cand_id+"' /><input type='hidden' name='job_id' value='"+job_id+"' /><input type='hidden' name='app_id' value='"+app_id+"' /></form>");
	$("#myForm_cand").submit();
	}
     $(document).ready(function(){

        var limit=$('#limit').val();
        var sortby=$('#sortby').val();
        var orderby=$('#orderby').val();
        var searchfor=$('#searchfor').val();
        var search=$('#search').val();
        var currentpage=1;
        $.ajax({
                url:'institute_view_applications_data.php',
                
                type:'POST',
                data:{
                    'page':currentpage,
                    'limit': limit,
                    'sortby': sortby,
                    'orderby': orderby,
                    'searchfor':searchfor,
                    'search':search,
                    },
                success:function(result)
                {
                    $('#result').html(result);
                }
            });

        $("#filter").click(function(){
        $.fn.filters(1);
        });
        
        $.fn.filters=function(page)
        {
            currentpage=page;
            
            var limit=$('#limit').val();
            var sortby=$('#sortby').val();
            var orderby=$('#orderby').val();
            var searchfor=$('#searchfor').val();
            var search=$('#search').val();

            $.ajax({
                url:'institute_view_applications_data.php',
                
                type:'POST',
                data:{
                    'page':currentpage,
                    'limit': limit,
                    'sortby': sortby,
                    'orderby': orderby,
                    'searchfor':searchfor,
                    'search':search,
                    },
                success:function(result)
                {
                    $('#result').html(result);
                }
            });
         
        } //end filters
        

     });
</script>


<?php 
require_once('institute_footer.php');
?>