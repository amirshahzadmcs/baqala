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
							<table cellspacing="0" cellpadding="4" width="100%">
								<thead>
									<tr>
										<th style="border-bottom:1px solid #000;">PO No</th>
										<th style="border-bottom:1px solid #000;">Date</th>
										<th style="border-bottom:1px solid #000;">Staff</th>
										<th style="border-bottom:1px solid #000;">Paid (SAR)</th>
										<th style="border-bottom:1px solid #000;">Unpaid (SAR)</th>
										<th style="border-bottom:1px solid #000;">Refund (SAR)</th>
										<th style="border-bottom:1px solid #000;">Total (SAR)</th>
									</tr>
								</thead>
								<tbody>
									<?php $sub_total = 0; $total = 0; $unpaid = 0; $refund = 0; ?>
									<?php foreach($grv as $item){ ?>
									
									<tr class="subtotal">
										<td><?php echo $item->po_no; ?></td>
										<td><?php echo date('d-M-Y',strtotime($item->invoice_date)); ?></td>
										<td><?php echo 'N/A'; ?></td>
										<td><?php echo number_format($item->grv_value,2); ?></td>
										<td><?php echo number_format($unpaid,2); ?></td>
										<td><?php echo number_format($refund,2); ?></td>
										<td><?php echo number_format($item->grv_value,2); ?></td>
										<?php 
											$sub_total += $item->grv_value;
											$total += $item->grv_value;
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
						</td>
                    </tr>
					
					
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
