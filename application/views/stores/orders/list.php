<?php $this->load->view('stores/layout/header');?>
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
                            <h4><?php echo $page_name;?></h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('store'); ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url('store/order/dashboard'); ?>">Orders</a></li>
                                <li class="breadcrumb-item active"><?php echo $page_name;?></li>
                            </ol>
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
							<div class="card-body">
								<form id="myform" name="myform" method="post" action="">
									<table id="orderTable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr style="background-color:#74788d !important; color: white;">
												<th align="center">#</th>
												<th>Order ID</th>
												<th>Date</th>
												<th>Billing Name</th>
												<th>Total</th>
												<th>Payment Status</th>
												<th>Invoice</th>
												<th style="width: 120px;">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck1">
														<label class="form-check-label" for="ordercheck1">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1572</a> </td>
												<td>
													04 Jan, 2024
												</td>
												<td>Walter Brown</td>
												
												<td>
													SAR 172
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td>
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck2">
														<label class="form-check-label" for="ordercheck2">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1571</a> </td>
												<td>
													03 Jan, 2024
												</td>
												<td>Jimmy Barker</td>
												
												<td>
													SAR 165
												</td>
												<td>
													<div class="badge badge-soft-warning font-size-12">unpaid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container2">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck3">
														<label class="form-check-label" for="ordercheck3">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1570</a> </td>
												<td>
													03 Jan, 2024
												</td>
												<td>Donald Bailey</td>
												
												<td>
													SAR 146
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container3">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck4">
														<label class="form-check-label" for="ordercheck4">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1569</a> </td>
												<td>
													02 Jan, 2024
												</td>
												<td>Paul Jones</td>
												
												<td>
													SAR 183
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container4">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck5">
														<label class="form-check-label" for="ordercheck5">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1568</a> </td>
												<td>
													01 Jan, 2024
												</td>
												<td>Jefferson Allen</td>
												
												<td>
													SAR 160
												</td>
												<td>
													<div class="badge badge-soft-danger font-size-12">Chargeback</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container5">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck6">
														<label class="form-check-label" for="ordercheck6">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1567</a> </td>
												<td>
													31 Dec, 2023
												</td>
												<td>Jeffrey Waltz</td>
												
												<td>
													SAR 105
												</td>
												<td>
													<div class="badge badge-soft-warning font-size-12">unpaid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container6">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck7">
														<label class="form-check-label" for="ordercheck7">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1566</a> </td>
												<td>
													30 Dec, 2023
												</td>
												<td>Jewel Buckley</td>
												
												<td>
													SAR 112
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container7">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck8">
														<label class="form-check-label" for="ordercheck8">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1565</a> </td>
												<td>
													29 Dec, 2023
												</td>
												<td>Jamison Clark</td>
												
												<td>
													SAR 123
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container8">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck9">
														<label class="form-check-label" for="ordercheck9">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1564</a> </td>
												<td>
													28 Dec, 2023
												</td>
												<td>Eddy Torres</td>
												
												<td>
													SAR 141
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container9">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck10">
														<label class="form-check-label" for="ordercheck10">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS1563</a> </td>
												<td>
													28 Dec, 2023
												</td>
												<td>Frank Dean</td>
												
												<td>
													SAR 164
												</td>
												<td>
													<div class="badge badge-soft-warning font-size-12">unpaid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>

												<td id="tooltip-container10">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
											<tr>
												<td>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" id="ordercheck11">
														<label class="form-check-label" for="ordercheck11">&nbsp;</label>
													</div>
												</td>
												
												<td><a href="javascript: void(0);" class="text-dark fw-bold">#BS15632</a> </td>
												<td>
													27 Dec, 2023
												</td>
												<td>James Hamilton</td>
												
												<td>
													SAR 154
												</td>
												<td>
													<div class="badge badge-soft-success font-size-12">Paid</div>
												</td>
												<td>
													<button class="btn btn-light btn-rounded">Invoice <i class="mdi mdi-download ml-2"></i></button>
												</td>
												<td id="tooltip-container11">
													<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="<?php echo base_url('store/order/detail/1');?>"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('stores/layout/footer');?>
<script>
	$(document).ready(function() {
    	$('#orderTable').dataTable({
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
    		"fixedHeader": true,
			"searching": true,
    		"columnDefs":[
    			{
    			 "targets":[0,1,2,3,4,5,6,7],
    			 "orderable":false
    			},
    		],
    	});
    	
    });
</script>
