<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Gift Card</h3>

</div>

<div class="title_right">

<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this gift card?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete">
	<i class="fa fa-trash"></i>
</button>
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
<h5><i class="fa fa-list"></i>Gift Card List</h5>
<div class="x_panel">
	<div class="x_content">
		<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
			<div class="row top_tiles">  
				<div>
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-blue" style="padding: 10px;">
							<h4>Total Gift Card:</h4>
							<div class="count"><?php echo $total_gift; ?></div>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-green" style="padding: 10px;"> 
							<h4>Active:</h4>
							<div class="count"><?php echo $active_gift; ?></div>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-red" style="padding: 10px;"> 
							<h4>Disabled:</h4>
							<div class="count"><?php echo $disable_gift; ?></div>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-red" style="padding: 10px;"> 
							<h4>Used:</h4>
							<div class="count"><?php echo $used_gift; ?></div>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-red" style="padding: 10px;"> 
							<h4>Unused:</h4>
							<div class="count"><?php echo $unused_gift; ?></div>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-orange" style="padding: 10px;"> 
							<h4>Duplicate:</h4>
							<div class="count"><?php echo count($duplicate_gift); ?></div>
						</div>     
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<form action="<?php echo base_url(); ?>admin/voucher/set_status" method="post" id="filter_form">
					<div class="col-md-2 col-sm-3 col-xs-12">
						<div class="form-group">
						<label>From</label>
						<input type="number" id="_from" name="from" autocomplete="off" class="form-control col-md-7 col-xs-12" placeholder="Enter Start ID" required>
						</div>
					</div>

					<div class="col-md-2 col-sm-3 col-xs-12">
						<div class="form-group">
						<label>To</label>
						<input type="number" id="_to" name="to" autocomplete="off" class="form-control col-md-7 col-xs-12" placeholder="Enter End ID" required>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<label>Activate or Deactivate</label>
						<select id="status" name="status" class="form-control col-md-7 col-xs-12" required>
							<option value="">Select Status Type</option>
							<option value="1">Activate Vouchers</option>
							<option value="0">Deactivate Vouchers</option>
						</select>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-3 col-xs-12" style="padding-top: 24px;">
						<button type="submit" class="btn btn-success bg-green">Set Status</button>
						<a href="<?php echo base_url(); ?>admin/voucher" class="btn btn-warning">Reset</a>
					</div>
				</form>
			</div>
			
		</div>
		<?php echo form_open('admin/voucher/delete', array("id"=>"delete_form"));?>
			<table id="coupanTable" class="table table-bordered">
				<thead>
					<tr>
					<th>[]</th>
					<th>S.No.</th>
					<th>ID</th>
					<th>From</th>
					<th>To</th>
					<th>Message</th>
					<th>Expiry Date</th>
					<th>Value/Price</th>
					<th>Used</th>
					<th>status</th>
					<th>Created On</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1;
					foreach($list as $ref){?>
					<tr>
						<td><input type="checkbox" value="<?php echo $ref->g_id; ?>" name="check_list[]" /></td>
						<td><?php echo $i++;?></td>
						<td><?php echo $ref->g_id;?></td>
						<td><?php echo $ref->from_name;?><br/><?php echo $ref->email;?></td>
						<td><?php echo $ref->to_name;?><br/><?php echo $ref->to_email;?></td>
						<td><?php echo $ref->message;?></td>
						<td><?php echo $ref->expiry_date;?></td>
						<td>
							<a href="<?php echo base_url()?>admin/order_process/detail?id=<?php echo $ref->order_id;?>" target="_blank">O Id: <b><?php echo $ref->invoice_prefix.$ref->order_id;?></b></a><br/>
							Price: <b><?php echo $ref->order_total;?></b><br/>
							Value: <b><?php echo $ref->g_value;?></b>
						</td>
						<td><?php echo $ref->is_g_used == 1 ? '<div class="label label-danger">Used</div>':'<div class="label label-primary">Unused</div>';?></td>
						<td><?php echo $ref->g_status == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';?></td>
						<td><?php echo $ref->created_at;?></td>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		<?php echo form_close(); ?>
	</div>				 
</div>                
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	
	$('#coupanTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'ASC']],
		dom: 'Blfrtip',
		buttons: [
			'csv'
		],
	});
});
</script>