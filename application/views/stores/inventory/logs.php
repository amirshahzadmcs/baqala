<?php $this->load->view('stores/layout/header');?>
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
							<h4>Inventory Logs</h4>
							<ol class="breadcrumb m-0">
								<li class="breadcrumb-item"><a href="<?php echo base_url('store');?>">Home</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('store/inventory/inventory-logs');?>">Inventory</a></li>
								<li class="breadcrumb-item active">Logs</li>
							</ol>
						</div>
                    </div>
					<div class="col-sm-6">
					    <div class="flash-message">
							<?php if($this->store->getInfo()){ 
							$info = explode("--", $this->store->getInfo());
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
							<?php } } $this->store->removeInfo();?>
						</div>
    					<div class="float-end d-none d-sm-block">
    					    
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
							<table id="storeInventory" class="table table-striped table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
								<thead>
									<tr style="background-color:#74788d !important; color: white;">
										<th align="center">S.NO</th>
    									<th align="left">PRODUCT SKU</th>
    									<th align="left">BARCODE</th>
    									<th class="text-center">PRODUCT DESCRIPTION</th>
    									<th align="left">SIZE</th>
    									<th align="left">QTY</th>
    									<th align="left">STATUS</th>
    									<th align="left">COMMENTS</th>
    									<th align="left">REMARKS</th>
    									<th align="left">DATE</th>
									</tr>
								</thead>
			
								<tbody>
								
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('stores/layout/footer');?>

<script type="text/javascript">
	
	$(document).ready(function() {
    	$('#storeInventory').dataTable({
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
			"searching": true,
    		"ajax":{
    			url:"<?php echo base_url();?>store/inventory/inventory-logs-ajax",
    			type:"POST"
    		},
    		"columnDefs":[
    			{
    			 "targets":[0,1,2,3,4,5,6,7,8,9],
    			 "orderable":false
    			},
    		],
    	});
    	
    });
    
</script>
