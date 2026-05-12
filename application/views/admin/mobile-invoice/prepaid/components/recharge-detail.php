<div class="sim-detail-ajax">
	<h6>Recharge Card Detail:</h6>
	<p><strong>Recharge Card Sr No : <?php echo $voucher_detail->serial_no;?></strong></p>
	<p><strong>Recharge Amount (VAT Inc.) : <?php echo ($voucher_detail->unit_price + $voucher_detail->unit_vat);?> SAR</strong></p>
	<p><strong>Recharge Source : <?php echo 'Recharge Card';?></strong></p>
</div>