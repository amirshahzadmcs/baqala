<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
input, textarea, select, select.select2{
    pointer-events: none;
}
span.required{
	color:red;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Sim Card Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/hr/recruitment/sim-card">Sim Card List</a></li>
						<li class="breadcrumb-item active">Sim Card's Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/hr/recruitment/sim-card"><i class="fa fa-reply"></i> Back</a>
					<!-- <a class="btn btn-sm btn-custom pull-right ms-1" onclick="loginDetail()" title="credentials" href="javascript:void(0)"><i class="fa fa-key"></i> Login Detail</a>
					<a class="btn btn-sm btn-custom-danger pull-right ms-1"  data-bs-toggle="modal" data-bs-target=".bs-changepassword-modal" href="javascript:void(0)"><i class="fa fa-key"></i> Change Password</a> -->
				</div>

				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
					<?php } else{?>
					<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
				<?php } ?> <?php } $this->admin->removeInfo();?>

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
						<div class="row">
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ref_no">Ref No <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="ref_no" name="ref_no" maxlength="150" value="<?php echo $ref_no; ?>" required />
								<p class="hint">Enter Ref No</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="ref_date">Ref Date <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="ref_date" name="ref_date" maxlength="150" value="<?php echo $ref_date; ?>" required />
								<p class="hint">Enter Ref Date</p>
							</div>
							
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="emp_no">Employee Number <span class="required-field">*</span></label>
								<!-- <input type="text" name="cv_no" id="cv_no" class="form-control" value="<?php echo $cv_no; ?>"> -->
								<select name="emp_no" id="emp_no" class="form-control select2" required data-placeholder="Choose Position...">
									<option value="">select</option>
									<?php foreach($employees as $cv) { ?>
										<option value="<?php echo $cv->id; ?>" <?php echo ($cv->id == $emp_no) ? 'selected' : '' ?>><?php echo $cv->emp_no; ?></option>
									<?php } ?>
								</select>
								<p class="hint">Select Employee</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="name">Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" onKeyPress="return Alpha(event);" id="name" name="name" maxlength="150" value="<?php echo $name; ?>" required />
								<p class="hint">Enter Employee Name</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="mobile">Mobile <span class="required-field">*</span></label>
								<input type="text" onKeyPress="return numerics(event);" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>" required />
								<p class="hint">Enter Mobile Number</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="position">Position <span class="required-field">*</span></label>
								<input type="text" name="position" id="position" class="form-control" value="<?php echo $position; ?>">
								<!-- <select name="position" id="position" class="form-control select2" required data-placeholder="Choose Position...">
									<option value="">select</option>
									<?php foreach($positions as $pos) { ?>
										<option value="<?php echo $pos->id; ?>" <?php //echo ($pos->id == $position) ? 'selected' : '' ?>><?php echo $pos->name; ?></option>
									<?php } ?>
								</select> -->
								<p class="hint">Select Position</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="joining_date">Joining Date <span class="required-field">*</span></label>
								<input type="date" class="form-control" id="joining_date" name="joining_date" value="<?php echo $joining_date; ?>" required />
								<p class="hint">Enter Joining Date</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="location">Location <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>" required />
								<p class="hint">Enter Location</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="fname">Father Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" required />
								<p class="hint">Enter Father Name</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="network">Network <span class="required-field">*</span></label>
								<select name="network" id="network" class="form-control select2" required data-placeholder="Choose Position...">
									<option value="">select</option>
									<?php foreach($networks as $pos) { ?>
										<option value="<?php echo $pos->id; ?>" <?php echo ($pos->id == $network) ? 'selected' : '' ?>><?php echo $pos->network_name; ?></option>
									<?php } ?>
								</select>
								<p class="hint">Select Network</p>
							</div>
							<div class="col-md-4 col-sm-12 mb-2 form-group">
								<label for="sim_no">Sim <span class="required-field">*</span></label>
								<select name="sim_no" id="sim_no" class="form-control select2" required data-placeholder="Choose Position...">
									<option value="">select</option>
									<?php foreach($sims as $sim) { ?>
										<option value="<?php echo $pos->id; ?>" <?php echo ($sim->id == $sim_no) ? 'selected' : '' ?>><?php echo $sim->sim_no .' ('.$sim->mobile.')'; ?></option>
									<?php } ?>
								</select>
								<p class="hint">Select Sim</p>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#vendor_table').dataTable({
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
		fixedHeader: true,
		"order":[],
		"ajax":{
				url:"<?php echo base_url();?>admin/vendor/get_order_list?id=<?php echo $this->input->get('id');?>",
				type:"POST"
			},
			"columnDefs":[
			{
			 "targets":[0,1],
			 "orderable":false
			},
		]
	});
});
$(document).ready(function(){
	var id = $('#id').val();
	if (id != '') {
		var val = $('#network option:selected').val();
		var plan_id = $('#plan_id').val();
		// alert(plan_id);
		$.ajax({
			url: "<?php echo base_url()?>admin/Sim_card/getPlans",
			data: { "id": val, "plan_id": plan_id },
			//dataType:"html",
			type: "get",
			success: function(data){
				$('#plan').append(data);
				console.log(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
});
$(document).ready(function() {
	$('#regionTable').dataTable({
		"lengthMenu": [
			[25, 50, 100, 500],
			[25, 50, 100, 500]
		],
		order: [
			[0, 'asc']
		],
		"responsive": true,
		fixedHeader: true,
	});
});
</script>
