<?php $this->load->view('admin/home/header');?>
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    border-top: none;
}
table{
	color: #000;
}
.x_panel {
    padding: 10px 5px;
}
.item-list{
	border-bottom: 1px dashed;
}
</style>
<div class="page-title hide_container">
	<div class="title_left">
		<h3>Sales Return</h3>
	</div>
	<div class="title_right">
		<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-toggle="tooltip" title="Add" data-target="#myModal"><i class="fa fa-plus"></i></button>
		<div>
			<?php if($this->admin->getInfo()){ 
			$info = explode("--", $this->admin->getInfo());
			$info_type = $info[0];
			$msg_data = $info[1];
			if($info_type == 2){
			?>  
			<div class="alert alert-danger" style="width: 75%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?> 
			</div> 
			<?php } else{?>
			<div class="alert alert-info" style="width: 75%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?> 
			</div>
			<?php } $this->admin->removeInfo(); } ?>
		</div>
	</div>
</div>
<div class="clearfix"></div>

<div class="row hide_container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

            <div class="x_title">
                <h5><i class="fa fa-list"></i> Sales Return List</h5>
                <div class="clearfix"></div>
            </div>
			
            <div class="x_content" id="DivIdToPrint">
				<table id="order-table" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
					<thead>
						<tr>
							<th width="42px">Sr. No</th>
							<th width="65px">SRV No.</th>				  
							<th width="45px">Invoice No.</th>				  
							<th width="45px">Quotation No.</th>				  
							<th width="45px">Company Name</th>				  
							<th width="55px">Quotation Date</th>				  
							<th width="55px">Order Value</th>				  
							<th width="50px">Payment Term</th>				  
							<th width="50px">Status</th>
							<th width="50px">Created </th>							
							<th width="50px">Updated </th>							
							<th width="75px">Tools</th>
						</tr>
					</thead>
				</table>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Sales Return</h4>
            </div>
            <div class="modal-body">
				<form action="<?php echo base_url(); ?>admin/sales_return/return_form" method="get" id="return_form">
					<div class="col-md-12" style="padding: 13px;margin: 10px 0px;">
						<div class="form-group">
							<label for="o_id" class="col-form-label">SEARCH ORDER TO RETURN: </label>
							<select class="form-control" id="o_id" name="o_id" required>
								<option value="">--- Select Invoice Number ---</option>
								<?php foreach($order_list as $order_no){ ?>
								<option value="<?php echo $order_no->id; ?>"><?php echo $order_no->invoice_prefix.'-'.$order_no->id; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" form="return_form" class="btn btn-success">Search</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
$(document).ready(function() {
	$('#order-table').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
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
		"processing":true,  
		"serverSide":true,
		fixedHeader: true,  
		"order":[],  
		"ajax":{  
				url:"<?php echo base_url();?>admin/sales_return/get_list",  
				type:"POST"
			},  
			"columnDefs":[  
			{  
			 "targets":[0,1,7,8],  
			 "orderable":false
			},  
		]
	});
});
</script>