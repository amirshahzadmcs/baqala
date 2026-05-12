<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
#messageContainer{
	max-height: 250px;
    overflow: auto;
    margin-bottom: 34px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Hunger Daily Compliance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/hunger/compliance-list'); ?>">Rider Compliance</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(),'hunger_compliance','delete')):?>
					<button type="button" class="btn btn-custom-danger btn-sm pull-right" onclick="deleteAction()" title="Delete"><i class="fa fa-trash me-1"></i> Delete</button>
					<?php endif; if(check_action_permission(get_user_role(),'hunger_compliance','import_file')):?>
					<a class="btn btn-custom-white btn-sm pull-right ms-2" title="Import New Compliance" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bulkImportModal"><i class="ti-import"></i> Import New Compliance</a>
					<?php endif;?>
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
						<form action="<?php echo base_url('admin/logistic-management/hunger/compliance-list'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name/Number</label>
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
									<a href="<?php echo base_url('admin/logistic-management/hunger/compliance-list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
							<table id="complianceTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>S.No.</th>
										<th>Operation Day Date</th>
										<th>Rider ID</th>
										<th>Emp No.</th>
										<th>Rider Name</th>
										<th>Phone Number</th>
										<th>Failure Reason Name</th>
										<th>Description</th>
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

<!-- Modal -->
<div class="modal fade bulkImportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="bulkImportModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title px-3" id="bulkImportModalLabel">Rider Daily Compliance <b>(Hunger)</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="messageContainer" class="px-3"></div>
				<form id="delivery_bulk_form" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="row px-3">
						<div class="col-md-12 col-sm-12 mb-3 form-group">
							<label for="attachment">Rider Daily Compliance <span class="text-secondary">(Supported file format is: .xls .xlsx)</span></label>
							<input type="file" name="file" id="attachment" class="dropify" accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-max-file-size="2M" data-height="100" required>
						</div>
						<div class="col-md-12">
							<p class="text-secondary">Upload the same file format in (.xls) provided from Baqala Station to avoid any errors while importing your data.</p>
							<p style="text-align: center;"><a type="button" href="<?php echo base_url('admin_assets/samples/Hunger_Compliance_File.xlsx'); ?>" class="btn bt btn-link text-success" target="_blank" download>Download sample file</a></p>
						</div>
						<div class="col-md-12 mb-3">
							<button type="save" id="btnUpload" class="btn btn-custom-success btn-md w-100">Import</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
function initializeDataTable() {
    if ($.fn.DataTable.isDataTable('#complianceTable')) {
        $('#complianceTable').DataTable().destroy();
    }

	$('#complianceTable').dataTable({
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
		"searching": false,
		"ajax":{
			url:"<?php echo base_url();?>admin/logistic-management/hunger/compliance-ajax-list?keyword=<?php echo $this->input->get('keyword')?>&rider_id=<?php echo $this->input->get('rider_id')?>&start_date=<?php echo $this->input->get('start_date')?>&end_date=<?php echo $this->input->get('end_date')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7,8,9],
			 "orderable":false
			},
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "className": "text-center",
			}
		],
	});
}

// Call the function to initialize DataTable
$(document).ready(function() {
    initializeDataTable();
});

function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected items?") == true) {
			changeActionAndSubmit('admin/logistic-management/hunger/compliance-delete');
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

$('.dropify').dropify();

$(document).ready(function() {
	$("body").on("submit", "#delivery_bulk_form", function(e) {
		e.preventDefault();
		var data = new FormData(this);
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('admin/logistic-management/hunger/compliance-import') ?>",
			data: data,
			//dataType: 'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function() {
				$("#btnUpload").prop('disabled', true);
				$("#btnUpload").html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
			}, 
			success: function(response) {
				//console.log(response);
				$("#btnUpload").prop('disabled', false);
				$("#btnUpload").html('Import');
				$("#attachment").val('');
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.error_message) {
					var tableHtml = '<p style="color: red;">Error: ' + jsonResponse.error_message + '</p>';
					if (jsonResponse.duplicate_rows) {
						tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Rider ID</th><th>Date</th></tr>';
						$.each(jsonResponse.duplicate_rows, function(index, row) {
							tableHtml += '<tr>';
							tableHtml += '<td>' + row[0] + '</td>';
							tableHtml += '<td>' + row[3] + '</td>';
							tableHtml += '<td>' + formatDateJS(row[1]) + '</td>';
							// $.each(row, function(key, value) {
							// 	tableHtml += '<td>' + value + '</td>';
							// });
							tableHtml += '</tr>';
						});
						tableHtml += '</table>';
					}
					$('#messageContainer').html(tableHtml);
				} else if (jsonResponse.success_message) {
					$('#messageContainer').html('<p style="color: green;">Success: ' + jsonResponse.success_message + '</p>');
				} else if (jsonResponse.duplicate_rows) {
					tableHtml += '<h6>Duplicate Rows</h6><table class="table border-danger"><tr><th>S.No.</th><th>Rider ID</th><th>Date</th></tr>';
					$.each(jsonResponse.duplicate_rows, function(index, row) {
						tableHtml += '<tr>';
						tableHtml += '<td>' + row[0] + '</td>';
						tableHtml += '<td>' + row[3] + '</td>';
						tableHtml += '<td>' + formatDateJS(row[1]) + '</td>';
						// $.each(row, function(key, value) {
						// 	tableHtml += '<td>' + value + '</td>';
						// });
						tableHtml += '</tr>';
					});
					tableHtml += '</table>';
					$('#messageContainer').html(tableHtml);
				}
				initializeDataTable();
			},
			error: function(xhr, status, error) {
				//console.log(error);
				$("#btnUpload").prop('disabled', false);
				$("#btnUpload").html('Import');
				$('#messageContainer').html('<p style="color: red;">Error: ' + error + '</p>');
			}
		});
	});
});

function formatDateJS(date_string){
	// Input date string
	let inputDate = date_string;

	// Convert the input date string into a Date object
	let dateObj = new Date(inputDate);

	// Extract the day, month, and year from the Date object
	let day = dateObj.getDate();
	let month = dateObj.getMonth() + 1; // Months are zero-based, so add 1
	let year = dateObj.getFullYear();

	// Format the date into "d-m-Y"
	let formattedDate = `${day}-${month}-${year}`;

	// Output the formatted date
	return formattedDate;
}
</script>
