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
                                <div id="accordion" class="custom-accordion">
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">
                                                    Search by dispatch ID / Reference ID
                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                </h6>
                                            </div>
                                        </a>

                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <form action="javascript:;" method="get" id="filter_form">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group mb-2">
                                                                <label>Dispatch ID</label>
                                                                <input type="text" class="form-control" name="dispatched_id" />
                                                            </div>
                                                            <div style="padding-top: 6px;">
                                                                <a href="<?php echo base_url('logistic-partner/organization-payment'); ?>" class="btn btn-custom-danger btn-sm">Clear Filter</a>
                                                                <button type="submit" class="btn btn-custom-success btn-sm ms-2">Apply Filter</button>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-6">
                                                            <div class="form-group mb-2">
                                                                <label>Reference ID</label>
                                                                <input type="text" class="form-control" name="reference_id" />
                                                            </div>
                                                            <div style="padding-top: 6px;">
                                                                <a href="<?php echo base_url('logistic-partner/organization-payment'); ?>" class="btn btn-custom-danger btn-sm">Clear Filter</a>
                                                                <button type="submit" class="btn btn-custom-success btn-sm ms-2">Apply Filter</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="card-header" id="headingTwo">
                                                <h6 class="m-0">
                                                    Advance Search
                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                <form action="<?php echo base_url(''); ?>" method="get" id="filter_form">
                                                    <div class="row">
                                                        <div class="col-6 mb-2">
                                                            <div class="form-group mb-2">
                                                                <label>Driver</label>
                                                                <select class="form-control show-tick select2" name="rider_id" required data-placeholder="Choose Driver...">
                                                                    <option value="all">All</option>
                                                                    <?php foreach($riders_list as $dList){ ?>
                                                                    <option value="<?= $dList->id; ?>"><?= $dList->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <div class="form-group mb-2">
                                                                <label>Driver Settled</label>
                                                                <select class="form-control show-tick select2" name="rider_id" required data-placeholder="Choose Driver...">
                                                                    <option value="all">All</option>
                                                                    <option value="all">All</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 mb-2">
                                                            <div class="form-group mb-2">
                                                                <label>Search by settlement date?</label>
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input" type="checkbox" id="formCheck1" style="width: 2em;height: 2em;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4 mb-2">
                                                            <div class="form-group mb-2">
                                                                <label>Date From</label>
                                                                <input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12" />
                                                            </div>
                                                        </div>
                                                        <div class="col-4 mb-2">
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
                                    </div>
                                </div>

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
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <h6 class="scheduler-border mb-3"></h6>
                                        <table class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>	
                                                    <th>Total Manual Dispatch</th>			  
                                                    <td class="text-align:right">0</td>
                                                </tr>
                                                <tr>	
                                                    <th>Total Rejected</th>			  
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
                                <div class="btn-toolbar float-end" role="toolbar">
                                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                        <button type="button" class="btn btn-custom-success btn-sm waves-light waves-effect"><i class="mdi mdi-microsoft-excel"></i> Excel Export</button>
                                    </div>
                                </div>
                                <h5 class="scheduler-border mb-4">Drivers Table:</h5>
                                <table id="driver-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
									<thead>
										<tr>
                                            <td>Ref. ID</th>
                                            <td>Driver Name</th>
                                            <td>Amount</th>
                                            <td>Price</th>
                                            <td>Driver Debit Amount</th>
                                            <td>Driver CreditAmount</th>
                                            <td>Is Free Order</th>
                                            <td>Dispatch Time</th>
                                            <td>Subscriber</th>
                                            <td>Driver Paid Org.</th>
                                            <td>Org. Settled</th>
                                            <td>Driver Settled</th>
                                            <td>Driver Settled Date</th>
                                            <td>Driver Username</th>
                                            <td>Driver Paid Organization Date</th>
                                            <td>Organization Settled Date</th>
										</tr>
									</thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="16" align="center">
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
				extend: "excel",
                text: 'Export Current Page',
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
                "targets":[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                "orderable":false
            },
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	
</script>