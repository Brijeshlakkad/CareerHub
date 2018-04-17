
<?php
require_once('institute_functions.php');
require_once('functions.php');
@session_start();
get_details_from_institute();

$limit=protect_anything($_POST['limit']);
$sortby=protect_anything($_POST['sortby']);
$orderby=protect_anything($_POST['orderby']);
$searchfor=protect_anything($_POST['searchfor']);
$search=protect_anything($_POST['search']);
$deljobid=protect_anything($_POST['deljobid']);

if (isset($_POST['page'])) { $page  = $_POST['page']; } else { $page=1; };
$start_from = ($page-1) * $limit;

if($deljobid!=0)
{
	$del_id=$deljobid;
	$deljobid=0;
	$delque="delete from jobs where institute_id='$institute_id' AND job_id='$del_id'";
	$exdelque=mysqli_query($con,$delque);
		
}


if($searchfor=='all' && $search!='') {

	/*
	$sql="SELECT * from jobs WHERE `institute_id`='$institute_id'";
	$sql_query=mysqli_query($con,$sql);
	$logicStr="";
	$count=mysqli_num_fields($sql_query);
	for($i=0 ; $i < mysqli_num_fields($sql_query) ; $i++){
	 if($i == ($count-1) )
	$logicStr=$logicStr." `".mysqli_fetch_field_direct($sql_query, $i)->name."` LIKE '%".$search."%' ";
	else
	$logicStr=$logicStr." `".mysqli_fetch_field_direct($sql_query, $i)->name."` LIKE '%".$search."%' OR ";
	}
	
    $sql="SELECT * from jobs WHERE institute_id='$institute_id' AND ".$logicStr;
	*/

	
	$q1="select * from jobs where institute_id='$institute_id' AND `job_id` like '%$search%'  OR `job/training` like '%$search%' OR `category` like '%$search%' OR `vacancy` like '%$search%'  OR `experience` like '%$search%'  OR `max_age` like '%$search%'  OR `opening_date` like '%$search%' OR 	`closing_date` like '%$search%' OR `expected_salary` like '%$search%'  OR `role` like '%$search%' OR `state` like '%$search%' OR `country` like '%$search%' OR `city` like '%$search%' OR `job_title` like '%$search%' OR `qualification` like '%$search%' OR `required_skills` like '%$search%' OR `posted` like '%$search%' OR `description` like '%$search%' OR `last_updated` like '%$search%' ORDER BY $sortby $orderby LIMIT $start_from,$limit";


	$ex1=mysqli_query($con,$q1);
	$allq1="select * from jobs where institute_id='$institute_id' AND 
	`job_id`='$search' OR  
	`job/training`='$search' OR
	`category`='$search' OR
	`vacancy`='$search' OR
	`experience`='$search' OR
	`max_age`='$search' OR
	`opening_date`='$search' OR
	`closing_date`='$search' OR
	`expected_salary`='$search' OR
	`role` like '%$search%' OR
	`state` like '%$search%' OR
	`country` like '%$search%' OR
	`city` like '%$search%' OR
	`job_title` like '%$search%' OR
	`qualification` like '%$search%' OR
	`required_skills` like '%$search%' OR
	`posted` like '%$search%' OR
	`description` like '%$search%'";
	$allex1=mysqli_query($con,$allq1);
	$total_records = mysqli_num_rows($allex1); 
	$total_pages = ceil($total_records / $limit);
}


else if($searchfor=='all' || $search=='')
{

$q1="select * from jobs where institute_id='$institute_id' ORDER BY $sortby $orderby LIMIT $start_from,$limit";
$ex1=mysqli_query($con,$q1);
$allq1="select * from jobs where institute_id='$institute_id'";
$allex1=mysqli_query($con,$allq1);
$total_records = mysqli_num_rows($allex1); 
$total_pages = ceil($total_records / $limit);
}


else if(($searchfor=='required_skills' || $searchfor=='posted' || $searchfor=='qualification' || $searchfor=='job_title' ||  $searchfor=='description') && $search!='')
{
	$q1="select * from jobs where institute_id='$institute_id' AND `$searchfor` like '%$search%' ORDER BY $sortby $orderby LIMIT $start_from,$limit";
	$ex1=mysqli_query($con,$q1);
	$allq1="select * from jobs where institute_id='$institute_id' AND `$searchfor` like '%$search%'";
	$allex1=mysqli_query($con,$allq1);
	$total_records = mysqli_num_rows($allex1); 
	$total_pages = ceil($total_records / $limit);
}

