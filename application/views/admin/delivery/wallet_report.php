<?php $this->load->view('admin/home/header');?>
<style>
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
}
.content{
	background-color:#fff;
	padding: 10px;
}
.profile-user-img {
	text-align:-webkit-center;
}
.box-primary{
	border:1px solid #ddd;
}
.list-group-item{
	border-radius: 0px;
}
.list-group-item:last-child {
    border-bottom:none;
}
.list-group-item:first-child {
    border-radius: 0px;
}
/* Switch button */
.btn-default.btn-on.active{background-color: #5BB75B;color: white;}
.btn-default.btn-off.active{background-color: #DA4F49;color: white;}
.tile-stats .count {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.65857;
}
.x_content h4 {
    font-size: 14px;
    font-weight: 500;
}
.dataTables_wrapper {
    position: relative;
    clear: both;
    zoom: 1;
    overflow-y: inherit;
}
.dataTables_wrapper .row{
    overflow: hidden !important;
}
.dataTables_filter {
    width: 56%;
    float: right;
    text-align: right;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="page-title">
			<div class="title_left">
				<h4>Delivery Boy Wallet Report</h4>
			</div>
			<div class="title_right">
				<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/delivery"><i class="fa fa-reply"></i></a>
				<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#myModal">Recharge Wallet</button>
				<?php if($this->admin->getInfo()){ 
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 2){
				?>  
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				</div>
				<?php } else{?>
				<div class="alert alert-info">
					<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
				
			</div>
		</div>
	</section>
	<div class="clearfix"></div>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="row top_tiles">  
				<div>
					<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-green" style="padding: 10px;">
							<a href="javascript:void(0)" class="white">
							<h4>Available Balance:</h4>
							<div class="count">SAR <?php echo $result->wallet;?></div>
							</a>
						</div>     
					</div>
					<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-blue" style="padding: 10px;">
							<a href="javascript:void(0)" target="_blank" class="white">
							<h4>Credit Balance:</h4>
							<div class="count">SAR <?php echo $total_credit->amount_reveived == 0 ? '0':$total_credit->amount_reveived;?></div>
							</a>
						</div>     
					</div>  
					
					<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-purple" style="padding: 10px;"> 
							<a href="javascript:void(0)" target="_blank" class="white">
							<h4>Debit Balance:</h4>
							<div class="count">SAR <?php echo $total_debit->amount_paid == 0 ? '0':$total_debit->amount_paid;?></div>
							</a>
						</div>     
					</div>
					
					<div class="animated flipInY col-lg-3 col-md-3 col-sm-4 col-xs-12">               
						<div class="tile-stats bg-green" style="padding: 10px;"> 
							<a href="" target="_blank" class="white">
							<h4>Transactions:</h4>
							<div class="count"><?php echo $total_trans;?></div>
							</a>
						</div>     
					</div>
					
				</div>
			</div>
			<div class="alert_msg2"></div>
			<form action="<?php echo base_url(); ?>admin/delivery/wallet_report" method="get" id="filter_form">
				<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;">
					<input type="hidden" name="id" value="<?php echo $result->id;?>" required>
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
					
					<div class="col-md-3" style="margin-top: 23px;">
						<button type="submit" class="btn btn-success">Filter</button>
						<a href="<?php echo base_url(); ?>admin/delivery/wallet_report?id=<?php echo $result->id;?>" class="btn btn-warning">Reset Filter</a>
					</div>
				</div>
			</form>
			<table id="example" class="table table-bordered" style="text-transform: capitalize;width:100%">
				<thead>
					<tr>
					  <th>#</th>
					  <th>Recev. Amt</th>						  
					  <th>Amount</th>						  
					  <th>Type</th>					  
					  <th>Remarks</th>				  					  
					  <th>Transaction ID</th>				  					  
					  <th>Created</th>
					</tr>
				</thead>
				<tbody>
					<?php $sno = 1;
					// echo '<pre>';print_r($result->result());exit();
					foreach($reports as $report){?>
						<tr>
							<td><?php echo $sno++;?></td>
							<td><?php echo $report->rec_amt == 0 ? '-':$report->rec_amt;?></td>	
							<td><?php echo $report->amount;?></td>	
							<td><?php echo $report->trans_type == 'credit' ? '<div class="label label-success">'. $report->trans_type .'</div>':'<div class="label label-danger">'. $report->trans_type .'</div>';?></td>
							<td><?php echo $report->remarks;?></td>
							<td><?php echo $report->transaction_id;?></td>
							<td><?php echo $report->created_at;?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</section>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Recharge Wallet</h4>
			</div>
			<?php echo form_open("admin/delivery/update_wallet", array("id"=>"wallet_form"));?>
			<div class="modal-body">
				<input type="hidden" name="dbid" value="<?php echo $result->id;?>" required>
				<div class="form-group col-md-12">
					<label for="rec_amt">Received Amount</label>
					<input type="number" id="rec_amt" name="rec_amt" class="form-control" required />
				</div>
				<div class="form-group col-md-12">
					<label for="wallet">Recharge Amount</label>
					<input type="number" id="wallet" name="wallet" class="form-control" required />
				</div>
				<div class="form-group col-md-12">
					<label for="remarks">Remarks</label>
					<input type="text" id="remarks" name="remarks" maxlength="250" class="form-control" required />
				</div>
			</div>
			<div class="modal-footer" style="border-top:none;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
			<?php echo form_close(); ?>
		</div>

	</div>
</div>	

<?php $this->load->view('admin/home/footer');?>
<script>
	$('#wallet_form').on('submit', (function(e) {
		//alert('test');
		e.preventDefault();
		$.ajax({
			url: '<?php echo base_url();?>admin/delivery/update_wallet',
			type: "POST",
			data:  new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			success: 
			//showResponse,
			function(data){
				//$result = JSON.stringify(data)
				//$(".cred_box").load(location.href);
				window.location.reload();
				$(".alert_msg2").html(data).show();
			},
			error: function(data){
				alert(JSON.stringify(data));
			}
		});
	}));
</script>

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
			