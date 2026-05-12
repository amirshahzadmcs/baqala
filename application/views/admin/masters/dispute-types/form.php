<?php $this->load->view('admin/home/header'); ?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Master Disputes Type</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/masters/dispute-types'); ?>">Disputes Type List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/masters/dispute-types'); ?>"><i class="fa fa-reply"></i> Back</a>
					
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

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
						</div>																														?></div> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>																														?></div> -->
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
						<?php echo form_open("admin/masters/dispute-types/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

						<div class="row">
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="dispute_type_en">Dispute Type (English) <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="dispute_type_en" name="dispute_type_en" maxlength="250" value="<?php echo $dispute_type_en; ?>" required />
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="dispute_type_ar">Dispute Type (Arabic) <span class="required-field">*</span></label>
								<input type="text" class="form-control rtl-input" id="dispute_type_ar" name="dispute_type_ar" maxlength="250" value="<?php echo $dispute_type_ar; ?>" required />
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

<?php $this->load->view('admin/home/footer'); ?>

