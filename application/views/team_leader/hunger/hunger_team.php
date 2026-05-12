<?php $this->load->view('team_leader/layout/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	#messageContainer {
		max-height: 250px;
		overflow: auto;
		margin-bottom: 20px;
	}

	.modal-dialog-aside {
		width: 40%;
		max-width: 80%;
		height: 100%;
		margin: 0;
		transform: translate(0);
		transition: transform .2s;
	}

	.modal-dialog-aside .modal-content {
		height: inherit;
		border: 0;
		border-radius: 0;
	}

	.modal-dialog-aside .modal-content .modal-body {
		overflow-y: auto
	}

	.modal.fixed-left .modal-dialog-aside {
		margin-left: auto;
		transform: translateX(100%);
	}

	.modal.fixed-right .modal-dialog-aside {
		margin-right: auto;
		transform: translateX(-100%);
	}

	.modal.show .modal-dialog-aside {
		transform: translateX(0);
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}

	#responseContainer2 {
		position: absolute;
		width: 94%;
	}
</style>

<!-- start page title -->
<div class="main-content">
	<div class="page-content">
		<div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Hunger Team</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/team-list'); ?>">Hunger Team</a></li>
								<li class="breadcrumb-item active">List</li>
							</ol>
						</div>
					</div>
					<?php $admin_id = $this->session->userdata('admin_id'); ?>
					<div class="col-sm-6 message_place">
						<div class="float-end d-sm-block">
							<!-- <button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button> -->
							<!-- <button type="button" class="btn btn-custom-success btn-sm pull-right" data-bs-toggle="modal" data-bs-target="#createTeamModal" title="Create"><i class="fa fa-plus me-1"></i>Create Team</button> -->
						</div>
						<?php if ($this->admin->getInfo()) {
							$info = explode("--", $this->admin->getInfo());
							$info_type = $info[0];
							$msg_data = $info[1];
							if ($info_type == 1) {
						?>
								<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<strong><?php echo $msg_data; ?></strong>
								</div>

							<?php } else { ?>
								<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<strong><?php echo $msg_data; ?></strong>
								</div>
						<?php }
						}
						$this->admin->removeInfo();  ?>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->


		<div class="container-fluid">
			<div class="page-content-wrapper">
				<div class="row">
					<!-- <div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/logistic-management/hunger/hunger-team'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Team Name</label>
										<input type="search" id="keyword" name="name" placeholder="Search by Team Name" value="<?php echo $this->input->get('name') ? $this->input->get('name') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Team Leader</label>
										<select name="team_leader" class="form-control select2">
											<option value="">[Any]</option>
											<?php foreach ($team_leaders as $leader) : ?>
												<option value="<?php echo $leader->id; ?>" <?php echo $this->input->get('team_leader') == $leader->id ? 'selected' : ''; ?>><?php echo $leader->full_name; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range: </label>
									<div class="input-daterange input-group" data-date-format="MM yyyy" data-date-autoclose="true" data-provide="datepicker">
										<input type="text" class="form-control" name="start_date" placeholder="Start Month" value="<?php echo $this->input->get('start_date'); ?>" data-date-format="MM yyyy" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Month" value="<?php echo $this->input->get('end_date'); ?>" data-date-format="MM yyyy" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>

							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">

								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/logistic-management/hunger/hunger-team'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> -->
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<form id="myform" name="myform" method="post" action="">
									<table id="hunderTeamTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Team Name</th>
												<th>Team leader</th>
												<th>Member In Team</th>
												<th>Created At</th>
												<th>Tools</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- container-fluid -->

<!-- Create Team -->
<div class="modal fade fixed-left createTeamModal" id="createTeamModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="createTeamModalLabel">Create Team</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="responseContainer"></div>
				<div id="searchResult2" class="mt-4">
					<div class="size-inner-section px-1 py-1 mx-1">
						<div class="card-header">Fill Team Detail</div>
						<?php echo form_open("admin/logistic-management/hunger/team-create", array("id" => "createTeamForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<div class="row p-2">
							<div class="col-md-6 col-sm-12 mb-2 form-group">
								<label for="teamName">Team Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="teamName" name="team_name" required />
							</div>

							<div class="col-md-6 col-sm-12 mb-2 form-group">
								<label for="teamLeader">Team Leader <span class="text-danger">*</span></label>
								<select class="form-control select2" name="team_leader" id="teamLeader" data-parsley-errors-container="#teamLeaderError" required>
									<option value="">Choose</option>
									<?php foreach ($team_leaders as $leader) : ?>
										<option value="<?php echo $leader->id; ?>"><?php echo $leader->full_name; ?> (<?php echo $leader->emp_no; ?>)</option>
									<?php endforeach; ?>
								</select>
								<div id="teamLeaderError"></div>
							</div>

							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="Team">Select Team Member <span class="text-danger">*</span></label>
								<select name="team[]" id="Team" class="form-select select2" multiple required data-parsley-errors-container="#teamError">
									<option value="">Choose Team</option>
									<?php foreach ($teams as $team) : ?>
										<option value="<?php echo $team->id; ?>"><?php echo $team->full_name; ?> (<?php echo $team->emp_no; ?>)</option>
									<?php endforeach; ?>
								</select>
								<div id="teamError"></div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="searchModalFooter2">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
				<button type="submit" form="createTeamForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php $this->load->view('team_leader/layout/footer'); ?>
<script src="<?php echo base_url('store_assets/js/hunger-team.js') ?>"></script>