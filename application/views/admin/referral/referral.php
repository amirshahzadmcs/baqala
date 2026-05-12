<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Referral Charges</h3>

</div>

<div class="title_right">
<!--
<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/express_shipping/add"><i class="fa fa-plus"></i></a>-->
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
<h5><i class="fa fa-list"></i>Referral Charges List</h5>
<div class="x_panel">

<div class="x_content">
<table id="example" class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Heading</th>
<th>Referral Amount</th>
<th>Referer Amount</th>
<th>Content</th>
<th>status</th>
<th>Tools</th>
</tr>
</thead>
<tbody>
<?php $i = 1;
foreach($list as $ref){?>
<tr>
<td><?php echo $i++;?></td>
<td><?php echo $ref->referral_type;?></td>
<td><?php echo $ref->referral_charge;?></td>
<td><?php echo $ref->refferer_amount;?></td>
<td><?php echo $ref->content;?></td>
<td><?php echo $ref->status == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';?></td>
<td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/referral/add?id=<?php echo $ref->id;?>"><i class="fa fa-pencil"></i></a>
<!--
<a class="btn btn-danger btn-sm" href="<?php echo base_url()?>admin/express_shipping/delete?id=<?php echo $ref->id;?>"><i class="fa fa-trash"></i></a>-->
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
	$('#example').dataTable({
		"lengthMenu": [[25, 50], [25, 50]],
		dom: 'Blfrtip',
		buttons: [
		'csv'
		],
	});
});
</script>