<?php $this->load->view('admin/home/header');
$paytmColl = 0;
$coaColl = 0;
$cardColl = 0;
$poaColl = 0;

$TotalDelivery = 0;
$totalDelColl = 0;
if(!empty($results)){
    $TotalDelivery = count($results);
    //echo '<pre>';print_r($orders);'<pre>';exit();
	foreach($results as $delivery){
		if($delivery->payment_method == 'PayTm'){
			$paytmColl += $delivery->order_total;
		}
		if($delivery->payment_method == 'Cash On Arrival'){
			$coaColl += $delivery->collected_amt;
		}
		if($delivery->payment_method == 'Card On Arrival'){
			$cardColl += $delivery->collected_amt;
		}
		if($delivery->payment_method == 'PayTM On Arrival'){
			$poaColl += $delivery->collected_amt;
		}
	}
}
/*
if(!empty($cash_earn)){
    $allColl = count($cash_earn);
    //echo '<pre>';print_r($cash_earn);'<pre>';exit();
	foreach($cash_earn as $coll){
		$totalCash += $coll->collected_amount;
		$totalEarn += $coll->delivery_amt;
	}
}*/
?>
        			
<div class="page-title">
  <div class="title_left">
	<h3>Collection Reports</h3>
	
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
			 <h5><i class="fa fa-list"></i> Delivery Collection Reports</h5>
                <div class="x_panel">
					<form action="<?php echo base_url(); ?>admin/Order_process/CollectionReports" method="get" id="filter_form">
						<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="form-group">
								<label>From</label>
								<input type="text" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12">
								</div>
							</div>

							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="form-group">
								<label>To</label>
								<input type="text" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off"  class="form-control col-md-7 col-xs-12">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label for="nameFilter" class="col-form-label">Delivery Boy: </label>
									<select class="form-control" id="nameFilter" name="nameFilter">
										<option value="">--- Select Delivery Boy ---</option>
										<?php foreach($delivery_list as $delboy){ ?>
										<option value="<?php echo $delboy->id; ?>" <?php if($this->input->get('nameFilter') == $delboy->id){ echo 'selected'; }?>><?php echo $delboy->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label for="paymentFilter" class="col-form-label">Payment Method: </label>
									<select class="form-control" id="paymentFilter" name="paymentFilter">
										<option value="">--- Select Payment Method ---</option>
										<option value="PayTm" <?php if($this->input->get('paymentFilter') == 'PayTm'){ echo 'selected'; }?>>PAYTM</option>
										<option value="Cash On Arrival" <?php if($this->input->get('paymentFilter') == 'Cash On Arrival'){ echo 'selected'; }?>>Cash On Arrival</option>
										<option value="Card On Arrival" <?php if($this->input->get('paymentFilter') == 'Card On Arrival'){ echo 'selected'; }?>>Card On Arrival</option>
										<option value="PayTM On Arrival" <?php if($this->input->get('paymentFilter') == 'PayTM On Arrival'){ echo 'selected'; }?>>PayTM On Arrival</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-3">
								<button type="submit" class="btn btn-success">Filter</button>
								<a href="<?php echo base_url(); ?>admin/Order_process/CollectionReports" class="btn btn-warning">Reset Filter</a>
							</div>
						</div>
					</form>
                  <div class="x_content">

				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>S.No</th>
                          <th>O Id</th>
						  <th>Name</th>						  		
						  <th>Order Price</th>
						  <th>Amt. Col.</th>
						  <th>Order Date</th>
						  <th>Delv. Date</th>
						  <th>Payment Method</th>
						  <th>Collection Method</th>
						  <th>Order Status</th>
						  <th>Delivered By</th>
						  <th>Tools</th>
                        </tr>
                      </thead>
					  <tbody>
					  <?php $s = 1;
					  $total_shipping_collect = 0;
					 // echo '<pre>';print_r($result->result());exit();
					  foreach($results as $result){
					    $total_shipping_collect +=  $result->shipping_charge;
					?>
					  <tr>
					  <td><?php echo $s++;?></td>
					  <td><?php echo $result->id;?></td>
					  <td><?php echo $result->payment_firstname." ".$result->payment_lastname;?></td>		
					  					  				
					  <td><i class="fa fa-inr"></i> <?php echo $result->order_total;?></td>
					  <td><i class="fa fa-inr"></i> <?php echo $result->collected_amt;?></td>

					  <td><?php echo date("d/m/Y h:i A", strtotime($result->date_added));?></td>
					  <td><?php echo date("d/m/Y h:i A", strtotime($result->date_modified));?></td>
					   <td><?php echo $result->payment_method;?></td>				
					   <td><?php echo $result->delivery_payment;?></td>				
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
							echo '<div class="label label-success">Dispatched</div>';
						}
						
						if($result->order_status_id == '5'){
							echo '<div class="label label-success">Completed</div>';
						}
						
						if($result->order_status_id == '6'){
							echo '<div class="label label-warning">Cancel On Delivery</div>';
						}
						
						if($result->order_status_id == '7'){
							echo '<div class="label label-warning">Refund</div>';
						}
						
						if($result->order_status_id == '8'){
							echo '<div class="label label-warning">Cancel By Customer</div>';
						}
						
						?></td>
					  <td>
						<?php
							$alldb = $delivery_list;
							$dboy = $result->delivery_boy;
							//echo '<pre>'; print_r($alldb[0]->id);
							for($i = 0; $i < count($alldb); $i++)
							{
								//echo '<pre>'; print_r($alldb[$i]->id);
								if($alldb[$i]->id == $dboy)
								{
									echo $alldb[$i]->name .'<br/>'.$alldb[$i]->mobile;
								}else{
									echo '';
								}
							}
						?>
					  </td>
					  <td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/order_process/detail?id=<?php echo $result->id;?>"><i class="fa fa-info-circle"></i></button></td>
					  </tr>
					  <?php }?>
					  </tbody>
                    </table>
					<div class="row top_tiles">
						<div class="col-md-12">
						  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-paper-plane"></i></div> 
								<div><h3>Total Delivery: </h3></div>				  
							  <div class="count"><?php echo count($results); ?> </div>        
							  <h3></h3>       
							  </div>     
						  </div>  

						  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-inr"></i></div>
								<div><h3>Total Amount Collected: </h3></div>
							  <div class="count"><?php echo $paytmColl + $coaColl + $cardColl + $poaColl ?></div>
							  <h3></h3>    
							  </div>     
						  </div>
						  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-inr"></i></div>
								<div><h3>PayTm Collection: </h3></div>
							  <div class="count"><?php echo $paytmColl ?></div>
							  <h3></h3>    
							  </div>     
						  </div>
						  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-inr"></i></div>
								<div><h3>Cash Collection: </h3></div>
							  <div class="count"><?php echo $coaColl ?></div>
							  <h3></h3>    
							  </div>     
						  </div>
						  <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-inr"></i></div>
								<div><h3>Card Collection / Paytm QR Collection : </h3></div>
							  <div class="count"><?php echo $cardColl+$poaColl ?></div>
							  <h3></h3>    
							  </div>     
						  </div>
						  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">               
							  <div class="tile-stats" style="padding: 10px;">         
							  <div class="icon"><i class="fa fa-inr"></i></div>
								<div><h3>Shipping Charges Collected: </h3></div>
							  <div class="count"><?php echo $total_shipping_collect ?></div>
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
					"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
					 order: [[0, 'ASC']],
					dom: 'Blfrtip',
						buttons: [
							'csv'
						],
						
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
			}); 
			</script>