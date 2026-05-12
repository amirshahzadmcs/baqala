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
                            <h4>Service Driver Provider Report</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('logistic-partner'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">SDP / Report</li>
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
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body" style="min-height: 506px;">
                                <h6 class="scheduler-border mb-3">Top Performance Drivers:</h6>
                                <table id="driver-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>					  
											<th>Driver ID</th>
											<th>Name</th>						  
											<th>Mobile</th>				  
											<th>No. of Dispatches</th>
										</tr>
									</thead>
								</table>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-body" style="min-height: 506px;">
                                <h6 class="scheduler-border mb-3">Number of Dispatched Over Last 14 Days:</h6>
                                <div id="line_chart_dashed" class="apex-charts" dir="ltr"></div>
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
            url:"<?php echo base_url();?>logistic/RSdp_controller/performance_list",
            type:"POST",
            error: function(data){
                console.log(JSON.stringify(data));
            }
        },
        "columnDefs":[
            {
                "targets":[0,1,2,3],
                "orderable":false
            },
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	

options = {
    chart: { height: 380, type: "line", zoom: { enabled: !1 }, toolbar: { show: !1 } },
    colors: ["#525ce5"],
    dataLabels: { enabled: !1 },
    stroke: { width: [3], curve: "smooth", dashArray: [0] },
    series: [
        { name: "Total Dispatch", data: [89, 56, 74, 98, 72, 38, 64, 46, 84, 58, 46, 49, 51, 55] },
    ],
    title: { text: "Number of Dispatches", align: "left" },
    markers: { style: "inverted", size: 6, hover: { sizeOffset: 6 } },
    xaxis: { categories: ["01 Jan 2023", "02 Jan 2023", "03 Jan 2023", "04 Jan 2023", "05 Jan 2023", "06 Jan 2023", "07 Jan 2023", "08 Jan 2023", "09 Jan 2023", "10 Jan 2023", "11 Jan 2023", "12 Jan 2023", "13 Jan 2023", "14 Jan 2023"] },
    tooltip: {
        y: [
            {
                title: {
                    formatter: function (e) {
                        return e + " per day";
                    },
                },
            },
        ],
    },
    grid: { borderColor: "#f1f1f1", padding: { bottom: 5 } },
    legend: { offsetY: 5 },
};
(chart = new ApexCharts(document.querySelector("#line_chart_dashed"), options)).render();
</script>