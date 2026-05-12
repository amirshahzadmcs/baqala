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

	.icon-with-shadow {
		cursor: pointer;
		display: inline-block;
		font-size: 18px;
		color: #333;
		text-align: center;
		line-height: 1;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
		transition: box-shadow 0.3s ease;
	}

	.icon-with-shadow:hover {
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 40px rgba(0, 0, 0, 0.2);
	}

	.rider-detail {
		border: 1px solid #eaeaea;
		padding: 20px;
		border-radius: 10px;
		background-color: #ffffff;
	}

	.rider-info h4 {
		font-weight: bold;
	}

	.rider-info small {
		color: #6c757d;
	}

	.rider-details dl {
		margin-bottom: 0;
	}

	.rider-details dt {
		font-weight: bold;
	}

	.rider-details dd {
		margin-bottom: 10px;
		color: #333;
	}

	.modal-header .modal-title {
		font-weight: bold;
	}

	.modal-body {
		padding: 1.5rem;
	}

	.size-inner-section {
		background-color: #ffffff;
		border-radius: 8px;
		padding: 15px;
	}

	.img-fluid {
		max-width: 80px;
		height: auto;
		border-radius: 50%;
		margin-bottom: 15px;
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
								<li class="breadcrumb-item"><a href="<?php echo base_url('team_leader'); ?>">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('team_leader/logistic-management/hunger/team-list'); ?>">Hunger Team</a></li>
								<li class="breadcrumb-item active">View</li>
							</ol>
						</div>
					</div>
					<?php $team_leader_id = $this->session->userdata('team_leader_id'); ?>
					<div class="col-sm-6 message_place">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('team-leader/hunger/team') ?>"><i class="fa fa-reply"></i> Back</a>
							<!-- <a href="<?php //echo base_url('team_leader/logistic-management/hunger/print-hunger-team?team_id=' . $this->input->get('team_id')); 
											?>" class="btn btn-custom-success btn-sm pull-right" title="Print" target="_blank">
						<i class="fa fa-print me-1"></i>Print Pdf
					</a> -->
						</div>
						<?php if ($this->teamleader->getInfo()) {
							$info = explode("--", $this->teamleader->getInfo());
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
						$this->teamleader->removeInfo(); ?>
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
							<div class="card-body p-0">
								<div class="row px-2 py-4 mx-2">
									<div class="w-50">
										<h4 class="header-title float-start">Team Information</h4>
									</div>
									<table class="table">
										<tr>
											<td>Name :</td>
											<td><span id="teamName"></span></td>
											<!-- <td rowspan="2" class="align-content-center">
										<button type="button" class="btn btn-custom-success btn-sm pull-right" title="Change" onclick="editTeam(this)">
											<i class="fa fa-pencil-alt me-1"></i>Add Team Member
										</button>
									</td> -->
										</tr>
										<tr class="border-white">
											<td>Team Leader :</td>
											<td id="teamLeader"></td>
										</tr>

									</table>
								</div>
								<div class="row px-2 py-4 mx-2">
									<div class="w-50">
										<h4 class="header-title float-start">Team Members</h4>
									</div>

									<div class="teamMembers">
										<table class="table border">
											<thead>
												<tr>
													<th>S.No.</th>
													<th>Emp. No.</th>
													<th>Full Name</th>
													<th>Mobile No.</th>
													<th>Plateform</th>
													<th>Joining Date</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody id="teamData">
											</tbody>
										</table>
									</div>
								</div>
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
<div class="modal fade fixed-left editTeamModal" id="editTeamModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="editTeamModalLabel">Team Detail</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="responseContainer"></div>
				<div id="searchResult2" class="mt-4">
					<div class="size-inner-section px-1 py-1 mx-1">
						<?php echo form_open("team-leader/hunger/team_update", array("id" => "editTeamForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="teamId" name="teamId" value="">
						<div class="row p-2">
							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="teamName">Team Name<span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="team_name" name="team_name" required />
							</div>
							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="teamLeader">Team Leader <span class="text-danger">*</span></label>
								<select class="form-control select2" name="team_leader" id="team_leader" data-parsley-errors-container="#teamLeaderError" required>
								</select>
								<div id="teamLeaderError"></div>
							</div>
							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="Team">Add Team Member<span class="text-danger">*</span></label>
								<select name="team[]" id="Team" class="form-select select2" multiple data-parsley-errors-container="#teamError">
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
				<button type="submit" form="editTeamForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
			</div>
		</div>
	</div>
</div>
<!-- /.modal -->


<!-- Move Team Member-->
<div class="modal fade fixed-left moveTeamModal" id="moveTeamModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="moveTeamModalLabel">Member Move</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mt-4">
					<div class="size-inner-section px-1 py-1 mx-1">
						<?php echo form_open("team_leader/logistic-management/hunger/team_member_moveUpdate", array("id" => "moveTeamForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
						<input type="hidden" id="fromTeamId" name="fromTeamId" value="">
						<input type="hidden" id="teamMemberId" name="teamMemberId" value="">
						<div class="row p-2">
							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="teamLeader">Move To<span class="text-danger">*</span></label>
								<select class="form-control select2" name="move_to" id="move_to" data-parsley-errors-container="#teamError" required>
								</select>
								<div id="teamError"></div>
							</div>

							<div class="col-md-12 col-sm-12 mb-2 form-group">
								<label for="teamName">Reason<span class="text-danger">*</span></label>
								<textarea class="form-control" name="memberMoveReason" id="memberMoveReason" placeholder="Enter here..." required></textarea>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="searchModalFooter2">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
				<button type="submit" form="moveTeamForm" class="btn btn-custom-success" id="submitBtn">Submit</button>
			</div>
		</div>
	</div>
</div>
<!-- /.modal -->

<!-- Team Leader View -->

<div class="modal fade fixed-left viewTeamLeaderModal" id="viewTeamLeaderModal" data-bs-backdrop="static" aria-labelledby="#replacementModalModalLabel2" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="viewTeamLeaderModalLabel">Team Leader Information</h5>
				<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="responseContainer"></div>
				<div class="mt-4" id="viewTeamLeaderInformation">
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- Team Leader View End -->
<?php $this->load->view('team_leader/layout/footer'); ?>
<?php $this->load->view('team_leader/layout/mobile_header'); ?>
<div class="header-part-1">
	<div class="d-flex justify-content-between align-items-center">
		<div class="title-back-center">
			<h5>Hunger Team</h5>
		</div>
		<a href="<?php echo base_url('team-leader'); ?>">
			<div class="svg-1">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M4 12L3.29289 11.2929L2.58579 12L3.29289 12.7071L4 12ZM19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11V13ZM9.29289 5.29289L3.29289 11.2929L4.70711 12.7071L10.7071 6.70711L9.29289 5.29289ZM3.29289 12.7071L9.29289 18.7071L10.7071 17.2929L4.70711 11.2929L3.29289 12.7071ZM4 13H19V11H4V13Z"
						fill="#33363F" />
				</svg>
			</div>
		</a>
	</div>
</div>
<div class="container mt-3">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-team-1 mt-13">
				<div class="row">
					<div class="w-100">
						<h4 class="header-title float-start">Team Information</h4>
					</div>
					<div class="content-part-hunger">
						<p>
							<b>Name :</b> &nbsp;<span id="teamNameMobile">Team A</span>
						</p>
						<p>
							<b>Team Leader :</b> &nbsp;<span id="teamLeaderMobile">Mohammed Irfan Afzal Natekar</span>
						</p>
					</div>
					<div class="btn  text-left">
						<button class="btn btn-success samll-theme" id="teamLeaderButtonMobile" type="button" data-bs-toggle="modal"
							data-bs-target="#staticBackdrop" onclick="getTeamLeader(this)" leader_id=""><i class="fa fa-eye"></i> Team Leader</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="teamMembers new-table table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>Emp. No.</th>
								<th>Full Name</th>
								<th>Mobile No.</th>
								<th>Platform</th>
								<th>Joining Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody id="teamDataMobile">

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Team leader Mobile Modal -->
<div class="modal fade" id="teamLeaderMobileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="teamLeaderMobileModalLabel" aria-hidden="true">
	<div class="modal-dialog team-leader">
		<div class="modal-content custom-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 12L3.29289 11.2929L2.58579 12L3.29289 12.7071L4 12ZM19 13C19.5523 13 20 12.5523 20 12C20 11.4477 19.5523 11 19 11V13ZM9.29289 5.29289L3.29289 11.2929L4.70711 12.7071L10.7071 6.70711L9.29289 5.29289ZM3.29289 12.7071L9.29289 18.7071L10.7071 17.2929L4.70711 11.2929L3.29289 12.7071ZM4 13H19V11H4V13Z" fill="#33363F"></path>
					</svg>
				</button>
				<h5 class="modal-title custom-header-title" id="teamLeaderMobileModalLabel">Team Leader Information</h5>
			</div>
			<div class="modal-body">
				<div class="mt-4" id="viewTeamLeaderInformationMobile">
					<div class="size-inner-section custom_card_team_detail">
						<!-- <div class="card-header">Team Leader Detail</div> -->
						<div class="employee-detail-1 notfiy">
							<div class="image-2">
								<svg width="72" height="73" viewBox="0 0 72 73" fill="none" xmlns="http://www.w3.org/2000/svg">
									<ellipse cx="36" cy="30.1554" rx="9" ry="9.04663" fill="#35B366" />
									<ellipse cx="36" cy="36.1865" rx="27" ry="27.1399" stroke="#FFCD02" stroke-width="1.2" />
									<path d="M53.6192 56.7144C53.8482 56.5304 53.9405 56.223 53.8377 55.9478C52.7108 52.9314 50.442 50.2721 47.3443 48.3489C44.0898 46.3284 40.1022 45.2332 36 45.2332C31.8978 45.2332 27.9102 46.3284 24.6558 48.3489C21.558 50.2721 19.2892 52.9314 18.1623 55.9478C18.0595 56.223 18.1518 56.5304 18.3808 56.7143C28.6727 64.9803 43.3273 64.9803 53.6192 56.7144Z" fill="white" stroke="#35B366" stroke-width="1.2" stroke-linecap="round" />
								</svg>
								<!-- <img src="https://www.demo5.arinfotech.co/images/user-img.png" class="rounded" width="140"> -->
							</div>
							<div class="team-detail-content-hunger">
								<h5 class="mb-0 mt-0">Mohammed Irfan Afzal Natekar / محمد عرفان أفضل نتكار</h5>
								<span>Team Leader | Operation Department</span>
								<hr class="my-1">
								<div class="bottom-content">
									<p>Name : Team A</p>
									<p>Nationality : Indian </p>
									<p>Mobile No : 0570580603</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php $this->load->view('team_leader/layout/mobile_footer'); ?>
<script src="<?php echo base_url('store_assets/js/hunger-team.js') ?>"></script>

<script>
	$(document).ready(function() {
		teamData(<?php echo $this->teamleader->getId(); ?>);
	});

	$('#editTeamForm').parsley().on('form:submit', function() {
		var form = $(this.$element);
		$.ajax({
			type: "post",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: "json",
			success: function(response) {
				if (response.status) {
					$('#editTeamModal').modal('hide');
					teamData(getUrlParameter('team_id'));
					alertSuccess(response.message);
					form.find('select').val(null).trigger('change');
				} else {
					alertError(response.message);
				}
			}
		});
		return false;
	});

	$('#moveTeamForm').parsley().on('form:submit', function() {
		var form = $(this.$element);
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			dataType: "json",
			success: function(response) {
				if (response.status) {
					$('#moveTeamModal').modal('hide');
					form.trigger('reset');
					teamData(getUrlParameter('team_id'));
					alertSuccess(response.message);
				} else {
					alertError(response.message);
				}
			},
		});
		return false;
	});
</script>