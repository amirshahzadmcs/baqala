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
				<h4>Attendance Logs</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance-logs/list');?>">Attendance</a></li>
					<li class="breadcrumb-item active">Logs</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if ($this->customer->userd($admin_id)->role == "Admin") {?>
					<a class="btn btn-sm btn-danger pull-right" title="Delete" href="javascript:;"><i class="fa fa-trash"></i> Delete</a>
					<?php }?>
					<div class="btn-group ms-1">
						<button class="btn btn-custom-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Exports <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo base_url();?>admin/attendance-logs/export-pdf?keyword=<?php echo $this->input->get('keyword')?>&emp_id=<?php echo $this->input->get('emp_id')?>&iqama_no=<?php echo $this->input->get('iqama_no')?>&department=<?php echo $this->input->get('department')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>" target="_blank">Export PDF</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url(); ?>admin/attendance-logs/export-excel?network=keyword=<?php echo $this->input->get('keyword')?>&emp_id=<?php echo $this->input->get('emp_id')?>&iqama_no=<?php echo $this->input->get('iqama_no')?>&department=<?php echo $this->input->get('department')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>" target="_blank">Export Excel</a>
						</div>
					</div>
					<a href="<?php echo base_url('admin/attendance-logs/add-attendance');?>" class="btn btn-sm btn-custom-success pull-right ms-1" title="Add"><i class="fa fa-plus"></i> Add Attendance Day</a>
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/attendance-logs/list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
								    <label>Search by Employee Name or Employee No.</label>
								    <select name="keyword" id="keyword" class="form-control select2 w-100">
										<option value="">[Any Employee]</option>
										<?php foreach(employeeListHelper() as $emp_list) { ?>
											<option value="<?php echo $emp_list->id;?>" <?php echo ($emp_list->id == $this->input->get('keyword')) ? 'selected' : ''; ?>>#<?php echo $emp_list->emp_no;?> - <?php echo (($emp_list->first_name !=='') ? $emp_list->first_name : ''). (($emp_list->middle_name !=='') ? ' '.$emp_list->middle_name : ''). (($emp_list->third_name !=='') ? ' '.$emp_list->third_name : ''). (($emp_list->surname !=='') ? ' '.$emp_list->surname : ''); ?></option>
										<?php } ?>
									</select>
									<!--<div class="form-group mb-2">-->
									<!--	<label>Search by Employee Name or Employee No.</label>-->
									<!--	<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">-->
									<!--</div>-->
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Iqama Number</label>
										<input type="search" id="iqama_no" name="iqama_no" placeholder="Search Iqama Number" value="<?php echo $this->input->get('iqama_no') ? $this->input->get('iqama_no') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label class="d-block">Select Department</label>
										<select name="department" class="form-select select2">
											<option value="">[All Department]</option>
											<?php foreach(masterDepartments() as $department) { ?>
												<option value="<?php echo $department->id; ?>" <?php echo ($this->input->get('department') == $department->id) ? 'selected' : '' ?>><?php echo $department->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="from" placeholder="Start Date" value="<?php echo $this->input->get('from'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="to" placeholder="End Date" value="<?php echo $this->input->get('to'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/attendance-logs/list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
										<th>Department</th>
										<th>Date</th>
										<th>Sign In</th>
										<th>Sign Out</th>
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
			url:"<?php echo base_url();?>admin/attendance-logs/ajax-list?keyword=<?php echo $this->input->get('keyword')?>&emp_id=<?php echo $this->input->get('emp_id')?>&iqama_no=<?php echo $this->input->get('iqama_no')?>&department=<?php echo $this->input->get('department')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>",
			type:"POST",
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9],
			 "orderable":false
			},
			
		],
	});
	
	$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
		console.log(message);
	}
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected employee?") == true) {
			changeActionAndSubmit('admin/attendance-logs/delete');
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
