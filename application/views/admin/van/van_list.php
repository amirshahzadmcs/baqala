<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Delivery Van List (Marshalling)</h3>
	</div>

	<?php  $admin_id= $this->session->userdata('admin_id'); ?>
	<div class="title_right">
		<button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteAction()" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
		<button type="button" class="btn btn-success btn-sm pull-right" onclick="EnableStatus()" data-toggle="tooltip" title="Enable"><i class="fa fa-eye"></i></button>
		<button type="button" class="btn btn-danger btn-sm pull-right" onclick="DisableStatus()" data-toggle="tooltip" title="Disable"><i class="fa fa-ban"></i></button>
		<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/van/add"><i class="fa fa-plus"></i> ADD VAN</a>
		
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
<h5><i class="fa fa-list"></i> Delivery Van List</h5>
<div class="x_panel">

<div class="x_content">
<form id="myform" name="myform" method="post" action="">
<table id="example" class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>#</th>
<th>Van No</th>
<th>Driver Name</th>				  
<th>Arabic Name</th>	  
<th>Status</th>				  
<th>Tools</th>
</tr>
</thead>
<tbody>
<?php 
$i=1;
foreach($result as $result){
?>
<tr>
<th scope="row"><input type="checkbox" name="checklist[]" value="<?php echo $result['id'];?>"></th>
<th scope="row"><?php echo $i++; ?></th>
<td><?php echo $result['van_no'];?></td>
<td><?php echo $result['dname'];?></td>
<td><?php echo $result['arabic_name'];?></td>
<td><?php echo $result['status'] == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';?></td>
<td>
<a class="btn btn-warning btn-sm" href="<?php echo base_url()?>admin/van/add?id=<?php echo $result['id'];?>"><i class="fa fa-pencil"></i>
<a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/orderdispatch/getDispatchList?id=<?php echo $result['id'];?>">Dispatch List</a>
</td>
</tr>

<?php } ?>
</tbody>
</table>
</form>
</div>				 
</div>                
</div>

<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#example').dataTable({
		"lengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
		dom: 'Blfrtip',
		buttons: [
		'csv'
		],
	});
});


function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected category?") == true) {
			changeActionAndSubmit('van/delete');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}
	
var EnableStatus = function() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to enable selected category?") == true) {
			changeActionAndSubmit('van/setStatusEnable');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function DisableStatus() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to disable selected category?") == true) {
			changeActionAndSubmit('van/setStatusDisable');
		} else {
			userPreference = "Action Cancelled!";
		}
	}else{
		alert('Plese select check box first');
	}
}

function changeActionAndSubmit(action) {
	document.getElementById('myform').action = action;
	document.getElementById('myform').submit();
}
</script>