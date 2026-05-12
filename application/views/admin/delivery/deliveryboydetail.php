<?php $this->load->view('admin/home/header');?>
<style>
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
}
.content{
	background-color:#fff;
	padding: 10px;
}
.profile-user-img {
	text-align:-webkit-center;
}
.box-primary{
	border:1px solid #ddd;
}
.list-group-item{
	border-radius: 0px;
}
.list-group-item:last-child {
    border-bottom:none;
}
.list-group-item:first-child {
    border-radius: 0px;
}
/* Switch button */
.btn-default.btn-on.active{background-color: #5BB75B;color: white;}
.btn-default.btn-off.active{background-color: #DA4F49;color: white;}
.tile-stats .count {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.65857;
}
.x_content h4 {
    font-size: 14px;
    font-weight: 500;
}
.dataTables_wrapper {
    position: relative;
    clear: both;
    zoom: 1;
    overflow-y: inherit;
}
.dataTables_wrapper .row{
    overflow: hidden !important;
}
.dataTables_filter {
    width: 56%;
    float: right;
    text-align: right;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="page-title">
			<div class="title_left">
				<h4>Delivery Boy Details</h4>
			</div>
			<div class="title_right">
				<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/delivery"><i class="fa fa-reply"></i></a>
				<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal">Recharge Wallet</button>
				<!--<a class="btn btn-sm btn-primary pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/delivery/earnings?id=<?php echo $result->id;?>">View Earnings</a>-->
				<?php if($this->admin->getInfo()){ 
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>  
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				</div>
				<?php } else{?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
				
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-md-3">
				<!-- Profile Image -->
				<div class="box-primary">
					<div class="box-body box-profile">
						<div class="profile-user-img ">
							<img class="img-responsive img-circle" src="<?php echo base_url('build/images/user-icon.png');?>" alt="User profile picture" />
						</div>
						<h4 class="profile-username text-center"><?php echo $result->name;?></h4>
						<p class="text-muted text-center"><?php echo $result->arabic_name;?></p>
						<ul class="list-group list-group-unbordered">
							<li class="list-group-item"><b>Phone</b> <a class="pull-right"><?php echo $result->mobile;?></a></li>
							<li class="list-group-item"><b>Delivery Charge</b> <a class="pull-right"><?php echo $result->delivery_charge;?> SAR</a></li>
							<li class="list-group-item">
								<b>Iqama No.</b> <a class="pull-right"><?php echo $result->iqama_no;?></a>
							</li>
							<li class="list-group-item">
								<b>Iqama Exp.</b> <a class="pull-right"><?php echo $result->iqama_exp;?></a>
							</li>
							<li class="list-group-item">
								<b>Last Online</b> <a class="pull-right"><?php echo date("d M,Y h:i A");?></a>
							</li>
							<li class="list-group-item">
								<b>Status</b> 
								<a class="pull-right">
								<?php 
								  if($result->status == 1){ 
									echo '<div class="label label-success">Active</div>'; 
								  }elseif($result->status == 2){
									  echo '<div class="label label-success">Blocked</div>';
								  }else{
									echo '<div class="label label-success">Deactive</div>';
								  }
								?>
								</a>
							</li>
						</ul>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-9">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#activity" data-toggle="tab">About</a></li>
						<li><a href="#settings" data-toggle="tab">Change Password</a></li>
					</ul>
					<div class="tab-content">
						<div class="active tab-pane" id="activity">
							<!-- Post -->
							<div class="post">
								<div class="search-list">
									<h4></h4>
									<table class="table" id="myTable">
										<thead>
											<tr>
												<th>Title</th>
												<th>Title Details</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Partner</td>
												<td><?php echo $result->cname;?></td>
											</tr>
											<tr>
												<td>IBAN No.</td>
												<td><?php echo $result->iban;?></td>
											</tr>
											<tr>
												<td>Bank Name</td>
												<td><?php echo $result->bank_name;?></td>
											</tr>
											<tr>
												<td>STC Pay No.</td>
												<td><?php echo $result->stc_pay_no;?></td>
											</tr>

											<tr>
												<td>Driving Licence No.</td>
												<td><?php echo $result->dl_no;?></td>
											</tr>

											<tr>
												<td>Driving Licence Expiry</td>
												<td><?php echo $result->dl_expiry;?></td>
											</tr>
											
											<tr>
												<td>Van Number</td>
												<td><?php echo $result->van_no;?></td>
											</tr>
											
											<tr>
												<td>Van Colour</td>
												<td><?php echo $result->van_color;?></td>
											</tr>
											
											<tr>
												<td>Van Model</td>
												<td><?php echo $result->van_model;?></td>
											</tr>

											<tr>
												<td>Last Online</td>
												<td><?php echo date("d M,Y h:i A");?></td>
											</tr>
											<tr>
												<td>Created Date</td>
												<td><?php echo $result->created_at;?></td>
											</tr>
											<tr>
												<td>Last Updated</td>
												<td><?php echo $result->updated_at;?></td>
											</tr>
											<tr>
												<td>Iqama Image</td>
												<td><img src="<?php echo base_url().$result->iqama;?>" width="100px"/></td>
											</tr>
											<tr>
												<td>Driving Licence Image</td>
												<td><img src="<?php echo base_url().$result->dl_image;?>" width="100px"/></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- /.post -->
						</div>
						
						<div class="tab-pane" id="settings">
							<h4></h4>
							<div class="alert_msg"></div>
							<form method="post" action="admin/delivery/change_password" id="password_form" data-parsley-validate="" class="form-horizontal">
								<input type="hidden" id="id" name="id" value="1" />
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">New Password*</label>

									<div class="col-sm-10">
										<input type="password" id="password" name="password" required="required" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label for="confirm_password" class="col-sm-2 control-label">Confirm Password*</label>

									<div class="col-sm-10">
										<input type="password" id="confirm_password" name="confirm_password" required="required" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-danger">Submit</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Recharge Wallet</h4>
			</div>
			<?php echo form_open("admin/delivery/update_wallet", array("id"=>"wallet_form"));?>
			<div class="modal-body">
				<input type="hidden" name="dbid" value="<?php echo $result->id;?>" required>
				<div class="form-group col-md-12">
					<label for="rec_amt">Received Amount</label>
					<input type="number" id="rec_amt" name="rec_amt" class="form-control" required />
				</div>
				<div class="form-group col-md-12">
					<label for="wallet">Recharge Amount</label>
					<input type="number" id="wallet" name="wallet" class="form-control" required />
				</div>
				<div class="form-group col-md-12">
					<label for="remarks">Remarks</label>
					<input type="text" id="remarks" name="remarks" maxlength="250" class="form-control" required />
				</div>
			</div>
			<div class="modal-footer" style="border-top:none;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
			<?php echo form_close(); ?>
		</div>

	</div>
</div>	

<?php $this->load->view('admin/home/footer');?>
<script>
	$(document).ready(function() {
		$('#example1').dataTable({
    		"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
    		dom: 'Blfrtip',
    			buttons: [
    				'csv'
    			],
    			
    	});
	});
	
	$('#_from').datetimepicker({
		format: 'MM/DD/YYYY'
				
			  });
			  $('#_to').datetimepicker({
				format: 'MM/DD/YYYY',
				useCurrent: false
			  });
		$("#_from").on("dp.change", function (e) {
			$('#_to').data("DateTimePicker").minDate(e.date);
		});
		$("#_to").on("dp.change", function (e) {
			$('#from').data("DateTimePicker").maxDate(e.date);
	});
	
	$('#wallet_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/delivery/update_wallet',
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
				$(".alert_msg2").html(data).show();
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
	}));

	$('#password_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/delivery/change_password',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: 
			//showResponse,
			function(data){
				//$result = JSON.stringify(data);
				$("#password").val('');
				$("#confirm_password").val('');
				$(".alert_msg").html(data);
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
	}));
</script>

<script>
	$(document).ready(function() {
		var dbid = <?php echo $result->id;?>;
		$('#example').dataTable({
			"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
			"processing":true,  
			"serverSide":true,  
			"order":[],  
			"ajax":{  
					url:"<?php echo base_url();?>admin/delivery/get_wallet_report", 
					data:  {id: dbid},
					type:"POST"
				},  
				"columnDefs":[  
				{  
				 "targets":[0,2],  
				 "orderable":false
				},  
			]
		});
	});
</script>		
			