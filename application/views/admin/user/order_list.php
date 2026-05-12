<?php $this->load->view('admin/home/header');?>  
<?php 
if($this->input->get('status') == '1'){
	$statusString = 'Pending';
}elseif($this->input->get('status') == '9'){
	$statusString = 'Cancelled';
}elseif($this->input->get('status') == '6'){
	$statusString = 'Completed';
}else{
	$statusString = 'All';
}
?>  			
<div class="page-title">
              <div class="title_left">
                <h3><?php echo $statusString; ?> Orders</h3>
				
              </div>

              <div class="title_right">
			 
			
 <?php if($this->admin->getInfo()){ 
		$info = explode("--", $this->admin->getInfo());
		$info_type = $info[0];
		$msg_data = $info[1];
		if($info_type == 2){
 ?>  
 <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
		<?php } else{?>
		 <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
		<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
              </div>
            </div>
			
            <div class="clearfix"></div>
			<div class="col-md-12 col-sm-12 col-xs-12">
			 <h5><i class="fa fa-list"></i><?php echo $statusString; ?> Orders List</h5>
                <div class="x_panel">
                  <div class="x_content">

				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Order Id</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>Contact</th>						  		
						  <th>Order Price</th>						  	
						  <th>Order Date</th>
						  <th>Payment Method</th>
						  <th>Delv. Address</th>
						  <th>Order Status</th>
						  <th>Delivered By</th>
                        </tr>
                      </thead>
					  <tbody>
					  <?php $sno = 1;
					 // echo '<pre>';print_r($result->result());exit();
					  foreach($orders as $result){?>
					  <tr>
					  <td><?php echo $sno++;?></td>
					  <td>
						<?php echo $result->invoice_prefix .'-'. $result->id; ?>
					  </td>
					  <td>
						<?php echo $result->name;?><br/>
						<?php 
							if($result->c_role == '2'){
								echo '<div class="label label-success">Business</div>';
							}
						?>
					  </td>	
					  <td><?php echo $result->email;?></td>	
					  <td><?php echo $result->mobile;?></td>					  				
					  <td><?php echo $result->order_total;?> SAR</td>

					  <td><?php echo date("d/m/Y h:i A", strtotime($result->date_added));?></td>
					  <td><?php echo $result->payment_method;?></td>			
					  <td><?php echo $result->shipping_complete_address;?></td>				
					  <td><?php if($result->order_status_id == '0'){
							echo '<div class="label label-info">Payment Pending</div>';
						}
						if($result->order_status_id == '1'){
							echo '<div class="label label-primary">Recieved</div>';
						}
						
						if($result->order_status_id == '2'){
							echo '<div class="label label-success">Accepted</div>';
						}
						if($result->order_status_id == '3'){
							echo '<div class="label label-danger">Cancel By Admin</div>';
						}
						if($result->order_status_id == '4'){
							echo '<div class="label label-primary">Van Assigned</div>';
						}
						if($result->order_status_id == '5'){
							echo '<div class="label label-success">Dispatched</div>';
						}
						
						if($result->order_status_id == '6'){
							echo '<div class="label label-success">Delivered</div>';
						}
						
						if($result->order_status_id == '7'){
							echo '<div class="label label-warning">Cancel On Delivery</div>';
						}
						
						if($result->order_status_id == '8'){
							echo '<div class="label label-warning">Refund</div>';
						}
						
						if($result->order_status_id == '9'){
							echo '<div class="label label-warning">Cancel By Customer</div>';
						}
						
						?></td>
					  <td>
					      <?php echo $result->db_name; ?>
					  </td>
					  </tr>
					  <?php }?>
					  </tbody>
                    </table>
                  </div>				 
                  </div>                
                  </div>

			<?php $this->load->view('admin/home/footer');?>
			
			<script>
			 $(document).ready(function() {
				$('#example').dataTable({
				"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
				order: [[0, 'asc']],
				dom: 'Blfrtip',
				buttons: [
					'csv'
				],
					
			});
			}); 
			</script>