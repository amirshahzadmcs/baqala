<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Van Report List</h3>
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

	<div class="clearfix"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<h5><i class="fa fa-list"></i> Van Report List</h5>
		<div class="x_panel">
            <div class="x_content">
              <h4>Van Report List</h4>
                <form action="<?php echo base_url(); ?>admin/van/get_consignment" method="get" id="filter_form">
        			<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
        			    <input type="hidden" id="id" name="id" value="<?php echo $this->input->get('id') ?>" />
        			    <div class="col-md-4">
        					<div class="col-md-6 col-sm-3 col-xs-12">
        						<div class="form-group">
        						<label>From</label>
        						<input type="text" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12">
        						</div>
        					</div>
        
        					<div class="col-md-6 col-sm-3 col-xs-12">
        						<div class="form-group">
        						<label>To</label>
        						<input type="text" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off"  class="form-control col-md-7 col-xs-12">
        						</div>
        					</div>
        				</div>
        				<div class="col-md-4" style="margin-top: 22px;">
        				    <button type="submit" class="btn btn-success">Filter</button>
        				    <a href="<?php echo base_url(); ?>admin/van/get_consignment?id=<?php echo $this->input->get('id') ?>" class="btn btn-warning">Reset Filter</a>
        				</div>
        			</div>
    			</form>
                <table id="example1" class="table table-bordered" style="text-transform: capitalize;">
                  <thead>
                    <tr>
					  <th>S.No.</th>
					  <th>Consignment Id</th>			  		
					  <th>Order Ids</th>			  		
					  <th>Delivery Executive</th>						  	
					  <th>Van No.</th>						  	
					  <th>Assigned On</th>
					  <th>Tools</th>
					</tr>
                  </thead>
                  <tbody>
				  <?php $i = 1;
					foreach($results as $order){
                  ?>
                  <tr>
                        <td><?php echo $i++;?></td>
						<td><?php echo $order->id;?></td>
						<td><?php echo $order->order_ids;?></td>
						<td><?php echo $order->delivery_executive;?></td>
						<td><?php echo $order->van_no;?></td>
						<td><?php echo date("d/m/Y h:i A", strtotime($order->created_at));?></td>
						<td><a class="btn btn-primary btn-sm" data-toggle="tooltip" title="Report" href="<?php echo base_url()?>admin/van/get_report?id=<?php echo $order->id;?>"><i class="fa fa-list"></i></a>
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
			
			