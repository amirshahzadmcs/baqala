<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Referral</h3>
	</div>
</div>
	<div class="clearfix"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h5><i class="fa fa-list"></i> Referral Report</h5>
		<div class="x_panel">
			<div class="x_content">
				<div class="col-md-6">
					<b>Name: <?php echo $result->name;?></b>
				</div>
				<div class="col-md-6">
					<b>Mobile: <?php echo $result->mobile;?></b>
				</div>
				<div class="col-md-6">
					<b>Email: <?php echo $result->email;?></b>
				</div>
				<div class="col-md-6">
					<b>Referral Code: <?php echo $result->referral_code;?></b>
				</div>
			</div>
		</div>
		<div class="x_panel">

			<div class="x_content">
				<table id="example" class="table table-bordered">
					<thead>
						<tr>
						<th>#</th>
						<th>Referred Code</th>
						<th>Name</th>
						<th>Email</th>
						<th>Used On</th>
						<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1;
						foreach($reports as $result){?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $result->refered_code;?></td>
							<td><?php echo $result->name;?></td>
							<td><?php echo $result->email;?></td>
							<td><?php echo $result->created_at;?></td>
							<td>
							<?php if($result->status == 1){ ?>
							<span class="label label-success">Active</span>
							<?php }else{ ?>
							<span class="label label-danger">Deactive</span>
							<?php } ?>
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
		"lengthMenu": [[50, 100, 500], [50, 100, 500]],	
		});
	}); 
</script>
			