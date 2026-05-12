<?php $this->load->view('admin/home/header'); ?>

<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
.tab-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}

.request-table .request-sidebar{
	width:250px;height: 385px;padding: 0px;
}
.request-table .request-sidebar .list-group{
	border-radius: 0px;
	max-height: 400px;
    overflow: scroll;
	margin-bottom: -20px;
    padding-bottom: 0px;
}
.request-table .request-sidebar .list-group-item{
	color: #000000;
	font-weight: 500;
}
.request-table .request-sidebar .list-group-item.active {
    color: #000000;
    border: none;
    border-left: 4px solid #0e7e01;
    background-color: #f8f9fa;
    font-weight: 900;
}
/* Hide the delete icon by default */
.delete-icon {
	display: none;
}

/* Show the delete icon when hovering over the row */
.custom-hover-table tbody tr:hover .delete-icon {
	display: inline;
}
.delete-icon button:hover{
	text-decoration: none;
}
.delete-icon button{
	padding: 0px;
	line-height: 0px;
}
@media only screen and (max-width: 600px) {
	.modal-dialog-aside{
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

.select2-container--default .select2-selection--multiple {
    padding-right: 25px;
    position: relative;
}

.select2-container--default .select2-selection--multiple:after {
    content: "\F0140";
    font-family: 'Material Design Icons';
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 25px;
    color: #999;
    pointer-events: none;
}
#approverList {
    list-style: none;
    padding-left: 0;
}
.approver-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.approver-item select {
    flex-grow: 1;
    margin-right: 10px;
}
.remove-approver {
    margin-left: 10px;
}
.approver-section {
    margin-top: 20px;
}
#approverList .list-group-item+.list-group-item {
    border-top-width: 1px;
}
.grab-button{
	background: #dfdfdf;
    color: #000!important;
    border: 0;
    cursor: grabbing !important;
}
.fixed-option {
    color: #007bff;
    font-weight: bold;
}
.badge{
	font-size: 87%;
}
</style>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Requests</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/request'); ?>">Requests</a></li>
                        <li class="breadcrumb-item active">Driving Licence</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <button type="button" class="btn btn-custom-success btn-sm pull-right" title="Add" id="addDlBtn"><i class="fa fa-plus"></i> Add Approval Cycle</button>
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
                    <?php } ?> <?php } $this->admin->removeInfo(); ?>
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
                        <table class="table table-bordered request-table" border="1" cellpadding="0" cellspacing="0">
							<thead class="bg-light">
								<tr>
									<th style="width:250px;"><strong class="text-dark">Types</strong></th>
									<th><strong class="text-dark">Approval Cycles</strong></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="request-sidebar">
										<?php $this->load->view('admin/requests/request-sidebar'); ?>
									</td>
									<td class="p-0">
										<table class="table custom-hover-table" cellpadding="5" cellspacing="0">
											<thead>
												<th>Name</th>
												<th>Employees</th>
												<th>Approvers</th>
												<th width="100px"></th>
											</thead>
											<tbody>
												<?php 
												if($dl_approvals){
												foreach ($dl_approvals as $result) {
													// Calculate number of employees
													$employeeCount = !empty($result->employees_ids) ? count(json_decode($result->employees_ids)) : 0;
													
													// Calculate number of approvers
													$approverCount = !empty($result->approver) ? count(json_decode($result->approver)) : 0;
												?>
													<tr>
														<td>
															<?= htmlspecialchars($result->name) ?> 
															<?php if($result->type == 'default') { ?>
																<span class="badge rounded-pill badge-soft-info px-3 py-2 ms-2">Default</span>
															<?php } ?>
														</td>
														<td><?= $result->is_applicable_to_all == 'yes' ? 'All employees' : $employeeCount; ?></td>
														<td><?= $approverCount ?></td>
														<td align="right">
															<span class="delete-icon">
																<button class="btn btn-link text-dark mt-0 p-0 me-2 edit-leave-btn" style="vertical-align: inherit;" data-setting-id="<?= $result->id ?>">
																	<i class="mdi mdi-pencil-outline font-size-18"></i>
																</button>
																<?php if($result->type == 'custom') { ?>
																<button class="btn btn-link text-danger delete-btn2" data-setting-id="<?= $result->id ?>" data-day="">
																	<i class="dripicons-trash"></i>
																</button>
																<?php } ?>
															</span>
														</td>
													</tr>
												<?php }}else{ ?>
													<tr>
														<td colspan="4">No approvals added!</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
<!-- container-fluid -->

<div class="modal fade fixed-left leaveModal" aria-labelledby="#leaveModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="leaveModalLabel">New Dl Approval Cycles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="leave-modal-body">

				</div>
            </div>
			<div class="modal-footer">
				
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left employeeSelectionModal" aria-labelledby="#selectEmployeeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="selectEmployeeModalLabel">Driving Licence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="employee-selection-body">

				</div>
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Close </button>
					</div>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- Modal for Approver Employee -->
<div class="modal fade fixed-left" id="approverModal" tabindex="-1" role="dialog" aria-labelledby="approverModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside" role="document">
        <div class="modal-content">
			<div class="modal-header">
                <h5 class="modal-title mt-0" id="approverModalLabel">Add Approver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="leave-employee-group mt-2">
					<div style="position: fixed;width: 94%;z-index: 99;background: #fff;top: 59px;padding-top: 10px;border-bottom: 1px solid #eaedf1;">
						<div class="d-flex justify-content-between">
							<div class="input-group mb-2">
								<input type="text" id="searchApprovers" class="form-control" placeholder="Search employees" aria-label="Search employees" autocomplete="off">
								<span class="input-group-text">
									<i class="fas fa-search"></i>
								</span>
							</div>
							<!-- <button class="btn btn-outline-secondary" type="button" id="filterButton">Filters</button> -->
						</div>
					</div>
					
					<ul class="list-group mt-3" id="approverEmpList" style="margin-top: 50px!important;">
						<input type="hidden" id="currentApproverIndex" name="test_currentapprover" value="" />
						<?php foreach(employeeListHelper() as $emp){ ?>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<div>
								<h6 class="mb-0"><?php echo $emp->full_name; ?></h6>
								<small><?php echo $emp->emp_no; ?> - <?php echo $emp->designation_name; ?></small>
							</div>
							<button type="button" class="btn btn-outline-secondary btn-sm addEmpApprover" data-emp-id="<?php echo $emp->id; ?>">
								+ Add
							</button>
						</li>
						<?php } ?>
					</ul>
				</div>
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Close </button>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/home/footer'); ?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script type="text/javascript">
$('#addDlBtn').on('click', function() {
    // Make the AJAX request
    $.ajax({
        url: '<?php echo base_url('admin/hr-module/request/driving-licence/add-form'); ?>',
        method: 'GET',
        success: function(responseHtml) {
            $('.leaveModal').modal('show');
            $('.leave-modal-body').html(responseHtml);
			$('.select2').select2({dropdownCssClass: 'custom-dropdown'});
			//initializeSortable();
			$('#leaveModalLabel').html('Add DL Approval Cycles');
			var footerHtml = `<div class="row">
					<div class="col-md-12">
						<button form="addDlForm" type="submit" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>`;
			$('.leaveModal .modal-footer').html(footerHtml);
        },
        error: function(errorResponse) {
            console.log(errorResponse);
            toastr.error('Error fetching updated data');
        }
    });
});

$('.edit-leave-btn').on('click', function() {
	var id = $(this).data('setting-id');
    // Make the AJAX request
    $.ajax({
        url: '<?php echo base_url('admin/hr-module/request/driving-licence/edit-form'); ?>',
        method: 'GET',
		data: { id: id }, // Send the id as a query parameter
        success: function(responseHtml) {
            $('.leaveModal').modal('show');
			$('.leave-modal-body').html(responseHtml);
			$('.select2').select2({dropdownCssClass: 'custom-dropdown'});
			$('#leaveModalLabel').html('Edit Driving Licence Approval Cycles');
			var footerHtml = `<div class="row">
					<div class="col-md-12">
						<button form="editDlForm" type="submit" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>`;
			$('.leaveModal .modal-footer').html(footerHtml);
        },
        error: function(errorResponse) {
            console.log(errorResponse);
            toastr.error('Error fetching updated data');
        }
    });
});

$(document).on('click', '.delete-btn2', function() {
	var requestId = $(this).data('setting-id');
	var $button = $(this);
	// Show SweetAlert confirmation dialog
	Swal.fire({
		title: 'Are you sure?',
		text: "You won't be able to recover this record!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/request/driving-licence/delete'); ?>',
				method: 'POST',
				data: { dl_id: requestId },
				dataType: 'json',
				success: function(response) {
					if (response.status === 'success') {
						toastr.success(response.message);
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						toastr.error(response.message);
					}
				}.bind(this),
				error: function() {
					toastr.error('Error connecting to server');
				}
			});
		}
	});
});

