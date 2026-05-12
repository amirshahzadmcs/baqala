<?php $this->load->view('admin/home/header');?>            			<div class="page-title">
              <div class="title_left">
                <h3>Complete Orders</h3>
				
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
			 <h5><i class="fa fa-list"></i> Orders List</h5>
                <div class="x_panel">
                 
                  <div class="x_content">
					<?php echo form_open("admin/order_process/complete_list", array('method'=>'GET'));?>
					<div class="col-sm-3"><input type="text" autocomplete="off" value="<?php echo $this->input->get('date_from');?>" class="form-control" placeholder="Date From" name="date_from" id="date_from" /></div>
					<div class="col-sm-3"><input type="text" autocomplete="off" value="<?php echo $this->input->get('date_to');?>" class="form-control" placeholder="Date To" name="date_to" id="date_to" /></div>
					<div class="col-sm-3"><input type="submit" class="btn btn-primary" value="Get List"/></div>
					<br/><br/>
					<?php echo form_close(); ?>
				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Order Id</th>
						  <th>Name</th>						  					
						  <th>Contact</th>						  		
						  <th>Order Price</th>						  	
						  <th>Order Date</th>
						  <th>Payment Method</th>
						  <th>Order Status</th>
						  <th>Tools</th>
                        </tr>
                      </thead>
					  <tbody>
					  <?php $i = 1;
					 // echo '<pre>';print_r($result->result());exit();
					  foreach($result->result() as $result){?>
					  <tr>
					  <td><?php echo $result->id;?></td>
					  <td><?php echo $result->payment_firstname." ".$result->payment_lastname;?></td>		
					  <td><?php echo $result->payment_mobile;?></td>					  				
					  <td><i class="fa fa-inr"></i> <?php echo $result->order_total;?></td>

					  <td><?php echo date("d/m/Y h:i A", strtotime($result->date_added));?></td>
					   <td><?php echo $result->payment_method;?></td>				
					    <td><?php if($result->order_status_id == '0'){
							echo '<div class="label label-danger">Payment Pending</div>';
						}
						if($result->order_status_id == '1'){
							echo '<div class="label label-success">Recieved</div>';
						}
						
						if($result->order_status_id == '2'){
							echo '<div class="label label-success">Accept</div>';
						}
						if($result->order_status_id == '3'){
							echo '<div class="label label-danger">Deny</div>';
						}
						
						if($result->order_status_id == '4'){
							echo '<div class="label label-success">Dispatched</div>';
						}
						
						if($result->order_status_id == '5'){
							echo '<div class="label label-success">Completed</div>';
						}
						
						?></td>
					  <td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/order_process/detail?id=<?php echo $result->id;?>"><i class="fa fa-info-circle"></i></button></td>
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
				"lengthMenu": [[50, 100, 500], [50, 100, 500]],
				 order: [[0, 'desc']],
				dom: 'Blfrtip',
					buttons: [
						'csv'
					],
					
			});
			}); 
			
			 $('#date_from').datetimepicker();
                  $('#date_to').datetimepicker({
                    useCurrent: false
                  });
                  $("#date_from").on("dp.change", function (e) {
                  $('#date_to').data("DateTimePicker").minDate(e.date);
                  });
                  $("#date_to").on("dp.change", function (e) {
                      $('#date_from').data("DateTimePicker").maxDate(e.date);
                  });
			</script>