else
{

$q1="select * from jobs where institute_id='$institute_id' AND `$searchfor`='$search' ORDER BY $sortby $orderby LIMIT $start_from,$limit";
$ex1=mysqli_query($con,$q1);
$allq1="select * from jobs where institute_id='$institute_id' AND `$searchfor`='$search'";
$allex1=mysqli_query($con,$allq1);
$total_records = mysqli_num_rows($allex1); 
$total_pages = ceil($total_records / $limit);

}


?>
	<div class="table-responsive">  

	<table class="table table-bordered table-condensed" style="background-color:white">
		<tbody>
			<tr>
			<th>ID</th>
			<th>Type</th>
			<th>Job Title</th>
			<th>Category</th>
			<th>Role</th>
			<th>Vacancy</th>
			<th>Salary</th>
			<th>Qualifications</th>
			<th>Opening Date</th>
			<th>Closing date</th>
			<th>Experience</th>
			<th>Required Skills</th>
			<th>Country</th>
			<th>State</th>
			<th>City</th>
			<th>Maximum age</th>
			<th>Description</th>
			<th>Posted</th>
			<th>Last Updated</th>
			<th>Update</th>
			<th>Delete</th>
			</tr>

			<?php

			while($res1=mysqli_fetch_array($ex1))
			{ ?>
    		
				<tr>
				<td><?php echo $res1['job_id'];?></td>
				<td><?php echo $res1['job/training'];?> </td>  
	            <td><?php echo $res1['job_title'];?> </td>
	            <td><?php echo $res1['category'];?> </td>
	            <td><?php echo $res1['role'];?> </td>
	            <td><?php echo $res1['vacancy'];?> </td>
	            <td><?php echo $res1['expected_salary'];?> </td>
	            <td><?php echo $res1['qualification'];?> </td>
	            <td><?php echo $res1['opening_date'];?> </td>
	            <td><?php echo $res1['closing_date'];?> </td>
	            <td><?php echo $res1['experience'];?> </td>
	            <td><?php echo $res1['required_skills'];?></td>
	            <td><?php echo strtoupper($res1['country']);?> </td>
				<td><?php echo strtoupper($res1['state']);?> </td>
	            <td><?php echo strtoupper($res1['city']);?> </td>
	            <td><?php echo $res1['max_age'];?> </td>
	            <td><?php echo rtrim(mb_strimwidth($res1['description'] , 0, 50))."...";?> </td>
				<td><?php echo $res1['posted'];?> </td>
	            <td><?php echo $res1['last_updated'];?> </td>
	            <td><button type="button" class="update btn btn-success" id="<?php echo $res1['job_id'];?>">Update</button></td>
	            <td><button type="button" class="delete btn btn-danger" id="<?php echo $res1['job_id'];?>">Delete</button></td>
			</tr>
			
			<?php
			}
			?>
		</tbody>
		</table>

    </div>
    <?php 
    if($total_records==0)
	{
		echo '<br/><p style="color:red;text-align:center;font-size:25px;">No records found</p>';
	} 
	?>

        <div style="text-align:center;">
        <ul class="pagination">

        <?php if($page > 1) {?>
        <li><a id="previous" class="page" style="background-color:Tomato;color:black;"> Previous</a></li>
        <?php } ?>

        <?php
        for($i=1;$i<=$total_pages;++$i)
        {
            ?>
              <li id="<?php echo $i; ?>" class="page"><a style="color:Tomato;" id="pageno<?php echo $i; ?>"><?php echo $i; ?></a> </li>
            <?php
        }
        ?>

        <?php if($page < $total_pages) {?>
            <li><a id="next" class="page" style="background-color:Tomato;color:black;"> Next</a></li>
        <?php } ?>

            </ul>
        </div>



<script type="text/javascript">

$(document).ready(function(){

var cur_page_id=<?php echo $_POST['page']; ?>;

$('#pageno'+cur_page_id+'').css({'background-color':'DodgerBlue','color':'black'});

	$(".page").click(function(){
		var pageid=$(this).attr('id');
			if(pageid=='previous')
			{
				pageid=<?php echo ($page-1); ?>
			}
           
            if(pageid=='next')
            {
            	pageid=<?php echo ($page+1); ?>
            } 
             $.fn.filters(pageid);
        });
    

    $(".delete").click(function()
    {
    	var id=$(this).attr('id');
  		$.fn.deletejob(id,<?php echo $page; ?>);
    });

    $(".update").click(function(){
        var updid=$(this).attr('id');
  		$.ajax({
                url:'institute_jobs_update.php',
                
                type:'POST',
                data:{
                		'updateid':updid
                    },
                success:function(result)
                {
                    
                    $('#replace_by_update').html(result);
                }
                });
    });

});

</script>

