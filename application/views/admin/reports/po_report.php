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
		<h4>VAT Summary (PU - PR) Supplier Wise Report</h4>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/purchase_order"><i class="fa fa-reply"></i></a>
		<?php
			$date_from = $this->input->get('from');
			$date_to = $this->input->get('to');
			$supp_name = $this->input->get('nameFilter');
		?>
		<a class="btn btn-primary btn-sm pull-right" title="Print" href="<?php echo base_url().'admin/reports/print_report?from='.$date_from.'&to='.$date_to.'&nameFilter='.$supp_name;?>" target="_blank"><i class="fa fa-print"></i></a>
		<!--<input class="btn btn-sm btn-default pull-right" type='button' id='btn' value='Print' onclick='printDiv();'>-->
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
	<div class="col-md-12">
		<form action="<?php echo base_url(); ?>admin/reports/report" method="get" id="filter_form">
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
				
				<div class="col-md-3">
					<div class="form-group">
						<label for="nameFilter" class="col-form-label">Supplier: </label>
						<select class="form-control" id="nameFilter" name="nameFilter">
							<option value="">--- Select Supplier ---</option>
							<?php foreach($vendors as $vendor){ ?>
							<option value="<?php echo $vendor->id; ?>" <?php if($this->input->get('nameFilter') == $vendor->id){ echo 'selected'; }?>><?php echo $vendor->vendor_name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-3" style="padding-top: 24px;">
					<button type="submit" class="btn btn-success">Filter</button>
					<a href="<?php echo base_url(); ?>admin/reports" class="btn btn-warning">Reset Filter</a>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="row hide_container">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
			<!--
            <div class="x_title">
                <h5><i class="fa fa-pencil"></i> Purchase Order</h5>
                <div class="clearfix"></div>
            </div>-->
			<?php if(!empty($reports)){ ?>
            <div class="x_content" id="DivIdToPrint">
				<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
					<tr>
						<td align="left" valign="top">
							<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Maha Alfala Trading Est.</strong></h2>
							<h4 style="padding-bottom: 0px; margin-top: 0px;"><strong>Riyadh</strong></h4>
							<p style="padding-bottom: 0px; margin-bottom: 0px;">VAT No: <?php echo COMPANY_VAT_NO ?></p>
						</td>
						<td align="left" valign="top">
							<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>VAT Summary (PU - PR) Supplier Wise Report</strong></h2><br/>
							<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Date From:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('from')));?> &nbsp;&nbsp;&nbsp;<strong>To:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('to')));?></p>
						</td>
					</tr>
					
					<tr>
						<td colspan="3">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="border-top: 1px solid;border-bottom: 1px solid;">
									<td valign="top" style="width: 10%;text-align:right;"><strong>Before VAT<br>Value</strong></td>
									<td valign="top" style="width: 6%;text-align:right;"><strong>QTY</strong></td>
									<td valign="top" style="width: 14%;"><strong>Supplier VAT No.</strong></td>
									<td valign="top" style="width: 27%;"><strong>Supplier Name</strong></td>
									<td valign="top" style="width: 9%;text-align:right;"><strong>After VAT<br>Value</strong></td>
									<td valign="top" style="width: 7%;"><strong>GRV #</strong></td>
									<td valign="top" style="width: 10%;"><strong>Sup Inv #</strong></td>
									<td valign="top" style="width: 6%;text-align:right;"><strong>VAT<br>Value</strong></td>
									<td valign="top" style="width: 10%;"><strong>Date</strong></td>
								</tr>
								<?php
									$sumSubTotal = 0;
									$sumAfterVat = 0;
									$sumVatValue = 0;
								?>
								<?php foreach($reports as $report){
									$afterVat = $report->sub_total + $report->sale_tax_amt;
									$sumSubTotal += $report->sub_total;
									$sumAfterVat += $afterVat;
									$sumVatValue += $report->sale_tax_amt;
								?>
								<tr class="item-list">
									<td valign="top" style="text-align:right;"><?php echo $report->sub_total;?></td>
									<td valign="top" style="text-align:right;"><?php echo $report->total_qty;?></td>
									<td valign="top"><?php echo $report->vat_no;?></td>
									<td valign="top">00<?php echo $report->vendor_id;?> &nbsp;&nbsp;<?php echo $report->vendor_name;?></td>
									<td valign="top" style="text-align:right;"><?php echo number_format($afterVat, 2);?></td>
									<td valign="top"><?php echo $report->grv_no;?></td>
									<td valign="top"><?php echo $report->sup_invoice_no;?></td>
									<td valign="top" style="text-align:right;"><?php echo $report->sale_tax_amt;?></td>
									<td valign="top"><?php echo date("d-M-Y", strtotime($report->invoice_date));?></td>
								</tr>
								<?php } ?>
								<tr><td colspan="9"></td></tr>
								<tr>
									<td valign="top" style="text-align:right;border-top: 1px solid;border-bottom: 1px solid;"><?php echo number_format($sumSubTotal, 2);?></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top" style="text-align:right;border-top: 1px solid;border-bottom: 1px solid;"><?php echo number_format($sumAfterVat, 2);?></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top" style="text-align:right;border-top: 1px solid;border-bottom: 1px solid;"><?php echo number_format($sumVatValue, 2);?></td>
									<td valign="top"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
	function printDiv() 
	{
		var divToPrint=document.getElementById('DivIdToPrint');
		var newWin=window.open('','Print-Window');
		newWin.document.open();
		newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
		newWin.document.close();
		setTimeout(function(){newWin.close();},10);
	}
</script>