<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		 <div class="row align-items-center">
				 <div class="col-sm-6">
					<div class="page-title">
						<h4>Sim Allocation management</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item active">Alloted Sim List</li>
						</ol>
					</div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
							<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
							<?php } ?>
							&nbsp;
							<a class="btn btn-custom-success btn-sm pull-right me-1" title="Own Store" href="<?php echo base_url('admin/allot-sim/add')?>"><i class="fa fa-plus"></i> Allot Sim Card</a>
						</div>
						<?php if($this->admin->getInfo()){
						$info = explode("--", $this->admin->getInfo());
						$info_type = $info[0];
						$msg_data = $info[1];
						if($info_type == 1){
						?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data; ?></strong>
						</div>
						<!-- <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
						<?php } else{?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<strong><?php echo $msg_data;?></strong>
						</div>
						<!-- <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button></div> -->
						<?php }} $this->admin->removeInfo();  ?>
						<?php if($this->input->get('msg')){ ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<strong><?php echo $this->input->get('msg'); ?></strong>
							</div>
						<?php }?>
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
							<form method="get">
								<div class="row align-items-center">
									<div class="col-lg-2 col-sm-6">
										<label for="status">Allotment Status</label>
										<select name="status" class="form-control select2" data-placeholder="Choose...">
											<option value="">Select</option>
											<option value="yes" <?php echo $this->input->get('status') == 'yes' ? 'selected' : '' ?>>Alloted</option>
											<option value="no" <?php echo $this->input->get('status') == 'no' ? 'selected' : '' ?>>Unalloted</option>
										</select>
									</div>
									<div class="col-lg-2 col-sm-6">
										<label for="sim_type">Sim Type</label>
										<select name="sim_type" class="form-control select2" data-placeholder="Choose...">
											<option value="">Select</option>
											<option value="postpaid" <?php echo $this->input->get('sim_type') == 'postpaid' ? 'selected' : '' ?>>Postpaid</option>
											<option value="prepaid" <?php echo $this->input->get('sim_type') == 'prepaid' ? 'selected' : '' ?>>Prepaid</option>
										</select>
									</div>
									<div class="col-md-2 col-sm-6">
										<label class="form-label" for="user_type">User Type</label>
										<select name="user_type" class="form-control user_type select2" data-placeholder="Choose User...">
											<option value="">Select User</option>
											<option value="1" <?php echo ($this->input->get('user_type') == '1') ? "selected" : "" ?>>Rider / Driver</option>
											<option value="2" <?php echo ($this->input->get('user_type') == '2') ? "selected" : "" ?>>Employee</option>
										</select>
									</div>
									<div class="col-lg-2 col-sm-6">
										<label for="sim_network">Sim Network</label>
										<select name="sim_network" class="form-control select2" data-placeholder="Choose...">
											<option value="">Select</option>
											<?php foreach(masterNetworkHelper() as $master_network){ ?>
											<option value="<?= $master_network->id; ?>" <?php echo $this->input->get('sim_network') == $master_network->id ? 'selected' : '' ?>><?= $master_network->network_name; ?></option>
											<?php } ?>
										</select>
									</div>
									
									<div class="col-lg-2 col-sm-6">
										<label for=""></label>
										<button type="submit" class="form-control btn btn-success mt-2">Submit</button>
									</div>
									<div class="col-lg-2 col-sm-6">
										<label for=""></label>
										<a type="reset" href="<?php echo base_url();?>admin/allot-sim/list" class="form-control btn btn-danger mt-2">Reset</a>
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
											<th>Allocation Date</th>
											<th>Sim Number</th>
											<th>Sim Type</th>
											<th>Network</th>
											<th>User Name</th>
											<th>User Type</th>
											<th>Status</th>
											<th>Tools</th>
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


<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#store-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
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
			url:"<?php echo base_url();?>admin/Sim_allot/get_list?status=<?php echo $this->input->get('status')?>&sim_type=<?php echo $this->input->get('sim_type')?>&user_type=<?php echo $this->input->get('user_type')?>&sim_network=<?php echo $this->input->get('sim_network')?>",
			type:"POST",
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
			},
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "orderable":false
			},
		],
	});
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected alloted sim?") == true) {
			changeActionAndSubmit('admin/Sim_allot/delete');
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

</script>
