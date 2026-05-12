<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
</style>
<div class="page-title">
	<div class="title_left">
	<h3>Expenses VAT Entry</h3>
	</div>
	<?php  $admin_id= $this->session->userdata('admin_id'); ?>
	<div class="title_right">
		<?php if($this->customer->userd($admin_id)->role=="Admin" ){?>
		<button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteAction()" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
		<?php } ?>
		<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/expenses/add"><i class="fa fa-plus"></i></a>
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
	<div class="col-md-12">
		<form action="<?php echo base_url(); ?>admin/expenses" method="get" id="filter_form">
			<div class="col-md-12" style="border: 1px solid #eaeaea;padding: 13px;margin: 10px 0px;background-color: #fff;">
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
				<div class="col-md-3" style="padding-top: 24px;">
					<button type="submit" class="btn btn-success">Filter</button>
					<a href="<?php echo base_url(); ?>admin/expenses" class="btn btn-warning">Reset Filter</a>
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h5><i class="fa fa-list"></i> Expenses VAT List</h5>
		<div class="x_panel">
			<div class="x_content">
				<form id="myform" name="myform" method="post" action="">
					<table id="expenses-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>S. No</th>
								<th>Branch Code</th>				  
								<th>Date</th>			  
								<th>Invoice Number</th>					  
								<th>Item Description</th>		  
								<th>Supplier Name</th>		  
								<th>Amt Without VAT (SAR)</th>		  
								<th>Tax (SAR)</th>			  
								<th>Total (SAR)</th>
								<th style="width: 110px;">Tool</th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($results) > 0){?>
							<?php $i=1; foreach($results as $expenses){?>
							<tr>
								<td><?php echo '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$expenses->id.'" />';?></td>
								<td><?php echo  $expenses->id;?></td>
								<td><?php echo $expenses->branch_code;?></td>
								<td><?php echo date("d-M-Y", strtotime($expenses->date));?></td>
								<td><?php echo $expenses->invoice_number;?></td>
								<td><?php echo $expenses->item_description;?></td>
								<td><?php echo $expenses->supplier_name .'<br>'. $expenses->supplier_arabic_name;?></td>
								<td><?php echo round($expenses->amt_bef_vat,2);?></td>
								<td><?php echo round($expenses->tax,2);?></td>
								<td><?php echo round($expenses->total,2);?></td>
								<td><?php echo '<a class="btn btn-warning btn-sm" title="Edit" href="'.base_url().'admin/expenses/add?id='.$expenses->id.'"><i class="fa fa-edit"></i></a> <a class="btn btn-success btn-sm" title="View" href="'.base_url().'admin/expenses/detail?id='.$expenses->id.'"><i class="fa fa-eye"></i></a> <a class="btn btn-primary btn-sm" title="Print" href="'.base_url().'admin/expenses/print_invoice?id='.$expenses->id.'" target="_blank"><i class="fa fa-print"></i></a>';?></td>
							</tr>
							<?php }}else{ ?>
								<tr><td colspan="11" align="center">No Data Found</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</form>
			</div>				 
		</div>                
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script>
	$(document).ready(function() {
		$('#expenses-table').dataTable({
			"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
			//order: [[2, 'DESC']],
			dom: 'Blfrtip',
			buttons: [
				{
					extend: "copy",
					className: "btn-md"
				},
				{
					extend: "csv",
					className: "btn-md"
				},
				{
					extend: "excel",
					className: "btn-md"
				},
				{
					extend: "pdfHtml5",
					className: "btn-md"
				},
				{
					extend: "print",
					className: "btn-md"
				},
			],
			"responsive": true,
			fixedHeader: true,  
			"columnDefs":[  
				{  
				 "targets":[0,1,2,3,4,5,6,7,8,9,10],  
				 "orderable":false
				},  
			],
			"order":[], 
		});
	}); 
</script>
<script>
function deleteAction() {
	var inputCount = $('[name="checklist[]"]:checked').length;
	if(inputCount > 0){
		if (confirm("Do you want to delete selected expenses?") == true) {
			changeActionAndSubmit('expenses/delete');
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