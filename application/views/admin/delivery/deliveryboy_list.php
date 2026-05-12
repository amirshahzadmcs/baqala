<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper {
    overflow-y: inherit;
}
.dropdown-menu {
	font-size: 14px;
    min-width: 120px;
}
.dropdown-menu>li>a {
    color: #000000;
	padding: 3px 8px;
}
.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover {
    color: #ffffff;
    text-decoration: none;
    background-color: #f44336;
}  
.dropdown-menu {
    position: inherit !important;
}

</style>
	<div class="page-title">
	  <div class="title_left">
		<h3>Delivery Boy List</h3>
		
	  </div>

	  <div class="title_right">
	  <button class="btn btn-danger btn-sm pull-right" onclick="confirm('Really want to delete these Users?') ? $('#delete_form').submit() : false;" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
	<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/delivery/add"><i class="fa fa-plus"></i></a>
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
			 <h5><i class="fa fa-list"></i> Delivery Boy List</h5>
                <div class="x_panel">
                 
                  <div class="x_content">
				  <?php echo form_open("admin/delivery/delete", array("id"=>"delete_form"));?>
				    <table id="example" class="table table-bordered" style="text-transform: capitalize;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>						  
                          <th>mobile</th>					  
                          <th>Iqama No.</th>				  					  
                          <th>Orders</th>				  					  
                          <th>Delivery Ch.</th>		  					  
                          <th>Last Online</th>		  					  
                          <th>Reg. Date</th>		  					  
                          <th>Status</th>					  					  
						  <th>Tools</th>
                        </tr>
                      </thead>
					  
                    </table>
					<?php echo form_close();?>
                  </div>				 
                  </div>                
                  </div>
			
			<?php $this->load->view('admin/home/footer');?>
			
			<script>
			$(document).ready(function() {
				$('#example').dataTable({
					"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
					"processing":true,  
					"serverSide":true,  
					"order":[],  
					"ajax":{  
							url:"<?php echo base_url();?>admin/delivery/get_list",  
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
			