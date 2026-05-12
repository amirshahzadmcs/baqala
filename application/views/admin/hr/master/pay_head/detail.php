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
					<h4>Pay Head Master</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/hr/master/pay_head">Pay Head List</a></li>
						<li class="breadcrumb-item active">Pay Head's Detail</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/hr/master/pay_head"><i class="fa fa-reply"></i> Back</a>
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
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="name">Name <span class="required-field">*</span></label>
								<input type="text" class="form-control" id="name" name="name" maxlength="150" value="<?php echo $name; ?>" required />
								<p class="hint">Enter pay head name</p>
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="type">Type <span class="required-field">*</span></label>
								<!-- <input type="text" class="form-control" id="type" name="type" maxlength="150" value="<?php //echo $name; ?>" required /> -->
								<select class="form-control select2" name="type" id="type" required data-placeholder="Choose Type...">
									<option value="">Select</option>
									<option value="Add" <?php echo $type == 'Add' ? 'selected' : '' ?>>Add</option>
									<option value="Deduct" <?php echo $type == 'Deduct' ? 'selected' : '' ?>>Deduct</option>
								</select>
								<p class="hint">Select Type</p>
							</div>
							<div class="col-md-6 col-sm-12 mb-3 form-group">
								<label for="calculate_on">Calculate On <span class="required-field">*</span></label>
								<!-- <input type="text" class="form-control" id="type" name="type" maxlength="150" value="<?php //echo $name; ?>" required /> -->
								<select class="form-control select2" name="calculate_on" id="calculate_on" required data-placeholder="Choose...">
									<option value="">Select</option>
									<option value="Day" <?php echo $calculate_on == 'Day' ? 'selected' : '' ?>>Day</option>
									<option value="Week" <?php echo $calculate_on == 'Week' ? 'selected' : '' ?>>Week</option>
									<option value="Month" <?php echo $calculate_on == 'Month' ? 'selected' : '' ?>>Month</option>
									<option value="Year" <?php echo $calculate_on == 'Year' ? 'selected' : '' ?>>Year</option>
								</select>
								<p class="hint">Select Calculate On</p>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
			</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<button type="button" class="btn btn-primary btn-sm d-none" id="login_d_btn" data-bs-toggle="modal" data-bs-target=".bs-login-modal">Login Modal</button>
<div class="modal fade bs-login-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Login Credentials</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					
				</button>
			</div>
			<div class="modal-body cred-modal-body">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade bs-changepassword-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/store/change-password", array("id"=>"demo-form2", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
					<input type="hidden" id="id" name="id" value="<?php echo $result->id;?>" />
					<input type="hidden" id="store_type" name="store_type" value="1" />
					<div class="row">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="password">Password <span class="required-field">*</span></label>
							<input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="55" required />
							<p class="hint">Enter password minimum length 6.</p>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="confirm_password">Confirm Password <span class="required-field">*</span></label>
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" maxlength="55" required />
							<p class="hint">Enter confirm password.</p>
						</div>
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<button type="submit" class="btn btn-custom-success float-end">Change Password</button>
						</div>
					</div>
				<?php form_close();?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
