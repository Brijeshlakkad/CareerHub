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
if (isset($_POST['page'])) { $page  = $_POST['page']; } else { $page=1; };
$start_from = ($page-1) * $limit;


if($searchfor=='all' || $search=='')
{

$q1="select candidates.Candidate_rank,jobs.job_title,applications.* 
from applications 
JOIN candidates ON candidates.ID=applications.candidate_id 
JOIN jobs ON jobs.job_id=applications.job_id 
where applications.institute_id='$institute_id' 
ORDER BY $sortby $orderby LIMIT $start_from,$limit";
$ex1=mysqli_query($con,$q1);
$allq1="select candidates.Candidate_rank,jobs.job_title,applications.* from applications JOIN candidates ON candidates.ID=applications.candidate_id JOIN jobs ON jobs.job_id=applications.job_id where applications.institute_id='$institute_id'";
$allex1=mysqli_query($con,$allq1);
$total_records = mysqli_num_rows($allex1); 
$total_pages = ceil($total_records / $limit);
}

else if(($searchfor=='job_id' || $searchfor=='candidate_id' && $search!=''))
{
    $q1="select candidates.Candidate_rank,jobs.job_title,applications.* from applications JOIN candidates ON candidates.ID=applications.candidate_id JOIN jobs ON jobs.job_id=applications.job_id where applications.institute_id='$institute_id' AND applications.$searchfor= '$search' ORDER BY $sortby $orderby LIMIT $start_from,$limit";
    $ex1=mysqli_query($con,$q1);
    $allq1="select candidates.Candidate_rank,jobs.job_title,applications.* from applications JOIN candidates ON candidates.ID=applications.candidate_id JOIN jobs ON jobs.job_id=applications.job_id where applications.institute_id='$institute_id' AND applications.$searchfor= '$search'";
    $allex1=mysqli_query($con,$allq1);
    $total_records = mysqli_num_rows($allex1); 
    $total_pages = ceil($total_records / $limit);
}

else if( $searchfor=='candidate_rank' && $search!='')
{

    $q1="select candidates.Candidate_rank,jobs.job_title,applications.* from applications JOIN candidates ON candidates.ID=applications.candidate_id JOIN jobs ON jobs.job_id=applications.job_id where applications.institute_id='$institute_id' AND `$searchfor` >= '$search' ORDER BY $sortby $orderby LIMIT $start_from,$limit";
    $ex1=mysqli_query($con,$q1);
    $allq1="select candidates.Candidate_rank,jobs.job_title,applications.* from applications JOIN candidates ON candidates.ID=applications.candidate_id JOIN jobs ON jobs.job_id=applications.job_id where applications.institute_id='$institute_id' AND `$searchfor` >= '$search'";
    $allex1=mysqli_query($con,$allq1);
    $total_records = mysqli_num_rows($allex1); 
    $total_pages = ceil($total_records / $limit);    
}
?>

<div id="totalresponse" style="box-shadow: 5px 5px 5px #aaaaaa;">
        <div class="table-responsive" style="border-bottom:1px solid #ddd">
        <table class="table table-hover" style="background-color:white;margin-bottom:0px;">
            <thead>
            <tr>
            <th>No.</th>
            <th>Job id</th>
            <th>Candidate ID</th>
            <th>Candidate rank</th>
            <th>Job Title</th>
            <th>Date</th>
            <th>View Candidate</th>
            <th>Accept</th>
            <th>Reject</th>
            </tr>
            </thead>
            <tbody>


            <?php

            while($res1=mysqli_fetch_array($ex1))
            { 
                if($res1['status_bit']!='0')
                {
                ?>

                <tr>
                <td><?php echo $res1['application_id'];?></td>
                <td><?php echo $res1['job_id'];?></td>
                <td><?php echo $res1['candidate_id'];?></td>
                <td><?php echo $res1['Candidate_rank'];?></td>
                <td><?php echo $res1['job_title'];?></td>
                <td><?php echo $res1['apply_datetime']; ?></td>
                <td><button class="btn btn-warning View" id="<?php echo $res1['application_id'];?>">View Candidate</button></td>
                <?php if($res1['status_bit']==-99){?> <td><button class="btn btn-success Accept" id="<?php echo $res1['application_id'];?>">Accept</button></td> <?php  } else if($res1['status_bit']=='1'){ ?> <td><button class="btn btn-success Accepted" readonly="true" disabled>Accepted</button></td> <?php  } ?>
                
                <td><button class="btn btn-danger Reject" id="<?php echo $res1['application_id'];?>">Reject</button></td>
              </tr>
            <?php 
                    } //end if
                } //end while
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

<div style="text-align:center;background-color:#f0f0f0;">
        <ul class="pagination" style="margin-top:20px;">

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

</div>
<script type="text/javascript">


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
             $.fn.filters(pageid);
        });

    $(".View").click(function(){
        var viewid=$(this).attr('id');
        $.ajax({
            url:'candidate_view_full_job.php',
            type:'POST',
            data: {
                'jobid':viewid
            },
            success:function(result){
                $('#Container').html(result);
            }
        });
    });
    $(".Accept").click(function(){
        var acceptappid=$(this).attr('id');
        $.ajax({
            url:'institute_application_accept_deny.php',
            type:'POST',
            data: {
                'action':'accept',
                'application_id':acceptappid
            },
            success:function(result){
                alert('Accepted');
                $.fn.filters(cur_page_id);
            }
        });
    });
    $(".Reject").click(function(){
        var rejectappid=$(this).attr('id');
        $.ajax({
            url:'institute_application_accept_deny.php',
            type:'POST',
            data: {
                'action':'reject',
                'application_id':rejectappid
            },
            success:function(result){
                alert('Rejected');
                $.fn.filters(cur_page_id);
            }
        });
    });



</script>

