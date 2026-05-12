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
                            <h4>Payment Reports</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('logistic-partner'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Payment Reports</li>
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
                                <form action="<?php echo base_url(''); ?>" method="get" id="filter_form">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group mb-2">
                                                <label>Accountant Name<span class="text-danger">*</span></label>
                                                <select class="form-control show-tick select2" name="rider_id" required data-placeholder="Choose Accountant...">
                                                    <option value="">Select Accountant</option>
                                                    <?php foreach($riders_list as $dList){ ?>
                                                    <option value="<?= $dList->id; ?>"><?= $dList->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="form-group mb-2">
                                                <label>Date From</label>
                                                <input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group mb-2">
                                                <label>Date To</label>
                                                <input type="date" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12" style="padding-top: 6px;">
                                            <a href="<?php echo base_url('admin/order/list'); ?>" class="btn btn-custom-danger btn-sm">Clear Filter</a>
                                            <button type="submit" class="btn btn-custom-success btn-sm ms-2">Apply Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <h6 class="scheduler-border mb-3">Collection Amount Summary:</h6>
                                        <table class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>	
                                                    <th>Total</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Driver Debit</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Service Deducation</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Delivery</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Driver Credit</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Free Orders</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Driver's Tips</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr style="border-top: 1px solid #6b6b6b;">	
                                                    <th>Net Amount</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                            </thead>
                                        </table>
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
											<th>Driver's ID</th>
											<th>Driver Name</th>						  
											<th>Collection Amt.</th>					  
											<th>Delivery Price</th>  					  
											<th>Free Order Count</th> 					  
											<th>Driver Credit</th>
											<th>Driver Debit</th>
											<th>Service Deduction</th>
											<th>Driver Tips</th>
											<th>Settled By</th>
											<th>Settled Date</th>
										</tr>
									</thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="11" align="center">
                                                No data found
                                            </td>
                                        </tr>
                                    </tbody>
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
		
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6,7,8,9,10],
                "orderable":false
            },
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	
</script>