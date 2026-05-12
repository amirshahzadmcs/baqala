<?php $this->load->view('admin/home/header'); ?>

<style>
	.required-field {
		color: #f00;
	}

	.nav-pills .nav-link.active,
	.nav-pills .show>.nav-link {
		color: #fff !important;
		background-color: #005500 !important;
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

	.cv-documents {
		height: 40px;
	}

	.image-container {
		position: relative;
		display: inline-block;
	}

	.image-container .overlay {
		opacity: 0;
	}

	.image-container:hover .overlay {
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
	.modal .modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}


	.modal .modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal .modal-dialog-aside .modal-content .modal-body {
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
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Employee</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/employees'); ?>">Employees</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
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
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo(); ?>
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
						<?php $this->load->view('admin/hr-module/employees/components/top-profile-section'); ?>
						<div class="step-wraper">
							<?php
							$active_step = 6;
							$nav_emp_id = isset($emp_detail->id) ? $emp_detail->id : null;
							$this->load->view('admin/hr-module/employees/components/view_step_navigation', compact('active_step', 'nav_emp_id'));
							?>
						</div>
						<div class="row size-inner-section px-2 py-4 mx-2">
							<div class="justify-content-between d-flex align-items-center mb-3">
								<div>
									<h4 class="header-title">Employee Profile Picture</h4>
								</div>
								<?php if (!empty($emp_docs) && check_action_permission(get_user_role(), 'view_employees', 'export_combined_pdf')): ?>
									<div><a href="<?php echo base_url('admin/hr/employees/export-employee-documents/' . $nav_emp_id); ?>" class="btn btn-custom-white btn-sm font-size-14" target="_blank"><i class="mdi mdi-download"></i> Downnload All</a></div>
								<?php endif; ?>
							</div>
							<div class="employee-documents">
								<table class="table border">
									<thead>
										<tr class="bg-light">
											<th width="200px">Title</th>
											<th class="text-center">Attachment</th>
											<th class="text-center">Description</th>
											<th class="text-center">Date</th>
											<th class="text-center" style="width: 150px;">Tools</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$file_types = FileTypesHelper();

										foreach ($file_types as $type):
											// Filter documents of current type
											$docs_of_type = array_filter($emp_docs, function ($doc) use ($type) {
												return $doc['doc_type'] == $type->file_types;
											});

											if (!empty($docs_of_type)):
												foreach ($docs_of_type as $doc): ?>
													<tr>
														<td class="align-middle"><?php echo htmlspecialchars($type->file_types); ?></td>
														<td align="center" class="align-middle">
															<?php $file_extension = pathinfo($doc['document'], PATHINFO_EXTENSION); ?>
															<img src="<?php echo in_array($file_extension, ['doc', 'docx', 'pdf'])
																			? base_url('admin_assets/icons/attachment.svg')
																			: base_url('admin_assets/icons/image-64.png'); ?>" class="cv-documents" />
														</td>
														<td align="center" class="align-middle"><?php echo htmlspecialchars($doc['description']); ?></td>
														<td align="center" class="align-middle"><?php echo date('d-m-Y h:i A', strtotime($doc['created_at'])); ?></td>
														<td align="center" class="align-middle">
															<?php if (check_action_permission(get_user_role(), 'view_employees', 'view_document')): ?>
																<a class="btn btn-outline-primary btn-custom-light btn-sm waves-effect waves-light"
																	title="View"
																	href="<?php echo base_url($doc['document']); ?>" target="_blank">
																	<i class="mdi mdi-eye font-size-18"></i>
																</a>
															<?php endif;
															if (check_action_permission(get_user_role(), 'view_employees', 'download_document')): ?>
																<a class="btn btn-outline-primary btn-custom-light btn-sm waves-effect waves-light" data-toggle="tooltip" title="Download" href="<?php echo base_url($doc['document']); ?>" download="<?php echo str_replace(' ', '_', $doc['doc_type']) . '_' . $emp_detail->emp_no . '_' . str_replace(' ', '_', $emp_detail->full_name) . '.' . pathinfo($doc['document'], PATHINFO_EXTENSION); ?>"><i class="mdi mdi-download font-size-18"></i></a>
															<?php endif;
															if (check_action_permission(get_user_role(), 'view_employees', 'delete_image')): ?>

																<button class="btn btn-outline-primary btn-custom-light btn-sm remove-cv-image waves-effect waves-light"
																	title="Remove"
																	data-id="<?php echo $doc['id']; ?>">
																	<i class="mdi mdi-delete font-size-18"></i>
																</button>
															<?php endif; ?>
														</td>
													</tr>
												<?php endforeach;
											else: ?>
												<tr>
													<td class="align-middle"><?php echo htmlspecialchars($type->file_types); ?></td>
													<td align="center" class="align-middle">
														<img src="<?php echo base_url('admin_assets/icons/no-attachment.svg'); ?>" class="cv-documents" />
													</td>
													<td align="center" class="align-middle">-</td>
													<td align="center" class="align-middle">-</td>
													<td align="center" class="align-middle">Not Uploaded</td>
												</tr>
										<?php endif;
										endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row size-inner-section px-2 py-4 mx-2">
							<div>
								<h4 class="header-title">Company Documents</h4>
								<hr>
							</div>
							<div class="employee-documents">
								<table class="table border">
									<thead>
										<tr class="bg-light">
											<th width="200px">Title</th>
											<th class="text-center">Attachment</th>
											<th class="text-center">Description</th>
											<th class="text-center">Date</th>
											<th class="text-center" style="width: 150px;">Tools</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$company_files = [
											["title" => "Employee Contract", "id" => '1'],
											["title" => "Offer Letter", "id" => '2'],
											["title" => "Warning Letter", "id" => '3']
										];
										$comp_uploaded_docs = [];
										foreach ($company_docs as $doc) {
											$comp_uploaded_docs[] = $doc['doc_type'];
										}
										?>
										<?php
										$is_first_comp_upload_button_enabled = true;
										?>
										<?php foreach ($company_files as $index1 => $type1): ?>
											<tr>
												<td class="align-middle"><?php echo $type1['title']; ?></td>

												<?php
												$comp_doc_found = false;
												foreach ($company_docs as $doc) {
													if ($doc['doc_type'] == $type1['title']) {
														$comp_doc_found = true;
												?>
														<td align="center" class="align-middle">
															<?php $file_extension = pathinfo($doc['document'], PATHINFO_EXTENSION); ?>
															<img src="<?php echo ($file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'pdf') ? base_url('admin_assets/icons/attachment.svg') : base_url('admin_assets/icons/image-64.png'); ?>" class="cv-documents" />
														</td>
														<td align="center" class="align-middle"><?php echo $doc['description']; ?></td>
														<td align="center" class="align-middle"><?php echo date('d-m-Y h:i A', strtotime($doc['created_at'])); ?></td>
														<td align="center" class="align-middle">
															<a class="btn btn-outline-primary btn-custom-light btn-sm waves-effect waves-light" data-toggle="tooltip" title="View" href="<?php echo base_url($doc['document']); ?>" target="_blank">
																<i class="mdi mdi-eye font-size-18"></i>
															</a>
															<a class="btn btn-outline-primary btn-custom-light btn-sm waves-effect waves-light" data-toggle="tooltip" title="Download" href="<?php echo base_url($doc['document']); ?>" download="<?php echo str_replace(' ', '_', $doc['doc_type']) . '_' . $emp_detail->emp_no . '_' . str_replace(' ', '_', $emp_detail->full_name) . '.' . pathinfo($doc['document'], PATHINFO_EXTENSION); ?>"><i class="mdi mdi-download font-size-18"></i></a>
															<button class="btn btn-outline-primary btn-custom-light btn-sm remove-cv-image waves-effect waves-light" data-toggle="tooltip" title="Remove" data-id="<?php echo $doc['id']; ?>">
																<i class="mdi mdi-delete font-size-18"></i>
															</button>
														</td>
													<?php
														break;
													}
												}
												if (!$comp_doc_found): ?>
													<td align="center" class="align-middle"><img src="<?php echo base_url('admin_assets/icons/no-attachment.svg'); ?>" class="cv-documents" /></td>
													<td align="center" class="align-middle">-</td>
													<td align="center" class="align-middle">-</td>
													<td align="center" class="align-middle">
														Not Uploaded
													</td>
												<?php endif; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="twitter-bs-wizard">
							<ul class="pager wizard twitter-bs-wizard-pager-link">
								<li class="previous"><a href="<?php echo ($emp_detail->id > 0) ? base_url('admin/hr/employees/view/step-5/' . $emp_detail->id) : base_url('admin/hr/employees'); ?>" class="btn btn-custom-secondary"><i class="mdi mdi-arrow-left me-1"></i> Prevoius </a></li>
								<li class="next"><a type="button" href="<?php echo base_url('admin/hr/employees/view/step-7/' . $emp_detail->id); ?>" class="btn btn-custom-success">Next Step <i class="mdi mdi-arrow-right ms-1"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<div class="modal fade fixed-left bs-more-document-upload-modal" aria-labelledby="#exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="exampleModalFullscreenLabel">Add New Employee Document</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="upload_form" action="<?php echo base_url('admin/hr/employees/submit-documents'); ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_detail->id; ?>" required />
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="doc_type">File Type <span class="text-danger">*</span></label>
							<select name="doc_type" id="doc_type" class="form-select" required>
								<option value="">Select File type</option>
								<?php foreach (FileTypesHelper() as $filetype) { ?>
									<option value="<?php echo $filetype->file_types; ?>"><?php echo $filetype->file_types; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="document">Upload File <span class="text-danger">*</span></label>
							<input type="file" name="document" id="document" class="dropify"
								accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
								data-max-file-size="2M" data-height="100">
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="description">Description <span class="text-danger">*</span></label>
							<textarea class="form-control" name="description" autocomplete="off" id="description" rows="5"></textarea>
						</div>

						<div class="col-md-12 mt-2">
							<button type="submit" class="btn btn-success btn-md">Upload</button>
							<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade fixed-left bs-document-upload-comp" aria-labelledby="#exampleModalFullscreenLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="exampleModalFullscreenLabel2">Add New Company Document</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="upload_form2" action="<?php echo base_url('admin/hr/employees/submit-comp-documents'); ?>" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id; ?>" required />
					<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="doc_type">File Type <span class="text-danger">*</span></label>
							<select name="doc_type" class="form-select" required>
								<option value="">Select File type</option>
								<?php foreach (FileTypesHelper() as $filetype) { ?>
									<option value="<?php echo $filetype->file_types; ?>"><?php echo $filetype->file_types; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="document">Upload File <span class="text-danger">*</span></label>
							<input type="file" name="document" class="dropify"
								accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
								data-max-file-size="2M" data-height="100">
						</div>
						<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
							<label for="description">Description <span class="text-danger">*</span></label>
							<textarea class="form-control" name="description" autocomplete="off"></textarea>
						</div>

						<div class="col-md-12 mt-2">
							<button type="submit" class="btn btn-success btn-md">Upload</button>
							<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
	$('.dropify').dropify();

	$('.remove-cv-image').click(function() {
		var img_id = $(this).data('id');
		var emp_id = "<?php echo $emp_detail->id; ?>";
		if (confirm('Are you sure want to delete?')) {
			if (img_id > 0) {
				$.ajax({
					url: "<?php echo base_url('admin/hr/employees/delete-image'); ?>",
					type: "POST",
					data: {
						img_id: img_id,
						emp_id: emp_id,
					},
					dataType: "json",
					success: function(data) {
						if (data.type == 'success') {
							$('#img_' + img_id).remove();
							Swal.fire({
								icon: 'success',
								title: 'Success',
								text: data.message,
								timer: 1500
							}).then((result) => {
								// Reload the Page
								location.reload();
							});
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: data.message,
								timer: 1500
							});
						}
					},
					error: function(data) {
						console.log(data);
					},
				});
			} else {
				return false;
			}
		} else {
			return false;
		}
		return false;
	});

</script>