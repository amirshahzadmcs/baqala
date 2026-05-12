<?php $this->load->view('admin/home/header'); ?>
<style>
	#wait{
		display: none;
		width: 100%;
		height: 100%;
		position: fixed;
		padding: 2px;
		z-index: 9999;
		background: #ffffffde;
		text-align: center;
		padding-top: 17%;
		top: 0;
		bottom: 0;
	}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>No Dues Certificate</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/no-dues">No Dues Certificate</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
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
				<div class="card pb-5">
					<div class="card-body">
						<?php echo form_open("admin/no-dues/print", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "", "target"=>"_blank")); ?>
						
						<div class="row">
							<div class="col-md-4 col-sm-12 mb-3 form-group">
								<label for="rider">Select Rider <span class="required-field">*</span></label>
								<select name="rider" class="form-control select2" id="rider" data-placeholder="Choose Rider..." required>
									<option value="">Select One</option>
									<?php foreach(deliveryBoyList() as $rider){ ?>
									<option value="<?php echo $rider->id;?>"><?php echo $rider->name;?></option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
								<label for="month_of">Select Month: <span class="text-danger">*</span></label>
								<div class="position-relative" id="datepicker4">
									<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker"
									data-date-format="MM yyyy" data-date-min-view-mode="1" name="month_of" id="month_of" autocomplete="off" value="<?php echo $this->input->get('month_of');?>" required>
								</div>
							</div>
							
							<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
								<label for="salary">Rider Salary <span class="text-danger">*</span></label>
								<input id="salary" name="salary" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" required>
							</div>
							<div class="form-group col-lg-12 col-md-4 col-12 mb-3">
								<a href="<?php echo base_url('admin/attendance/list'); ?>"class="btn btn-custom-danger float-end">Reset</a>
								<input type="submit" value="Print Certificate" class="btn btn-custom-success me-2 float-end" />
							</div>
						</div>

						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->




<!-- <div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">
		<div class="x_content">

		</div>
	</div>
</div> -->
<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">
	
	$(document).ready(function() {
		$(document).ajaxStart(function() {
			$("#wait").css("display", "block");
		});
		$(document).ajaxComplete(function() {
			$("#wait").css("display", "none");
		});
		$(document).ajaxError(function() {
			$("#wait").css("display", "none");
		});
	});

	$('#rider').on('change', function() {
		var rider_id = $('#rider option:selected').val();
		$('#salary').val('');
		$('#month_of').val('');
		if(rider_id > 0){
			$.ajax({
				url: "<?php echo base_url() ?>admin/new/nodues/get_rider_detail",
				data: {
					"rider_id": rider_id,
				},
				//dataType:"html",
				type: "POST",
				success: function(data) {
					console.log(data);
					var data = JSON.parse(data);
					$('#salary').val(data.total_salary);
				},
				error: function(response) {
					console.log(response);
				}
			});
		}else{
			alert('Invalid rider');
		}
	});

</script>
