<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper {
    position: relative;
    clear: both;
    zoom: 1;
    overflow-y: inherit;
    overflow: hidden;
}
</style>
<div class="page-title">
<div class="title_left">
<h3>Slot List</h3>

</div>

<div class="title_right">
<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/timeslot/add"><i class="fa fa-plus"></i></a>
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
<h5><i class="fa fa-list"></i> Slot List</h5>
<div class="x_panel">

<div class="x_content">
<table id="datatable" class="table table-bordered">
<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Short Name</th>
<th>Time Slot</th>
<th>Orders</th>
<th>Status</th>
<th>Tools</th>
</tr>
</thead>
<tbody>
<?php $i = 1;
foreach($query->result() as $query){?>
<tr>
<td><?php echo $i++;?></td>
<td><?php echo $query->name;?></td>
<td><?php echo $query->short_name;?></td>
<td><?php echo $query->time_from." - ".$query->time_to;?></td>
<td><?php echo $query->slot_order;?></td>
<td><?php echo $query->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';?></td>
<td><a class="btn btn-info btn-sm" href="<?php echo base_url()?>admin/timeslot/add?id=<?php echo $query->id;?>"><i class="fa fa-pencil"></i></a><a class="btn btn-danger btn-sm" href="<?php echo base_url()?>admin/shipping/delete?id=<?php echo $query->id;?>"><i class="fa fa-trash"></i></a></td>
</tr>
<?php }?>
</tbody>
</table>
</div>				 
</div>                
</div>

<?php $this->load->view('admin/home/footer');?>