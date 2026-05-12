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
				<h4>Employed Riders</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item active">List</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash"></i> Delete</button>
					<a class="btn btn-custom-success btn-sm pull-right ms-2" title="Add New Rider" href="<?php echo base_url('admin/employed-rider/add')?>"><i class="fa fa-plus"></i> Add New Rider</a>
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
				
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
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
						<form action="<?php echo base_url('admin/employed-rider/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Iqama Number</label>
										<input type="search" id="iqama_no" name="iqama_no" placeholder="Search Iqama Number" value="<?php echo $this->input->get('iqama_no') ? $this->input->get('iqama_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('hunger_id'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('jahez_id'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('emp_id'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Employee ID</label>
											<input type="search" id="emp_id" name="emp_id" placeholder="Search by Employee ID" value="<?php echo $this->input->get('emp_id') ? $this->input->get('emp_id') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Hunger Station ID</label>
											<input type="search" id="hunger_id" name="hunger_id" placeholder="Search Hunger Station ID" value="<?php echo $this->input->get('hunger_id') ? $this->input->get('hunger_id') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Jahez ID</label>
											<input type="search" id="jahez_id" name="jahez_id" placeholder="Search Jahez ID" value="<?php echo $this->input->get('jahez_id') ? $this->input->get('jahez_id') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/employed-rider/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="empTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Emp ID</th>
										<th>Emp Name</th>
										<th>Iqama No</th>
										<th>Flex No</th>
										<th>Bike No</th>
										<th>Hunger ID</th>
										<th>Jahez ID</th>
										<th>Created At</th>
										<th>Updated At</th>
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
	$('#empTable').dataTable({
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
			url:"<?php echo base_url();?>admin/Employed_riders/get_ajax_list?keyword=<?php echo $this->input->get('keyword')?>&iqama_no=<?php echo $this->input->get('iqama_no')?>&hunger_id=<?php echo $this->input->get('hunger_id')?>&jahez_id=<?php echo $this->input->get('jahez_id')?>&emp_id=<?php echo $this->input->get('emp_id')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11],
			 "orderable":false
			},
		],
	});
	
});


function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected employee?") == true) {
			changeActionAndSubmit('admin/employed-rider/delete');
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
