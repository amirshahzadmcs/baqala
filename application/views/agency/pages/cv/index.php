<?php $this->load->view('agency/layout/header');?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
			<div class="container-fluid">
				<div class="row align-items-center">
					<div class="col-sm-6">
						<div class="page-title">
							<h4>Manage CV</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
								<li class="breadcrumb-item active">CV List</li>
							</ol>
						</div>
					</div>
					<?php $admin_id = $this->session->userdata('admin_id'); ?>
					<div class="col-sm-6">
						<a class="btn btn-custom-success btn-sm float-end" title="Add New CV" href="<?php echo base_url('hiring-agency/cv/form')?>"><i class="fa fa-plus"></i> Add New CV</a>
						<?php $this->load->view('agency/partials/alert');?>
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
							<div class="card-header">
								<h4 class="header-title mb-0">Search</h4>
							</div>
							<div class="card-body">
								<form action="<?php echo base_url('hiring-agency/cv/list'); ?>" method="get" id="filter_form">
									<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Date Between (From and To)</label>
												<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
													<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
													<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
												</div>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select CV Status </label>
												<select name="cv_status" class="form-select">
													<option value="">[Any CV Status]</option>
													<option value="new" <?php echo ($this->input->get('cv_status') == 'new') ? 'selected':'';?>>New</option>
													<option value="shortlisted" <?php echo ($this->input->get('cv_status') == 'shortlisted') ? 'selected':'';?>>Shortlisted</option>
													<option value="not_qualified" <?php echo ($this->input->get('cv_status') == 'not_qualified') ? 'selected':'';?>>Not Qualified</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="d-block">Select Interview Status </label>
												<select name="interview_status" class="form-select">
													<option value="">[Any Interview Status]</option>
													<option value="selected" <?php echo ($this->input->get('interview_status') == 'selected') ? 'selected' : '' ?>>Selected</option>
													<option value="rejected" <?php echo ($this->input->get('interview_status') == 'rejected') ? 'selected' : '' ?>>Rejected</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label>Search Applicant Name or CV No.</label>
												<input type="search" id="keyword" name="keyword" placeholder="Enter name or cv number" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
											</div>
										</div>
										
										<div class="col-lg-4 col-md-4 col-sm-12">
											<div class="form-group mb-2">
												<label class="control-label" for="applied_for">Position Applied For </label>
												<select style="height:410px;" name="applied_for" id="applied_for" class="form-control select2">
													<option value="">[Any Position]</option>
													<?php foreach($positions as $pos) { ?>
														<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $this->input->get('applied_for')) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-lg-4 col-md-4 col-sm-12" style="padding-top: 29px;">
											<a href="<?php echo base_url('hiring-agency/cv/list'); ?>" class="btn btn-danger btn-md">Clear Filter</a>
											<button type="submit" class="btn btn-success btn-md">Apply Filter</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<form id="myform" name="myform" method="post" action="">
									<table id="store-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
										<thead>
											<tr>
												<th>#</th>
												<th>CV No</th>
												<th>Applicant Type</th>
												<th>Full Name</th>
												<th>Nationality</th>
												<th>Age</th>
												<th>Passport No.</th>
												<th>PP Expiry</th>
												<th>Position Applied For</th>
												<th>CV Status</th>
												<th>Interview Status</th>
												<th>Medical Status</th>
												<th>Created At</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div> <!-- end col -->
					</div> <!-- end row -->
			</div>
		 </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('agency/layout/footer');?>

<div class="modal fade upload-image-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">Upload</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">
                
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(document).ready(function() {
	$('#store-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],

		"responsive": true,
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		searching: false,
		"ajax":{
			url:"<?php echo base_url();?>hiring-agency/cv/ajax-list?keyword=<?php echo $this->input->get('keyword')?>&applied_for=<?php echo $this->input->get('applied_for')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>&cv_status=<?php echo $this->input->get('cv_status')?>&interview_status=<?php echo $this->input->get('interview_status')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13],
			 "orderable":false
			},
		],
	});
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected cv data?") == true) {
			changeActionAndSubmit('hiring-agency/cv/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}

function uploadCertificate(identifier) {
	let id = $(identifier).data('id');
	let type = $(identifier).data('type');
	if(id > 0){
		$.ajax({
			type: "post",
			url: "<?php echo base_url('hiring-agency/cv/upload-form');?>",
			data: {'id': id, 'type': type},
			//dataType: "json",
			success: function (response) {
				console.log(response);
				$('.upload-image-modal').modal('show');
				$('#summary_body_modal').html(response);
				$('#summaryModalFullscreenLabel').html('UPLOAD '+ type.toUpperCase());
			},
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				$('#summary_body_modal').after(JSON.stringify(request));
			},
		});
	}else{
		alert('Invalid request id!');
	}
}

</script>
