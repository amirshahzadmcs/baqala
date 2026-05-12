<?php $this->load->view('admin/home/header'); ?>
<style>
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Loans </h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/hr/payroll/loan">Loans List</a></li>
						<li class="breadcrumb-item active">Create / Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") { ?>
						<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/hr/payroll/loan"><i class="fa fa-reply"></i> Back</a>
					<?php } ?>
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
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data; 
																																					?></div> -->
					<?php } else { ?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button><?php //echo $msg_data;
																																					?></div> -->
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

						<input type="hidden" id="id" name="id" value="" />

							<div class="row size-inner-section px-2 py-4">
								<h4 class="header-title">Loan Information</h4>
								<hr>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="employee">Employee <span class="required-field">*</span></label>
								<input type="text" class="form-control"  name="employee" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-6 col-xs-12">
								<div class="form-group mb-2">
									<label class="control-label" for="arabic_employee">Employee (Arabic)</label>
									<input type="text" name="arabic_employee" value="" class="form-control rtl-input">
								</div>
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="Date"> <span class="required-field">Application Date*</span></label>
								<input type="date" class="form-control"  name="application_date" maxlength="150" value="" required />

							</div>
							
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="start_date"> <span class="required-field">Installment Start Date*</span></label>
								<input type="date" class="form-control" id="startdate" name="start_date" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="amount"> <span class="required-field">Amount*</span></label>
								<input type="text" class="form-control"  name="amount" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="arabic_amount"> <span class="required-field">Amount (Arabic)</span></label>
								<input type="text" class="form-control rtl-input"  name="arabic_amount" maxlength="150" value="" />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="ins_amount"> <span class="required-field">Installment Amount*</span></label>
								<input type="text" class="form-control" name="ins_amount" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="arabic_ins_amount"> <span class="required-field">Installment Amount (Arabic)</span></label>
								<input type="text" class="form-control rtl-input" name="arabic_ins_amount" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="ins_period"> <span class="required-field">Installment Period*</span></label>
								<input type="text" class="form-control" name="ins_period" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="arabic_ins_period"> <span class="required-field">Installment Period (Arabic)</span></label>
								<input type="text" class="form-control rtl-input" name="arabic_ins_period" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="tre_account"> <span class="required-field">Treasury Account*</span></label>
								<input type="text" class="form-control" name="tre_account" maxlength="150" value="" required />

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="arabic_tre_account"> <span class="required-field">Treasury Account (Arabic)</span></label>
								<input type="text" class="form-control rtl-input" name="arabic_tre_account" maxlength="150" value="" />
							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="note"> <span class="required-field">Note*</span></label>
								<textarea type="text" class="form-control " name="net_pay" maxlength="150" value=""  row="4" columns="20" required ></textarea>

							</div>
							<div class="col-md-3 col-sm-12 mb-3 form-group">
								<label for="arabic_note"> <span class="required-field">Note(Arabic)</span></label>
								<textarea type="text" class="form-control rtl-input " name="arabic_note" maxlength="150" row="4" columns="20" value="" ></textarea>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!-- end col -->
</div> <!-- end row -->
</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>
