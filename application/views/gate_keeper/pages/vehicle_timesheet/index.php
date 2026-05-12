<?php $this->load->view('gate_keeper/layout/mobile-header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}


	.main-body {
		padding: 15px;
	}

	.main-body hr {
		margin: 0.7rem 0;
	}

	.card {
		box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
	}

	.card {
		position: relative;
		display: flex;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 0 solid rgba(0, 0, 0, .125);
		border-radius: .25rem;
	}

	.card-body {
		flex: 1 1 auto;
		min-height: 1px;
		padding: 1rem;
	}

	.gutters-sm {
		margin-right: -8px;
		margin-left: -8px;
	}

	.gutters-sm>.col,
	.gutters-sm>[class*=col-] {
		padding-right: 8px;
		padding-left: 8px;
	}

	.mb-3,
	.my-3 {
		margin-bottom: 1rem !important;
	}

	.bg-gray-300 {
		background-color: #e2e8f0;
	}

	.h-100 {
		height: 100% !important;
	}

	.shadow-none {
		box-shadow: none !important;
	}

	.mt-2 {
		margin-top: 0px !important;
	}

	@media only screen and (max-width: 600px) {
		.mt-2 {
			margin-top: 6px !important;
		}
		div.dataTables_wrapper div.dataTables_info{
			white-space: break-spaces !important;
		}
	}
	
</style>

<div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<form id="myform" name="myform" method="post" action="">
						<div class="table-rep-plugin">
							<div class="table-responsive mb-0" data-pattern="priority-columns">
								<table id="timesheet-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
											<th>S.No.</th>
											<th>Vehicle No</th>
											<th>Emp No</th>
											<th>Rider Name</th>
											<th>Platform</th>
											<th>Out Time</th>
											<!-- <th>In Time</th> -->
											<th>Km</th>
											<th>Battery</th>
											<th>Tools</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('gate_keeper/layout/mobile-footer'); ?>
<!-- Mobile View End -->
<!--  Vehichle Timesheet View Modal-->
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

<div class="modal fade " id="timesheetViewModal" data-bs-backdrop="static" role="dialog" aria-labelledby="timesheetViewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<h5 class="modal-title mt-0">Detail</h5>
				</div>
				<div>
					<!-- <button type="button" class="btn btn-sm"><i class="fas fa-pencil-alt"></i></button> -->
					<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Vehicle No</label><br>
						<span class="text-muted sheet_view_vehicle_no">Emp No</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Emp No</label><br>
						<span class="text-muted sheet_view_emp_no">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Emp Name</label><br>
						<span class="text-muted sheet_view_name">Human Resources</span>
					</div>
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Km</label><br>
						<span class="text-muted sheet_view_checkOut_km">Human Resources</span>
					</div>
					<!-- <div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Km</label><br>
						<span class="text-muted sheet_view_checkIn_km">Human Resources</span>
					</div> -->
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Battery(%)</label><br>
						<span class="text-muted sheet_view_checkOut_battery">Human Resources</span>
					</div>
					<!-- <div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Battery(%)</label><br>
						<span class="text-muted sheet_view_checkIn_battery">Human Resources</span>
					</div> -->
					<div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check Out Time</label><br>
						<span class="text-muted sheet_view_checkOut_time">Human Resources</span>
					</div>
					<!-- <div class="col-md-3 mb-4 form-group">
						<label class="form-label">Check In Time</label><br>
						<span class="text-muted sheet_view_checkIn_time">Human Resources</span>
					</div> -->

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!--  Vehichle Timesheet View Modal End-->

<script type="text/javascript">
	$(function() {
		$('.checkAll').click(function() {
			if (this.checked) {
				$(".checkboxesall").prop("checked", true);
			} else {
				$(".checkboxesall").prop("checked", false);
			}
		});

		$(".checkboxesall").click(function() {
			var numberOfCheckboxes = $(".checkboxesall").length;
			var numberOfCheckboxesChecked = $('.checkboxesall:checked').length;
			if (numberOfCheckboxes == numberOfCheckboxesChecked) {
				$(".checkAll").prop("checked", true);
			} else {
				$(".checkAll").prop("checked", false);
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('#timesheet-table').dataTable({
			"lengthMenu": [
				[50, 100, 500],
				[50, 100, 500]
			],
			dom: 'Blfrtip',
			buttons: [
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
			processing: true,
			serverSide: true,
			responsive: true,
			fixedHeader: true,
			searching: false,
			pageLength:50,
			ajax: {
				url: "<?php echo base_url() ?>gate-keeper/vehicle/get-list",
				type: "POST",
				error: function(request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
				},
			},

			columnDefs: [{
				targets: [0, 1, 2, 3, 4, 5, 6, 7],
				orderable: false,
			}, ],
		});
	});
</script>