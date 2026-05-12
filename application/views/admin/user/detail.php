<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Individual Client Details</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/user/list');?>">Individual Client Management</a></li>
						<li class="breadcrumb-item active">Client's Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/user/list');?>"><i class="fa fa-reply"></i> Back</a>
				</div>
			</div>
		</div>
	</div>
 </div>
 <!-- end page title -->
 <?php
	$pending = 0;
	$delivered = 0;
	$canceled = 0;
	$total_revenue = 0;
	if(!empty($orders)){
		foreach($orders as $order){
			$orderStatus = $order->order_status_id;
			if($orderStatus == '1' || $orderStatus == '2' || $orderStatus == '4' || $orderStatus == '5'){
				$pending++;
			}
			if($orderStatus == '6'){
				$delivered++;
				$total_revenue += $order->order_total;
			}
			if($orderStatus == '3' || $orderStatus == '7' || $orderStatus == '8' || $orderStatus == '9'){
				$canceled++;
			}
		}
	}
?>
<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
						<div class="color-box bg-primary m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Total Revenue</h6>
								<h4 class="my-2 text-white"><?php echo $total_revenue; ?></h4>
								<a class="my-2 text-white font-size-12" href="javascript:;">VIEW ALL</a>
							</div>
							<div class="color-box bg-success m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Total Orders</h6>
								<h4 class="my-2 text-white"><?php echo count($orders); ?></h4>
								<a class="my-2 text-white font-size-12" href=" href="<?php echo base_url('admin/user/orders?id='. $result->id); ?>" target="_blank"">VIEW ALL</a>
							</div>
							<div class="color-box bg-info m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Pending Orders</h6>
								<h4 class="my-2 text-white"><?php echo $pending ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $result->id .'&status=1'); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-warning m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Completed Orders</h6>
								<h4 class="my-2 text-white"><?php echo $delivered ?></h4>
								<a class="my-2 text-white font-size-12" href=" href="<?php echo base_url('admin/user/orders?id='. $result->id .'&status=6'); ?>" target="_blank"">VIEW ALL</a>
							</div>
							<div class="color-box bg-danger m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Cancel Orders</h6>
								<h4 class="my-2 text-white"><?php echo $canceled ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/orders?id='. $result->id .'&status=9'); ?>" target="_blank">VIEW ALL</a>
							</div>
							<div class="color-box bg-dark m-2 col-md-2 p-2 rounded text-center">
								<h6 class="my-2 text-white">Total Active Referral</h6>
								<h4 class="my-2 text-white"><?php echo $referral_count[0]['total_referred'] ?></h4>
								<a class="my-2 text-white font-size-12" href="<?php echo base_url('admin/user/referral_report?id='. $result->id .'&ref_code='. $result->referral_code); ?>" target="_blank">VIEW ALL</a>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h5 class="scheduler-border">Individual Client Details:</h5>
						<table id="example" class="table table-bordered">
							<thead>
							<tr><th>Client ID</th><td><?php echo $result->id;?></td></tr>
							<tr><th>Client Ref. No</th><td><?php echo $result->customer_no;?></td></tr>
							<tr><th>Name</th><td><?php echo $result->name;?></td></tr>
							<tr><th>Conatct Number</th><td><?php echo $result->mobile;?></td></tr>
							<tr><th>Email ID</th><td><?php echo $result->email;?></td></tr>
							<tr>
								<th>Rewards</th>
								<td>
									<h5>Available Balance: <?php echo $result->rewards;?> SAR</h5>
									<a href="<?php echo base_url().'admin/user/rewards_report?id='.$result->id; ?>" class="btn btn-primary btn-sm" style="float: right;margin-top: -27px;" target="_blank">view rewards report</a>
									<div class="row">
										<?php echo form_open("admin/user/update_rewards", array("id"=>"rewards_form"));?>
										<input type="hidden" name="uid" value="<?php echo $result->id;?>" required>
										<div class="col-md-12">
											<label for="rewards">Rewards Amount</label>
											<input type="number" id="rewards" name="rewards" class="form-control" required />
										</div>
										<div class="col-md-12">
											<label for="remarks">Remarks</label>
											<input type="text" id="remarks" name="remarks" maxlength="250" class="form-control" required />
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-success btn-sm btn-block float-end" style="margin-top: 10px;">Update</button>
										</div>
										<?php echo form_close(); ?>
									</div>
								</td>
							</tr>
							<tr>
								<th>Wallet</th>
								<td>
									<h5>Available Balance: <?php echo $result->wallet;?> SAR</h5>
									<a href="<?php echo base_url().'admin/user/wallet_report?id='.$result->id; ?>" class="btn btn-primary btn-sm" style="float: right;margin-top: -27px;" target="_blank">view wallet report</a>
									<div class="row">
										<?php echo form_open("admin/user/update_wallet", array("id"=>"wallet_form"));?>
										<input type="hidden" name="uid" value="<?php echo $result->id;?>" required>
										<div class="form-group col-md-12">
											<label for="wallet">Wallet Amount</label>
											<input type="number" id="wallet" name="wallet" class="form-control" required />
										</div>
										<div class="form-group col-md-12">
											<label for="remarks">Remarks</label>
											<input type="text" id="remarks" name="remarks" maxlength="250" class="form-control" required />
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-success btn-sm btn-block float-end" style="margin-top: 10px;">Update</button>
										</div>
										<?php echo form_close(); ?>
									</div>
								</td>
							</tr>
							<tr><th>Account Type</th><td><p><?php echo $result->role_id == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Normal</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Business</span>';?></p></td></tr>
							<tr>						  
								<th valign="middle">Address</th>	
								<td>
									<?php foreach($addresses->result() as $address){?>
									<div class="p-3 bg-white rounded shadow-sm w-100">
										<p class="text-muted m-0"><b><?php echo $address->name; ?></b></p>
										<p class="text-muted m-0"><?php echo $address->complete_address; ?></p>
									</div>
									<hr/>
									<?php } ?>
								</td>
							</tr>
							<tr><th>Status</th><td><?php echo $result->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';?></td></tr>
							<tr><th>Created On</th><td><?php echo $result->created;?></td></tr>
							<tr><th>Updated On</th><td><?php echo $result->modified;?></td></tr>
							<tr><th>IP Address</th><td><?php echo $result->ip;?></td></tr>
						</thead>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>

<script>
$('#rewards_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/user/update_rewards',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg2").html(data).show();
		},
		error: function(data){
			alert(JSON.stringify(data));
		}
	});
}));

$('#wallet_form').on('submit', (function(e) {
	//alert('test');
	e.preventDefault();
	$.ajax({
		url: '<?php echo base_url();?>admin/user/update_wallet',
		type: "POST",
		data:  new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			//$result = JSON.stringify(data)
			//$(".cred_box").load(location.href);
			window.location.reload();
			$("#errmsg2").html(data).show();
		},
		error: function(data){
			alert(JSON.stringify(data));
		}
	});
}));
</script>
