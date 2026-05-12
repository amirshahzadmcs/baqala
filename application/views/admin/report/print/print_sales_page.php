<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station - <?php echo $this->input->get('page') ?></title>
<style>
*{padding:0px;margin:0px}
</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
        <tr>
            <td colspan="1" style="width: 100%;">
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                        <td valign="top" style="width: 100%; text-align: left;">
						<?php if($this->input->get('page') == 'Detailed Revenue by Client') { ?>
							<table cellspacing="0" cellpadding="4" width="100%">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #000;">Order No</th>
										<th style="border-bottom:1px solid #000;">Delivered Date</th>
										<th style="border-bottom:1px solid #000;">Staff</th>
										<th style="border-bottom:1px solid #000;">Paid (SAR)</th>
										<th style="border-bottom:1px solid #000;">Unpaid (SAR)</th>
										<th style="border-bottom:1px solid #000;">Refund (SAR)</th>
										<th style="border-bottom:1px solid #000;">Total (SAR)</th>
									</tr>
								</thead>
								<tbody>
									<?php $sub_total = 0; $total = 0; $unpaid = 0; $refund = 0; ?>
									<?php foreach($order as $item){ ?>
									<tr class="subtotal">
										<td><?php echo $item->invoice_prefix.$item->order_no; ?></td>
										<td><?php echo isset($item->delivery_date) ? date('d-M-Y',strtotime($item->delivery_date)) : 'NA'; ?></td>
										<td><?php echo 'N/A'; ?></td>
										<td><?php echo number_format($item->net_payble_amt,2); ?></td>
										<td><?php echo number_format($unpaid,2); ?></td>
										<td><?php echo number_format($refund,2); ?></td>
										<td><?php echo number_format($item->net_payble_amt,2); ?></td>
										<?php 
											$sub_total += $item->net_payble_amt;
											$total += $item->net_payble_amt;
										?>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<th style="border-top:1px solid #000;" colspan="2"></th>
										<th style="border-top:1px solid #000;"align="left">NET (SAR)</th>
										<th style="border-top:1px solid #000;"><?php echo number_format($sub_total,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($unpaid,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($refund,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($total,2); ?></th>
									</tr>
								</tfoot>
							</table>
						<?php } else if($this->input->get('page') == 'Detailed Payments by Client') { ?>
							<table cellspacing="0" cellpadding="4" width="100%">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #000;">Order No</th>
										<th style="border-bottom:1px solid #000;">Delivered Date</th>
										<th style="border-bottom:1px solid #000;">Staff</th>
										<th style="border-bottom:1px solid #000;">Item Price</th>
										<th style="border-bottom:1px solid #000;">Shipping Charges</th>
										<th style="border-bottom:1px solid #000;">Collected Amount</th>
										<th style="border-bottom:1px solid #000;">Total (SAR)</th>
									</tr>
								</thead>
								<tbody>
									<?php $sub_total = 0; $total = 0; $shipping_charge = 0; $collected_amt = 0; ?>
									<?php foreach($order as $item){ ?>
									<tr class="subtotal">
										<td><?php echo $item->invoice_prefix.$item->order_no; ?></td>
										<td><?php echo isset($item->delivery_date) ? date('d-M-Y',strtotime($item->delivery_date)) : 'NA'; ?></td>
										<td><?php echo 'N/A'; ?></td>
										<td><?php echo number_format($item->item_total_price,2); ?></td>
										<td><?php echo number_format($item->shipping_charge,2); ?></td>
										<td><?php echo number_format($item->collected_amt,2); ?></td>
										<td><?php echo number_format($item->net_payble_amt,2); ?></td>
										<?php 
											$sub_total += $item->item_total_price;
											$shipping_charge += $item->shipping_charge;
											$collected_amt += $item->collected_amt;
											$total += $item->net_payble_amt;
										?>
									</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<th style="border-top:1px solid #000;" colspan="2"></th>
										<th style="border-top:1px solid #000;"align="left">NET (SAR)</th>
										<th style="border-top:1px solid #000;"><?php echo number_format($sub_total,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($shipping_charge,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($collected_amt,2); ?></th>
										<th style="border-top:1px solid #000;"><?php echo number_format($total,2); ?></th>
									</tr>
								</tfoot>
							</table>
							<?php } else if(($this->input->get('page') == 'Item Sales by Item') || ($this->input->get('page') == 'Item Sales by Category') || ($this->input->get('page') == 'Item Sales by Brand')) { ?>
								<table cellspacing="0" cellpadding="4" width="100%">
									<thead>
										<tr>
											<th style="border-bottom:1px solid #000;width:10%;">Order No</th>
											<th style="border-bottom:1px solid #000;width:40%;">Product Name</th>
											<th style="border-bottom:1px solid #000;width:10%;">Product Code</th>
											<th style="border-bottom:1px solid #000;width:10%;" align="right">Item Price</th>
											<th style="border-bottom:1px solid #000;width:10%;" align="right">Quantity</th>
											<th style="border-bottom:1px solid #000;width:10%;" align="right">Discount</th>
											<th style="border-bottom:1px solid #000;width:10%;" align="right">Total (SAR)</th>
										</tr>
									</thead>
									<tbody>
										<?php $sub_total = 0; $total = 0; $shipping_charge = 0; $collected_amt = 0; ?>
										<?php foreach($order as $item){ ?>
										<tr class="subtotal">
											<td width="10%"><?php echo $item->invoice_prefix.$item->order_no; ?></td>
											<td width="40%"><?php echo $item->product_name; ?></td>
											<td width="10%"><?php echo $item->product_sku; ?></td>
											<td width="10%" align="right"><?php echo number_format($item->real_price,2); ?></td>
											<td width="10%" align="right"><?php echo $item->quantity; ?></td>
											<td width="10%" align="right"><?php echo '0.00'; ?></td>
											<td width="10%" align="right"><?php echo number_format($item->order_price,2); ?></td>
											<?php 
												$sub_total += $item->real_price;
												$shipping_charge += $item->quantity;
												// $collected_amt += $item->collected_amt;
												$total += $item->order_price;
											?>
										</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th style="border-top:1px solid #000;" colspan="2"></th>
											<th style="border-top:1px solid #000;"align="left">NET (SAR)</th>
											<th style="border-top:1px solid #000;" align="right"><?php echo number_format($sub_total,2); ?></th>
											<th style="border-top:1px solid #000;" align="right"><?php echo $shipping_charge; ?></th>
											<th style="border-top:1px solid #000;" align="right"><?php echo number_format($collected_amt,2); ?></th>
											<th style="border-top:1px solid #000;" align="right"><?php echo number_format($total,2); ?></th>
										</tr>
									</tfoot>
								</table>
							<?php }?>
						</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
