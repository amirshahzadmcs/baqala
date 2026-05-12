<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
#professionTable thead tr th, #professionTable tbody tr td{
	white-space: nowrap;
}
.batch-detail-body {
    overflow-x: scroll;
}
.batch-detail-body {
    overflow-x: auto;
    scrollbar-width: thin; /* For Firefox */
    scrollbar-color: #888 #f1f1f1;
}

/* WebKit Browsers (Chrome, Safari) */
.batch-detail-body::-webkit-scrollbar {
    height: 6px;
}

.batch-detail-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.batch-detail-body::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
}

.batch-detail-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}

#batchDetailTable thead tr th, #batchDetailTable tbody tr td{
	white-space: nowrap;
}
@media only screen and (max-width: 600px) {
	.modal-dialog-aside{
		width: 100% !important;
		max-width: 100% !important;
	}
}

.modal-dialog-aside {
	width: 40%;
	max-width: 80%;
	height: 100%;
	margin: 0;
	transform: translate(0);
	transition: transform .2s;
}

.modal-dialog-aside .modal-content {
	height: inherit;
	border: 0;
	border-radius: 0;
}

.modal-dialog-aside .modal-content .modal-body {
	overflow-y: auto
}

.modal-dialog-aside {
	width: 35%;
	max-width: 80%;
	height: 100%;
	margin: 0;
	transform: translate(0);
	transition: transform .2s;
}

.modal-dialog-aside .modal-content {
	height: inherit;
	border: 0;
	border-radius: 0;
}

.modal-dialog-aside .modal-content .modal-body {
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
::-webkit-scrollbar {
    width: 5px;
}

</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Change Profession</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/hr/change-profession/index'); ?>">Change Profession</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
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
						<form action="<?php echo base_url('admin/hr/change-profession/index'); ?>" method="get" id="filter_form">
							<div class="row">
								
								<!-- Batch No -->
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Batch No.</label>
										<input type="search" name="batch_no" placeholder="Search Batch Number" value="<?php echo $this->input->get('batch_no') ?: ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Request Date Between:</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
									</div>
								</div>

								<div class="form-group col-lg-4 col-md-4 col-12" style="margin-top: 28px;">
									<button type="submit" class="btn btn-success ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/hr/change-profession/index'); ?>" class="btn btn-danger">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form id="myform" name="myform" method="post" action="" style="overflow: auto;">
							<table id="professionTable" class="table table-striped table-bordered jambo_table bulk_action text-center" style="width:100%">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Batch No.</th>
										<th>Request Date</th>
										<th>Total Employees</th>
										<th>Created At</th>
										<th style="width: 110px !important;">Tools</th>
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

<div class="modal fade fixed-left transferModal" aria-labelledby="#transferModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="transferModalLabel">Employee Transfer Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="food-modal-body">

				</div>
            </div>
			<div class="modal-footer">
				
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade detailModal" aria-labelledby="#detailModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="detailModalLabel">Batch Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div class="batch-detail-body">

				</div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php $this->load->view('admin/home/footer');?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<script>
	function initializeDataTable() {
		if ($.fn.DataTable.isDataTable('#professionTable')) {
			$('#professionTable').DataTable().destroy();
		}

		$('#professionTable').dataTable({
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
			"searching":false,
			"serverSide":true,
			"fixedHeader": true,
			"ajax":{
				url:"<?php echo base_url();?>admin/hr/change-profession/ajax-list?batch_no=<?php echo $this->input->get('batch_no')?>&start_date=<?php echo $this->input->get('start_date')?>&end_date=<?php echo $this->input->get('end_date')?>",
				type:"POST"
			},
			"columnDefs":[
				{
				"targets":[0,1,2,3,4,5],
				"orderable":false
				},
			],
		});
	}

	$(document).ready(function() {
		initializeDataTable();
	});

	function viewBatchDetail(batch_no) {
		// Make the AJAX request
		$.ajax({
			url: '<?php echo base_url('admin/hr/change-profession/view-batch-detail'); ?>',
			method: 'GET',
			data: { batch_no: batch_no },
			success: function(responseHtml) {
				$('#detailModalLabel').html('Batch Detail - '+batch_no);
				$('.detailModal').modal('show');
				$('.batch-detail-body').html(responseHtml);
			},
			error: function(errorResponse) {
				console.log(errorResponse);
				toastr.error('Error fetching batch data');
			}
		});
	}

	function formatDateJS(date_string){
		let inputDate = date_string;

		let dateObj = new Date(inputDate);

		let day = dateObj.getDate();
		let month = dateObj.getMonth() + 1; // Months are zero-based, so add 1
		let year = dateObj.getFullYear();

		let formattedDate = `${day}-${month}-${year}`;

		return formattedDate;
	}
</script>
