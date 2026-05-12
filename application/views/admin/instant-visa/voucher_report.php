<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Recharge Report</h3>

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
<h5><i class="fa fa-list"></i>Recharge Report List</h5>
<div class="x_panel">
	<div class="x_content">
		<table id="reportTable" class="table table-bordered">
			<thead>
				<tr>
				<th>S.No.</th>
				<th>Voucher Serial</th>
				<th>Voucher Code</th>
				<th>Expiry Date</th>
				<th>Value</th>
				<th>Used</th>
				<th>Used By</th>
				<th>Mobile</th>
				<th>Email</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>				 
</div>                
</div>

<?php $this->load->view('admin/home/footer');?>

<script>
	$(document).ready(function() {
		$('#reportTable').dataTable({
			"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
			order: [[0, 'asc']],
			dom: 'Blfrtip',
			buttons: [
				'csv'
			],
			"processing":true,  
			"serverSide":true,  
			"order":[],  
			"ajax":{  
					url:"<?php echo base_url();?>admin/voucher/get_report_list",  
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