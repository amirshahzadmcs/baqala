<html><body>
<table width="700px" border="0" align="left" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                    <td valign="top" style="font-size:14px"><img src="<?php echo base_url();?>images/logo.jpg" width="120" /></td>
                    <td valign="top"><h3>Tax Invoice/Bill of Supply/Cash Memo</h3></td>
                </tr>
                <tr>
                    <td valign="top"><strong>Sold By:</strong><br />
                        IXIANA Technologies Pvt. Ltd<br />
                        Shanti Niketan Shop No 9<br/>
                        Plot 8A Sector 8, Kharghar, Navi Mumbai 410210<br/>
                        Maharashtra, India<br/>
                    </td>
                    <td valign="top"><strong>Shipping Address:</strong><br />
                      <?php echo $result['order']['shipping_firstname'];?><br />
                      Mob: <?php echo $result['order']['shipping_mobile']; ?><br />
                      <?php echo $result['order']['shipping_address1'];?><br/>
            		  <?php echo $result['order']['shipping_address2'];?><br/>
            		  <?php echo $result['order']['shipping_city'] . ", " . $result['order']['shipping_state'] . ' - ' . $result['order']['shipping_postcode'] . ', IN';?>
            		</td>
                </tr>
              <tr>
                <td valign="top">GST No: <strong>27AAFCI1625M1ZF</strong><br/>
                    Tel:  <strong>+91 22 6995 6998</strong><br />
                    Email: <strong>order@apnikirana.com</strong><br />
                    Order ID: <strong>#00<?php echo $result['order']['id'];?></strong><br />
                    Order Date :<strong> <?php echo date("d-m-Y", strtotime($result['order']['date_added']));?></strong><br/>
                    <!--Invoice No : <strong><?php echo $result['order']['id'];?></strong><br />-->
                    Invoice Date : <strong><?php echo date("d-m-Y", strtotime($result['order']['date_added']));?></strong>
                </td>
                <td valign="top"><strong>Billing Address:</strong><br />
            		<?php echo $result['order']['shipping_firstname'];?><br />
            		 Mob: <?php echo $result['order']['payment_mobile']; ?><br/>
            		<?php echo $result['order']['villa_building'];?>, <?php echo $result['order']['payment_address1'];?><br />
            		<?php echo $result['order']['payment_address2'];?><br/>
            		<?php echo $result['order']['payment_city'] . ", " . $result['order']['payment_state'] . ' - ' . $result['order']['payment_postcode'] . ', IN';?>
            	</td>
              </tr>
            </table>
        </td>
    </tr>
  <tr>
    <td style="font-size:10px;">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:10px;">
        <table width="100%" border="1" cellspacing="0" cellpadding="5">
            <tr>
                <td align="center"><strong>S.No.</strong></td>
                <td align="center"><strong>Name</strong></td>
                <td align="center"><strong>Size</strong></td>
                <td align="center"><strong>MRP</strong></td>
                <td align="center"><strong>Qty</strong></td>
                <td align="center"><strong>Unit Price</strong></td>
                <td align="center"><strong>Total (Rs.)</strong></td>
                <td align="center"><strong>Saving (Rs.)</strong></td>
            </tr>
            
            <?php $total_qty =0;$i = 1;
            $mrp = 0;
            $saving = 0;
            $ptotal = 0;
            foreach($result['product'] as $product){
            $total_qty += $product['quantity'];
            $mrp += $product['real_price'] * $product['quantity'];
            ?>
            <tr>
            <td valign="top"><?php echo $i++;?></td>
            <td valign="top"><strong><?php echo $product['product_name']; ?></strong></td>
            <td align="center" valign="top"><?php echo $product['size'];?></td>
            <td align="center" valign="top"><?php echo round($product['real_price']);?></td>
            <td align="center" valign="top"><?php echo $product['quantity'];?></td>
            <td align="center" valign="top"><?php echo ($product['discounted_price'] > 0) ? number_format($product['discounted_price'], 2):number_format($product['real_price'], 2);?></td>
            <td align="center" valign="top"><?php echo round($product['order_price']);?></td>
            <td align="center" valign="top"><?php $ptotal += $product['order_price']; $saving += ($product['real_price'] * $product['quantity']) - $product['order_price']; echo number_format(($product['real_price'] * $product['quantity']) - $product['order_price'], 2);?></td>
            </tr>
            <?php } ?>
            
            <tr>
            <td colspan="5" valign="top">Product MRP</td>
            <td colspan="3" align="right"><?php echo round($mrp);?></td>
            </tr>
            <tr>
            <td colspan="5" valign="top">Total Saving</td>
            <td colspan="3" align="right"><?php echo round($saving);?></td>
            </tr>
            <tr>
            <td colspan="5" valign="top">Product Amount</td>
            <td colspan="3" align="right"><?php echo round($ptotal);?></td>
            </tr>
            <tr>
            <td colspan="5" valign="top">Discount Price</td>
            <td colspan="3" align="right"><?php echo round($result['order']['promo_code_price']);?></td>
            </tr>
            <tr>
            <td colspan="5" valign="top">Delivery Charge</td>
            <td colspan="3" align="right"><?php echo round($result['order']['shipping_charge']);?></td>
            </tr>
            <tr>
            <td colspan="5" valign="top"><strong>TOTAL QTY: <?php echo $total_qty;?> </strong><br/><?php echo $result['order']['payment_method']; ?></td>
            <td colspan="3" align="right" valign="top"><strong style="font-size:12px">TOTAL PRICE : Rs. <?php echo round($result['order']['order_total']); ?></strong><br />
            ALL VALUES ARE IN INR</td>
            </tr>
        </table>
    </td>
  </tr>
</table>
</body></html>