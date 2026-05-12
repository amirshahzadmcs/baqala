<?php $this->load->view('admin/home/header');?>            			
<div class="page-title">
<div class="title_left">
<h3>Marshalling List</h3>

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
	<h5><i class="fa fa-list"></i> Marshalling List</h5>
	<div class="x_panel">
		<form action="<?php echo base_url(); ?>admin/marshalling" method="get" id="filter_form">
			<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
					<label>From</label>
					<input type="date" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" class="form-control col-md-7 col-xs-12">
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
					<label>To</label>
					<input type="date" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off"  class="form-control col-md-7 col-xs-12">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="refFilter" class="col-form-label">Driver: </label>
						<select class="form-control" id="refFilter" name="refFilter">
							<option value="">--- Select Driver ---</option>
							<?php foreach($delivery_list as $dboy){ ?>
							<option value="<?php echo $dboy->id; ?>" <?php if($this->input->get('refFilter') == $dboy->id){ echo 'selected'; }?>><?php echo $dboy->name .' - '. $dboy->mobile; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="col-md-3" style="margin-top: 23px;">
					<button type="submit" class="btn btn-success">Filter</button>
					<a href="<?php echo base_url(); ?>admin/marshalling" class="btn btn-warning">Reset Filter</a>
				</div>
			</div>
		</form>
		<div class="x_content">
			<table id="example" class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Consignment No.</th>
						<th>Van No.</th>
						<th>Driver Name</th>
						<th>Order Id's</th>
						<th>Total Boxes</th>
						<th>Delv. Date</th>
						<th>Delv. Time</th>
						<th>Created On</th>
						<th>Tools</th>
					</tr>
				</thead>
				<tbody>
					<?php $sno = 1;
					// echo '<pre>';print_r($result->result());exit();
					foreach($results as $result){?>
						<tr>
							<td><?php echo $sno++;?></td>
							<td><?php echo $result->id;?></td>	
							<td><?php echo $result->van_no;?></td>	
							<td><?php echo $result->delivery_executive;?></td>
							<td><?php echo $result->order_ids;?></td>
							<td><?php echo $result->total_packets;?></td>
							<td><?php echo $result->delivery_date;?></td>
							<td><?php echo $result->delivery_time;?></td>
							<td><?php echo date("d/m/Y - h:i A", strtotime($result->created_at));?></td>
							<td><a href="<?php echo base_url();?>admin/marshalling/print_sheet?id=<?php echo $result->id ;?>" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Print Marshalling Sheet" target="_blank"><i class="fa fa-print"></i></a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>				 
	</div>                
</div>

<?php $this->load->view('admin/home/footer');?>

<script>
	$(document).ready(function() {
		$('#example').dataTable({
			"lengthMenu": [[25, 100, 500], [25, 100, 500]],
			order: [[0, 'asc']],
			dom: 'Blfrtip',
			buttons: [
			'csv'
			],
		});
	});
</script>