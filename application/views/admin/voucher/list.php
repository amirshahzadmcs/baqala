<?php $this->load->view('admin/home/header'); ?>
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
					<h4>Recharge Voucher Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Recharge Voucher List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'vouchers', 'delete')): ?>
						<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'vouchers', 'save')): ?>
						<button class="btn btn-custom-success btn-sm pull-right ms-1" title="Add Recharge Voucher" data-bs-toggle="modal" data-bs-target=".add-voucher-modal"><i class="fa fa-plus"></i> Add Voucher</button>
					<?php endif; ?>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo();  ?>
				<?php if ($this->input->get('msg')) { ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php } ?>
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
								<!--   <div class="form-group col-lg-4 col-sm-6 mb-3">-->
								<!--	<label>Search By Serial No.</label>-->
								<!--	<input type="text" id="keyword" name="keyword" placeholder="Enter serial no." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">-->
								<!--</div>-->
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="network">Select Network:</label>
									<select name="network" id="network" class="form-control select2 w-100">
										<option value="">[Any Network]</option>
										<?php foreach ($networks as $network) { ?>
											<option value="<?php echo $network->id; ?>" <?php echo ($network->id == $this->input->get('network')) ? 'selected' : ''; ?>><?php echo $network->network_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<!--<div class="form-group col-lg-4 col-sm-6 mb-3">-->
								<!--	<label for="status">Status</label>-->
								<!--	<select name="status" class="form-control select2">-->
								<!--		<option value="">[Any Voucher Status]</option>-->
								<!--		<option value="new" <?php echo $this->input->get('status') == 'new' ? 'selected' : '' ?>>New</option>-->
								<!--		<option value="used" <?php echo $this->input->get('status') == 'used' ? 'selected' : '' ?>>Used</option>-->
								<!--		<option value="expired" <?php echo $this->input->get('status') == 'expired' ? 'selected' : '' ?>>Expired</option>-->
								<!--	</select>-->
								<!--</div>-->
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label>Purchase Date Between (From and To)</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
										<input type="text" class="form-control" id="_from" name="purchase_from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
										<input type="text" class="form-control" id="_to" name="purchase_to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
									</div>
								</div>
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label>Used Date Between (From and To)</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
										<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
										<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
									</div>
								</div>
								<div class="row mt-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<!--<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>-->
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/sim/vouchers'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="">
							<table id="voucherTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Date Of Purchase</th>
										<th>Service Provider</th>
										<th>No. of Vouchers</th>
										<th>Voucher Value</th>
										<th>VAT</th>
										<th>Total Voucher Value</th>
										<th>Expiry Date</th>
										<!-- <th>Status</th> -->
										<th>Created At</th>
										<th>Updated At</th>
										<th>Tools</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
<div class="modal fade add-voucher-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add Recharge Vouchers</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/sim/vouchers/save", array("id" => "voucherForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="id" name="id" value="" />
				<div class="row">
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="purchase_date">Date Of Purchase <span class="text-danger">*</span></label>
						<input type="date" class="form-control" id="purchase_date" name="purchase_date" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="sim_network">Service Provider <span class="text-danger">*</span></label>
						<select name="sim_network" class="form-control select2" id="sim_network" data-placeholder="Choose Network..." required>
							<option value="">-- select --</option>
							<?php if (!empty($networks)) {
								foreach ($networks as $key => $item) { ?>
									<option value="<?php echo $networks[$key]->id; ?>"><?php echo $networks[$key]->network_name; ?></option>
								<?php }
							} else { ?>
								<option value="" disabled>Add Service Provider</option>
							<?php } ?>
						</select>
					</div>

					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="total_vouchers">No. of Vouchers Purchased <span class="text-danger">*</span></label>
						<input type="number" class="form-control" id="total_vouchers" name="total_vouchers" maxlength="5" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="voucher_value">Voucher Value <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="voucher_value" name="voucher_value" maxlength="15" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="voucher_vat">VAT <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="voucher_vat" name="voucher_vat" maxlength="15" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="voucher_total">Total Voucher Value <span class="text-danger">*</span></label>
						<input type="text" class="form-control" id="voucher_total" name="voucher_total" maxlength="15" required />
					</div>
					<div class="col-md-4 col-sm-12 mb-3 form-group">
						<label for="expiry_date">Expiry Date <span class="text-danger">*</span></label>
						<input type="date" class="form-control" id="expiry_date" name="expiry_date" required />
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="voucherForm" class="btn btn-success">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	$(document).ready(function() {
		$('#voucherTable').dataTable({
			"lengthMenu": [
				[25, 50, 100, 500],
				[25, 50, 100, 500]
			],
			order: [
				[0, 'asc']
			],

			dom: 'Blfrtip',
			buttons: [{
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
			"processing": true,
			"serverSide": true,
			"fixedHeader": true,
			searching: false,
			"ajax": {
				url: "<?php echo base_url(); ?>admin/sim/vouchers/ajax-list?network=<?php echo $this->input->get('network') ?>&status=<?php echo $this->input->get('status') ?>&purchase_from=<?php echo $this->input->get('purchase_from') ?>&purchase_to=<?php echo $this->input->get('purchase_to') ?>&keyword=<?php echo $this->input->get('keyword') ?>&from=<?php echo $this->input->get('from'); ?>&to=<?php echo $this->input->get('to'); ?>",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},
			"columnDefs": [{
				"targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
				"orderable": false
			}, ],
		});
	});

	function deleteAction() {
		var inputCount = $('[name="checklist[]"]:checked').length;
		if (inputCount > 0) {
			if (confirm("Do you want to delete selected voucher?") == true) {
				changeActionAndSubmit('admin/sim/vouchers/delete');
			} else {
				userPreference = "Action Cancelled!";
			}
		} else {
			alert('Plese select check box first');
		}
	}

	function changeActionAndSubmit(action) {
		document.getElementById('myform').action = action;
		document.getElementById('myform').submit();
	}
</script>