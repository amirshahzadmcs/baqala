
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
	}
	.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
		color: #fff !important;
		background-color: #005500!important;
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
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Daily Petrol Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/petrol-summary/index'); ?>">Daily Petrol Report</a></li>
						<li class="breadcrumb-item active">Upload</li>
					</ol>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/petrol-summary/index'); ?>"><i class="fa fa-reply"></i> Back</a>
					
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
						<div class="row">
							<div class="col-md-6">
								<form id="form-upload-user" method="post" autocomplete="off">
									<div class="ajax-response"></div>
									<div class="form-group">
										<label class="control-label">Choose File <small class="text-danger">*</small> (<a href="<?php echo base_url('admin_assets/samples/Petrol_Sample_File.xlsx'); ?>" target="_blank" download>Download Sample File</a>)</label>
										<input type="file" class="form-control" id="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
										<small class="text-danger">Upload excel or csv file only.</small>
										</div>
									<div class="form-group">
										<div class="text-center">
											<div class="user-loader" style="display: none; ">
												<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>
											</div>
										</div>
									</div>
									<div class="form-group mt-2">
										<button type="submit" class="btn btn-success waves-effect waves-light" id="btnUpload">Upload</button>
									</div>
								</form>
							</div>
						</div>
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
		$('#form-upload-user').data('initial-state', $('#form-upload-user').serialize()); // On load save form current state

		// Prevent user from leaving page with inputs with new values
		window.onbeforeunload = function() {
			if ($('#form-upload-user').serialize() != $('#form-upload-user').data('initial-state')) {
				return 'You have unsaved changes! If you leave this page, your changes will be lost.';
			}
		};
	});
</script>
<script>
    $(document).ready(function() {
        $("body").on("submit", "#form-upload-user", function(e) {
            e.preventDefault();
            var data = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('admin/petrol-summary/import') ?>",
                data: data,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function() {
                    $("#btnUpload").prop('disabled', true);
                    $(".user-loader").show();
                }, 
                success: function(result) {
					console.log(result);
                    $("#btnUpload").prop('disabled', false);
                    if($.isEmptyObject(result.error_message)) {
                        $(".ajax-response").html('<div class="alert alert-success" role="alert">'+ result.success_message +'</div>');
						$('#form-upload-user #file').val('');
                    } else {
                        $(".ajax-response").html('<div class="alert alert-danger" role="alert">'+ result.error_message +'</div>');
                    }
                    $(".user-loader").hide();
                },
				error: function(response){
					console.log(response);
				}
            });
        });
    });
</script>
