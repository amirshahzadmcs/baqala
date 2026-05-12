
<?php $this->load->view('admin/home/header');?>

<style>
.required-field{
	color:#f00;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Logistic Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/rider/list'); ?>">Rider Profile</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/logistic-management/rider/list'); ?>"><i class="fa fa-reply"></i> Back</a>
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
						<div class="employee-profile-pic text-center">
								
							<div class="rounded-circle mb-2" style="width: 100px;margin: auto;">
								<img id="profilePicture" src="<?php echo base_url('images/user-img.png'); ?>" style="width: 100px;
							height: 100px;
							border-radius: 50%;
							margin: auto;">
							</div>
							<div id="searchNameContainer">
								<form id="searchForm">
									<div class="row pt-2 justify-content-center">
										<div class="form-group col-lg-3 col-md-3 col-12 mb-3">
											<select name="search_employee" id="search_employee" class="form-control select2 w-100">
												<?php if(deliveryBoyList()->num_rows() > 0){ ?>
												<option value="">Search Employee</option>
												<?php foreach(deliveryBoyList()->result() as $emp_list) { ?>
													<option value="<?php echo $emp_list->id;?>"><?php echo $emp_list->emp_no; ?> - <?php echo $emp_list->full_name; ?></option>
												<?php } }else{ ?>
													<option value="" disabled>No Employee Found, Add First!</option>
												<?php } ?>
											</select>
										</div>
									</div>
								</form>
							</div>
							<div id="empTitleContainer" class="d-none">
								<div id="empNameContainer" class="pt-2">
									<h5 id="employeeName" class="mb-0">Employee Name</h5>
								</div>
								<button type="button" class="btn btn-link p-0 text-dark" onclick="resetEmpDetail()"><i class="mdi mdi-pencil font-size-16"></i> Search another employee</button>
							</div>
						</div>
						
						<div id="responseContainer"></div>
						<form id="accident_form" method="post" enctype="multipart/form-data" class="form-label-left" data-parsley-validate="" accept-charset="utf-8">
							<div id="searchResult" class="mt-4">

							</div>
						</form>
						
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
	function submitButton() {
		window.onbeforeunload = null;
	}
	
	$(document).ready(function () {
		$('#accident_form').data('initial-state', $('#accident_form').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#accident_form').serialize() != $('#accident_form').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});

	Parsley.addValidator('allselected',
    function (value) {
        return true==(value != '-1')
    });

	$(document).ready(function() {
		$('#search_employee').change(function() {
			// Serialize the form data
			var formData = $('#searchForm').serialize();
			
			$.ajax({
				url: "<?php echo base_url('admin/logistic-management/rider/search-emp');?>",
				type: 'POST',
				data: formData, // Send serialized form data
				dataType: 'json', // Expect JSON response
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResult').html(response.output_html);
						$('#searchNameContainer').addClass('d-none');
						$('#empTitleContainer').removeClass('d-none');
						// Update employee name and profile picture if available
						if (response.emp_name) {
							$('#employeeName').html(response.emp_name);
						}
						if (response.profile_picture_url) {
							$('#profilePicture').attr('src', response.profile_picture_url);
						}
					} else {
						$('#searchResult').html('<div class="alert alert-danger">' + response.message + '</div>');
					}
				},
				error: function() {
					$('#searchResult').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
				}
			});
		});
	});

	function resetEmpDetail(){
		$('#searchNameContainer').removeClass('d-none');
		$('#empTitleContainer').addClass('d-none');
		$('#searchResult').html('');
		$('#search_employee').val('');
		$('#responseContainer').html('');
		$('#profilePicture').attr('src', '<?php echo base_url('images/user-img.png'); ?>');
	}
	
	$(document).ready(function() {
		$('#accident_form').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			//alert(formData);
			$.ajax({
				url: '<?php echo base_url('admin/hr/accidents/submit');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						$('#responseContainer').html('<div class="alert alert-success">' + response.message + '</div>');
						$('#searchResult').html('');
					} else {
						$('#responseContainer').html('<div class="alert alert-danger">' + response.message + '</div>');
					}
				},
				error: function() {
					$('#responseContainer').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
				}
			});
		});
	});
</script>
