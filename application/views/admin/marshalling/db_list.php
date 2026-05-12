<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Delivery Boy List (Marshalling)</h3>

</div>
<?php  $admin_id= $this->session->userdata('admin_id'); ?>
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
<h5><i class="fa fa-list"></i> Delivery Boy List</h5>
<div class="x_panel">

<div class="x_content">
<form id="myform" name="myform" method="post" action="">
<table id="example" class="table table-bordered">
<thead>
<tr>
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
<th scope="row"><?php echo $i++; ?></th>
<td><?php echo $result['van_no'];?></td>
<td><?php echo $result['name'];?></td>
<td><?php echo $result['arabic_name'];?></td>
<td><?php echo $result['status'] == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';?></td>
<td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/orderdispatch/getDispatchList?id=<?php echo $result['id'];?>">Dispatch List</a></td>
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
"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
dom: 'Blfrtip',
buttons: [
'csv'
],
});
});

</script>