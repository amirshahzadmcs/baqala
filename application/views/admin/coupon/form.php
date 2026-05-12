<?php $this->load->view('admin/home/header'); ?>
<style> 
ul.nav-pills li.nav-item{
	width:16.66% !important;
}


@media only screen and (max-width: 1240px) {
  ul.nav-pills li.nav-item{
		width:24% !important;
	}
}
@media only screen and (max-width: 767px) {
  ul.nav-pills li.nav-item{
		width:50% !important;
	}
}

.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #181818 !important;
    background-color: #e7e7e7!important;
}
.nav-tabs-custom .nav-item .nav-link::after {
    background: #005500!important;
}

i.material-icons {
  transition: color 100ms ease-in-out;
  font-size: 2.25em;
  line-height: 55px;
  color: white;
  display: block;
}

.drop {
  display: block;
  position: absolute;
  background: rgba(95, 158, 160, 0.2);
  border-radius: 100%;
  transform: scale(0);
}

.animate {
  -webkit-animation: ripple 0.4s linear;
          animation: ripple 0.4s linear;
}

@-webkit-keyframes ripple {
  100% {
    opacity: 0;
    transform: scale(2.5);
  }
}

@keyframes ripple {
  100% {
    opacity: 0;
    transform: scale(2.5);
  }
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Coupon Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/coupon/list'); ?>">Coupon</a></li>
						<li class="breadcrumb-item active">Add / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url(); ?>admin/coupon/list"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
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
					<div class="card-header">Fill all information below</div>
					<div class="card-body">
						<?php echo form_open("admin/coupon/submit-form", array("id" => "demo-form2", "enctype" => "multipart/form-data", "class" => "form-horizontal form-label-left")); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
						<div class="row">
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="name">Coupon Title<span class="text-danger">*</span></label>
									<input type="text" id="name" name="name" value="<?php echo $name; ?>" required="required" class="form-control">
								</div>
							</div>

							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="coupon_code">Coupon Code<span class="text-danger">*</span></label>
									<input type="text" id="coupon_code" name="coupon_code" value="<?php echo $coupon_code; ?>" placeholder="Eg: SMM020" required="required" class="form-control">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="discount_type">Discount Type<span class="text-danger">*</span></label>
									<select name="discount_type" class="form-select">
										<option value="">Select Type</option>
										<option value="1" <?php echo ($discount_type == '1') ? "selected" : ""; ?>>Flat</option>
										<option value="2" <?php echo ($discount_type == '2') ? "selected" : ""; ?>>Percentage</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="discount">Discount<span class="text-danger">*</span></label>
									<input type="number" id="discount" name="discount" value="<?php echo $discount; ?>" required="required" class="form-control">
								</div>
							</div>

							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="min_price">Min. Price (Min. Price For Discount)<span class="text-danger">*</span></label>
									<input type="number" id="min_price" name="min_price" value="<?php echo $min_price; ?>" min="1" required="required" class="form-control">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="max_discount">Max Discount Price</label>
									<input type="number" id="max_discount" name="max_discount" value="<?php echo $max_discount; ?>" class="form-control">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="date_start">Discount Start Date<span class="text-danger">*</span></label>
									<input type="date" id="date_start" name="date_start" value="<?php echo $date_start; ?>" required="required" class="form-control">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="date_end">Discount End Date<span class="text-danger">*</span></label>
									<input type="date" id="date_end" name="date_end" value="<?php echo $date_end; ?>" required="required" class="form-control">
								</div>
							</div>
							
							<div class="col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="total_coupons">Total Coupons<span class="text-danger">*</span></label>
									<input type="number" id="total_coupons" name="total_coupons" value="<?php echo $total_coupons; ?>" min="1" required="required" class="form-control">
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="status">Status<span class="text-danger">*</span></label>
									<select name="status" class="form-control form-select">
										<option value="1" <?php echo ($status == '1') ? "selected" : ""; ?>>Enable</option>
										<option value="0" <?php echo ($status == '0') ? "selected" : ""; ?>>Disable</option>
									</select>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="description">Coupon Short Description</label>
									<textarea id="textarea" class="form-control" name="description" maxlength="300" rows="5" style="min-height: 200px;"><?php echo $description; ?></textarea>
								</div>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
								<div class="form-group">
									<label class="control-label" for="description2">Coupon Full Description</label>
									<textarea id="description2" class="form-control elm1" name="description2" maxlength="3000" rows="20" style="min-height: 200px;"><?php echo $description2; ?></textarea>
								</div>
								<small style="font-size:12px;color:red;"> NOTE:- Don't copy content directly from word file or any website. Please copy in notepad and then paste</small>
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