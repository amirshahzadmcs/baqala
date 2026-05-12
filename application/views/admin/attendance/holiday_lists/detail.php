
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
	input, textarea, select, select.select2{
		pointer-events: none;
	}
	input[type=checkbox] +label {
		pointer-events: none;
	}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Holiday Detail</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/holidays-list'); ?>">Holiday List</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/holidays-list'); ?>"><i class="fa fa-reply"></i> Back</a>
					
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
						<!-- Tab panes -->
						<div class="tab-content p-3 text-muted">
							<div class="tab-pane active" id="home1" role="tabpanel">
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">Holiday List Information</h4><hr>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="group_title">Name <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="group_title" name="group_title" value="<?php echo $group->group_title; ?>" maxlength="25" onBlur="checkDuplicateName()" required />
										<small class="hint res-msg">Enter Unique Holiday Name</small>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="group_title_ar">Arabic Name</label>
										<input type="text" class="form-control rtl-input" id="group_title_ar" name="group_title_ar" value="<?php echo $group->group_title_ar; ?>" maxlength="120" />
										<small class="hint">Enter Arabic Holiday Name</small>
									</div>
								</div>
								<div class="row size-inner-section px-2 py-4 family-container">
									<h4 class="header-title">Select Holidays (Days Off):</h4><hr>
									<table id="family_sections" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<td class="text-left" style="width: 10%;">Serial<span class="required-field">*</span></td>
												<td class="text-left" style="width: 25%;">Date <span class="required-field">*</span></td>
												<td class="text-left">Title <span class="required-field">*</span></td>
												<td class="text-left">Arabic Title</td>
											</tr>
										</thead>
										<tbody>
											<?php if(count($days) > 0){ ?>
											<?php $count_days = 1;foreach($days as $h_days){ ?>
											<tr class="family-inner-section">
												<td><?php echo $count_days++;?></td>
												<td class="text-left">
													<input type="date" class="form-control" name="date_off[]" value="<?php echo $h_days['date_off'];?>" required>
												</td>
												<td class="text-left">
													<div class="input-group">
														<input type="text" name="title[]" class="form-control" value="<?php echo $h_days['title'];?>" maxlength="120" required>
													</div>
												</td>
												<td class="text-left">
													<div class="input-group">
														<input type="text" name="title_ar[]" class="form-control rtl-input" value="<?php echo $h_days['title_ar'];?>" maxlength="120">
													</div>
												</td>
											</tr>
											<?php }} ?>
										</tbody>

									</table>
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

<?php $this->load->view('admin/home/footer');?>

