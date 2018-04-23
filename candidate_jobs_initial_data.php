<?php
include_once('functions.php');
include_once("config.php");

include_once('candidate_details.php');
check_session();
get_details_from_candidate();
//echo $_POST['page'].' '.$_POST['limit'].' '.$_POST['job_training'].' '.$_POST['lowsalary'].' '.$_POST['highsalary'].' '.$_POST['searchfor'].' '.$_POST['search'];
$initial=protect_anything($_POST['initial_state']);
$limit=protect_anything($_POST['limit']);
$job_training=protect_anything($_POST['job_training']);
$lowsalary=protect_anything($_POST['lowsalary']);
$highsalary=protect_anything($_POST['highsalary']);
$searchfor=protect_anything($_POST['searchfor']);
$search=protect_anything($_POST['search']);
//$skills=json_decode($_POST['skills']);

if (isset($_POST['page'])) { $page  = $_POST['page']; } else { $page=1; };
$start_from = ($page-1) * $limit;

if($initial=='yes')
{
	$q1="SELECT jobs.*, institutes.Bname from jobs JOIN institutes ON jobs.institute_id=institutes.ID WHERE (`expected_salary`>='$lowsalary' AND `expected_salary`<='$highsalary') order by jobs.job_impressions DESC LIMIT $start_from,$limit ";

	
	$allex1="SELECT jobs.*, institutes.Bname from jobs JOIN institutes ON jobs.institute_id=institutes.ID WHERE (`expected_salary`>='$lowsalary' AND `expected_salary`<='$highsalary')";
}
$ex1=mysqli_query($con,$q1);
$total=mysqli_num_rows($ex1);
$allex1=mysqli_query($con,$allex1);
$total_records = mysqli_num_rows($allex1); 
$total_pages = ceil($total_records / $limit);


while($res1=mysqli_fetch_array($ex1)) {
?>

<div class="container" style="margin-top:20px;background-color:white;border-left:3px solid Tomato;border-top:2px solid Tomato;box-shadow: 5px 5px 5px #aaaaaa;">

<p style="font-size:19px;color:hsl(0, 0%, 24%);margin-top:5px;"><b><?php echo $res1['job_title'];?></b></p><p>
<?php echo $res1['Bname'];?></p>
<p><span class="glyphicon glyphicon-briefcase"></span> <?php if($res1['experience']>0){
	echo $res1['experience']." Years"; } else { echo "Not required";} ?> &nbsp; <span class="glyphicon glyphicon-map-marker"></span> <?php echo strtoupper($res1['city'])." ".strtoupper($res1['state'])." ".strtoupper($res1['country']); ?> </p>
<br/>


<div class="row" style="padding-left:10px;">
<div class="col-md-1" style="padding-left:0px;"><span>Job/Training:</span></div> 
<div class="col-md-11" style="padding-left:0px;"><span><?php echo strtoupper($res1['job/training']); ?></span><br/></div>
</div>
<div class="row" style="padding-left:10px;margin-top:5px;">
<div class="col-md-1" style="padding-left:0px;"><span>Role:</span></div> 
<div class="col-md-11" style="padding-left:0px;"><span><?php echo strtoupper($res1['role']); ?></span><br/></div>
</div>
<div class="row" style="padding-left:10px;margin-top:5px;">
<div class="col-md-1" style="padding-left:0px;"><span>Key skills:</span></div> 
<div class="col-md-11" style="padding-left:0px;"><span><?php echo strtoupper($res1['required_skills']); ?></span><br/></div>
</div>
<div class="row" style="padding-left:10px;margin-top:5px;">
<div class="col-md-1" style="padding-left:0px;"><span>Description:</span></div> 
<div class="col-md-11" style="padding-left:0px;"><span>
<?php echo rtrim(mb_strimwidth($res1['description'] , 0, 150))."...";?>
 </span><br/></div>
</div>
<br/>
<div class="row" style="background-color:Tomato;min-height:40px;color:white;">
	<div class="col-md-3">
		
		<span style="vertical-align:middle;line-height: 50px;">Salary:</span> <span>  &#8377; <?php echo " ".$res1['expected_salary']." (P.M. in INR)" ?> </span>
		
	</div>
	<div class="col-md-6">
	</div>
	<div class="col-md-2" style="vertical-align:middle;line-height: 50px;">
	<span>Posted on:</span>
	<span><?php echo date('Y-m-d',strtotime($res1['posted']));?></span>
	</div>
	<div class="col-md-1" style="vertical-align:middle;line-height: 50px;">
	<button id="<?php echo $res1['job_id'];?>" class="btn btn-primary view" style="width:80px;">View</button>
	</div>
</div>


</div>


<?php
}		
?> 


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
// do not write $(document).ready(function){} here, otherwise script won't run

	var cur_page_id=<?php echo $_POST['page']; ?>;
	$('#pageno'+cur_page_id+'').css({'background-color':'DodgerBlue','color':'black'});

	$('.page').click(function(){
		var pageid=$(this).attr('id');
			if(pageid=='previous')
			{
				pageid=<?php echo ($page-1); ?>
			}
           
            if(pageid=='next')
            {
            	pageid=<?php echo ($page+1); ?>
            } 

            
				initialfilters(pageid);
        });

	
 	$(".view").click(function(){
    	var viewid=$(this).attr('id');
    	$.ajax({
    		url:'candidate_view_full_job.php',
    		type:'POST',
    		data: {
    			'jobid':viewid
    		},
    		success:function(result){
    			$('#result').html(result);
    		}
    	});
    });
</script>
