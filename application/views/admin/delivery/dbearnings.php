<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Earning List</h3>
	</div>
	<div class="title_right">
	    <a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/delivery/detail?id=<?php echo $this->input->get('id');?>"><i class="fa fa-reply"></i></a>
		<?php if($this->admin->getInfo()){ 
		$info = explode("--", $this->admin->getInfo());
		$info_type = $info[0];
		$msg_data = $info[1];
		if($info_type == 2){
		?>
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
			<?php }else{?>
			<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
			<?php } echo $msg_data; ?>
			</div>
			<?php } $this->admin->removeInfo();?>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h5><i class="fa fa-list"></i> &nbsp;Earning List</h5>
		<div class="x_panel">
			<div class="x_content">
				<table id="example" class="table table-bordered">
                  <thead>
                    <tr>
					  <th>Order Id</th>
					  <th>Collected Amt.</th>
					  <th>Payment Type</th>		  	
					  <th>Delivery Charge</th>
					  <th>Delivery Status</th>
					  <th>Delivered On</th>
					</tr>
                  </thead>
                  <tbody>
                  <?php $i = 1;
				  $total_collect = 0;
                  foreach($earnings as $order){
                    $total_collect += $order->delivery_amt;
                  ?>
                  <tr>
						<td><?php echo $order->order_id;?></td>
						<td><i class="fa fa-inr"></i> <?php echo $order->collected_amount;?></td>
						<td><?php echo $order->payment_type;?></td>
						<td><i class="fa fa-inr"></i> <?php echo $order->delivery_amt;?></td>

						
					    <td><?php if($order->delivery_status == '0'){
							echo '<div class="label label-danger">Payment Pending</div>';
						}
						if($order->delivery_status == '1'){
							echo '<div class="label label-success">Recieved</div>';
						}
						
						if($order->delivery_status == '2'){
							echo '<div class="label label-success">Accept</div>';
						}
						if($order->delivery_status == '3'){
							echo '<div class="label label-danger">Deny</div>';
						}
						
						if($order->delivery_status == '4'){
							echo '<div class="label label-success">Dispatched</div>';
						}
						
						if($order->delivery_status == '5'){
							echo '<div class="label label-success">Completed</div>';
						}
						
						if($order->delivery_status == '6'){
							echo '<div class="label label-success">Declined by user</div>';
						}
						
						?></td>
						<td><?php echo date("d/m/Y h:i A", strtotime($order->created_at));?></td>
					  
					</tr>
                  <?php }?>
                  </tbody>
                </table>
                
				<div class="row top_tiles">
					<div class="col-md-12">
					  <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">               
					  <div class="tile-stats" style="padding: 10px;">         
					  <div class="icon"><i class="fa fa-paper-plane"></i></div> 
						<div><h3>Total Delivery: </h3></div>				  
					  <div class="count"><?php echo count($earnings); ?> </div>        
					  <h3></h3>       
					  </div>     
					  </div>  

					  <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">               
					  <div class="tile-stats" style="padding: 10px;">         
					  <div class="icon"><i class="fa fa-inr"></i></div>
						<div><h3>Total Earning Amount: </h3></div>
					  <div class="count"><?php echo $total_collect ?></div>
					  <h3></h3>    
					  </div>     
					  </div>
					</div>
                </div>
			</div>
		</div>
	</div>

<?php $this->load->view('admin/home/footer');?>

<script>
	$(document).ready(function() {

		$('#example').dataTable({

			"lengthMenu": [
				[50, 100, 500],
				[50, 100, 500]
			],

			dom: 'Blfrtip',
			buttons: [
				'csv'
			],
		});
	});

	$(document).on("click", "#selectall", function() {
		$('.checklist').prop('checked', this.checked);
	});

	function deletenow() {
		if ($(".checklist:checked").length > 0) {
			confirm('Really want to delete this task(s)?') ? $('#delete_form').submit() : false;
		} else {
			alert("Please select appropriate checkbox to delete.");
		}
	}
</script>