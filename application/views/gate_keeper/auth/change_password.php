<?php $this->load->view('gate_keeper/layout/mobile-header'); ?>
<?php if ($this->gatekeeper->getInfo()) {
	$info = explode("--", $this->gatekeeper->getInfo());
	$info_type = $info[0];
	$msg_data = $info[1] ?? '';
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
	<?php } ?> <?php }
			$this->admin->removeInfo(); ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <?php $this->load->view('gate_keeper/layout/profile-sidebar'); ?>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card p-3">
                <div class="card-body" style="min-height: 506px;">
                    <?php $this->load->view('gate_keeper/partials/alert'); ?>

                    <form method="post" action="<?php echo base_url('gate-keeper/update-password') ?>" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                        <div class="form-group mb-3">
                            <label class="control-label col-md-12" for="old_password">Old
                                Password <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <input type="password" id="old_password" name="old_password" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label col-md-12" for="new_password">New
                                Password <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <input type="password" id="new_password" name="new_password" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm_password">Confirm Password <span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <input type="password" id="confirm_password" name="confirm_password" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <input type="submit" name="submit" class="btn btn-success">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end page content-->
<?php $this->load->view('gate_keeper/layout/mobile-footer'); ?>