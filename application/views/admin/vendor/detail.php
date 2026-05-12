<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Supplier Detail</h3>
	</div>
	<div class="title_right">
	</div>
</div>
<div class="clearfix"></div>	  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h5><i class="fa fa-pencil"></i> Supplier Detail</h5>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<br />
				<ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Orders</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<table id="example" class="table table-bordered">
							<thead>
								<tr><th>#</th><td><?php echo $result->id;?></td></tr>
								<tr><th>Name</th><td><p><?php echo $result->vendor_name;?></p><p text-align="right"><?php echo $result->vendor_arabic_name;?></p></td></tr>
								<tr><th>Conatct Number</th><td><p><?php echo $result->alternate_no;?></p></td></tr>
								<tr><th>Email ID</th><td><p><?php echo $result->vendor_email;?></p></td></tr>
								<tr><th>Building Name</th><td><p><?php echo $result->building_no;?></p></td></tr>
								<tr><th>Street Name</th><td><p><?php echo $result->street_name;?></p></td></tr>
								<tr><th>District</th><td><p><?php echo $result->district;?></p></td></tr>
								<tr><th>City</th><td><p><?php echo $result->city;?></p></td></tr>
								<tr><th>Country</th><td><p><?php echo $result->country;?></p></td></tr>
								<tr><th>Postal Code</th><td><p><?php echo $result->postal_code;?></p></td></tr>
								<tr><th>Vat Number</th><td><p><?php echo $result->vat_number;?></p></td></tr>
								<tr><th>Other Buyer ID</th><td><p><?php echo $result->other_buyer_id;?></p></td></tr>
								<tr><th>Status</th><td><p><?php echo $result->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';?></p></td></tr>
								<tr><th>Created On</th><td><p><?php echo $result->created_at;?></p></td></tr>
								<tr><th>Updated On</th><td><p><?php echo $result->updated_at;?></p></td></tr>
								<tr>
									<th>Documents</th>
									<td>
										<?php foreach($docs as $doc){
											$fileExt = pathinfo($doc->document, PATHINFO_EXTENSION);
											if($fileExt == 'jpg' || $fileExt == 'png' || $fileExt == 'JPG' || $fileExt == 'PNG'){
												echo '<div class="col-md-2 text-center"><img src="'. base_url($doc->document) .'" height="70px" /><br>'. $doc->doc_name .'</div>';
											}else{
												echo '<div class="col-md-2 text-center"><a href="'. base_url($doc->document) .'" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a><br>'. $doc->doc_name .'</div>';
											}
										}?>
									</td>
								</tr>
							</thead>
						</table>
					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<table id="vendor_table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>				  
									<th>Purchaser Name</th>				  
									<th>Purchaser Address</th>				  
									<th>Phone No.</th>				  
									<th>Recipient Name</th>				  
									<th>Recipient Address</th>			  
									<th>Recipient Phone</th>			  
									<th>P.O Number</th>			  
									<th>P.O Address</th>			  
									<th>P.O Phone</th>			  
									<th>P.O Date</th>  
									<th>Requisitioner</th>	
									<th>Shipped Via</th>						
									<th>FOB Point</th>						
									<th>Terms</th>						
									<th>Sub Total</th>						
									<th>Sale Tax</th>					
									<th>Shipping Handling</th>				
									<th>Total</th>				
									<th>Status</th>	
									<th>Created</th>							
									<th>Updated</th>							
									<th>Tools</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#vendor_table').dataTable({
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
				url:"<?php echo base_url();?>admin/vendor/get_order_list?id=<?php echo $this->input->get('id');?>",  
				type:"POST"
			},  
			"columnDefs":[  
			{  
			 "targets":[0,1],  
			 "orderable":false
			},  
		]
	});
});
</script> 
