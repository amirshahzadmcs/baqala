<?php $this->load->view('gate_keeper/layout/mobile-header'); ?>
<?php if ($this->gatekeeper->getInfo()) {
	$info = explode("--", $this->gatekeeper->getInfo());
	$info_type = $info[0];
	$msg_data = $info[1] ?? '';
	if ($info_type == 2) {
?>
		<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			<strong><?php echo $msg_data; ?></strong>
		</div>

	<?php } else { ?>
		<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			<strong><?php echo $msg_data; ?></strong>
		</div>
	<?php } ?> <?php }
			$this->admin->removeInfo(); ?>
<div class="container mt-5">
	<div class="row">
		<div class="col-sm-6 w-50">
			<div class="item-1 text-center">
				<div class="svg">
					<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="7.5" y="5" width="16.25" height="21.25" rx="2" stroke="#35B366" />
						<path d="M18.75 12.5V10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 11.25H10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 16.25H10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 21.25H10" stroke="#35B366" stroke-linecap="round" />
					</svg>

				</div>
				<h4>Today's Entries</h4>
				<p><?php echo $today_entries; ?></p>
			</div>
		</div>
		<div class=" col-sm-6 w-50">
			<div class="item-1 text-center">
				<div class="svg">
					<svg width="46" height="38" viewBox="0 0 46 38" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="7.5" y="5" width="16.25" height="21.25" rx="2" stroke="#35B366" />
						<path d="M18.75 12.5V10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 11.25H10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 16.25H10" stroke="#35B366" stroke-linecap="round" />
						<path d="M5 21.25H10" stroke="#35B366" stroke-linecap="round" />
						<path fill-rule="evenodd" clip-rule="evenodd" d="M30.2917 19.3142C30.2917 19.1529 30.2917 19.0723 30.2379 19.0273C30.1841 18.9823 30.1069 18.9962 29.9525 19.024C29.1761 19.1638 28.5914 19.4061 28.1126 19.826C27.9813 19.9411 27.8578 20.0647 27.7426 20.196C26.75 21.3278 26.75 23.0519 26.75 26.5C26.75 29.9481 26.75 31.6722 27.7426 32.8041C27.8578 32.9353 27.9813 33.0589 28.1126 33.174C29.2445 34.1667 30.9686 34.1667 34.4167 34.1667H35.5833C39.0314 34.1667 40.7555 34.1667 41.8874 33.174C42.0187 33.0589 42.1422 32.9353 42.2574 32.8041C43.25 31.6722 43.25 29.9481 43.25 26.5C43.25 23.0519 43.25 21.3278 42.2574 20.196C42.1422 20.0647 42.0187 19.9411 41.8874 19.826C41.4086 19.4061 40.8239 19.1638 40.0475 19.024C39.8931 18.9962 39.8159 18.9823 39.7621 19.0273C39.7083 19.0723 39.7083 19.1529 39.7083 19.3142L39.7083 21.2292C39.7083 22.0576 39.0368 22.7292 38.2083 22.7292C37.3799 22.7292 36.7083 22.0576 36.7083 21.2292L36.7083 19.1336C36.7083 18.9927 36.7083 18.9222 36.6645 18.8783C36.6207 18.8344 36.5503 18.8342 36.4096 18.8339C36.1457 18.8333 35.8705 18.8333 35.5833 18.8333H34.4167C34.1295 18.8333 33.8543 18.8333 33.5904 18.8339C33.4497 18.8342 33.3793 18.8344 33.3355 18.8783C33.2917 18.9222 33.2917 18.9927 33.2917 19.1336L33.2917 21.2292C33.2917 22.0576 32.6201 22.7292 31.7917 22.7292C30.9632 22.7292 30.2917 22.0576 30.2917 21.2292L30.2917 19.3142Z" fill="#7E869E" fill-opacity="0.25" />
						<path d="M31.7917 17.3958L31.7917 21.2292" stroke="#35B366" stroke-linecap="round" />
						<path d="M38.2083 17.3958L38.2083 21.2292" stroke="#35B366" stroke-linecap="round" />
						<circle cx="30.5" cy="25.5" r="0.5" fill="#35B366" />
						<circle cx="33.5" cy="25.5" r="0.5" fill="#35B366" />
						<circle cx="36.5" cy="25.5" r="0.5" fill="#35B366" />
						<circle cx="39.5" cy="25.5" r="0.5" fill="#35B366" />
						<circle cx="30.5" cy="28.5" r="0.5" fill="#35B366" />
						<circle cx="33.5" cy="28.5" r="0.5" fill="#35B366" />
						<circle cx="36.5" cy="28.5" r="0.5" fill="#35B366" />
						<circle cx="39.5" cy="28.5" r="0.5" fill="#35B366" />
						<circle cx="30.5" cy="31.5" r="0.5" fill="#35B366" />
						<circle cx="33.5" cy="31.5" r="0.5" fill="#35B366" />
						<circle cx="36.5" cy="31.5" r="0.5" fill="#35B366" />
						<circle cx="39.5" cy="31.5" r="0.5" fill="#35B366" />
					</svg>


				</div>
				<h4>Total Entries</h4>
				<p><?php echo $total_entries; ?></p>
			</div>
		</div>
	</div>
</div>
<div class="d-grid gap-2 py-2 custom-button side-1">
	<button data-bs-target="#vehicleModal" data-bs-toggle="modal" class="btn btn-success btn-lg btn-block" type="submit">Create Timesheet</button>
</div>
<?php $this->load->view('gate_keeper/layout/mobile-footer'); ?>
<!-- end page content-->

<!-- Vehicle entry Model -->

<div class="modal fade " id="vehicleModal" data-bs-backdrop="static" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title mt-0">Vehicle Timesheet</h5>
				</div>
				<div>
					<!-- <a href="<?php echo base_url() ?>admin/application-manage/department-form-builder" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></a> -->
					<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<form id="empCheck" action="<?php echo base_url('gate-keeper/vehicle/check_employee'); ?>" method="post" data-parsley-validate>
					<div class="row justify-content-center">
						<div class="card bg-light col-md-6">
							<div class="card-body row" id="empNo">
								<div class="col-md-8 form-group">
									<label class="form-label">Employee Id<span class="text-danger">*</span></label>
									<input class="form-control" type="text" name="employee_no" required>
								</div>
								<div class="col-md-4 form-group align-content-end">
									<button form="empCheck" type="submit" class="btn btn-success submit_button mt-2">Submit</button>
								</div>
								<p id="empCheckMsg" class="mt-1"></p>
							</div>
						</div>
					</div>
				</form>
				<hr>
				<div class="col-md-12 mb-3" id="empDetails" style="display:none;">

				</div>

			</div>
		</div>
	</div>
</div>