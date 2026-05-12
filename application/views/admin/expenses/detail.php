<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Expenses VAT Detail</h3>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/expenses"><i class="fa fa-reply"></i></a>
	</div>
</div>
<div class="clearfix"></div>  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h5><i class="fa fa-pencil"></i> Expenses VAT Detail</h5>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<table id="example" class="table table-bordered">
					<thead>
						<tr><th>Batch No.</th><td><?php echo $result->id;?></td></tr>
						<tr><th>Branch Code</th><td><p><?php echo $result->branch_code;?></p></td></tr>
						<tr><th>Date</th><td><p><?php echo date("d-M-Y", strtotime($result->date));?></p></td></tr>
						<tr><th>Invoice Number</th><td><p><?php echo $result->invoice_number;?></p></td></tr>
						<tr><th>Item Description</th><td><p><?php echo $result->item_description;?></p></td></tr>
						<tr><th>Supplier Name</th><td><p><?php echo $result->supplier_name;?></p></td></tr>
						<tr><th>Supplier Arabic Name</th><td><p><?php echo $result->supplier_arabic_name;?></p></td></tr>
						<tr><th>Supplier VAT No</th><td><p><?php echo $result->supplier_vat_no;?></p></td></tr>
						<tr><th>CR No</th><td><p><?php echo $result->cr_no;?></p></td></tr>
						<tr><th>Amount Without VAT</th><td><p><?php echo $result->amt_bef_vat;?></p></td></tr>
						<tr><th>Tax</th><td><p><?php echo $result->tax;?></p></td></tr>
						<tr><th>Total</th><td><p><?php echo $result->total;?></p></td></tr>
						<tr><th>Created On</th><td><p><?php echo $result->created_at;?></p></td></tr>
						<tr><th>Updated On</th><td><p><?php echo $result->updated_at;?></p></td></tr>
						<tr><th>Attatchment</th><td><img src="<?php echo base_url().$result->image;?>" width="50px" target="_blank"></img></td></tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>


