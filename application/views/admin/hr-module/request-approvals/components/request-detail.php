<style> 
.dropify-wrapper .dropify-message span.file-icon {
    font-size: 30px;
    color: #CCC;
}
.dropify-wrapper .dropify-message p {
	margin: 0;
    font-size: 12px;
}
.vertical-line {
	position: absolute;
    left: 6%;
    top: 133px;
    bottom: 78px;
    width: 0px;
    height: auto;
    background-color: #8d8d8d;
    z-index: 0;
    padding: 1px;
}
.correction-comment {
	background-color: #f5f5f5;
    border-color: #f5c6cb;
    padding: 10px;
    position: relative;
    z-index: 1;
    border-radius: 5px;
    margin-bottom: 10px;
}
.image-lightbox {
	height: 120px;
    overflow: hidden;
    border: 1px dashed #ddd;
    padding: 5px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0" id="requestDetailModalLabel"><?= addSpaceBetweenWords($request_info['request_type']);?></h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-0">
	<div class="py-2">
		<ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">
					<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
					<span class="d-none d-sm-block">Request details</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">
					<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
					<span class="d-none d-sm-block">Approvals and Comments</span>
				</a>
			</li>
		</ul>
		<div class="tab-content px-2 py-3">
			<div class="tab-pane active" id="tab1" role="tabpanel">
				<div class="card border p-2 mx-1">
					<?php if (!empty($request_info['requester_name'])) : ?>
						<div class="card-header px-2 py-1 font-size-12">
							Requested by <span class="text-primary"><?= $request_info['requester_name']; ?> <?= $request_info['requester_arabic_name']; ?></span>
						</div>
					<?php endif; ?>
					<div class="card-body pt-2 pb-1 px-2">
						<div class="row justify-content-between font-size-12">
							<div class="col-md-8">
								<?= $request_info['employee_name']; ?><br>
								<?= $request_info['emp_no']; ?> <?= $request_info['designation_name']; ?>
							</div>
							<div class="col-md-4 text-end">
								<?= date('d M, Y', strtotime($request_info['request_date'])); ?><br>
								<?= date('h:i A', strtotime($request_info['request_date'])); ?>
							</div>
						</div>

						<div class="row justify-content-between font-size-12 text-muted pt-3">
							<div class="col-md-5">
								<i class="mdi mdi-clipboard-text-outline align-middle me-1 font-size-14"></i> ID
							</div>
							<div class="col-md-7 text-end">
								<?= $request_info['id']; ?>
							</div>
						</div>
						<div class="row border-top my-2"></div>
						<div class="row justify-content-between font-size-12 text-muted">
							<div class="col-md-5">
								<i class="mdi mdi-clipboard-text-outline align-middle me-1 font-size-14"></i> Request Type
							</div>
							<div class="col-md-7 text-end">
								<span class="badge rounded-pill badge-soft-info px-2 py-1 font-size-12"><?= addSpaceBetweenWords($request_info['request_type']); ?></span>
							</div>
						</div>
						<div class="row border-top my-2"></div>
						<div class="row justify-content-between font-size-12 text-muted">
							<div class="col-md-5">
								<i class="mdi mdi-progress-check align-middle me-1 font-size-14"></i> Status
							</div>
							<div class="col-md-7 text-end">
								<?php
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
								$status = $statusMapping[$request_info['request_status']] ?? ['label' => 'Unknown', 'badgeClass' => 'badge-soft-info'];
								?>
								<span class="badge rounded-pill <?= $status['badgeClass'] ?> px-2 py-1 font-size-12"><?= $status['label'] ?></span>
							</div>
						</div>
						<?php
						$requestDetails = $request_info['request_detail'];
						?>
						<?php
						if (!empty($requestDetails)) :
							$assetDetails = get_asset_details($requestDetails);
						?>
							<?php if (!empty($assetDetails)) : ?>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="dripicons-to-do align-middle me-1"></i> Asset Items
									</div>
									<div class="col-md-7 text-end">
										<?php foreach ($assetDetails as $asset) : ?>
											<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
												<i class="mdi mdi-text-box-check-outline align-middle"></i> <?= $asset['categoryName']; ?>
											</span>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
							<?php
							$requestDetailArray = json_decode($requestDetails);
							if ($request_info['request_type'] == 'LoanRequest') :
								$calculationType = $requestDetailArray->calculation_type;
								$loanAmount = $requestDetailArray->amount;
								$specifiedValue = $requestDetailArray->specified_value;
								$deductionStartDate = $requestDetailArray->deduction_start_date;
								$installments = 0;

								// Calculate Monthly Deduction and Installments
								if ($calculationType == 'specified_amount') {
									$monthlyAmt = $specifiedValue;
									$installments = ceil($loanAmount / $monthlyAmt);
								} elseif ($calculationType == 'specified_months') {
									$monthlyAmt = $loanAmount / $specifiedValue;
									$installments = $specifiedValue;
								}

								// Calculate Deduction Period
								$startDate = new DateTime($deductionStartDate);
								$endDate = clone $startDate;
								$endDate->modify('+' . ($installments - 1) . ' months');
								$deductionPeriod = $startDate->format('M Y') . ' - ' . $endDate->format('M Y');
							?>

								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fas fa-ticket-alt align-middle me-1"></i> Loan Amount
									</div>
									<div class="col-md-7 text-end">
										<?= number_format($loanAmount, 2) . ' SAR'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fas fa-divide align-middle me-1"></i> Monthly Deduction
									</div>
									<div class="col-md-7 text-end">
										<?= number_format($monthlyAmt, 2) . ' SAR'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fas fa-divide align-middle me-1"></i> Installment
									</div>
									<div class="col-md-7 text-end">
										<?= $installments . ' Months'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fas fa-divide align-middle me-1"></i> Period of deduction
									</div>
									<div class="col-md-7 text-end">
										<?= $deductionPeriod; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ($request_info['request_type'] == 'TransactionRequest') : ?>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fas fa-ticket-alt align-middle me-1"></i> Transaction Amount
									</div>
									<div class="col-md-7 text-end">
										<?= $requestDetailArray->amount . ' SAR'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="far fa-plus-square align-middle me-1"></i> Payment Date
									</div>
									<div class="col-md-7 text-end">
										<?= date('d M Y', strtotime($requestDetailArray->payment_date)); ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="far fa-plus-square align-middle me-1"></i> Effective Date
									</div>
									<div class="col-md-7 text-end">
										<?= date('d M Y', strtotime($requestDetailArray->effective_date)); ?>
									</div>
								</div>
							<?php endif; ?>
							<?php if ($request_info['request_type'] == 'VehicleAllotmentRequest') : ?>
								<?php $vehicle_id = isset($requestDetailArray->vehicle_id) ? $requestDetailArray->vehicle_id : ''; ?>
								<?php if (!empty($vehicle_id)) : ?>
									<?php $vehicleInfo = vehicleDetailHelper($vehicle_id); ?>
									<?php if (!empty($vehicleInfo)) : ?>
										<div class="row border-top my-2"></div>
										<div class="row justify-content-between font-size-12 text-muted">
											<div class="col-md-5">
												<?php echo ($vehicleInfo->vehicle_type == 'car') ? '<i class="mdi mdi-car-side align-middle font-size-14"></i>' : '<i class="mdi mdi-motorbike align-middle font-size-14"></i>'; ?> Vehicle Information
											</div>
											<div class="col-md-7 text-end">
												<?= $vehicleInfo->vehicle_no .' / '. $vehicleInfo->vehicle_model .' / '. $vehicleInfo->make_name; ?>
											</div>
										</div>
										<div class="row border-top my-2"></div>
										<div class="row justify-content-between font-size-12 text-muted">
											<div class="col-md-5">
												<i class="mdi mdi-speedometer align-middle me-1 font-size-14"></i> Meter Reading
											</div>
											<div class="col-md-7 text-end">
												<?= $requestDetailArray->meter_reading; ?>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>
						   <?php if ($request_info['request_type'] == 'ChangeProfessionRequest') : ?>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="mdi mdi-briefcase-off align-middle me-1 font-size-14"></i> Current Profession
									</div>
									<div class="col-md-7 text-end">
										<?= professionDetailHelper($requestDetailArray->current_profession)->profession_name ?? 'N/A'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="mdi mdi-briefcase-check align-middle me-1 font-size-14"></i> New Profession
									</div>
									<div class="col-md-7 text-end">
										<?= professionDetailHelper($requestDetailArray->new_profession)->profession_name ?? 'N/A'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="mdi mdi-account align-middle me-1 font-size-14"></i> Debit Cost To
									</div>
									<div class="col-md-7 text-end">
										<?= $requestDetailArray->debit_cost_to ?? 'N/A'; ?>
									</div>
								</div>
								<div class="row border-top my-2"></div>
								<div class="row justify-content-between font-size-12 text-muted">
									<div class="col-md-5">
										<i class="fa fa-ticket-alt align-middle me-1 font-size-14"></i> Fee
									</div>
									<div class="col-md-7 text-end">
										<?= $requestDetailArray->fee_amount .' SAR' ?? 'N/A'; ?>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>

				<div class="card border p-2 mx-1">
					<div class="card-body pt-2 pb-1 px-2">
						<div class="row justify-content-between font-size-12 text-muted">
							<div class="col-md-12">
								<h6>Reason</h6>
							</div>
							<div class="col-md-12">
								<p><?= $request_info['reason']; ?></p>
							</div>
							<?php if ($request_info['request_type'] == 'NoticesAndWarning') : ?>
								<div class="col-md-12">
									<h6>Notices and Warning Detail:</h6>
									<p class="mb-1"><span class="text-dark">Type:</span> <?= $requestDetailArray->type; ?></p>
									<p class="mb-1"><span class="text-dark">Title:</span> <?= $requestDetailArray->title_english; ?></p>
									<p><?= $requestDetailArray->description_english; ?></p>
									<p><a href="<?php echo base_url('admin/hr-module/requests/print-warning-request/'.$request_info['id']);?>" target="_blank">Export as PDF</a></p>
								</div>
							<?php endif; ?>
						</div>
						<?php if (!empty($request_info['request_documents'])) : ?>
							<div class="row border-top my-2"></div>
							<div class="row justify-content-between font-size-12 text-muted mb-3">
								<div class="col-md-8">
									<?php
									$requestDocuments = json_decode($request_info['request_documents'], true);
									$documentCount = is_array($requestDocuments) ? count($requestDocuments) : 0;
									?>
									<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
										<i class="dripicons-paperclip align-middle"></i> <?= $documentCount; ?>
									</span>
								</div>
								<div class="col-md-4 text-end">
									<?php if (is_array($requestDocuments) && count($requestDocuments) > 0) { ?>
										<!-- <a class="font-size-18 text-primary me-2" href="<?= base_url('admin/hr-module/requests/view-request-docs?documents=' . urlencode($request_info['request_documents'])); ?>" target="_blank"><i class="far fa-eye"></i></a> -->
										<a class="font-size-18 text-primary" href="<?= base_url('admin/hr-module/requests/download-request-docs?documents=' . urlencode($request_info['request_documents'])); ?>" target="_blank"><i class="dripicons-download"></i></a>
									<?php } else { ?>
										<a class="font-size-18 text-primary" href="<?= base_url($request_info['request_documents']); ?>" download><i class="dripicons-download"></i></a>
									<?php } ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if (!empty($requestDocuments)): ?>
							<div class="popup-gallery d-flex flex-wrap gap-2">
								<?php foreach ($requestDocuments as $document): ?>
									<?php 
										$filePath = base_url(ltrim($document, './'));
										$fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
									?>
									
									<?php if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif'])): ?>
										<!-- Lightbox for image -->
										<a href="<?= $filePath ?>" class="me-2 image-lightbox" title="Image">
											<img src="<?= $filePath ?>" class="img-thumbnail" style="width: 120px; height: auto;">
										</a>
									<?php elseif ($fileExt === 'pdf'): ?>
										<!-- Open PDF in new tab -->
										<a href="<?= $filePath ?>" target="_blank" class="me-2">
											<img src="<?= base_url('admin_assets/icons/pdf.png') ?>" class="img-thumbnail" style="width: 120px;" alt="PDF">
										</a>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php else: ?>
							<p>No documents found.</p>
						<?php endif; ?>



						<?php if (!empty($request_info['uploaded_video'])) : ?>
							<div class="row border-top my-2"></div>
							<div class="row justify-content-between font-size-12 text-muted">
								<div class="col-md-8">
									<?php
									$requestVideo = $request_info['uploaded_video'];
									?>
									<span class="badge rounded-pill badge-soft-secondary px-2 py-1 font-size-12 my-1">
										<i class="mdi mdi-motion-play-outline align-middle"></i> 1
									</span>
								</div>
								<div class="col-md-4 text-end">
									<a class="font-size-18 text-primary me-2" href="<?= base_url($requestVideo); ?>" target="_blank"><i class="far far fa-eye"></i></a>
									<a class="font-size-18 text-primary" href="<?= base_url($requestVideo); ?>" download><i class="dripicons-download"></i></a>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<!--- Approval --->
				<div class="card border p-2 mx-1">
					<div class="card-header bg-white border-bottom pt-2 pb-1 px-2">
						<div class="row justify-content-between font-size-12">
							<div class="col-md-6">
								<h6>Approvals</h6>
							</div>
							<div class="col-md-6 text-end"><a href="javascript:;">Edit Approval Cycle</a> <i class="mdi mdi-arrow-top-right"></i></div>
						</div>
					</div>
					<div class="card-body pt-2 pb-1 px-2">
						<?php if (!empty($request_info['requester_name'])) : ?>
							<div class="card-header p-2 my-2 font-size-12">
								Requested by <span class="text-primary"><?= $request_info['requester_name']; ?> <?= $request_info['requester_arabic_name']; ?></span>
							</div>
						<?php endif; ?>
						<div class="row justify-content-between font-size-12">
							<div class="vertical-line"></div>
							<div class="col-md-1 text-center pe-0"><i class="mdi mdi-account-circle-outline font-size-24 text-muted"></i></div>
							<div class="col-md-7">
								<?= $request_info['employee_name']; ?><br>
								<?= $request_info['emp_no']; ?> <?= $request_info['designation_name']; ?>
							</div>
							<div class="col-md-4 text-end">
								<?= date('d M, Y', strtotime($request_info['request_date'])); ?><br>
								<?= date('h:i A', strtotime($request_info['request_date'])); ?>
							</div>
						</div>

						<div class="row border-top my-2"></div>
						<div class="correctionList">
							<?php $this->load->view('admin/hr-module/request-approvals/components/correction_comments', ['corrections' => $corrections]); ?>
						</div>
						<?php $this->load->view('admin/hr-module/request-approvals/components/approvers-list', ['request_info' => $request_info, 'statusMapping' => $statusMapping]); ?>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab2" role="tabpanel">
				<div class="accordion mx-2 rounded-3" id="accordionExample">
					<div class="accordion-item">
						<h2 class="accordion-header" id="headingOne">
							<button class="accordion-button bg-white text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<b>Comments (<?= count($comments);?>)</b>
							</button>
						</h2>
						<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							<div class="accordion-body">
								<?php echo form_open("admin/hr-module/requests/save-comment", array("id" => "commentForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
									<input type="hidden" name="request_id" value="<?= $request_info['id']; ?>">
									<div class="row justify-content-between font-size-12 mb-3">
										<div class="col-md-1 text-center pe-0"><i class="mdi mdi-account-circle-outline font-size-24 text-muted"></i></div>
										<div class="col-md-11">
											<input type="text" class="form-control" name="comment" placeholder="Type your comment..." required>
										</div>
										<div class="col-md-12 my-2">
											<input type="file" name="attachment" id="attachment" class="dropify"
												accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
												data-max-file-size="2M" data-height="50">
										</div>
										<div class="col-md-12 mt-2">
											<button type="submit" form="commentForm" class="btn btn-info btn-sm float-end">Submit</button>
										</div>
									</div>
								<?php echo form_close(); ?>
								<!-- <div class="row border-top my-2"></div> -->
								<div id="commentSection">
									<?php $this->load->view('admin/hr-module/request-approvals/components/comments', ['comments' => $comments]); ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!--- Approval --->
				<div class="card border p-2 m-2">
					<div class="card-header bg-white border-bottom pt-2 pb-1 px-2">
						<div class="row justify-content-between font-size-12">
							<div class="col-md-6">
								<h6>Approvals</h6>
							</div>
							<div class="col-md-6 text-end"><a href="javascript:;">Edit Approval Cycle</a> <i class="mdi mdi-arrow-top-right"></i></div>
						</div>
					</div>
					<div class="card-body pt-2 pb-1 px-2">
						<?php if (!empty($request_info['requester_name'])) : ?>
							<div class="card-header p-2 my-2 font-size-12">
								Requested by <span class="text-primary"><?= $request_info['requester_name']; ?> <?= $request_info['requester_arabic_name']; ?></span>
							</div>
						<?php endif; ?>
						<div class="row justify-content-between font-size-12">
							<div class="vertical-line"></div>
							<div class="col-md-1 text-center pe-0"><i class="mdi mdi-account-circle-outline font-size-24 text-muted"></i></div>
							<div class="col-md-7">
								<?= $request_info['employee_name']; ?><br>
								<?= $request_info['emp_no']; ?> <?= $request_info['designation_name']; ?>
							</div>
							<div class="col-md-4 text-end">
								<?= date('d M, Y', strtotime($request_info['request_date'])); ?><br>
								<?= date('h:i A', strtotime($request_info['request_date'])); ?>
							</div>
						</div>

						<div class="row border-top my-2"></div>
						<div class="correctionList">
							<?php $this->load->view('admin/hr-module/request-approvals/components/correction_comments', ['corrections' => $corrections]); ?>
						</div>
						<?php $this->load->view('admin/hr-module/request-approvals/components/approvers-list', ['request_info' => $request_info, 'statusMapping' => $statusMapping]); ?>
					</div>
				</div>
			</div>
		</div>
		<div id="correctionSection" class="p-3 pt-0">
			
		</div>
	</div>
</div>
<?php 
$loginUserId = $this->admin->getLoginEmpId();
if ($request_info['request_status'] == '1' && ($request_info['current_approver_id'] == $loginUserId || $loginUserId == 1)) : ?>
	<div class="modal-footer" id="detailModalFooter">
		<div class="row w-100">
			<div class="col-md-6">
				<a class="btn btn-link text-danger float-start" onclick="getCorrectionForm()"><b>Return for correction</b></a>
			</div>
			<div class="col-md-6">
				<button type="button" id="approveButton" class="btn btn-success btn-md float-end">Approve</button>
				<button type="button" class="btn btn-outline-danger btn-md float-end me-2" onclick="getStatusForm()">Reject </button>
			</div>
		</div>
	</div>
<?php endif; ?>

<script>
	$(document).ready(function() {
		$('.dropify').dropify();
	});

	// Function to get correction form
	function getCorrectionForm() {
		var requestId = $('input[name="request_id"]').val();
		$.ajax({
			url: "<?php echo base_url('admin/hr-module/requests/get-correction-form'); ?>",
			method: 'GET',
			data: { request_id: requestId },
			success: function(response) {
				try {
					if (typeof response === "string") {
						response = JSON.parse(response);
					}
					if (response.type === 'success') {
						$('#detailModalFooter').hide();
						$('#correctionSection').html(response.message);
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
				toastr.error('Failed to load correction form.');
			}
		});
	}

	// Function to get status form
	function getStatusForm() {
		var requestId = $('input[name="request_id"]').val();
		$.ajax({
			url: "<?php echo base_url('admin/hr-module/requests/get-status-form'); ?>",
			method: 'GET',
			data: { request_id: requestId },
			success: function(response) {
				try {
					if (typeof response === "string") {
						response = JSON.parse(response);
					}
					if (response.type === 'success') {
						$('#detailModalFooter').hide();
						$('#correctionSection').html(response.message);
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
				toastr.error('Failed to load correction form.');
			}
		});
	}

	$(document).ready(function() {
		$('#commentForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/save-comment');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						toastr.success(response.message);
						// Clear the form
						$('#commentForm')[0].reset();
						// Refresh the comments section
						refreshComments();
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error(response.message);
				}
			});
		});

		// Function to refresh the comments section
		function refreshComments() {
			var requestId = $('input[name="request_id"]').val();
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/get-comments'); ?>',
				type: 'GET',
				data: { request_id: requestId },
				success: function (html) {
					$('#commentSection').html(html);
				},
				error: function () {
					toastr.error("Failed to refresh comments.");
				}
			});
		}

		$('#approveButton').click(function(e) {
			e.preventDefault();

			var $btn = $(this); // reference to the button
			var originalText = $btn.text(); // store original text
			var requestId = $('input[name="request_id"]').val();

			// Disable button and change text
			$btn.prop('disabled', true).text('Saving...');

			$.ajax({
				url: '<?php echo base_url('admin/hr-module/requests/approve-request-status'); ?>',
				type: 'POST',
				data: { request_id: requestId },
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#correctionSection').html('');
						refreshComments();
						if (response.reload) {
							setTimeout(function() {
								location.reload();
							}, 1000);
						}
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error("Something went wrong while processing your request.");
				},
				complete: function() {
					// Re-enable button and restore original text
					$btn.prop('disabled', false).text(originalText);
				}
			});
		});


	});
</script>