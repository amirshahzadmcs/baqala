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
					<h4>Hunger Daily Order</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/employed-rider/hunger/index'); ?>">Hunger Orders</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button type="button" class="btn btn-custom-danger btn-sm pull-right mr-2" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button>
					<a class="btn btn-custom-success btn-sm pull-right ms-2" title="Import New Orders" href="<?php echo base_url('admin/employed-rider/hunger/upload')?>"><i class="ti-import me-1"></i> Import New Orders</a>
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
						<form action="<?php echo base_url('admin/employed-rider/hunger/index'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Rider Id</label>
										<input type="search" id="rider_id" name="rider_id" placeholder="Search Rider ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range: </label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/employed-rider/hunger/index'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
										<th>Rider Id</th>
										<th>Rider Name</th>
										<th>Phone Number</th>
										<th>City Name</th>
										<th>Date Local</th>
										<th>Completed Deliveries</th>
										<th>Cancelled Deliveries</th>
										<th>Notified Deliveries</th>
										<th>Declined Deliveries</th>
										<th>Accepted Deliveries</th>
										<th>Not Accepted Deliveries</th>
										<th>Not Accepted Deliveries Fine</th>
										<th>Rider Earnings</th>
										<th>Avg. Rider Acceptance</th>
										<th>Avg. Rider Delivery Time</th>
										<th>Working Hours</th>
										<th>Created At</th>
										<!-- <th>Tools</th> -->
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
			url:"<?php echo base_url();?>admin/employed-rider/hunger/ajax-list?keyword=<?php echo $this->input->get('keyword')?>&rider_id=<?php echo $this->input->get('rider_id')?>&start_date=<?php echo $this->input->get('start_date')?>&end_date=<?php echo $this->input->get('end_date')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17],
			 "orderable":false
			},
			{
			 "targets":[1,7,8,9,10,11,12,13,14,15],
			 "className": "text-center",
			},
		],
	});
	
});


function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected items?") == true) {
			changeActionAndSubmit('admin/employed-rider/hunger/delete');
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
