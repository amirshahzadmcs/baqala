<?php $this->load->view('admin/home/header');?>
<style>
.tile-stats .count {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.65857;
}
.x_content h4 {
    font-size: 14px;
    font-weight: 500;
}
</style>
<div class="page-title">
	<div class="title_left">
		<h3>Van Delivery Report</h3>
	</div>

	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/van"><i class="fa fa-reply"></i></a>
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
	<?php
		$total_collect = 0;
		$total_delivered = 0;
		$total_pending = 0;
		$total_canceled = 0;
		foreach($results as $order){
			$total_collect += $order->d_charge;
			if($order->order_status_id == '5'){
				$total_pending += count($order->order_status_id);
			}
			
			if($order->order_status_id == '6'){
				$total_delivered += count($order->order_status_id);
			}
			
			if($order->order_status_id == '7'){
				$total_canceled += count($order->order_status_id);
			}
		}
	  ?>
	<div class="clearfix"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
            <div class="x_content">
				<h4>Van Delivery Report</h4>
			  
				<div class="row top_tiles">  
					<div>
						<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
							<div class="tile-stats bg-blue" style="padding: 10px;">
								<h4>Total Delivery:</h4>
								<div class="count"><?php echo count($results); ?> </div>
							</div>     
						</div>
						
						<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
							<div class="tile-stats bg-green" style="padding: 10px;"> 
								<h4>Total Amount Collected:</h4>
								<div class="count"><?php echo $total_collect ?></div>
							</div>     
						</div>
						
						<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
							<div class="tile-stats bg-red" style="padding: 10px;"> 
								<h4>Delivered:</h4>
								<div class="count"><?php echo $total_delivered ?></div>
							</div>     
						</div>
						
						<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
							<div class="tile-stats bg-orange" style="padding: 10px;"> 
								<h4>Pending:</h4>
								<div class="count"><?php echo $total_pending ?></div>
							</div>     
						</div>
						<div class="animated flipInY col-lg-2 col-md-2 col-sm-4 col-xs-12">               
							<div class="tile-stats bg-green" style="padding: 10px;"> 
								<h4>Cancel On Delivery:</h4>
								<div class="count"><?php echo $total_canceled ?></div>
							</div>     
						</div>
						
					</div>
				</div>
			  
                <table id="example1" class="table table-bordered" style="text-transform: capitalize;">
                  <thead>
                    <tr>
					  <th>S.No.</th>
					  <th>Order Id</th>			  		
					  <th>O. Price</th>						  	
					  <th>O. Date</th>
					  <th>Delivered On</th>
					  <th>Pmt. Method</th>
					  <th>Amt. Cl.</th>
					  <th>Remarks</th>
					  <th>Order Status</th>
					</tr>
                  </thead>
                  <tbody>
                  <?php $i = 1;
					foreach($results as $order){
                  ?>
                  <tr>
                        <td><?php echo $i++;?></td>
						<td><?php echo $order->invoice_prefix .'-'. $order->id;?></td>
						<td><?php echo $order->order_total;?></td>
						<td><?php echo date("d/m/Y h:i A", strtotime($order->date_added));?></td>
						<td><?php echo date("d/m/Y h:i A", strtotime($order->delivery_date));?></td>
						<td><?php echo $order->payment_method;?></td>
						<td><?php echo $order->collected_amt;?></td>
						<td><?php echo $order->cancelreason;?></td>
					    <td><?php if($order->order_status_id == '0'){
							echo '<div class="label label-info">Payment Pending</div>';
							}
							if($order->order_status_id == '1'){
								echo '<div class="label label-primary">Recieved</div>';
							}
							
							if($order->order_status_id == '2'){
								echo '<div class="label label-success">Accepted</div>';
							}
							if($order->order_status_id == '3'){
								echo '<div class="label label-danger">Cancel By Admin</div>';
							}
							if($order->order_status_id == '4'){
								echo '<div class="label label-primary">Van Assigned</div>';
							}
							if($order->order_status_id == '5'){
								$total_pending += count($order->order_status_id);
								echo '<div class="label label-success">Dispatched</div>';
							}
							
							if($order->order_status_id == '6'){
								$total_delivered += count($order->order_status_id);
								echo '<div class="label label-success">Delivered</div>';
							}
							
							if($order->order_status_id == '7'){
								$total_canceled += count($order->order_status_id);
								echo '<div class="label label-warning">Cancel On Delivery</div>';
							}
							
							if($order->order_status_id == '8'){
								echo '<div class="label label-warning">Refund</div>';
							}
							
							if($order->order_status_id == '9'){
								echo '<div class="label label-warning">Cancel By Customer</div>';
							}
							
							?>
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
		$('#example1').dataTable({
    		"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
    		dom: 'Blfrtip',
    			buttons: [
    				'csv'
    			],
    			
    	});
	});
	
	$('#_from').datetimepicker({
		format: 'MM/DD/YYYY'
				
			  });
			  $('#_to').datetimepicker({
				format: 'MM/DD/YYYY',
				useCurrent: false
			  });
		$("#_from").on("dp.change", function (e) {
			$('#_to').data("DateTimePicker").minDate(e.date);
		});
		$("#_to").on("dp.change", function (e) {
			$('#from').data("DateTimePicker").maxDate(e.date);
	});
</script>
			
			