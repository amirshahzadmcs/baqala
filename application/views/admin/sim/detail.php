<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
input, textarea, select, select.select2{
    pointer-events: none;
}
span.required{
	color:red;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/sim/list">Sim Cards</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/sim/list"><i class="fa fa-reply"></i> Back</a>
				</div>

				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
					<?php } else{?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>

			</div>
		</div>
	</div>
 </div>
 <!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
									<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
									<span class="d-none d-sm-block">Sim Card Details</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
									<span class="d-block d-sm-none"><i class="fas fa-history"></i></span>
									<span class="d-none d-sm-block">Allotment History</span>
								</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" data-bs-toggle="tab" href="#profile3" role="tab">
									<span class="d-block d-sm-none"><i class="fas fa-history"></i></span>
									<span class="d-none d-sm-block">Replacement History</span>
								</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content p-3 text-muted">
							<div class="tab-pane active" id="home1" role="tabpanel">
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">SIM Ownership</h4><hr>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="ownership_type">Ownership Type<span class="text-danger">*</span></label>
										<select name="ownership_type" id="ownership_type" class="form-select" required>
											<option value="">Select Ownership</option>
											<option value="corporate" <?php echo ($ownership_type == 'corporate') ? "selected" : "" ?>>Corporate</option>
											<option value="individual" <?php echo ($ownership_type == 'individual') ? "selected" : "" ?>>Individual</option>
										</select>
										<p class="hint">Select sim ownership type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="owner_name">Owner Name <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="owner_name" name="owner_name" maxlength="150" value="<?php echo $owner_name; ?>" required />
										<p class="hint">Enter owner name of sim card</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="owner_id">Owner I'd <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="owner_id" name="owner_id" maxlength="10" value="<?php echo $owner_id; ?>" required />
										<p class="hint">Enter owner i'd for sim card</p>
									</div>
									
								</div>
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">Sim Information</h4><hr>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="date_of_purchase">Date Of Purchase <span class="text-danger">*</span></label>
										<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" value="<?php echo $date_of_purchase; ?>" required />
										<p class="hint">Enter date of purchase of sim</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="network">Service Provider <span class="text-danger">*</span></label>
										<select name="network" class="form-control select2" id="network" data-placeholder="Choose Network..." required>
											<option value="">-- select --</option>
											<?php if (!empty($networks)) {  
												foreach($networks as $key => $item) { ?>
													<option value="<?php echo $networks[$key]->id; ?>" <?php echo ($networks[$key]->id == $network) ? 'selected' : ''; ?>><?php echo $networks[$key]->network_name; ?></option>
												<?php } } else { ?>
												<option value="" disabled>Add Service Provider</option>
											<?php } ?>
										</select>
										<p class="hint">Select Service Provider</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="sim_type">Service Type<span class="text-danger">*</span></label>
										<select name="sim_type" id="sim_type" class="form-select" required>
											<option value="prepaid" <?php echo ($sim_type == 'prepaid') ? "selected" : "" ?>>Prepaid</option>
											<option value="postpaid" <?php echo ($sim_type == 'postpaid') ? "selected" : "" ?>>Postpaid</option>
											<option value="Postpaid - Data SIM" <?php echo ($sim_type == 'Postpaid - Data SIM') ? "selected" : "" ?>>Postpaid - Data SIM</option>
										</select>
										<p class="hint">Select Service Type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="plan">Plan <span class="text-danger">*</span></label>
										<input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_id; ?>">
										<select name="plan" class="form-control select2" id="plan" data-placeholder="Choose Plan...">
											<option value="">-- select --</option>
											
										</select>
										<p class="hint">Enter plan for sim card</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="internet_data">Internet Data</label>
										<select name="internet_data" id="internet_data" class="form-select">
											<option value="">-- Select Internet Data --</option>
											<option value="15 GB" <?php echo ($internet_data == '15 GB') ? "selected" : "" ?>>15 GB</option>
											<option value="25 GB" <?php echo ($internet_data == '25 GB') ? "selected" : "" ?>>25 GB</option>
										</select>
										<p class="hint">Select Service Type</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label class="d-block">Is GPS Sim (for Postpaid Sim)</label>
										<input type="checkbox" id="switch3" switch="bool" name="is_gps_sim" <?php echo ($is_gps_sim == 'on') ? "checked":"" ?> />
										<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
										<p class="hint">Switch Yes, If sim is GPS sim</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group d-none" id="gps_vehicle">
										<label for="gps_installed_vehicle">Select Vehicle</label>
										<select name="gps_installed_vehicle" class="form-control select2" id="gps_installed_vehicle">
											<option value="">-- Select Vehicle --</option>
											<?php if (!empty($unalloted_vehicle)) {  
												foreach($unalloted_vehicle as $key => $item) { ?>
													<option value="<?php echo $item['id']; ?>" <?php echo ($item['id'] == $gps_installed_vehicle) ? 'selected' : ''; ?>><?php echo $item['vehicle_no'] .' - '. ucfirst($item['vehicle_type']); ?></option>
												<?php } } else { ?>
												<option value="" disabled>No Unalloted Vehicle Found</option>
											<?php } ?>
										</select>
										<p class="hint">Select vehicle in which GPS installed</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="mobile">Mobile No <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="mobile" name="mobile" onKeyPress="return numerics(event);" onBlur="checkDuplicateMob()" minlength="<?php echo MOB_LENGTH; ?>" maxlength="<?php echo MOB_LENGTH; ?>" value="<?php echo $mobile; ?>" required />
										<p class="hint res-msg">Enter mobile number</p>
									</div>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="sim_no">Sim Card No <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="sim_no" name="sim_no" onKeyPress="return numerics(event);" onBlur="checkDuplicateSim()" value="<?php echo $sim_no; ?>" required />
										<p class="hint res-msg-sim">Enter sim card number</p>
									</div>

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label>Sim Card Status</label>
										<select name="" class="form-select" disabled>
											<option value="">-- Select Sim Status --</option>
											<?php if($allotment == '' || $allotment == '0'){ ?>
											<option value="0" <?php echo ($status == '0') ? "selected" : "" ?>>New</option>
											<?php } ?>
											<?php if($id != ''){ ?>
											<option value="1" <?php echo ($status == '1') ? "selected" : "" ?>>Active</option>
											<option value="2" <?php echo ($status == '2') ? "selected" : "" ?>>Discontinued</option>
											<option value="3" <?php echo ($status == '3') ? "selected" : "" ?>>Port</option>
											<?php } ?>
										</select>
									</div>
									
									<?php if($status == '2'){ ?>
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="date_of_discontinued">Discontinue date</label>
										<input type="date" class="form-control" id="date_of_discontinued" value="<?php echo $date_of_discontinued; ?>" disabled />
									</div>
									<?php } ?>
									<?php if($discontinue_reason !== ''){ ?>
									<div class="col-md-4 col-sm-12 mb-2 form-group d-none" id="rejection_container">
										<label for="discontinue_reason">Reason for Discontinue (if Discontinue)<span class="required-field">*</span></label>
										<input type="text" class="form-control" id="discontinue_reason" name="discontinue_reason" />
										<small class="hint">Write discontinue's reason</small>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="tab-pane" id="profile2" role="tabpanel">
								<div class="row">
									<div class="col-md-12 col-sm-12 mb-3">
										<table id="regionTable" class="table table-bordered jambo_table bulk_action" style="width:100%">
											<thead>
												<tr>
													<th>#</th>
													<th>Mobile Number</th>
													<th>Allotment Date</th>
													<th>User Name</th>
													<th>Status</th>
													<th>Last Updated</th>
												</tr>
											</thead>
											<tbody>
												<?php if (isset($logs) && !empty($logs)) {
													$i = 1;
													foreach ($logs as $key => $item) { ?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo $item->mobile; ?></td>
															<td><?php echo date('d M, Y', strtotime($item->status_date)); ?></td>
															<td><?php echo $item->full_name; ?></td>
															<td>
																<?php 
																echo ($item->status == 1 ? '<span class="badge bg-soft-success text-dark p-2">Alloted</span>' :
																	($item->status == 2 ? '<span class="badge bg-soft-danger text-dark p-2">Unalloted</span>' :
																	($item->status == 3 ? '<span class="badge bg-soft-warning text-dark p-2">Port</span>' :
																	($item->status == 4 ? '<span class="badge bg-soft-primary text-dark p-2">Active</span>' :
																	($item->status == 5 ? '<span class="badge bg-soft-secondary text-dark p-2">Discontinue</span>' : 
																	'<span class="badge bg-soft-default text-dark p-2">Unknown</span>')))));
																?>
															</td>
															<td><?php echo date('d M, Y h:i A', strtotime($item->updated_at)); ?></td>
														</tr>
												<?php $i++;	}
												} ?>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="profile3" role="tabpanel">
								<div class="row">
									<div class="col-md-12 col-sm-12 mb-3">
										<?php if (!empty($replacement_logs)): ?>
										<table id="regionTable" class="table table-bordered jambo_table bulk_action" style="width:100%">
											<thead>
												<tr>
													<th>#</th>
													<th>Old SIM No.</th>
													<th>New SIM No.</th>
													<th>Reason</th>
													<th>Message</th>
													<th>Replacement Date</th>
													<th>Created Date</th>
												</tr>
											</thead>
											<tbody>
												<?php $rso = 1;foreach ($replacement_logs as $log): ?>
													<?php 
													// Decode the JSON log_detail
													$log_detail = json_decode($log['log_detail'], true); 
													?>
													<tr>
														<td><?php echo $rso++; ?></td>
														<td>
															<?php echo htmlspecialchars($log_detail['old_sim_no'], true); ?>
														</td>
														<td>
															<?php echo htmlspecialchars($log_detail['new_sim_no'], true); ?>
														</td>
														<td>
															<?php echo htmlspecialchars($log_detail['reason'], true); ?>
														</td>
														<td>
															<?php echo htmlspecialchars($log_detail['message'], true); ?>
														</td>
														<td>
															<?php echo date('d-m-Y', strtotime($log_detail['replacement_date'])); ?>
														</td>
														<td><?php echo date('d-m-Y H:i A', strtotime($log['created_at'])); ?></td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
										<?php else: ?>
											<p>No log history available.</p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#vendor_table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "copy",
				className: "btn-md"
			},
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],
		"responsive": true,
		"processing":true,
		"serverSide":true,
		fixedHeader: true,
		"order":[],
		"ajax":{
				url:"<?php echo base_url();?>admin/vendor/get_order_list?id=<?php echo $this->input->get('id');?>",
				type:"POST"
			},
			"columnDefs":[
			{
			 "targets":[0,1],
			 "orderable":false
			},
		]
	});
});
$(document).ready(function(){
	selectedPlan();
});

function selectedPlan() {
	var id = $('#id').val();
	if (id != '') {
		var network = $('#network option:selected').val();
		var sim_type = $('#sim_type option:selected').val();
		var plan_id = $('#plan_id').val();
		// alert(plan_id);
		$.ajax({
			url: "<?php echo base_url()?>admin/Sim_card/getPlans",
			data: { "id": network, "plan_id": plan_id, "sim_type": sim_type },
			//dataType:"html",
			type: "get",
			success: function(data){
				$('#plan').html(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
}

$(document).ready(function() {
	$('#regionTable').dataTable({
		"lengthMenu": [
			[25, 50, 100, 500],
			[25, 50, 100, 500]
		],
		order: [
			[0, 'asc']
		],
		"responsive": true,
		fixedHeader: true,
	});
});
</script>
