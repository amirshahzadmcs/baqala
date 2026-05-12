<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;">
    <tbody>
        <tr class="thead-caption">
			<td align="center" style="line-height:20px;width:5%;"><b>S.No</b></td>
			<td align="center" style="line-height:20px;width:10%;"><b>Job No.</b></td>
			<td align="center" style="line-height:20px;width:10%;"><b>Job Date</b></td>
			<td align="center" style="line-height:20px;width:11%;"><b>Item Code</b></td>
			<td align="center" style="line-height:20px;width:23%;"><b>Spare Part Name</b></td>
			<td align="center" style="line-height:20px;width:8%;"><b>Cost</b></td>
			<td align="center" style="line-height:20px;width:6%;"><b>Qty.</b></td>
			<td align="center" style="line-height:20px;width:10%;"><b>Amt. Excl. VAT</b></td>
			<td align="center" style="line-height:20px;width:7%;"><b>VAT</b></td>
			<td align="center" style="line-height:20px;width:10%;"><b>Amt. Incl. VAT</b></td>
		</tr>
        
		<?php if(count($results) > 0){ ?>
		<?php 
		$total_cost = 0;
		$total_qty = 0;
		$total_line_amount = 0;
		$total_vat_price = 0;
		$total_amt_incl_vat = 0;
		$i=1;
		foreach($results['job_cards'] as $jlist){ 
		foreach($jlist['job_items'] as $list){ 
			$total_cost += $list['cost'];
			$total_qty += $list['qty'];
			$total_line_amount += $list['line_amount'];
			$total_vat_price += $list['vat_price'];
			$total_amt_incl_vat += $list['amt_incl_vat'];
		?>
		<tr>
			<td align="center"><?= $i++;?></td>
			<td align="left"><?= 'JC-'. invoiceNmFormat($list['jobcard_id']);?></td>
			<td align="left"><?= date('d-m-Y', strtotime($jlist['job_date']));?></td>
			<td align="left"><?= $list['item_code'];?></td>
			<td align="left"><?= $list['spare_part_name'];?></td>
			<td align="right"><?= $list['cost'];?></td>
			<td align="center"><?= $list['qty'];?></td>
			<td align="right"><?= $list['line_amount'];?></td>
			<td align="right"><?= $list['vat_price'];?></td>
			<td align="right"><?= $list['amt_incl_vat'];?></td>
		</tr>
		<?php }} ?>
		<tr class="thead-caption">
			<td colspan="5" align="right"><b>Total </b></td>
			<td align="right"><b><?= number_format($total_cost, 2);?></b></td>
			<td align="center"><b><?= $total_qty;?></b></td>
			<td align="right"><b><?= number_format($total_line_amount, 2);?></b></td>
			<td align="right"><b><?= number_format($total_vat_price, 2);?></b></td>
			<td align="right"><b><?= number_format($total_amt_incl_vat, 2);?></b></td>
		</tr>
		<?php }else{ ?>
		<tr class="text-dark h6" style="background-color: #efefefcc!important">
			<td colspan="10" align="center">No data found</td>
		</tr>
		<?php } ?>
    </tbody>
</table>