// Handle Approver Search Functionality
$('#searchApprovers').on('keyup', function() {
	var searchQuery = $(this).val().toLowerCase();
	//console.log('Search Query:', searchQuery); // Log search query
	$('#approverEmpList .list-group-item').each(function() {
		var approverName = $(this).find('h6.mb-0').text().toLowerCase();
		var approverID = $(this).find('small').text().toLowerCase();
		var isVisible = approverName.includes(searchQuery) || approverID.includes(searchQuery);
		//console.log('Item Visible:', isVisible); // Log whether the item will be visible
		
		if (isVisible) {
			$(this).addClass('show-important').removeClass('hide-important');
		} else {
			$(this).addClass('hide-important').removeClass('show-important');
		}
	});
});

// Handle adding an employee as the approver
$('.addEmpApprover').click(function() {
    var empId = $(this).data('emp-id').toString();
    var empName = $(this).closest('li').find('h6.mb-0').text();
    
    var approverIndex = parseInt($('#currentApproverIndex').val()) - 1;
    var approverSelect = $('#approverList .approver-item').eq(approverIndex).find('.approver-select');
    var isDuplicate = false;

	// Check if the selected value is already in any approver_list
	$('input[name="approver_list[]"]').each(function () {
		if ($(this).val() === empId) {
			isDuplicate = true;
			return false;
		}
	});

	if (isDuplicate) {
		toastr.error('This employee is already selected as an approver.');
		$(this).val(null).trigger('change');
	} else {
		// Check if approverSelect was found
		if (approverSelect.length) {
			if (approverSelect.find("option[value='" + empId + "']").length === 0) {
				// If the option does not exist, append it
				var newOption = new Option(empName, empId, true, true);
				approverSelect.append(newOption);
			}
			approverSelect.val(empId).trigger('change');

			// Set the hidden input value for approver_list[]
			$('#approverList .approver-item').eq(approverIndex).find('input[name="approver_list[]"]').val(empId);
			$('#approverList .approver-item').eq(approverIndex).find('input[name="approver_type[]"]').val('employee');

			// Close the modal
			$('#approverModal').modal('hide');
			
			// Optionally update the UI to reflect the selected approver
			$(this).text('x').removeClass('addEmpApprover btn-outline-secondary').addClass('removeEmpApprover btn-outline-danger');
		} else {
			console.error('Approver select dropdown not found for index:', approverIndex);
		}
	}
});

</script>
