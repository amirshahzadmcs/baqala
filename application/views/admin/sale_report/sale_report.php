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
		<h4>VAT Summary (SA - SR) Customer Wise</h4>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/order_process"><i class="fa fa-reply"></i></a>
		<?php
			$date_from = $this->input->get('from');
			$date_to = $this->input->get('to');
			$supp_name = $this->input->get('nameFilter');
		?>
		<a class="btn btn-primary btn-sm pull-right" title="Print" href="<?php echo base_url().'admin/sell_report/print_report?from='.$date_from.'&to='.$date_to.'&nameFilter='.$supp_name;?>" target="_blank"><i class="fa fa-print"></i></a>
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
		<form action="<?php echo base_url(); ?>admin/sell_report/report" method="get" id="filter_form">
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
							<option value="">--- All Customer ---</option>
							<?php foreach($vendors as $vendor){ ?>
							<option value="<?php echo $vendor->id; ?>" <?php if($this->input->get('nameFilter') == $vendor->id){ echo 'selected'; }?>><?php echo $vendor->name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-3" style="padding-top: 24px;">
					<button type="submit" class="btn btn-success">Filter</button>
					<a href="<?php echo base_url(); ?>admin/sell_report" class="btn btn-warning">Reset Filter</a>
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
							<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>VAT Summary (SA - SR) Customer Wise</strong></h2><br/>
							<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Date From:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('from')));?> &nbsp;&nbsp;&nbsp;<strong>To:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('to')));?></p>
						</td>
					</tr>
					
					<tr>
						<td colspan="3">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="border-top: 2px solid;border-bottom: 2px solid;">
									<td valign="top" style="width: 10%;text-align:left;"><strong>Sale<br>Type</strong></td>
									<td valign="top" style="width: 14%;"><strong>Customer VAT No.</strong></td>
									<td valign="top" style="width: 27%;"><strong>Customer Name</strong></td>
									<td valign="top" style="width: 6%;text-align:right;"><strong>VAT<br>Value</strong></td>
									<td valign="top" style="width: 9%;text-align:right;"><strong>Inv. Value<br>After VAT</strong></td>
									<td valign="top" style="width: 9%;text-align:right;"><strong>Inv. Value<br>Before VAT</strong></td>
									<td valign="top" style="width: 10%;"><strong>Date</strong></td>
									<td valign="top" style="width: 10%;"><strong>Inv. #</strong></td>
								</tr>
								<tr><td colspan="7"></td></tr>
								<tr>
									<td colspan="3" valign="top" style="text-align:left;border-top: 1px solid;border-bottom: 1px solid;">Sales</td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
								</tr>
								<?php
									$sumBeforeVat = 0;
									$sumAfterVat = 0;
									$sumVatValue = 0;
								?>
								<?php foreach($reports as $report){
									$vatValue = $report->item_total_price - $report->total_vat;
									$sumBeforeVat += $report->total_vat;
									$sumAfterVat += $report->item_total_price;
									$sumVatValue += $vatValue;
									$payment_method = $report->payment_method;
									if($payment_method == 'Credit Wallet' || $payment_method == 'Credit'){
										$payment_method = 'Credit';
									}else{
										$payment_method = 'Cash';
									}
								?>
								<tr class="item-list">
									<td valign="top" style="text-align:left;"><?php echo $payment_method;?></td>
									<td valign="top"><?php echo $report->c_vat;?></td>
									<td valign="top">00<?php echo $report->customer_id;?> &nbsp;&nbsp;<?php echo $report->c_role == 1 ? $report->name : $report->c_company;?></td>
									<td valign="top" style="text-align:right;"><?php echo number_format($vatValue, 2);?></td>
									<td valign="top" style="text-align:right;"><?php echo number_format($report->item_total_price, 2);?></td>
									<td valign="top" style="text-align:right;"><?php echo number_format($report->total_vat, 2);?></td>
									<td valign="top"><?php echo date("d-M-Y", strtotime($report->date_modified));?></td>
									<td valign="top" style="text-align:left;"><?php echo $report->invoice_prefix .'-'. $report->id;?></td>
								</tr>
								<?php } ?>
								<tr><td colspan="9"></td></tr>
								<tr>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumVatValue, 2);?></p></td>
									<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumAfterVat, 2);?></p></td>
									<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumBeforeVat, 2);?></p></td>
									<td valign="top"></td>
									<td valign="top"></td>
									<td valign="top"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
            </div>
			<?php }else{ ?>
			<div class="x_content">
				<h4><center>No Data Found</center></h4>
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