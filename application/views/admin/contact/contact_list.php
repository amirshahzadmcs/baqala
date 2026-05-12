<?php $this->load->view('admin/home/header');?>
            <div class="page-title">
              <div class="title_left">
                <h3>Contact Form</h3>
				
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
			 <h5><i class="fa fa-list"></i> Contact Form List</h5>
                <div class="x_panel">
                 
                  <div class="x_content">
				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>						  
                          <th>Email</th>						  
                          <th>Contact Number</th>						  
                          <th>Subject</th>						  
						  <th>Message</th>
                        </tr>
                      </thead>
					  
                    </table>
                  </div>				 
                  </div>                
                  </div>
			
			<?php $this->load->view('admin/home/footer');?>
			
			<script>
			$(document).ready(function() {
			$('#example').dataTable({
				"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
				"processing":true,  
				"serverSide":true,  
				"order":[],  
				"ajax":{  
						url:"<?php echo base_url();?>admin/contact/get_list",  
						type:"POST"
					},  
					"columnDefs":[  
					{  
                     "targets":[0,2],  
                     "orderable":false
					},  
				]
			});
			});
			</script>
			