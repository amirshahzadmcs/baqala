<?php $this->load->view('admin/home/header'); ?>
<style>
	/* Hide the delete icon by default */
	.delete-icon {
		display: none;
		position: absolute;
		width: 70px;
		right: 15px;
	}

	/* Show the delete icon when hovering over the row */
	.table-hover tbody tr:hover .delete-icon {
		display: inline;
	}
	.delete-icon button:hover{
		text-decoration: none;
	}
	.delete-icon button{
		padding: 10px 4px;
    	line-height: 0px;
		vertical-align: top;
	}
	.header-title {
		color: #364152;
		font-size: 17px;
	}
	.card-title-desc {
		color: #364152;
	}
	.bg-info-light{
		background-color: #f4f6fe;
		color: #000;
	}
	.card-bodyquote p{
		margin-left: 22px;
    	margin-bottom: 0px;
	}
	#toast-container > div{
		width: 320px;
	}
	.swal2-icon .swal2-icon-content {
		display: flex;
		align-items: center;
		font-size: 1.75em;
	}
	.swal2-icon {
		width: 3em;
		height: 3em;
	}
	/*---- Sidebar ----*/
	.modal .modal-dialog-aside{
		width: 30%;
		max-width:80%; height: 100%; margin:0;
		transform: translate(0); transition: transform .2s;
	}
	#requestTable th:hover {
		background: #e9e9e9;
	}

	.modal .modal-dialog-aside .modal-content{  height: inherit; border:0; border-radius: 0;}
	.modal .modal-dialog-aside .modal-content .modal-body{ overflow-y: auto }
	.modal.fixed-left .modal-dialog-aside{ margin-left:auto;  transform: translateX(100%); }
	.modal.fixed-right .modal-dialog-aside{ margin-right:auto; transform: translateX(-100%); }

	.modal.show .modal-dialog-aside{ transform: translateX(0);  }

	/*----- End ------*/
	.leave-employee-group .list-group .list-group-item{
		border-bottom: 1px solid #edf1f5 !important;
	}
	#requestTable td.user-name{
		font-size: 12px;
	}
	#requestTable tr{
		cursor: pointer;
	}
	#requestTable td{
		vertical-align: middle;
	}
	.badge-soft-info {
    	color: #0040c1;
	}
	.badge-soft-secondary {
    	color: #44464e;
	}
	.table>:not(caption)>*>* {
    	padding: 0.75rem 0.4rem;
	}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Team Requests</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/requests/team-requests'); ?>">Team Requests</a></li>
						<li class="breadcrumb-item active">All requests</li>
					</ol>
				</div>
			</div>
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
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-custom">
							<?php 
								$currentSegment = $this->uri->segment(5);
								$tabs = [
									'pending' => 'Pending',
									'approved' => 'Approved',
									'rejected' => 'Rejected',
									'expired' => 'Expired',
									'canceled' => 'Canceled',
									'all' => 'All requests'
								];
							?>

							<?php foreach ($tabs as $key => $label): ?>
								<li class="nav-item">
									<a class="nav-link disable-right-click <?php echo ($currentSegment === $key) ? 'active' : ''; ?>" 
									href="<?php echo base_url("admin/hr-module/requests/team-requests/$key"); ?>">
										<span class="d-block d-sm-none">
											<i class="far fa-envelope"></i>
										</span>
										<span class="d-none d-sm-block"><?php echo $label; ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
						<!-- Tab panes -->
						<div class="row pt-2">
							<div class="col-12">
								<div class="card border">
									<div class="card-body p-0">
										<div class="table-responsive">
											<table class="table table-hover mb-0" id="requestTable">
												<thead>
													<tr style="background: #f9fafb;">
														<th width="3%"><input type="checkbox" name="check_all" id="checkAll" class="checkbox" style="vertical-align: middle;" /></th>
														<th width="4%">ID</th>
														<th width="6%">EMP ID</th>
														<th width="17%">Employee</th>
														<th width="37%">Request</th>
														<th width="17%">Approver</th>
														<th width="7%">Status</th>
														<th width="9%">Requested on</th>
														<th width="0.1%" style="text-align: right;"></th>
													</tr>
												</thead>
												<tbody id="requestTableBody">
													<?php
													if (count($requests) > 0) {
														$statusMapping = [
															0 => ['label' => 'Awaiting', 'badgeClass' => 'badge-soft-info'],
															1 => ['label' => 'Pending', 'badgeClass' => 'badge-soft-warning'],
															2 => ['label' => 'Approved', 'badgeClass' => 'badge-soft-success'],
															3 => ['label' => 'Rejected', 'badgeClass' => 'badge-soft-danger'],
															4 => ['label' => 'Expired', 'badgeClass' => 'badge-soft-secondary'],
															5 => ['label' => 'Canceled', 'badgeClass' => 'badge-soft-dark'],
															6 => ['label' => 'Pending correction', 'badgeClass' => 'badge-soft-primary'],
															7 => ['label' => 'Admin Approved', 'badgeClass' => 'badge-soft-success']
														];
														foreach ($requests as $request) {
														$status = $statusMapping[$request['request_status']] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info'];
														$requestedApprovers = getRequestedApprover($request['id']);
														$loginUserId = $this->admin->getLoginEmpId();
														if(in_array($loginUserId, array_column($requestedApprovers, 'approver_id')) || $loginUserId == 1){
													?>
													<tr>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')"><input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="<?= $request['id'] ?>" /></td>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')"><?= $request['id'] ?></td>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')"><?= $request['emp_no'] ?></td>
														<td class="user-name" onclick="viewRequestDetail('<?= $request['id'];?>')"><?= $request['employee_name'] ?><br><?= $request['designation_name'] ?></td>
														<?php
															// Call the helper function
															$requestDetails = $request['request_detail'];
															$assetDetails = get_asset_details($requestDetails);
														?>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')">
															<span class="badge rounded-pill badge-soft-info px-2 py-1 font-size-12"><?= addSpaceBetweenWords($request['request_type']);?></span>
															<?php if (!empty($requestDetails)) : ?>
																<?php if (!empty($assetDetails)) : ?>
																	<?php foreach ($assetDetails as $asset) : ?>
																		<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																			<i class="mdi mdi-text-box-check-outline align-middle"></i> <?= $asset['categoryName']; ?>
																		</span>
																	<?php endforeach; ?>
																<?php endif; ?>
																<?php $requestDetailArray = json_decode($requestDetails);?>
																<?php if ($request['request_type'] == 'LoanRequest' || $request['request_type'] == 'TransactionRequest' || $request['request_type'] == 'NoticesAndWarning') : ?>
																	<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																		<?= (isset($requestDetailArray->type) && !empty($requestDetailArray->type)) ? $requestDetailArray->type : ''; ?>
																	</span>
																	<?= (isset($requestDetailArray->amount) && !empty($requestDetailArray->amount)) ? 
																		'<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																			<i class="fas fa-ticket-alt align-middle"></i> ' . $requestDetailArray->amount . ' SAR
																		</span>' 
																		: ''; 
																	?>
																<?php endif; ?>
																<?php if ($request['request_type'] == 'VehicleAllotmentRequest') : ?>
																	<?php $vehicle_id = isset($requestDetailArray->vehicle_id) ? $requestDetailArray->vehicle_id : ''; ?>
																	<?php if (!empty($vehicle_id)) : ?>
																		<?php $vehicleInfo = vehicleDetailHelper($vehicle_id); ?>
																		<?php if (!empty($vehicleInfo)) : ?>
																			<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-13 my-1">
																				<?php echo ($vehicleInfo->vehicle_type == 'car') ? '<i class="mdi mdi-car-side align-middle"></i>' : '<i class="mdi mdi-motorbike align-middle"></i>'; ?> <?= $vehicleInfo->vehicle_no; ?>
																			</span>
																		<?php endif; ?>
																	<?php endif; ?>
																<?php endif; ?>
															    <?php if ($request['request_type'] == 'ChangeProfessionRequest') : ?>
																	<span class="badge rounded-pill badge-soft-danger px-2 py-1 font-size-12 my-1">
																		<i class="mdi align-middle mdi mdi-briefcase-off"></i> <?= professionDetailHelper($requestDetailArray->current_profession)->profession_name ?? ''; ?>
																	</span>
																	<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																		<i class="mdi align-middle mdi mdi-briefcase-check"></i> <?= professionDetailHelper($requestDetailArray->new_profession)->profession_name ?? ''; ?>
																	</span>
																<?php endif; ?>
															<?php endif; ?>
															<?php if (!empty($request['reason'])) : ?>
																<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																	<i class="mdi mdi-comment-text-outline align-middle"></i> <?= $request['reason']; ?>
																</span>
															<?php endif; ?>
															<?php if (!empty($request['request_documents'])) : ?>
																<?php
																	$requestDocuments = json_decode($request['request_documents'], true);
																	$documentCount = is_array($requestDocuments) ? count($requestDocuments) : 0;
																?>
																<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
																	<i class="dripicons-paperclip align-middle"></i> <?= $documentCount; ?>
																</span>
															<?php endif; ?>
														</td>
														<td onclick="viewRequestDetail('<?= $request['id']; ?>')">
															<?php if ($request['request_status'] == 2): ?>
																<?php 
																$finalApproverId = $request['final_approver'];
																if ($finalApproverId != 0):
																	$finalApprover = employeeDetailHelper($finalApproverId); 
																?>
																	<div class="d-flex align-items-center">
																		<div class="me-2">
																			<img src="<?= base_url(!empty($finalApprover->employee_pic) ? $finalApprover->employee_pic : 'images/user-img.png'); ?>" 
																				class="rounded-circle" 
																				alt="<?= $finalApprover->full_name ?? 'No Name'; ?>" 
																				height="25" width="25">
																		</div>
																		<div>
																			<h5 class="font-size-10 mb-0"><?= $finalApprover->full_name ?? 'No Name'; ?></h5>
																			<p class="font-size-10 mb-0 text-muted"><?= $finalApprover->emp_no ?? ''; ?> - <?= $finalApprover->employee_arabic_name ?? ''; ?></p>
																		</div>
																	</div>
																<?php endif; ?>
															<?php else: ?>
																<?php 
																$approverList = getRequestedApprover($request['id']);
																if (!empty($approverList)):
																	foreach ($approverList as $approver):
																		if ($approver['approver_id'] == $request['current_approver_id']): 
																?>
																			<div class="d-flex align-items-center">
																				<div class="me-2">
																					<img src="<?= base_url(!empty($approver['employee_pic']) ? $approver['employee_pic'] : 'images/user-img.png'); ?>" 
																						class="rounded-circle" 
																						alt="<?= $approver['full_name'] ?? 'No Name'; ?>" 
																						height="25" width="25">
																				</div>
																				<div>
																					<h5 class="font-size-10 mb-0"><?= $approver['full_name'] ?? 'No Name'; ?></h5>
																					<p class="font-size-10 mb-0 text-muted"><?= $approver['emp_no'] ?? ''; ?> - <?= $approver['employee_arabic_name'] ?? ''; ?></p>
																				</div>
																			</div>
																<?php 
																		endif;
																	endforeach;
																endif;
																?>
															<?php endif; ?>
														</td>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')"><span class="badge rounded-pill <?= $status['badgeClass'] ?> px-2 py-1 font-size-12"><?= $status['label'] ?></span></td>
														<td onclick="viewRequestDetail('<?= $request['id'];?>')"><?= date('d M Y', strtotime($request['request_date'])) ?></td>
														<td align="right" style="vertical-align: inherit;">
															<?php if ($request['request_status'] == '1' && $request['status_label'] == 'Pending' && ($request['current_approver_id'] == $loginUserId || $loginUserId == 1)) { ?>
																<span class="delete-icon">
																	<button class="btn btn-success edit-custom-leave-btn quickApproveButton" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve" data-bs-original-title="Approve" style="vertical-align: inherit;" data-setting-id="<?= $request['id'];?>">
																		<i class="mdi mdi-check font-size-18"></i>
																	</button>
																	<button class="btn btn-danger delete-btn2 quickRejectButton" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject" data-bs-original-title="Reject" data-setting-id="<?= $request['id'];?>">
																		<i class="mdi mdi-close font-size-18"></i>
																	</button>
																</span>
															<?php }elseif ($request['request_status'] == '6' && $request['status_label'] !== 'Expired' && $request['request_type'] == 'LoanRequest' && ($request['requested_by'] == $loginUserId || $loginUserId == 1)) { ?>
																<span class="delete-icon">
																	<button class="btn btn-warning edit-custom-leave-btn quickEditButton" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Request" data-bs-original-title="Edit Request" style="vertical-align: inherit;" data-setting-id="<?= $request['id'];?>" onclick="updateRequestDetail(<?= $request['id'];?>)">
																		<i class="mdi mdi-lead-pencil font-size-18"></i>
																	</button>
																</span>
															<?php } ?>
														</td>
													</tr>
													<?php
															}else{
																echo '<tr><td colspan="8" align="center">No request found</td></tr>';
															}
														}
													} else {
														echo '<tr><td colspan="8" align="center">No request found</td></tr>';
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade fixed-left requestDetailModal" aria-labelledby="#requestDetailModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.disable-right-click');
    
    links.forEach(link => {
        link.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    });
});

