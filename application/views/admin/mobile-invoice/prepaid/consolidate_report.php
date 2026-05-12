<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Prepaid Consolidate Report</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item active">Prepaid Consolidate Report</li>
				</ol>
			</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(($this->input->get('period_start') != NULL) && ($this->input->get('period_end') != NULL) && check_action_permission(get_user_role(), 'recharge_reports', 'print_consolidate_report')) { ?>
						<a type="button" href="<?php echo base_url();?>admin/prepaid-mobile-invoice/print-consolidate-report?sim_no=<?php echo $this->input->get('sim_no') ?>&network=<?php echo $this->input->get('network') ?>&plan=<?php echo $this->input->get('plan') ?>&owner=<?php echo $this->input->get('owner') ?>&period_start=<?php echo $this->input->get('period_start') ?>&period_end=<?php echo $this->input->get('period_end') ?>&user=<?php echo $this->input->get('user') ?>" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank"><i class="fa fa-print me-2"></i>Print Report</a>
						<!-- <a type="submit" href="javascript:;" class="btn btn-custom-white btn-sm pull-right me-2" target="_blank"><i class="fa fa-print me-2"></i>Print Report</a> -->
					<?php } ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
				</div>
				
				<?php }} $this->admin->removeInfo();  ?>
				<?php if($this->input->get('msg')){ ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php }?>
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
						<form method="get">
							<div class="row align-items-center">
								
								<div class="col-lg-4 col-sm-6">
									<label for="sim_no">Select Sim Number</label>
									<select name="sim_no" class="form-control select2" id="sim_no">
										<option value="">[ANY]</option>
										<?php foreach($inv_sim_list as $sim_list) { ?>
											<option value="<?php echo $sim_list->id;?>" <?php echo $this->input->get('sim_no') == $sim_list->id ? 'selected' : '' ?>><?php echo $sim_list->mobile; ?> (<?php echo $sim_list->sim_no; ?>)</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-lg-4 col-sm-6 mb-2">
									<label for="network">Select Sim Network</label>
									<select name="network" class="form-control select2" id="network">
										<option value="">[ANY]</option>
										<?php if (!empty($networks)) {  
											foreach($networks as $key => $item) { ?>
												<option value="<?php echo $networks[$key]->id; ?>" <?php echo ($this->input->get('network') == $networks[$key]->id) ? 'selected' : ''; ?>><?php echo $networks[$key]->network_name; ?></option>
											<?php } } else { ?>
											<option value="" disabled>Add Network First</option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Recharge Between: <span class="text-danger">*</span></label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="period_start" placeholder="Start Date" value="<?php echo $this->input->get('period_start'); ?>" autocomplete="off" required>
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="period_end" placeholder="End Date" value="<?php echo $this->input->get('period_end'); ?>" autocomplete="off" required>
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<?php
									$adv_show = false;
									if(!empty($this->input->get('user')) || !empty($this->input->get('plan')) || !empty($this->input->get('owner'))){
										$adv_show = true;
									}
								?>
								<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
									<div class="row">
										
										<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
											<label for="plan">Select Plan:</label>
											<select name="plan" id="plan" class="form-control select2 w-100">
												<option value="">[Any Plan]</option>
												<?php foreach($plans as $plan) { ?>
													<option value="<?php echo $plan->id;?>" <?php echo ($plan->id == $this->input->get('plan')) ? 'selected' : ''; ?>><?php echo $plan->plan_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-sm-6 mb-2">
											<label for="owner">Select Owner</label>
											<select name="owner" class="form-control select2" id="owner">
												<option value="">[ANY]</option>
												<?php foreach($inv_sim_list as $sim_list) { ?>
													<option value="<?php echo $sim_list->owner_name;?>" <?php echo $this->input->get('owner') == $sim_list->owner_name ? 'selected' : '' ?>><?php echo $sim_list->owner_name; ?> (<?php echo $sim_list->owner_id; ?>)</option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-sm-6 mb-2">
											<label for="user">User</label>
											<select name="user" class="form-control select2" id="user_no">
												<option value="">[ANY]</option>
												<?php foreach($emp_list as $item) { ?>
													<option value="<?php echo $item->id;?>" <?php echo $this->input->get('user') == $item->id ? 'selected' : '' ?>><?php echo (($item->full_name !=='') ? $item->full_name : ''); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>

								<div class="row mt-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/mobile-invoice/consolidate-report'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body" style="overflow-x: auto;">
						<?php if(count($invoice) > 0) { ?>
							<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th style="min-width: 65px;">Sr. No</th>
										<th style="min-width: 120px;">Employee UID</th>
										<th style="min-width: 150px;">Employee Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th>Network</th>
										<th style="min-width: 130px;">Mobile Number</th>
										<th style="min-width: 120px;">Recharge Date</th>
										<th style="min-width: 140px;">Source</th>
										<th style="min-width: 100px;">VAT (15%)</th>
										<th style="min-width: 150px;">Total Amount (Inc. VAT)</th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; foreach($invoice as $item) { ?>
										<tr>
											<td align="center"><?php echo $i ?></td>
											<td><?php echo ($item->emp_no != '' && $item->alloted_user > 0) ? $item->emp_no : 'NA' ?></td>
											<td><?php echo ($item->alloted_user != '' && $item->alloted_user > 0) ? (($item->full_name !=='') ? $item->full_name : '') : 'NA' ?></td>
											<td><?php echo ($item->designation != '' && $item->alloted_user > 0) ? $item->designation_name : 'NA'; ?></td>
											<td><?php echo ($item->department != '' && $item->alloted_user > 0) ? $item->department_name : 'NA'; ?></td>
											<td><?php echo ($item->network_name !== '') ? $item->network_name : 'NA'; ?></td>
											<td><?php echo $item->mobile; ?></td>
											<td align="center"><?php echo date('d-m-Y', strtotime($item->recharge_date)); ?></td>
											<td align="center"><?php echo $item->payment_source; ?></td>
											<td align="right"><?php echo bcdiv($item->vat_percent, 1, 2); ?></td>
											<td align="right"><?php echo bcdiv($item->total_amount, 1, 2); ?></td>
										</tr>
									<?php $i++; } ?>
								</tbody>
							</table>
						<?php } else { ?>
							<div class="col-12 text-center bg-soft-warning p-3">
								<span>No Data Found For Applied Filters.</span>
							</div>
						<?php } ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
 	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>


