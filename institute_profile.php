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
	<section class="content" >

        <div class="container-fluid" >

        <div id="AllContent">
            
            <div class="well" style="background-color:white;margin:auto;max-width:900px;margin-top:25px;margin-bottom:10px;min-height:85vh;box-shadow: 5px 5px 5px #aaaaaa;">


            
            
            <div id="result">

            <div class="media">
                <div class="row">

                <div class="col-md-3">
                <br/>
				<div class="media-left">
				  <img class="img-circle" style="max-width:200px;height:200px;" src="data:image/jpeg;base64,<?php echo $im; ?>" />
				</div>
                </div>
                <div class="col-md-4">
                <br/>
				<div class="media-body" style="line-height: 40px;align:center;"><b><span style="font-size:26px;"><?php echo $institute_name; ?></span></b><?php if(isset($bits[1])){
                    echo "<span style=\"color:green;font-size:21px;\"> <span class=\"glyphicon glyphicon-ok-sign \"><span></span>";
                    } else { /* echo "<span style=\"color:red;font-size:15px;\">&nbsp; Not verified <span class=\"glyphicon glyphicon-remove-sign\"></span></span>";*/ } ?>
                </div>    
                </div>
                
                <div class="col-md-5">    
                <div id="institute_details">
                    <br>
                    <span style="text-align:left;font-size:19px;"><b>Details:</b></span>
                    <span style="float: right;"><button id="edit_details" class="btn btn-info">Edit <span class="glyphicon glyphicon-edit"></span></button>
                    </span>
                    
                    <hr style="border-color:gray;">
                    <p><b>Institute Type:</b> <?php echo $institute_type;?></p>
                    <p><b>Business Email:</b> <?php echo $institute_email;?></p>
                    <p><b>Business Contact:</b> <?php echo  $institute_contact;?></p>
                    <p><b>Institute Address:</b> <?php echo $institute_address;?></p>
                    <p><b>Country: </b><?php echo $institute_country;?></p>
                    <p><b>ZIP: </b><?php echo $institute_zip;?></p>
                </div>

                </div>
               
                </div> <!-- end row -->

                <div class="row" style="margin-left:10px;margin-top:15px;">
                    
                    <?php 

                    if($institute_type=='') { ?>  
                    <p><b>Add institute details</b> <button id="edit_description" class="btn btn-info">Add <span class="glyphicon glyphicon-plus"></span></button></p>
                    <?php } ?>

                    <?php if($institute_descr=='') { ?>
                    <p><b>Write institute description  <button id="add_desc" class="btn btn-info" >Add <span class="glyphicon glyphicon-plus"></span></button></b></p>
                    <?php } ?>
                </div>

                <?php if($institute_descr!='') { ?>
                    <br/>
                    
                    <div class="row" id="descr" style="margin-top:10px;">
                        
                        <div class="col-md-10" style="text-align:justify">
                        <span style="font-size:19px;"><b>About:</b></span>
                        <span style="float: right;"><button id="edit_description" class="btn btn-info">Edit <span class="glyphicon glyphicon-edit"></span></button>
                        </span>
                        <hr style="border-color:gray;">
                        <?php echo nl2br($institute_descr);?>
                        </div>
                    </div>
                 <?php } ?>

                

                </div> 
           </div> <!-- end result -->

           
            </div>

        </div>


        </div>
    </section>
</div>

<?php require_once('institute_footer.php');?>
<script type="text/javascript">
      
    $(document).ready(function(){
            
            $('#add_desc').on('click',function(){
                $.fn.add('institute_profile_description.php','add_description');
            });
            $('#edit_description').on('click',function(){
                $.fn.add('institute_profile_description.php','edit_description');
            });
            $('#add_details').on('click',function(){
                $.fn.add('institute_profile_adddetails.php','add_details');
            });
            $('#edit_details').on('click',function(){
                $.fn.add('institute_profile_adddetails.php','edit_details');
            });
            
            $.fn.add=function(redirect,desc)
            {
                $.ajax({
                url: redirect,
                type:'POST',
                data:{
                    'add_type':desc    
                    },
                success:function(result)
                {

                    $('#result').html(result);
                }
                });    
            }
                       

            });

</script>