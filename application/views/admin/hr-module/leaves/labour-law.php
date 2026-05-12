<?php $this->load->view('admin/home/header'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	
	.delete-icon button{
		padding: 0px;
    	line-height: 0px;
		text-decoration: none;
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
	.tab-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	/*---- Sidebar ----*/
	.modal .modal-dialog-aside{
		width: 30%;
		max-width:80%; height: 100%; margin:0;
		transform: translate(0); transition: transform .2s;
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
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Leave Types</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr-module/leave-types'); ?>">Leave Types</a></li>
						<li class="breadcrumb-item active">Labor Law Leaves</li>
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
						<!-- Nav tabs -->
						<ul class="nav nav-tabs nav-tabs-custom nav-justified">
							<li class="nav-item">
								<a class="nav-link disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/annual-leave');?>">
									<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
									<span class="d-none d-sm-block">Annual Leave</span> 
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/labour-law');?>">
									<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
									<span class="d-none d-sm-block">Labor Law Leaves</span> 
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link disable-right-click" href="<?php echo base_url('admin/hr-module/leave-types/custom-leaves');?>">
									<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
									<span class="d-none d-sm-block">Custom Leaves</span>   
								</a>
							</li>
						</ul>
						<div class="row">
							<div class="col-md-12">
								<p class="card-title-desc mt-3">By default, Saudi labor law leaves are enabled to ensure your organization is complied with<br> labor law. However, you can set and adjust leaves depending on your organization’s policy.</p>
							</div>
							<div class="col-12">
								<div class="card border">
									<div class="card-body p-0">
										<div class="table-responsive">
											<table class="table table-hover mb-0" id="leave-table">
												<thead>
													<tr style="background: #f9fafb;">
														<th width="33%">Labor Law Leaves</th>
														<th width="33%">Days per year</th>
														<th width="44%" style="text-align: right;">Action</th>
													</tr>
												</thead>
												<tbody id="leave-table-body">
												<?php
													// Check if decoding was successful and the data is an array
													if (count($labour_laws) > 0) {
														foreach ($labour_laws as $laws) {
															// Ensure $edays is correctly used here
															// For simple values in the array, $edays should be a string or number directly
															?>
															<tr>
																<td style="vertical-align: middle;"><?php echo htmlspecialchars($laws['name']); ?></td>
																<td style="vertical-align: middle;"><?php echo htmlspecialchars($laws['days_allowed_per_year']); ?> Days</td>
																<td style="vertical-align: middle;" align="right">
																	<button class="btn btn-link text-dark mt-0 p-0 me-2 edit-labour-law-btn" style="vertical-align: text-bottom;"
																			data-setting-id="<?php echo htmlspecialchars($laws['id']); ?>">
																		<i class="mdi mdi-pencil-outline font-size-18"></i>
																	</button>
																	<span class="status-icon" style="vertical-align: middle;">
																		<input type="checkbox" id="status_<?php echo $laws['id'];?>" data-setting-id="<?php echo htmlspecialchars($laws['id']); ?>" switch="info" name="status" <?php echo ($laws['status'] == 'active') ? 'checked' : ''; ?>>
																		<label for="status_<?php echo $laws['id'];?>" data-on-label="Yes" data-off-label="No"></label>
																	</span>
																</td>
															</tr>
															<?php
														}
													} else {
														echo '<tr><td colspan="3" align="center">No laws found</td></tr>';
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

<div class="modal fade fixed-left labourLawModal" aria-labelledby="#labourLawModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="labourLawModalLabel">Update Labor Law Leave</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<?php echo form_open("admin/hr-module/leave-types/update-labour-law", array("id" => "addlabourLawForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<div class="labour-law-body">

					</div>
				<?php echo form_close(); ?>
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button form="addlabourLawForm" type="submit" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('admin/home/footer'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.disable-right-click');
    
    links.forEach(link => {
        link.addEventListener('contextmenu', function(event) {
            event.preventDefault(); // Prevent the default right-click menu
            //alert('Right-click is disabled on this link.'); // Optional: Add a custom message
        });
    });
});

$('.edit-labour-law-btn').on('click', function() {
    // Retrieve the data-id from the button
    var id = $(this).data('setting-id');
    
    // Make the AJAX request
    $.ajax({
        url: '<?php echo base_url('admin/hr-module/leave-types/edit-labour-law'); ?>',
        method: 'GET',
        data: { id: id }, // Send the id as a query parameter
        success: function(responseHtml) {
            $('.labour-law-body').html(responseHtml);
            $('.labourLawModal').modal('show');
        },
        error: function(errorResponse) {
            console.log(errorResponse);
            toastr.error('Error fetching updated data');
        }
    });
});

$(document).ready(function() {
    $('input[name="status"]').each(function() {
        $(this).data('original-status', $(this).is(':checked') ? 'active' : 'inactive');
    });
});

$(document).on('change', 'input[name="status"]', function() {
    var $checkbox = $(this);
    var id = $checkbox.data('setting-id');
    var newStatus = $checkbox.is(':checked') ? 'active' : 'inactive';
    var originalStatus = $checkbox.data('original-status');

    $.ajax({
        url: '<?php echo base_url('admin/hr-module/leave-types/update-labour-law-status'); ?>',
        method: 'POST',
        data: { id: id, status: newStatus },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Update the stored original status
                $checkbox.data('original-status', newStatus);
                toastr.success(response.message);
            } else {
                // Revert checkbox to original status on error
                $checkbox.prop('checked', originalStatus === 'active');
                toastr.error(response.message);
            }
        },
        error: function(errorResponse) {
            // Revert checkbox to original status on error
            $checkbox.prop('checked', originalStatus === 'active');
            console.log(errorResponse);
            toastr.error('Error updating status');
        }
    });
});

</script>
