
<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Tax Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/tax-setting/list">Tax Master</a></li>
						<li class="breadcrumb-item active">Add / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/tax-setting/list"><i class="fa fa-reply"></i> Back</a>
					
					&nbsp;
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>

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
						<?php echo form_open("admin/tax-setting/submit", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="<?php echo $id; ?>" />

							<div class="row">
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="title_en">Tax Name (English) <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="title_en" name="title_en" maxlength="90" value="<?php echo $title_en; ?>" required />
									<p class="hint">Enter Tax Name in English</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="title_ar">Tax Name (Arabic) <span class="text-danger">*</span></label>
									<input type="text" class="form-control rtl-input" id="title_ar" name="title_ar" maxlength="90" value="<?php echo $title_ar; ?>" required />
									<p class="hint">Enter Tax Name in Arabic</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="tax_percent">Tax Percent <span class="text-danger">*</span></label>
									<div class="input-group">
										<input type="number" class="form-control" id="tax_percent" name="tax_percent" maxlength="3" value="<?php echo $tax_percent; ?>" required />
										<span class="input-group-text">%</span>
									</div>
									<p class="hint">Enter Tax Percent</p>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group mb-2">
										<label class="control-labe" for="included">Included <span class="text-danger">*</span></label>
										<select name="included" class="form-select">
											<option value="1" <?php echo ($included == '1') ? "selected":"";?>>Inclusive</option>
											<option value="0" <?php echo ($included == '0') ? "selected":"";?>>Exclusive</option>
										</select>
									</div>
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

<?php $this->load->view('admin/home/footer');?>
