<?php $this->load->view('logistic/layout/header'); ?>
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
                            <h4>Service Driver Provider Dashboard</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('logistic-partner'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SDP / Dashboard</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
                            <a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('logistic-partner'); ?>"><i class="fa fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row tracking-bars">
                                    <div class="col-md-4">
                                        <div class="progress" data-percentage="74">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    18/190<br>
                                                    <span>Busy</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="progress" data-percentage="50">
                                            <span class="progress-left">
                                                <span class="progress-bar progress-success"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar progress-success"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    18/190<br>
                                                    <span>Available</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="progress" data-percentage="10">
                                            <span class="progress-left">
                                                <span class="progress-bar progress-info"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar progress-info"></span>
                                            </span>
                                            <div class="progress-value">
                                                <div>
                                                    18/190<br>
                                                    <span>Offline</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="min-height: 506px;">
                                <h6 class="scheduler-border mb-3">Drivers Table:</h6>
                                <table id="driver-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>					  
											<th>Driver ID</th>
											<th>Name</th>						  
											<th>Mobile</th>					  
											<th>Iqama No.</th>  					  
											<th>Last Online</th> 					  
											<th>Status</th>
										</tr>
									</thead>
								</table>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('logistic/layout/footer'); ?>
<script>
$(document).ready(function() {
	$('#driver-table').dataTable({
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
            url:"<?php echo base_url();?>logistic/Sdp_controller/driver_list",
            type:"POST",
            error: function(data){
                console.log(JSON.stringify(data));
            }
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
</script>