<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
	color: #fff !important;
	background-color: #005500!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
	content: "";
	background: #005500;
}
.nav-tabs-custom .nav-item .nav-link {
	background: #eee;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
.cv-documents{
	border: 1px dashed #a9a9a9;
	padding: 6px;
	width: 60px;
	height: 60px;
	margin-top: -9px;
}
.image-container {
	position: relative;
	display: inline-block;
}
.image-container .overlay{
	opacity: 0;
}
.image-container:hover .overlay{
	background: #0006;
	opacity: .9;
	position: absolute;
	top: -9px;
	bottom: 0;
	width: 130px;
	height: 130px;
}
.image-container:hover .edit {
	display: block;
}
.image-container .edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: absolute;
	right: 0;
	left: 0;
	top: 20%;
	display: none;
}
.employee-profle-pic {
    height: 39px;
    width: 36px;
    background-color: #eaedf1;
    padding: 3px;
}
/*---- Sidebar ----*/
.modal .modal-dialog-aside{
	width: 35%;
	max-width:80%; height: 100%; margin:0;
	transform: translate(0); transition: transform .2s;
}


.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

.modal.show .modal-dialog-aside{ transform: translateX(0);  }

</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>New Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">New Employee</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/hr/employees'); ?>"><i class="fa fa-reply"></i> Back</a>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<?php $this->load->view('admin/hr-module/employees/components/top-profile-section');?>
						<div class="step-wraper">
							<?php
								$active_step = 7;
								$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
								$this->load->view('admin/hr-module/employees/components/add_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="row size-inner-section px-2 py-4 mx-2">
							<div class="w-50"><h4 class="header-title float-start">Transactions List</h4></div>
							<div class="w-50"><?php if(count($trans_info) > 0){ ?><button type="button" class="btn btn-outline-secondary float-end" data-bs-toggle="modal" data-bs-target=".transModalFullscreen" style="margin-top: -16px;"><i class="fa fa-plus"></i> New Transaction</button><?php } ?></div><hr>
							
							<?php if(count($trans_info) > 0){ ?>
							<div class="employee-transactions">
								<table class="table border">
									<thead>
										<tr>
											<th>Created Date</th>
											<th>Effective On</th>
											<th>Paid On</th>
											<th>Trans. Type</th>
											<th class="text-end">Total Amount</th>
											<th>Pay Mode</th>
											<th>Payment Status</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$statusMapping = [
												1 => ['label' => 'Pending', 'badgeClass' => 'badge-soft-warning'],
												2 => ['label' => 'Approved', 'badgeClass' => 'badge-soft-success'],
												3 => ['label' => 'Rejected', 'badgeClass' => 'badge-soft-danger'],
												4 => ['label' => 'Expired', 'badgeClass' => 'badge-soft-secondary'],
												5 => ['label' => 'Canceled', 'badgeClass' => 'badge-soft-dark']
											];
											foreach ($trans_info as $emp_trans) {
											$status = $statusMapping[$emp_trans['request_status']] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info'];
										?>
										<tr>
											<td><?= date('d M Y', strtotime($emp_trans['created_at'])) ?></td>
											<td><?= date('d M Y', strtotime($emp_trans['request_date'])) ?></td>
											<td></td>
											<?php
												// Call the helper function
												$loanDetails = json_decode($emp_trans['request_detail']);
											?>
											<td><?php echo $loanDetails->type;?> (<?= addSpaceBetweenWords($emp_trans['request_type']);?>)</td>
											<td align="right"><?php echo 'SAR '. $loanDetails->amount;?></td>
											<td></td>
											<td><span class="badge rounded-pill <?= $status['badgeClass'] ?> px-2 py-1 font-size-12"><?= $status['label'] ?></span></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php }else{ ?>
							<div class="text-center m-auto">
								<p><i class="dripicons-copy text-secondary fa-3x"></i></p>
								<button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target=".transModalFullscreen"><i class="fa fa-plus"></i> New Transaction</button>
							</div>
							<?php } ?>
						</div>
						<div class="twitter-bs-wizard">
							<ul class="pager wizard twitter-bs-wizard-pager-link">
								<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/add/step-6/'.$emp_detail->id) : base_url('admin/hr/employees/add/step-1'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
								<li class="next"><a type="button" href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/add/step-8/'.$emp_detail->id) : base_url('admin/hr/employees/add/step-1'); ?>" class="btn btn-custom-success"> Save and Continue <i class="mdi mdi-arrow-right ms-1"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- container-fluid -->
<div class="modal fade fixed-left transModalFullscreen" aria-labelledby="#exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">Add New Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<?php echo form_open("admin/hr/employees/save-transaction-request", array("id" => "requestForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
					<input type="hidden" name="request_type" value="TransactionRequest" required />
					<!-- Tab panes -->
					
					<div class="row size-inner-section px-0 py-2 mx-0">
						<h4 class="header-title">Transaction/Loan</h4><hr>
						<div class="col-md-6 col-sm-12 mb-2 form-group">
							<label for="type_of_transaction">Transaction Type</label>
							<select class="form-select" data-parsley-allselected="true" name="type_of_transaction" id="type_of_transaction">
								<option value="">Select Transaction Type</option>
								<?php foreach(TransTypesHelper() as $transtype) { ?>
									<option value="<?php echo $transtype->transaction_name; ?>"><?php echo $transtype->transaction_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-2 form-group">
							<label for="amount">Amount</label>
							<input type="number" id="amount" name="amount" min="0" step="0.1" maxlength="10" class="form-control">
						</div>
					</div>
					<div class="row size-inner-section px-0 py-2 mx-0">
						<div class="col-md-12 col-sm-12 form-group">
							<input class="form-check-input" type="radio" name="payroll_type" id="out_payroll1" value="out_payroll" style="vertical-align: sub;margin-right: 3px;width:1.5em;height:1.5em;">
							<label class="form-check-label" for="out_payroll1" style="font-size: 20px;">Out-payroll</label>
							<p>Transaction will count outside the payroll</p>
						</div>
						<div id="outParoll" class="row"></div>
					</div>
					<div class="row size-inner-section px-0 py-2 mx-0">
						<div class="col-md-12 col-sm-12 form-group">
							<input class="form-check-input" type="radio" name="payroll_type" id="in_payroll1" value="in_payroll" style="vertical-align: sub;margin-right: 3px;width:1.5em;height:1.5em;">
							<label class="form-check-label" for="in_payroll1" style="font-size: 20px;">In-payroll</label>
							<p>Transaction will count inside the payroll</p>
						</div>
						<div id="inParoll" class="row"></div>
					</div>
					<div class="row size-inner-section px-0 py-2 mx-0">
						<div class="col-md-12 col-sm-12 mb-2 form-group">
							<label for="trans_attachment">Upload File</label>
							<input type="file" name="trans_attachment" id="trans_attachment" class="dropify"
								accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
								data-max-file-size="2M" data-height="100">
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="description">Description</label>
							<textarea class="form-control" name="description" autocomplete="off" id="description"></textarea>
						</div>
					</div>
				<?php echo form_close(); ?>
            </div>
			<div class="modal-footer">
				<div class="px-2">
					<button type="submit" form="requestForm" class="btn btn-success btn-md">Save Transaction</button>
					<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	$('.dropify').dropify();

	$('input[name="payroll_type"]').on('click', function() {
		$(".payroll-checked input").val('');
		var payroll_html = '';
		if (this.value == 'out_payroll') {
			$('#inParoll').html('');
			payroll_html = `<div class="col-md-6 col-sm-12 mb-2 form-group payroll-checked">
				<label for="effective_date">Effective Date</label>
				<input type="date" class="form-control" id="effective_date" name="effective_date" required />
			</div>
			<div class="col-md-6 col-sm-12 mb-2 form-group payroll-checked">
				<label for="payment_date">Payment Date</label>
				<input type="date" class="form-control" id="payment_date" name="payment_date" required />
			</div>`;
			$('#outParoll').html(payroll_html);
		}
		else if (this.value == 'in_payroll') {
			$('#outParoll').html('');
			payroll_html = `<div class="col-md-6 col-sm-12 mb-2 form-group payroll-checked">
					<label for="effective_date">Effective Date</label>
					<input type="date" class="form-control" id="effective_date" name="effective_date" required />
				</div>
				<input type="hidden" class="form-control" id="payment_date" name="payment_date" value="" />`;
			$('#inParoll').html(payroll_html);
		}
	});

	function numerics(key) {
		//getting key code of pressed key
		// alert($(this).val());
		var keycode = (key.which) ? key.which : key.keyCode;
		//comparing pressed keycodes

		if (keycode > 31 && (keycode < 48 || keycode > 57)) {
			alert("You can enter only characters 0 to 9 ");
			return false;
		} else return true;
	}
	
	$(document).ready(function () {
		$("#requestForm").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-transaction-request'); ?>",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response.type === "success") {
						toastr.success(response.message);
						setTimeout(function () {
							location.reload();
						}, 2000);
					} else if (response.type === "error") {
						toastr.error(response.message);
					}
				},
				error: function (xhr, status, error) {
					// Handle AJAX error
					console.error("AJAX Error:", status, error);
					toastr.error('An unexpected error occurred. Please try again.');
				},
			});
		});
	});
	
</script>
