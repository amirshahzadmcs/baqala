<?php $this->load->view('admin/home/header');?>
<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Recharge Voucher Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/sim/vouchers'); ?>">Recharge Vouchers</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/sim/vouchers'); ?>"><i class="fa fa-reply"></i> Back</a>
					
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
					<div class="card-header">Add Voucher Details</div>
					<div class="card-body">
						<?php echo form_open("admin/sim/vouchers/save", array("id" => "demo-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
							<input type="hidden" id="id" name="id" value="" />

							<div class="row py-4">
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="network">Service Provider <span class="text-danger">*</span></label>
									<select name="network" class="form-control select2" id="network" data-placeholder="Choose Network..." required>
										<option value="">-- select --</option>
										<?php if (!empty($networks)) {  
											foreach($networks as $key => $item) { ?>
												<option value="<?php echo $networks[$key]->id; ?>"><?php echo $networks[$key]->network_name; ?></option>
											<?php } } else { ?>
											<option value="" disabled>Add Service Provider</option>
										<?php } ?>
									</select>
									<p class="hint">Select Service Provider</p>
								</div>
								
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_id">Voucher Serial Number <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_id" name="owner_id" maxlength="55" required />
									<p class="hint">Enter voucher serial number</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_name">Value <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_name" name="owner_name" maxlength="15" required />
									<p class="hint">Enter voucher value</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_name">VAT Value <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_name" name="owner_name" maxlength="15" required />
									<p class="hint">Enter voucher vat value</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="owner_name">Voucher Total  Value <span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="owner_name" name="owner_name" maxlength="15" required />
									<p class="hint">Enter voucher total value</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="date_of_purchase">Date Of Purchase <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" required />
									<p class="hint">Enter date of purchase of voucher</p>
								</div>
								<div class="col-md-4 col-sm-12 mb-3 form-group">
									<label for="date_of_purchase">Date Of Expiry <span class="text-danger">*</span></label>
									<input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase" maxlength="150" required />
									<p class="hint">Enter date of expiry of voucher</p>
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

</script>
