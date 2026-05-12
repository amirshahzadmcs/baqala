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
							<h4><?php echo ucfirst($page_name); ?> CV</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
								<li class="breadcrumb-item active"><?php echo ucfirst($page_name); ?> CV List</li>
							</ol>
						</div>
					</div>
					<?php $admin_id = $this->session->userdata('admin_id'); ?>
					<div class="col-sm-6">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-custom pull-right me-2" title="Back" href="<?php echo base_url(); ?>hiring-agency/cv/list"><i class="fa fa-reply"></i> Back</a>
						</div>
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
												<th>Position</th>
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
		"ajax":{
			url:"<?php echo base_url();?>hiring-agency/cv/filter-ajax/<?php echo $page_name;?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12],
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
