<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	#employeeTable td {
		vertical-align: middle;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.bulkImportModal tbody td,
	.bulkImportModal tbody th,
	.bulkImportModal tbody tr {
		border-color: inherit;
		border-style: solid;
		border-width: 1px;
		padding: 3px 5px !important;
	}

	th {
		white-space: nowrap;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Clinical Visit Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/clinical-report/list'); ?>">Clinical Visit Report</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">

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
						<table id="employeeTable" class="table table-bordered jambo_table" style="width:100%">
							<thead>
								<tr>
									<th>Date</th>
									<th class="text-center">Total Employees</th>
									<th class="text-center">Vehicle No.</th>
									<th class="text-center">Driver Name</th>
									<th class="text-center">Status</th>
									<th class="text-center">Tools</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (count($clinical_reports) > 0) {
									$statusMapping = [
										2 => ['label' => 'Confirmed', 'badgeClass' => 'badge-soft-success'],
									];
									foreach ($clinical_reports as $summary) {
								?>
										<tr>
											<td>
												<?= ((isset($summary['request_date'])) ? date('d F Y', strtotime($summary['request_date'])) : ''); ?>
											</td>
											<td align="center"><?= $summary['employee_count']; ?></td>
											<td align="center">9121 ERA</td>
											<td align="center">Mohammad Wasim</td>
											<?php $status = $statusMapping[2] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info']; ?>
											<td align="center"><span class="badge rounded-pill <?= $status['badgeClass'] ?> px-3 py-2 font-size-12"><?= $status['label'] ?></span></td>
											<td align="center">
												<?php
												echo (check_action_permission(get_user_role(), 'clinical_visit_report', 'view_group_detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" data-request_date="' . $summary['request_date'] . '" onclick="getVisitDetail(\'' . $summary['request_date'] . '\')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>' : '') .
													(check_action_permission(get_user_role(), 'clinical_visit_report', 'print_visit_detail') ? '<button class="btn btn-outline-secondary btn-custom-light btn-sm edit print-visit-btn" title="Print" data-request_date="' . $summary['request_date'] . '">
                                                        <i class="mdi mdi-printer font-size-18"></i>
                                                    </button>' : '');
												?>
											</td>

										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="7" align="center">No Data Found</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade detailModal" aria-labelledby="#detailModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="detailModalLabel">Medical Visit Detail</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="modal-detail-body">

				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	$(document).ready(function() {
		//initializeDataTable();

		$('.print-visit-btn').on('click', function(e) {
			e.preventDefault();
			var request_date = $(this).data('request_date');
			var exportUrl = "<?php echo base_url(); ?>admin/hr-module/clinical-report/print?request_date=" + request_date;
			window.open(exportUrl, '_blank');
		});
	});

	function getVisitDetail(request_date) {
		// Make the AJAX request
		$.ajax({
			url: '<?php echo base_url('admin/hr-module/clinical-report/detail'); ?>',
			method: 'GET',
			data: {
				request_date: request_date
			},
			success: function(responseHtml) {
				var specificDate = new Date(request_date);
				$('#detailModalLabel').html('Medical visit detail of ' + formatDateDMY(specificDate));
				$('.detailModal').modal('show');
				$('.modal-detail-body').html(responseHtml);
			},
			error: function(errorResponse) {
				console.log(errorResponse);
				toastr.error('Error fetching visit data');
			}
		});
	}
</script>