<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Partner Van List</h3>

</div>
<?php  $admin_id= $this->session->userdata('admin_id'); ?>
<div class="title_right">
<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/partner/"><i class="fa fa-reply"></i></a>
<?php if($this->admin->getInfo()){ 
$info = explode("--", $this->admin->getInfo());
$info_type = $info[0];


$msg_data = $info[1];
if($info_type == 2){
?>  
<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
<?php } else{?>
<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
</div>
</div>

<div class="clearfix"></div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

<?php 
	$total_orders = 0;
	foreach($results as $result){
		$total_orders += $result->total;
	}
?>
<div class="row top_tiles">  
	<div class="col-md-12">
		<div class="animated flipInY col-lg-12">               
			<div class="tile-stats bg-green" style="padding: 10px;"> 
				<div class="col-md-4">
					<h5>Partner Company: <?php echo $partner_details->cname; ?></h5>
				</div>
				<div class="col-md-4">
					<h5>Contact Person: <?php echo $partner_details->contact_p; ?></h5>
				</div>
				<div class="col-md-4">
					<h5>Contact Number: <?php echo $partner_details->mobile; ?></h5>
				</div>
			</div>     
		</div> 
		
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
			<div class="tile-stats bg-blue" style="padding: 10px;"> 
				<h4>Total Van:</h4>
				<div class="count"><?php echo count($results); ?> </div>
			</div>     
		</div>  
		
		<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
			<div class="tile-stats bg-purple" style="padding: 10px;"> 
				<h4>Total Orders:</h4>
				<div class="count"><?php echo $total_orders ?></div>
			</div>     
		</div>
		
	</div>
</div>

<div class="x_content">
<form id="myform" name="myform" method="post" action="">
<table id="example" class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Van No</th>
<th>Driver Name</th>				  
<th>Mobile No.</th>				  
<th>Delivery Area</th>
<th>Insurance Expiry</th>
<th>Total Orders</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<?php 
$i = 1;
foreach($results as $result){
?>
<tr>
<td><?php echo $i++;?></td>
<td><?php echo $result->van_no;?></td>
<td><?php echo $result->dname;?><br/><?php echo $result->arabic_name;?></td>
<td><?php echo $result->driver_mo_no;?></td>
<td><?php echo $result->area;?></td>
<td><?php echo $result->car_ins_expiry;?></td>
<td><?php echo $result->total;?></td>
<td><?php echo $result->status == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';?></td>
</tr>

<?php } ?>
</tbody>
</table>

				
</form>
</div>				 
</div>                
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
$('#example').dataTable({
"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
dom: 'Blfrtip',
buttons: [
'csv'
],
});
});
</script>