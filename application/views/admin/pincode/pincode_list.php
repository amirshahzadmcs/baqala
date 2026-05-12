<?php $this->load->view('admin/home/header');?>            
<div class="page-title">
	<div class="title_left">
		<h3>Pincode List</h3>
	</div>

  <div class="title_right">
  <a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add Bulk" href="<?php echo base_url()?>admin/pincode/add_bulk_pincode"><i class="fa fa-plus"></i> Add Bulk Pincode</a>
  <button class="btn btn-danger btn-sm pull-right" onclick="deletenow()" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
  <a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/pincode/add"><i class="fa fa-plus"></i></a>
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
	 <h5><i class="fa fa-list"></i> Pincode List</h5>
		<div class="x_panel">
		 
		  <div class="x_content">
		  <?php echo form_open('admin/pincode/delete', array("id"=>"delete_form"));?>
			<table id="example" class="table table-bordered">
			  <thead>
				<tr>
				  <th># &nbsp;<input type="checkbox" id="selectall" /></th>
				  <th>Pincode</th>
				  <th>Region</th>
				  <th>Area Name</th>
				  <th>Area</th>
				  <th>SVC</th>
				  <th>Service Code Name</th>
				  <th>City</th>
				  <th>State</th>
				  <th>EDP</th>
				  <th>Status</th>
				  <th>Tool</th>
				</tr>
			  </thead>
			  
			  <tbody>
			  <?php $i = 1;
			  foreach($result->result() as $result){?>
			  <tr>
			  <td><input type="checkbox" value="<?php echo $result->id;?>" name="check_list[]" class="checklist" /></td>
			  <td><?php echo $result->pincode;?></td>
			  <td><?php echo $result->region;?></td>
			  <td><?php echo $result->area_name;?></td>
			  <td><?php echo $result->area;?></td>
			  <td><?php echo $result->svc;?></td>
			  <td><?php echo $result->service_code_name;?></td>
			  <td><?php echo $result->city;?></td>
			  <td><?php echo $result->state;?></td>
			  <td><?php echo $result->edp;?></td>
			  <td>
				<?php 
				  if($result->status == 1){ 
					echo 'Active'; 
				  }else{
					echo "Deactive";
				  }
				?> 
			  </td>
			  <td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/pincode/add?id=<?php echo $result->id;?>"><i class="fa fa-pencil"></i></button></td>
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
			order: [[1, 'asc']],
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