<?php $this->load->view('admin/home/header');?>
<style> 
@media only screen and (max-width: 600px) {
	.modal-dialog-aside{
		width: 100% !important;
		max-width: 100% !important;
	}
}

.insurance-modal .modal-dialog-aside {
	width: 30%;
	max-width: 80%;
	height: 100%;
	margin: 0;
	transform: translate(0);
	transition: transform .2s;
}

.insurance-modal .modal-dialog-aside .modal-content {
	height: inherit;
	border: 0;
	border-radius: 0;
}

.insurance-modal .modal-dialog-aside .modal-content .modal-body {
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
</style>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Insurance Policy Class</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/master/insurance-type/list');?>">Insurance Policy Class</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-none d-sm-block">
					<?php if(check_action_permission(get_user_role(), 'insurance_policy_class', 'delete')):?>
					<button class="btn btn-custom-danger btn-sm pull-right" onclick="confirm('Really want to delete this item?') ? $('#delete_form').submit() : false;" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<?php endif; ?>
					<?php if(check_action_permission(get_user_role(), 'insurance_policy_class', 'add')):?>
					<button class="btn btn-custom-success btn-sm pull-right ms-2" title="Add New Class" id="addInsuranceBtn"><i class="fa fa-plus"></i> Add New Class</button>
					<?php endif;?>
				</div>
				<div>
					<?php if($this->admin->getInfo()){ 
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if($info_type == 2){
					?>  
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong>Error!</strong>  <?php echo $msg_data; ?>
					</div>
					<?php } else{?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong>Success!</strong>  <?php echo $msg_data; ?>
					</div>
					<?php } } $this->admin->removeInfo();?>
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
					<div class="card-body">
						
						<?php echo form_open('admin/master/insurance-type/delete', array("id"=>"delete_form"));?>
						<table id="datatable-rack" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
								<tr>					  
									<th>#</th>
									<th>Insurance Type (EN)</th>
									<th>Insurance Type (AR)</th>
									<th>Status</th>
									<th>Created On</th>
									<th>Updated On</th>
									<th>Tools</th>
								</tr>
							</thead>

							<tbody>
								
							</tbody>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<!-- Modal -->
<div class="modal fade fixed-left insurance-modal" id="insuranceModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#datatable-rack').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "copy",
				className: "btn-md"
			},
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
		],
		"responsive": true,
		"processing":true,
		"serverSide":true,
		fixedHeader: true,
		"order":[],
		"ajax":{
			url:"<?php echo base_url();?>admin/master/insurance-type/ajax-list",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5],
			 "orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	

$(document).ready(function() {
	$("#addInsuranceBtn").click(function(){
		$('.insurance-modal .modal-content').html(`<div class="modal-header">
				<h5 class="modal-title mt-0">Add Insurance Policy Class</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form data-parsley-validate="" id="insuranceForm" method="POST" action="<?php echo base_url('admin/master/insurance-type/save');?>">
					<div class="row">
						<div class="col-md-12">
							<div class="mb-3">
								<label for="insurance_type" class="form-label">Policy Class (English) <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="insurance_type" name="insurance_type" required>
								<div class="invalid-feedback">
									Please provide a insurance policy class.
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="insurance_type_ar" class="form-label">Policy Class (Arabic) <span class="text-danger">*</span></label>
								<input type="text" class="form-control rtl-input" id="insurance_type_ar" name="insurance_type_ar" required>
								<div class="invalid-feedback">
									Please provide a insurance policy class in arabic.
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="mb-3">
								<label for="status-select" class="form-label">Status <span class="text-danger">*</span></label>
								<select class="form-select" name="status" id="status-select" required>
									<option value="">--- Select Status ---</option>
									<option value="active">Active</option>
									<option value="inactive">Deactive</option>
								</select>
								<div class="invalid-feedback">
									Please provide a status.
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
				<button type="submit" form="insuranceForm" class="btn btn-success">Save</button>
			</div>`);
		$('.insurance-modal').modal('show');
	});
});

function editModal(id){
	if (id > 0) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('admin/master/insurance-type/add'); ?>",
			data: {
				'id': id,
			},
			dataType: "json",
			success: function(response) {
				if (response.type === 'success') {
					$('.insurance-modal').modal('show');
					$('.insurance-modal .modal-content').html(response.output_html);
				} else {
					alert(response.message);
				}
			},
			error: function(request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
				alert(JSON.stringify(request));
			},
		});
	} else {
		alert('Invalid request id!');
	}
}
</script>
