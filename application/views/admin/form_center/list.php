<?php $this->load->view('admin/home/header'); ?>
<style>
	#responseContainer {
		position: fixed;
		width: 93%;
		top: 60px;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	@media only screen and (max-width: 600px) {
		.modal-dialog-aside {
			width: 100% !important;
			max-width: 100% !important;
		}
	}

	.modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal-dialog-aside {
		width: 35%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Form Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/form-center/list'); ?>">Form Center</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if (check_action_permission(get_user_role(), 'form_center', 'delete')): ?>
						<button class="btn btn-custom-danger btn-sm pull-right me-2" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif;
					if (check_action_permission(get_user_role(), 'form_center', 'store')): ?>
						<button class="btn btn-custom-success btn-sm pull-right" title="Add" id="addFormButton"><i class="fa fa-plus"></i> Add New Form</button>
					<?php endif; ?>

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
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
					<?php } ?> <?php }
							$this->admin->removeInfo(); ?>
				<!-- </div> -->
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
						<?php echo form_open('admin/form-center/delete', array("id" => "delete_form")); ?>
						<table id="itemTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>S.No.</th>
									<th>Doc. No.</th>
									<th>EMP ID</th>
									<th>EMP Name</th>
									<th>Iqama No.</th>
									<th>Mobile No.</th>
									<th>Designation</th>
									<th>Department</th>
									<th>Document Type</th>
									<th>Date Issue</th>
									<th>Tools</th>
								</tr>
							</thead>

						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
