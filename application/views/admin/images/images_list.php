<?php $this->load->view('admin/home/header');?>            <div class="page-title">
              <div class="title_left">
                <h3>Uploaded Images</h3>
				
              </div>

              <div class="title_right">
			  <button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete this page?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
			  
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
			 <h5><i class="fa fa-list"></i> Images List</h5>
                <div class="x_panel">
                 
                  <div class="x_content">									

				  <div class="col-sm-6" style="padding-bottom:15px;"><select class="form-control" id="customer_id" onchange="set_user()">						<option value="">SELECT USER</option>						<?php foreach($users->result() as $user){?>						<option value="<?php echo $user->id;?>" <?php echo ($user->id == $this->input->get('user')) ? 'selected':'';?>><?php echo $user->username;?></option>						<?php } ?>					</select>		</div>			
				  <?php echo form_open('admin/images/delete', array("id"=>"delete_form"));?>
				    <table id="example" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
						  <th>Customer</th>						  						  <th>Image</th>						  						  <th>Date</th>
						  
                        </tr>
                      </thead>
					  <tbody>
					  <?php $i = 1;
					  foreach($result->result() as $result){?>
					  <tr>
					  <td><input type="checkbox" value="<?php echo $result->id;?>" name="check_list[]" /></td>
					  <td><?php echo $result->user_name;?></td>					  					  <td><a href="<?php  echo base_url().$result->image;?>" target="_blank"><img src="<?php echo base_url().$result->image;?>" width="100px" /></a></td>
					  <td><?php echo date("d/m/Y", strtotime($result->created));?></td>
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
				dom: 'Blfrtip',
					buttons: [
						'csv'
					],
					
			});
			}); 
			
			function set_user(){
				location.href = '<?php echo base_url();?>admin/images?user='+$("#customer_id").val();
			}
			</script>