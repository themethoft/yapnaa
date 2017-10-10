<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	//print_r($_POST);die;
	if(isset($_POST['search']) || !empty($_POST['search'])){
		//echo "<pre>";print_r($_POST);
		$search = $_POST['search'];
		$filter = $_POST['filter'];
		if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){ //echo "<br>in from";
			$fromDate = date_format(date_create($_POST['fromDate']),"Y-m-d H:i:s");
		}
		else{
			$fromDate = "";
		}
		if(isset($_POST['toDate']) && !empty($_POST['toDate'])){// echo "<br>in to";
			$toDate = date_format(date_create($_POST['toDate'].' 23:59:59'),"Y-m-d H:i:s");
		}
		else{
			$toDate	=	"";
		}
		if(isset($_POST['amc_fromDate']) && !empty($_POST['amc_fromDate'])){// echo "<br>in to";
			$amc_fromDate= date_format(date_create($_POST['amc_fromDate']),"d-m-Y");
		}
		else{
			$amc_fromDate=	"";
		}
		if(isset($_POST['amc_toDate']) && !empty($_POST['amc_toDate'])){// echo "<br>in to";
			$amc_toDate= date_format(date_create($_POST['amc_toDate']),"d-m-Y");
		}
		else{
			$amc_toDate=	"";
		}
		
		//echo $fromDate."--".$toDate;die;
		//echo $date1;exit;
		$get_amc_list = $control->get_zerob_list($search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate);
	}
	/*else{
		$get_amc_list = $control->get_zerob_list("");
	}*/
	
	// Get Sub Categories List
	
	// echo  '<pre>';
	// print_r($get_amc_list);
	
	 
	
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Movilo | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
       <?php include "header.php";?>
        </div>

		<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>ZeroB Customer List</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>ZeroB Customer</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
           

		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<form id="form" method="POST" enctype="multipart/form-data">
				
                <div class="col-lg-3">
					<label>Search Keyword</label>
					<input type="text" id="searchBox" class="maincls form-control"  maxlength="60" name="search" placeholder="Enter name, number or area">
				</div>
                <div class="col-lg-2">
					<label>Filter By</label>
					<select id="filterBy" class="form-control" name="filter">
						<option value="0">Filter</option>
						<option value="1" >Call Back</option>
						<option value="2" >Not Interested</option>
						<option value="3" >Appointment Set</option>
						<option value="5" >Yapnaa Interested SMS Sent</option>
						<option value="6" >Expiry SMS Sent</option>
						<option value="7" >Yapnaa Registered</option>
					</select>
				</div>
			</div>
			</br>
			<div class="row">
			<div class="col-lg-2">
					<label>AMC From</label>
					<input type="date" class="form-control" id="amc_fromDate" name="amc_fromDate">
				</div>
				<div class="col-lg-2">
					<label>AMC To</label>
					<input type="date" class="form-control"  id="amc_toDate" name="amc_toDate">
				</div>
					<div class="col-lg-2">
					<label>Last Call From</label>
					<input type="date" class="form-control" id="fromDate" name="fromDate">
				</div>
				<div class="col-lg-2">
					<label>Last Call To</label>
					<input type="date" class="form-control"  id="toDate" name="toDate">
				</div>
				<div class="col-lg-2"  style="margin-left:-3%;margin-top: 23px;">
					<input type="submit" id="submit"  class="btn btn-info pull-right" value="Search"  name="submit" >
				</div>
				<div class="col-lg-2">
					<input type="submit" id="submit"  class="btn btn-info pull-right"  name="none" style="visibility:hidden;">
				</div>
				</form>
			</div>
		</div> 
	
        <div class="wrapper wrapper-content animated fadeInRight" style="margin-top: -30px;">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
							<th>ZeroB ID</th>
							<th>Phone </th>
							<th>Name</th>
							<th>AMC From & To</th>
							<th>Last Call</th>
							<th>Last Action</th>
							<th>Last Comment</th>
							<th>Action</th> 
						
						
					</tr>
					</thead>
					<tbody>
					<?php $j=1;?>
					<?php for($i=0;$i<count($get_amc_list);$i++){ 
								
							date_default_timezone_set('Asia/Kolkata');
	
							$date = new DateTime("now");
							$date1 = strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
							$date2 = strtotime(date_format($date,"d-m-Y")); 
							$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
							
							//echo "<br>".$date1."--".$date2."--".$diff."<br>";
							$datediff= (int)round(($date2 - $date1)/3600/24,0);
							//echo "Days".$datediff;
					?>
						<tr>
							<td <?php //echo "status".$get_amc_list[$i]['status'];
									if($get_amc_list[$i]['users'] != null || !empty($get_amc_list[$i]['users'])){
											echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>Yapnaa Registered';
										}
									
									else{
											
											switch($get_amc_list[$i]['status']){
										
												case 0:
													echo ">".$get_amc_list[$i]['CUSTOMERID'];
												break;
												
												case 1:
												//Asked to call back
													if(!$datediff <= 15){
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 2:
												//AMC Renewal
													if(!$datediff <= 15){
														echo 'style="background-color:red;color:white;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 3:
												//Appointment set
													if(!$datediff <= 15){
														echo 'style="background-color:green;color:white;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 4:
												//Registered in App
													if(!$datediff <= 15){
														echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>Yapnaa Registered';
													}
												break;
												
												case 5:
													echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
												break;
												
												case 6:
												//AMC Expiry SMS sent
													if(!$datediff <= 15){
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												default:
													echo $get_amc_list[$i]['CUSTOMERID'];
												break;
											}
											/*if($datediff <= 15){ 
												echo "style='background-color:#23c6c8;color:white;'>";
											}*/
											
										}
									
									
									?>
									
							</td>
							<td><?php echo $get_amc_list[$i]['PHONE1']; ?></a></td>
							<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
							<td><?php echo (empty($get_amc_list[$i]['CONTRACT_FROM']) && empty($get_amc_list[$i]['CONTRACT_TO'])) ? '-' :($get_amc_list[$i]['CONTRACT_FROM']." to ".$get_amc_list[$i]['CONTRACT_TO']); ?></td>
							<td><?php echo ($get_amc_list[$i]['last_called'] == '0000-00-00 00:00:00') ? '-' : $get_amc_list[$i]['last_called']; ?></td> 
							<td><?php
							if($get_amc_list[$i]['users'] == null || empty($get_amc_list[$i]['users'])){
								switch($get_amc_list[$i]['status']){
									
									case 1:
										echo "Call back";
									break;
									case 2:
										echo "Not interested";
									break;
									case 3:
										echo "Appointment set";
									break;
									case 4:
										echo "Registered in App";
									break;
									case 6:
										echo "AMC Expiry SMS sent";
									break;
									case 5:
										echo "General SMS sent";
									break;
									
									default:
										echo "-";
									break;
								}
							}
							else{
								echo "Registered in App";
							}
								
							
							?></td> 
							<td><?php echo $get_amc_list[$i]['last_call_comment']; ?></td>
							<td><?php //if(!($datediff <= 15)){ ?>  
							<button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-toggle="modal" data-target="#editAMC" title="Edit AMC Details"><i class="fa fa-pencil"></i></button>
							
							<button type="button"  style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i></button><?php //}?></td>   
							 
						</tr>
					<?php $j++; } ?>
					</tbody>
				</table>  

                    </div>
                </div>
            </div>
            </div>
        </div>
        
  <!-- Modal -->
  <div class="modal fade" id="myAction" role="dialog">
    <div class="modal-dialog  modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div>
        <div class="modal-body">
			 <div class="row" style="margin-top:2%;">
			<div class="col-lg-5"> 
				
			</div>
			
				<div class="col-lg-5"> 
				
			</div>
		   </div>
          <div class="row">
				<div class="col-lg-3"> 
					<label>Appointment Time</label>
				</div>
				<div class="col-lg-4"> 
					<input type="datetime-local"  class="maincls form-control" id="appDate"  name="bdaytime"/>
				</div>
				<div class="col-lg-4"> 
					<button type="button" class="btn btn-success" id="appSMS">
								<i class="fa fa-calendar" style="margin-right:3%;"></i>AMC Appt SMS &nbsp;</button>
				</div>
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
          <div class="row" style="margin-top:5%;margin-bottom:5%;">
				<div class="col-lg-3"> 
					<label>AMC Expiry Msg</label>
				</div>
				<div class="col-lg-4"> 
					<input type="date"  class="maincls form-control" id="amcExp"  name="amcexp"/>
				</div>
				<div class="col-lg-4"> 
					<button type="button" class="btn btn-success" id="expirySMS">
								<i class="fa fa-calendar" style="margin-right:3%;"></i>Send Reminder &nbsp;</button>
				</div>
			</div>
		<div class="row"  style="margin-top:2%;">
			<i class="fa fa-comments" style="margin-right:1%;"></i><label>Customers Comments:</label></br>
				<textarea rows="5" cols="70" id="comments" class="maincls form-control" ></textarea>
		</div>
		
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-danger pull-left" data-toggle="modal" id="noInsterest" data-target="#myAction">
							<i class="fa fa-microphone-slash" style="margin-right:3%;"></i>Customer Not Interested</button>
			<button type="button" class="btn btn-warning pull-left" id="general">
									<i class="fa fa-bullhorn" style="margin-right:3%;"></i>Yapnaa Interested</button>
			<button type="button" id="callBack" class="btn btn-info" data-toggle="modal" data-target="#myAction">
							<i class="fa fa-mail-reply" style="margin-right:3%;"></i>Call customer back, later</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
               
<?php include "footer.php";?>

 <!-- Modal -->
  <div class="modal fade" id="editAMC" role="dialog">
    <div class="modal-dialog  modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div>
        <div class="modal-body">
			 <div class="row" style="margin-top:2%;">
			<div class="col-lg-5"> 
				
			</div>
			
				<div class="col-lg-5"> 
				
			</div>
		   </div>
          <div class="row">
				<div class="col-lg-3"> 
					<label>Current AMC Duration:</label>
				</div>
				<div class="col-lg-4"> 
					<label id="currentAMC"></label>
				</div>
				
			</div>
			<div class="line line-dashed line-lg pull-in"></div>
          <div class="row" style="margin-top:5%;margin-bottom:5%;">
				<div class="col-lg-3"> 
					<label>New AMC date</label>
				</div>
				<div class="col-lg-3"> 
					<input type="date"  class="maincls form-control" id="newAMCStart"  name="amcexp"/>
				</div>
				<div class="col-lg-1"> 
					<label>to</label>
				</div>
			
				<div class="col-lg-3"> 
					<input type="date"  class="maincls form-control" id="newAMCEnd"  name="amcexp"/>

				</div>
			</div>
		<div class="row" style="margin-top:5%;margin-bottom:5%;">
			<label>Deal closed by?</label>
			<input type="radio" name="closedBy" name="closedBy" id="closedBy" checked>Yapnaa
			<input type="radio" name="closedBy" name="closedBy" id="closedBy" >3rd Party
		</div>
		<div class="row"  style="margin-top:2%;">
			<i class="fa fa-comments" style="margin-right:1%;"></i><label>Customers Comments:</label></br>
				<textarea rows="5" cols="70" id="comments" class="maincls form-control" ></textarea>
		</div>
		
        </div>
        <div class="modal-footer">
			
			<button type="button" id="editAMCSubmit" class="btn btn-info" data-toggle="modal" data-target="#myAction">
							<i class="fa fa-mail-reply" style="margin-right:3%;"></i>Update AMC dates</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
       



    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
			/*$("#submit").click(function(){
				if
			});*/
            $('.dataTables-example').dataTable({
                responsive: true,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

			$(".actionBox,editAMC").click(function(){
				sessionStorage.id = $(this).attr('data-id');
				sessionStorage.name = $(this).attr('data-name');
				sessionStorage.mobile = $(this).attr('data-mobile');
				sessionStorage.expiry = $(this).attr('data-expiry');
				sessionStorage.amcFrom = $(this).attr('data-contract');

				var now = new Date(sessionStorage.expiry);
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				
				// $("#newAMCStart").val(sessionStorage.amcFrom);
				// $("newAMCEnd").val(sessionStorage.expiry);
				if(sessionStorage.expiry != "" && sessionStorage.amcFrom != ""){
					$("#currentAMC").html($(this).attr('data-expiry')+" to "+$(this).attr('data-contract'));
				}
				else{
					$("#currentAMC").html("Not available");
				}
				
				
				//$('#datePicker').val(today);
				
				if(sessionStorage.expiry){
					$("#amcExp").val(today);
				}
				$("#modal-title").html("Customer Name: "+sessionStorage.name);
			});
			
			$("#appSMS").click(function(){
				var date = $("#appDate").val();
				if(date == ''){
					alert("Appointment Date and time is not entered!");
				}
				else{
					$.ajax({
						url:"smsActions.php?appointmentDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#expirySMS").click(function(){
				var date = $("#amcExp").val();
				if(date == ''){
					alert("Expiry Date is not entered!");
				}
				else{
					$.ajax({
						url:"smsActions.php?expiryDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#noInsterest").click(function(){
				if($("#comments").val() == ''){
					alert("Enter comments first!");
				}
				else{
					$.ajax({
						url:"smsActions.php?notInterested=submit",
						type:"POST",
						data:{id:sessionStorage.id,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("Comment updated successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#callBack").click(function(){
				if($("#comments").val() == ''){
					alert("Enter comments first!");
				}
				else{
					$.ajax({
						url:"smsActions.php?callBack=submit",
						type:"POST",
						data:{id:sessionStorage.id,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("Comment updated successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#general").click(function(){ 
					$.ajax({
						url:"smsActions.php?general=submit",
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				
			});

        });


    </script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:53:35 GMT -->
</html>

<?php
}
else
{
?>
<script>
  window.location.assign("../index.php")
</script>
<?php
}
?>