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
							<h4>Stock Transfer Request</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript: void(0);">Stock Transfer Request</a></li>
								<li class="breadcrumb-item active">Detail</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
						<div class="float-end d-none d-sm-block">
							<a class="btn btn-custom-white btn-sm pull-right" title="Add" href="<?php echo base_url('store/warehouse/stock-request')?>"><i class="fa fa-reply"></i> Back</a>
							<a class="btn btn-custom-success btn-sm pull-right" title="Add" href="javascript:window.print()"><i class="fa fa-print"></i> Print</a>
							<!--
							<button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this request?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
							-->
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
								<div>
									<?php if($this->customer->getInfo()){ 
									$info = explode("--", $this->customer->getInfo());
									$info_type = $info[0];
									$msg_data = $info[1];
									if($info_type == 2){
									?>  
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Error!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } else{?>
									<div class="alert alert-success alert-dismissible fade show" role="alert">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										<strong>Success!</strong>  <?php echo $msg_data; ?>
									</div>
									<?php } } $this->customer->removeInfo();?>
								</div>
								<?php echo form_open('store/stock_request/delete', array("id"=>"delete_form"));?>
									<div class="row">
										<div class="col-12">
											<div class="invoice-title">
												<h4 class="float-end font-size-16"><strong>#<?= $order->request_id;?></strong></h4>
												<h5 class="m-t-0">
													<!--<img src="<?= base_url('store_assets/images/logo.png');?>" alt="logo" height="50"/>-->
													Stock Transfer Request
												</h5>
											</div>
											<hr>
											<div class="row">
												<div class="col-4">
													<address>
														<strong>Supplier Information:</strong><br>
														<?= $warehouse_address->name_english;?><br>
														<?= '<strong>Email:</strong> '.$warehouse_address->warehouse_email;?><br>
														<?= '<strong>Phone:</strong> '.$warehouse_address->warehouse_phone;?><br>
														<?= '<strong>Address:</strong> '.$warehouse_address->complete_address;?>
													</address>
												</div>
												<div class="col-4">
													<address>
														<strong>Billing Information:</strong><br>
														<?= $order->store_name;?><br>
														<?= '<strong>Contact Person:</strong> '.$order->store_incharge;?><br>
														<?= '<strong>Contact Number:</strong> '.$order->contact_number;?><br>
														<?= '<strong>Address:</strong> '.$order->store_location;?><br>
													</address>
												</div>
												<div class="col-4 text-end">
													<address>
														<strong>Request Date:</strong><br>
														<?= date("d-m-Y h:i:s", strtotime($order->created_at)); ?><br>
														<strong>Expected Delivery Date:</strong><br>
														<?= date("d-m-Y h:i:s", strtotime($order->expected_date)); ?><br>
														<strong>Request Status:</strong><br>
														<?= '<span class="badge badge-pill badge-soft-'. $order->status_type .' font-size-13">'. $order->status_name .'</span>'; ?><br>
													</address>
												</div>
											</div>
											
										</div>
									</div>
	
									<div class="row">
										<div class="col-12">
											<div class="panel panel-default">
												<div class="p-2">
													<h3 class="panel-title font-size-20">Product summary</h3>
												</div>
												<div class="">
													<div class="table-responsive">
														<table class="table">
															<thead>
															<tr>
																<td class="text-start"><strong>SKU</strong></td>
																<td class="text-start"><strong>Barcode</strong></td>
																<td class="text-start"><strong>Item Description</strong></td>
																<td class="text-start"><strong>Size</strong></td>
																<td class="text-end"><strong>Request Unit</strong></td>
																<td class="text-end"><strong>Approved Unit</strong></td>
															</tr>
															</thead>
															<tbody>
															<?php foreach ($products as $product){ ?>
															<tr>
																<td class="text-start"><?= $product->parent_sku;?>-<?= $product->item_sku;?></td>
																<td class="text-start"><?= $product->barcode;?></td>
																<td class="text-start"><?= $product->item_description;?></td>
																<td class="text-start"><?= $product->size;?></td>
																<td class="text-end"><?= $product->item_unit;?></td>
																<td class="text-end"><?= $product->approved_unit;?></td>
															</tr>
															<?php } ?>
															</tbody>
														</table>
													</div>
													<!--
													<div class="d-print-none mo-mt-2">
														<div class="float-end">
															<a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
															
														</div>
													</div>
													-->
												</div>
											</div>
	
										</div>
									</div> <!-- end row -->
								<?php echo form_close(); ?>
							</div>
						</div>
					</div> <!-- end col -->
				</div> <!-- end row -->
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
	$('#request_table').dataTable({
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
			url:"<?php echo base_url();?>store/stockrequest/request_list",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "orderable":false
			},
		]
	});
});
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
	console.log(message);
};	
</script>