<div class="modal fade staticBackdrop fixed-left form-center-modal" id="formRequestModal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add Form Request</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row size-inner-section px-2 py-4 mx-1" id="searchSection">
					<form id="searchForm">
						<div class="form-group">
							<label for="search_employee">Search by Emp. ID / Name <span class="text-danger">*</span></label>
							<select class="form-control" class="form-control" placeholder="Search by Emp. Name or Emp. ID" aria-label="Employee Number" name="search_employee" id="search_employee" aria-describedby="button-addon2" required>
								<option value="">Search...</option>
							</select>
						</div>
					</form>
					<div id="searchResponse"></div>
				</div>
				<div id="responseContainer"></div>
				<div id="searchResult" class="mt-4">

				</div>
			</div>
			<div class="modal-footer" id="searchModalFooter">

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script>
	// ---------------- DataTable ----------------
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#itemTable')) {
			$('#itemTable').DataTable().destroy();
		}

		$('#itemTable').DataTable({
			lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
			order: [[0, 'DESC']],
			dom: 'Blfrtip',
			buttons: [
				{ extend: "csv", className: "btn-md" },
				{ extend: "excel", className: "btn-md" },
				{ extend: "pdfHtml5", className: "btn-md" },
				{ extend: "print", className: "btn-md" }
			],
			responsive: true,
			processing: true,
			serverSide: true,
			fixedHeader: true,
			ajax: {
				url: "<?php echo base_url(); ?>admin/form-center/list-ajax",
				type: "POST",
				error: function (request) {
					console.log("DataTable error: ", request);
				}
			},
			columnDefs: [{ targets: [0,1,2,3,4,5,6,7,8,9,10,11], orderable: false }]
		});
	}

	// ---------------- Select2 init function (fresh) ----------------
	function createEmployeeSelect2() {
		// ensure any previous instance is removed
		if ($('#search_employee').hasClass('select2-hidden-accessible')) {
			try { $('#search_employee').select2('destroy'); } catch (e) { console.log('destroy error', e); }
		}

		$('#search_employee').select2({
			placeholder: 'Search...',
			allowClear: true,
			minimumInputLength: 2,
			dropdownParent: $('#formRequestModal'),
			ajax: {
				url: "<?= base_url('admin/form-center/Form_center/employee_list'); ?>",
				type: 'POST',
				dataType: 'json',
				delay: 250,
				cache: false,
				data: function (params) {
					return { search: params.term };
				},
				processResults: function (data) {
					// guard if endpoint returns an object or array
					var arr = data || [];
					console.log('select2 processResults:', arr);
					return {
						results: $.map(arr, function (item) {
							return { id: item.employee_id, text: item.employee_id + ' - ' + item.employee_name };
						})
					};
				},
				error: function (xhr) {
					console.log('Select2 AJAX error:', xhr.responseText);
				}
			},
			escapeMarkup: function (m) { return m; }
		});
	}

	// ---------------- Document ready ----------------
	$(document).ready(function () {
		initializeDataTable();
		// create once initially to avoid undefined behavior
		createEmployeeSelect2();
	});

	// ---------------- Open Add Modal ----------------
	$(document).on('click', '#addFormButton', function () {
		$('#formRequestModal .modal-title').html('Add Form Request');
		$('#searchSection').show();
		resetModalData();

		// force fresh select2 instance
		createEmployeeSelect2();
		$('#search_employee').val(null).trigger('change');

		$('#formRequestModal').modal('show');

		// small delay then focus input inside select2 when modal opens
		// setTimeout(function () {
		// 	try {
		// 		$('#search_employee').select2('open');
		// 		$('.select2-container--open .select2-search__field').focus();
		// 	} catch (e) { /* ignore */ }
		// }, 250);
	});

	// ---------------- On select (user selects an employee) ----------------
	$(document).on('select2:select', '#search_employee', function (e) {
		console.log('select2:select fired', e);

		$('#responseContainer, #searchResponse, #searchResult').html('');
		var formData = $('#searchForm').serialize();

		$.ajax({
			url: "<?php echo base_url('admin/form-center/search-emp'); ?>",
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function (response) {
				console.log('search-emp success:', response);
				if (response.type === 'success') {
					$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
					$('#searchResult').html(response.output_html);
					$('#searchModalFooter').html(`
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
						<button type="submit" form="riderProfileForm" class="btn btn-custom-success">Submit</button>
					`);
				} else {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
				}

				// ---------- CRITICAL: re-initialize select2 fresh for next search ----------
				// destroy and recreate to avoid stale internal state
				try {
					$('#search_employee').select2('destroy');
				} catch (err) { console.log('destroy after select error', err); }

				// tiny delay so destroy completes
				setTimeout(function () {
					createEmployeeSelect2();
					// clear any selected value
					$('#search_employee').val(null).trigger('change');

					// open and focus so user can start typing new search immediately
					setTimeout(function () {
						try {
							//$('#search_employee').select2('open');
							//$('.select2-container--open .select2-search__field').focus();
						} catch (err) { console.log('open/focus error', err); }
					}, 120);
				}, 120);
			},
			error: function (xhr) {
				console.log('search-emp error', xhr.responseText);
				$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');

				// still recreate select2 so user can search again
				try { $('#search_employee').select2('destroy'); } catch (e) {}
				setTimeout(function () { createEmployeeSelect2(); $('#search_employee').val(null).trigger('change'); }, 120);
			}
		});
	});

	// ---------------- If user clears selection manually ----------------
	$(document).on('select2:unselecting', '#search_employee', function (e) {
		console.log('select2:unselecting', e);
		resetModalData();
		// recreate clean instance
		try { $('#search_employee').select2('destroy'); } catch (e) {}
		setTimeout(function () { createEmployeeSelect2(); $('#search_employee').val(null).trigger('change'); }, 120);
	});

	// ---------------- Edit / Detail handlers (unchanged except reuse reset) ----------------
	$(document).on('click', '.form-edit-btn', function () {
		var id = $(this).data('id');
		resetModalData();
		$('#formRequestModal .modal-title').html('Edit Form Request');
		$('#searchSection').hide();

		$.ajax({
			url: "<?php echo base_url('admin/form-center/edit'); ?>",
			type: 'POST',
			data: { id: id },
			dataType: 'json',
			success: function (response) {
				if (response.type === 'success') {
					$('#formRequestModal').modal('show');
					$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
					$('#searchResult').html(response.output_html);
					$('#searchModalFooter').html(`
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
						<button type="submit" form="editProfileForm" class="btn btn-custom-success">Submit</button>
					`);
				} else {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
				}
			},
			error: function (xhr) {
				$('#formRequestModal').modal('show');
				console.log('edit ajax error', xhr.responseText);
				$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');
			}
		});
	});

	$(document).on('click', '.form-detail-btn', function () {
		var id = $(this).data('id');
		resetModalData();
		$('#formRequestModal .modal-title').html('Detail Form Request');
		$('#searchSection').hide();

		$.ajax({
			url: "<?php echo base_url('admin/form-center/detail'); ?>",
			type: 'POST',
			data: { id: id },
			dataType: 'json',
			success: function (response) {
				if (response.type === 'success') {
					$('#formRequestModal').modal('show');
					$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
					$('#searchResult').html(response.output_html);
					$('#searchModalFooter').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>`);
				} else {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
				}
			},
			error: function (xhr) {
				$('#formRequestModal').modal('show');
				console.log('detail ajax error', xhr.responseText);
				$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');
			}
		});
	});

	// ---------------- Modal hide cleanup ----------------
	$('#formRequestModal').on('hidden.bs.modal', function () {
		resetModalData();
		try { $('#search_employee').select2('destroy'); } catch (e) {}
	});

	// ---------------- Utility ----------------
	function resetModalData() {
		$('#searchResult, #searchModalFooter, #searchResponse, #responseContainer').html('');
	}
</script>

