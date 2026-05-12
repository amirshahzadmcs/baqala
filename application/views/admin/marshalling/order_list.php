<?php $this->load->view('admin/home/header');?>            			
<div class="page-title">
<div class="title_left">
<h3>Dispatch Item List</h3>

</div>

<div class="title_right">
<button type="button" class="btn btn-danger btn-sm pull-right" onclick="DispatchStatus()" data-toggle="tooltip" title="Set Dispatch">Dispatch</button>

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
<h5><i class="fa fa-list"></i> Dispatch List</h5>
<div class="x_panel">
<form action="<?php echo base_url(); ?>admin/Orderdispatch/getDispatchList" method="get" id="filter_form">
<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
<div class="col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
<input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id');?>" required>
<label>From</label>
<input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="col-md-3 col-sm-3 col-xs-12">
<div class="form-group">
<label>To</label>
<input type="date" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off"  class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="col-md-3" style="margin-top: 23px;">
<button type="submit" class="btn btn-success">Filter</button>
<a href="<?php echo base_url(); ?>admin/Orderdispatch/getDispatchList?id=<?php echo $this->input->get('id');?>" class="btn btn-warning">Reset Filter</a>
</div>
</div>
</form>
<div class="x_content">
<form id="myform" name="myform" method="post" action="">
<input type="hidden" name="did" value="<?php echo $van_detail->id; ?>" required/>
<input type="hidden" name="dname" value="<?php echo $van_detail->name; ?>" required/>
<input type="hidden" name="van_no" value="<?php echo $van_detail->van_no; ?>" required/>
<input type="hidden" name="driver_mo_no" value="<?php echo $van_detail->mobile; ?>" required/>
<table id="example" class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Order No</th>
<th>Name</th>
<th>Contact</th>						  		
<th>Order Price</th>						  	
<th>Order Date</th>
<th>Delivery Date</th>
<th>Time Slot</th>
<th>Payment Method</th>
<th>Area</th>
<!--<th>Delv. Address</th>-->
<th>Order Status</th>
</tr>
</thead>
<tbody>
	<?php $sno = 1;
	// echo '<pre>';print_r($result->result());exit();
	foreach($orders as $result){?>
		<tr>
		<td><?php echo $sno++;?> <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="<?php echo $result->id;  ?>" /></td>
		<td>
		<?php echo $result->invoice_prefix .'-'. $result->id; ?>
		</td>
		<td>
		<?php echo $result->name;?><br/>
		<?php 
		if($result->c_role == '2'){
		echo '<div class="label label-success">Business</div>';
		}
		?>
		</td>		
		<td><?php echo $result->mobile;?></td>					  				
		<td><?php echo $result->order_total;?> SAR</td>

		<td><?php echo date("d/m/Y h:i A", strtotime($result->date_added));?></td>
		<td><?php echo $result->shipping_date_slot;?></td>
		<td><?php echo $result->shipping_time_slot;?></td>
		<td><?php echo $result->payment_method;?></td>	
		<td><?php echo $result->shipping_sector;?></td>		
		<!--<td><?php echo $result->shipping_complete_address;?></td>	-->			
		<td><?php if($result->order_status_id == '0'){
		echo '<div class="label label-info">Payment Pending</div>';
		}
		if($result->order_status_id == '1'){
		echo '<div class="label label-primary">Recieved</div>';
		}
		if($result->order_status_id == '2'){
			echo '<div class="label label-success">Accepted</div>';
		}
		if($result->order_status_id == '3'){
			echo '<div class="label label-danger">Cancel By Admin</div>';
		}
		if($result->order_status_id == '4'){
			echo '<div class="label label-primary">Van Assigned</div>';
		}
		if($result->order_status_id == '5'){
			echo '<div class="label label-success">Dispatched</div>';
		}

		if($result->order_status_id == '6'){
			echo '<div class="label label-success">Delivered</div>';
		}

		if($result->order_status_id == '7'){
			echo '<div class="label label-warning">Cancel On Delivery</div>';
		}

		if($result->order_status_id == '8'){
			echo '<div class="label label-warning">Refund</div>';
		}

		if($result->order_status_id == '9'){
			echo '<div class="label label-warning">Cancel By Customer</div>';
		}
		?></td>
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
			"lengthMenu": [[25, 100, 500], [25, 100, 500]],
			order: [[0, 'asc']],
			dom: 'Blfrtip',
			buttons: [
			'csv'
			],
		});
	});
	
	function DispatchStatus() {
		var inputCount = $('[name="check_list[]"]:checked').length;
		if(inputCount > 0){
			if (confirm("Do you want to dispatch selected orders?") == true) {
				changeActionAndSubmit("<?php echo base_url('admin/Orderdispatch/setStatusDispatch'); ?>");
			} else {
				userPreference = "Action Cancelled!";
			}
		}else{
			alert('Plese select check box first');
		}
	}
	
	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}
</script>