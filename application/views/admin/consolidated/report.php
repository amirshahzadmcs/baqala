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
		<h4>VAT Summary Report</h4>
	</div>
	<div class="title_right">
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/purchase_order"><i class="fa fa-reply"></i></a>
		<?php
			$date_from = $this->input->get('from');
			$date_to = $this->input->get('to');
		?>
		<!--
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
		<form action="<?php echo base_url(); ?>admin/consolidated_report/report" method="get" id="filter_form">
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
					<a href="<?php echo base_url(); ?>admin/consolidated_report" class="btn btn-warning">Reset Filter</a>
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
			<?php if(!empty($purchase_report) AND !empty($purchase_return)){ ?>
            <div class="x_content" id="DivIdToPrint">
				<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 22px;">
					<tr>
						<td align="left" valign="top">
							<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Maha Alfala Trading Est.</strong></h2>
							<h4 style="padding-bottom: 0px; margin-top: 0px;"><strong>Riyadh</strong></h4>
							<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>VAT No:</strong> <?php echo COMPANY_VAT_NO ?></p>
						</td>
						<td align="left" valign="top">
							<h2 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>VAT Summary Report</strong></h2><br/>
							<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Date From:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('from')));?> &nbsp;&nbsp;&nbsp;<strong>To:</strong> <?php echo date("d-M-Y", strtotime($this->input->get('to')));?></p>
						</td>
					</tr>
					<?php
						// Total Purchase
						$total_purchase_before_vat = $purchase_report->sub_total + $purchase_report->shipping_bef_vat;
						$total_purchase_vat = $purchase_report->total_vat + $purchase_report->shipping_vat;
						$total_purchase_after_vat = $total_purchase_before_vat + $total_purchase_vat;
						// Total Purchase Return
						$total_preturn_before_vat = $purchase_return->sub_total + $purchase_return->shipping_bef_vat;
						$total_preturn_vat = $purchase_return->total_vat + $purchase_return->shipping_vat;
						$total_preturn_after_vat = $total_preturn_before_vat + $total_preturn_vat;
						// Total Cash Sales
						$total_sales_before_vat = $cash_sales->total_bef_vat + $cash_sales->shipping_bef_vat;
						$total_sales_vat = $cash_sales->total_prod_vat + $cash_sales->shipping_vat;
						$total_sales_after_vat = $total_sales_before_vat + $total_sales_vat;
						// Total Credit Sales
						$total_credit_sales_before_vat = $credit_sales->total_bef_vat + $credit_sales->shipping_bef_vat;
						$total_credit_sales_vat = $credit_sales->total_prod_vat + $credit_sales->shipping_vat;
						$total_credit_sales_after_vat = $total_credit_sales_before_vat + $total_credit_sales_vat;
						// Total Sales Return
						$total_return_sales_before_vat = $return_sales->total_bef_vat + $return_sales->shipping_bef_vat;
						$total_return_sales_vat = $return_sales->total_prod_vat + $return_sales->shipping_vat;
						$total_return_sales_after_vat = $total_return_sales_before_vat + $total_return_sales_vat;
					?>
					<tr>
						<td colspan="3">
							<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="border-top: 1px solid;border-bottom: 1px solid;">
									<td valign="top" style="width: 40%;"><strong></strong></td>
									<td valign="top" style="width: 15%;text-align:center;"><strong>Amount (SAR)<br/>المبلغ (ريال)</strong></td>
									<td valign="top" style="width: 20%;text-align:center;"><strong>Adjustment Amount (SAR)<br/>مبلغ التعديل (ريال)</strong></td>
									<td valign="top" style="width: 25%;text-align:center;"><strong>Value Added Tax Amount (SAR)<br/>مبلغ ضريبة القيمة المضافة (ريال)</strong></td>
								</tr>
								<tr>
									<td valign="top"><strong>1. Value Added Tax on Sales - ضريبة القيمة المضافة على المبيعات</strong></td>
									<td colspan="3" valign="top" style="text-align:center;"></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Sales subject to the basic rate - المبيعات الخاضعة للنسبة الأساسية</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_sales_before_vat + $total_credit_sales_before_vat,2);?></td>
									<td valign="top" style="text-align:center;">-</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_sales_vat + $total_credit_sales_vat,2);?></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Sales Return</td>
									<td valign="top" style="text-align:center;">-</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_return_sales_before_vat,2);?></td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_return_sales_vat,2);?></td>
								</tr>
								<tr>
									<td valign="top"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;background-color: #ffff94;"><?php $total_input = $total_sales_vat+$total_credit_sales_vat-$total_return_sales_vat;echo number_format($total_input,2);?></td>
								</tr>
								<tr>
									<td valign="top"><strong>2. Value Added Tax on Purchases - الضريبى على المشتريات</strong></td>
									<td colspan="3" valign="top" style="text-align:center;"></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Purchases subject to the basic rate - المشتريات الخاضعة للنسبة الأساسية</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_purchase_before_vat,2);?></td>
									<td valign="top" style="text-align:center;">-</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_purchase_vat,2);?></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Purchas Return</td>
									<td valign="top" style="text-align:center;">-</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_preturn_before_vat,2);?></td>
									<td valign="top" style="text-align:center;"><?php echo number_format($total_preturn_vat,2);?></td>
								</tr>
								<tr>
									<td valign="top"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;background-color: #ffff94;"><?php $total_output = $total_purchase_vat - $total_preturn_vat;echo number_format($total_output,2);?></td>
								</tr>
								<!---- Expenses ----->
								<tr>
									<td valign="top"><strong>3. Value Added Tax on Expenses - ضريبة القيمة المضافة على المصروفات</strong></td>
									<td colspan="3" valign="top" style="text-align:center;"></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;Expenses subject to the basic rate - تخضع المصروفات للمعدل الأساسي</td>
									<td valign="top" style="text-align:center;"><?php echo number_format($expenses_report->total_bef_vat,2);?></td>
									<td valign="top" style="text-align:center;">-</td>
									<td valign="top" style="text-align:center;"><?php $total_exp_output = $expenses_report->total_vat;echo number_format($total_exp_output,2);?></td>
								</tr>
								<tr>
									<td valign="top"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;"></td>
									<td valign="top" style="text-align:center;background-color: #ffff94;"><?php echo number_format($total_exp_output,2);?></td>
								</tr>
								<tr><td colspan="3"></td></tr>
								<tr style="border-bottom: 1px solid;">
									<td colspan="4" valign="top" style="text-align:left;"></td>
								</tr>
								<tr><td colspan="3"></td></tr>
								<tr>
									<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Total Value-Added Tax Incurred for the Current Period - إجمالي ضريبة القيمة المضافة المستهقة للفترة الحالية</td>
									<td style="text-align:center;"><?php echo number_format($total_input - $total_output - $total_exp_output,2);?></td>
								</tr>
								<tr>
									<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Corrections from Previous Periods (between 5,000 riyals) - تصحيحات من الفترات الصابقة (بين 5,000 ريال)</td>
									<td style="text-align:center;">-</td>
								</tr>
								<tr>
									<td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;Net Tax Payable (or Refunded) - صافي الضريبة المستحق ( أو المستعادة)</td>
									<td style="text-align:center;"><strong><?php echo number_format($total_input - $total_output - $total_exp_output,2);?></strong></td>
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