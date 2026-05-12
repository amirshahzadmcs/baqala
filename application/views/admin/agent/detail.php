<?php $this->load->view('admin/home/header');?>
            <div class="page-title">
              <div class="title_left">
                <h3>Agent</h3>
				
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
			 <h5><i class="fa fa-list"></i> Agent Detail</h5>
                <div class="x_panel">
                 
                  <div class="x_content">
				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th><td><?php echo $result->id;?></td></tr>
                        
                          <tr><th>Name</th><td><?php echo $result->name;?></td></tr>
                          <tr>						  
                          
                          					  
                          <th>Email</th><td><?php echo $result->email;?></td></tr>
                          <tr>						  
                          <th>Phone</th><td><?php echo $result->phone;?></td></tr>
                          <tr>						  
							  <th valign="middle">Referal Code</th>	
							  <td>
								<?php echo $result->ref_code;?>
							  </td>
						  </tr>
						  <tr>						  
							  <th valign="middle">Account Number</th>	
							  <td>
								<?php echo $result->account_no;?>
							  </td>
						  </tr>
						  <tr>						  
							  <th valign="middle">Bank Name</th>	
							  <td>
								<?php echo $result->bank_name;?>
							  </td>
						  </tr>
						  <tr>						  
							  <th valign="middle">Bank IFSC</th>	
							  <td>
								<?php echo $result->ifsc;?>
							  </td>
						  </tr>
						  <tr>						  
							  <th valign="middle">Status</th>	
							  <td>
								<?php echo $result->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>'; ?>
							  </td>
						  </tr>
                          <tr>						  
							  <th valign="middle">Added On</th>	
							  <td>
								<?php echo $result->created_at;?>
							  </td>
						  </tr>
						  <tr>						  
							  <th valign="middle">Last Updated</th>	
							  <td>
								<?php echo $result->updated_at;?>
							  </td>
						  </tr>
                      </thead>
					  
                    </table>
					</div>				 
                  </div>                
                  </div>
			
			<?php $this->load->view('admin/home/footer');?>
			
			