function viewRequestDetail(requestId) {
    $.ajax({
        url: "<?php echo base_url('admin/hr-module/requests/request-detail'); ?>",
        method: 'GET',
        data: { request_id: requestId },
        success: function(response) {
            try {
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                if (response.type === 'success') {
                    $('.requestDetailModal .modal-content').html(response.message);
                    $('.requestDetailModal').modal('show');
					// Load lightbox script dynamically
					$.getScript("<?= base_url('admin_assets/libs/magnific-popup/jquery.magnific-popup.min.js'); ?>")
						.done(function() {
							$('.image-lightbox').magnificPopup({
								type: 'image',
								gallery: {
									enabled: true
								}
							});
						})
						.fail(function() {
							console.error("Failed to load lightbox script");
						});

                } else {
                    toastr.error(response.message || 'Unable to fetch details.');
                }
            } catch (error) {
                console.error('Error parsing response:', error);
                toastr.error('Invalid server response.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            toastr.error('An error occurred while fetching details.');
        }
    });
}

function updateRequestDetail(requestId) {
    $.ajax({
        url: "<?php echo base_url('admin/hr-module/requests/edit-team-request/'); ?>" + requestId,
        method: 'GET',
        success: function(response) {
            try {
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                if (response.status === 'success') {
                    $('.requestDetailModal .modal-content').html(response.data);
                    $('.requestDetailModal').modal('show');
                } else {
                    toastr.error(response.message || 'Unable to fetch details.');
                }
            } catch (error) {
                console.error('Error parsing response:', error);
                toastr.error('Invalid server response.');
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            toastr.error('An error occurred while fetching details.');
        }
    });
}
	
$(document).ready(function() {
	$('.quickApproveButton').click(function (e) {
		e.preventDefault();
		var requestId = $(this).attr('data-setting-id');
		$.ajax({
			url: '<?php echo base_url('admin/hr-module/requests/approve-request-status');?>',
			type: 'POST',
			data: { request_id: requestId },
			dataType: 'json',
			success: function (response) {
				// Handle server response
				if (response.type === 'success') {
					toastr.success(response.message);
					if (response.reload) {
						setTimeout(function () {
							location.reload();
						}, 1000);
					}
				} else {
					toastr.error(response.message);
				}
			},
			error: function () {
				toastr.error('An error occurred. Please try again.');
			}
		});
	});

	$('.quickRejectButton').click(function (e) {
		e.preventDefault();
		var requestId = $(this).attr('data-setting-id');
		$.ajax({
			url: '<?php echo base_url('admin/hr-module/requests/reject-request-status');?>',
			type: 'POST',
			data: { request_id: requestId },
			dataType: 'json',
			success: function (response) {
				// Handle server response
				if (response.type === 'success') {
					toastr.success(response.message);
					if (response.reload) {
						setTimeout(function () {
							location.reload();
						}, 1000);
					}
				} else {
					toastr.error(response.message);
				}
			},
			error: function () {
				toastr.error('An error occurred. Please try again.');
			}
		});
	});

});
</script>
