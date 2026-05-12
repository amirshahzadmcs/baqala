<?php $this->load->view("front/common/header");?>
<section class="order-pg  mb-5">
    <div class="container">
        <hr />
        <div class="py-3 d-flex justify-content-between">
            <div class="file-actions text-start">
                <ul>
                    <li><a href="<?= base_url('order-history'); ?>">Order</a></li>
                    <li><a href="javascript:;"><i class="fal fa-chevron-right"></i></a></li>
                    <li><a href="javascript:;" class="text-success">Detail</a></li>
                </ul>
            </div>
            <?php if(!empty($order_info['order'])){ ?>
            <div class="file-actions text-end">
                <ul>
                    <li> <a href="<?= base_url('export-order/'.$order_info['order']['id']); ?>">Export to CSV </a></li>
                    <li> <a href="javascript:;" onclick="ordertocart('<?= $order_info['order']['id'];?>')">Copy To Basket </a></li>
                </ul>
            </div>
			<?php } ?>
        </div>
        <?php if(!empty($order_info['order'])){ ?>
        <h4>Order Detail</h4>
        <div class="order-pg-sec table-responsive">
            <div class="row">
                <div class="col-lg-6">
                    <table>
                        <tbody>
                            <tr>
                                <th>Status</th>
                                
                                <td>
									<b>
									<?php if($order_info['order']['order_status_id'] == '1'){ echo '<span class="bg-warning text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_pending') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '2'){ echo '<span class="bg-info text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_accepted') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '3'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_order_denied') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '4'){ echo '<span class="bg-primary text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_ready_to_dispatched') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '5'){ echo '<span class="bg-success text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_dispatched') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '6'){ echo '<span class="bg-success text-white py-1 px-2 mb-0 rounded small">'. $this->lang->line('msg_delivered') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '7'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_order_denied') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '8'){ echo '<span class="bg-success text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_refund_success') .'</span>'; }
										elseif($order_info['order']['order_status_id'] == '9'){ echo '<span class="bg-danger text-white py-1 px-2 rounded small m-0">'. $this->lang->line('msg_cancel_by_cust') .'</span>'; }
										else{ 'Lost'; }
									?>
									</b>
								</td>
                            </tr>
                            <tr>
                                <th>Ordered On</th>
                                <td><b><?php $qdate=$order_info['order']['date_added']; echo date('d-m-Y h:i:s', strtotime($qdate)); ?></b>
                                </td>
                            </tr>
							<tr>
                                <th>Created By</th>
                                <td><b><?php echo ($order_info['order']['associate_id'] > 0) ? $order_info['order']['associate_name'].' / Admin' : '@'.$order_info['order']['staff_username'] .' / '. $order_info['order']['staff_display_name'];?></b></td>
                            </tr>
                            <tr>
                                <th>Customer PO Ref</th>
                                <td><b>#<?= $order_info['order']['po_number'];?></b>
                                </td>
                            </tr>
							<tr>
                                <th>Quotation No</th>
                                <td><b><?php echo 'QTN-'. $this->customer->invoiceNmFormat($order_info['order']['quotation_no']);?></b>
                                </td>
                            </tr>
							<tr>
                                <th>Order No</th>
                                <td><b><?= $order_info['order']['invoice_prefix'] .'-'. $order_info['order']['order_no'];?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table-borderless">
                        <thead>
                            <tr>
                                <th>Invoice To</th>
                                <th>Deliver To</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo $order_info['order']['name'];?><br />
                                    <?php echo $order_info['order']['mobile'];?><br />
                                    <?php echo $order_info['order']['email'];?><br />
                                    <?php echo $order_info['order']['building_no'];?>
                                    <?php echo $order_info['order']['street_name'];?> -
                                    <?php echo $order_info['order']['district_name'];?><br />
                                    Unit No <?php echo $order_info['order']['unit_no'];?><br />
                                    <?php echo $order_info['order']['sel_city_name'];?>
                                    <?php echo $order_info['order']['zip_code'];?> -
                                    <?php echo $order_info['order']['additional_no'];?><br />
                                    <?php echo $order_info['order']['country'];?>
                                </td>
                                <td>
                                    <?php echo $order_info['order']['shipping_person_name'];?><br />
                                    <?php echo $order_info['order']['shipping_mobile'];?><br />
                                    <?php echo $order_info['order']['shipping_email'];?><br />
                                    <?php echo $order_info['order']['villa_building'];?>-<?php echo $order_info['order']['shipping_house_no'];?>,
                                    <?php echo $order_info['order']['shipping_street'];?><br />
                                    <?php echo $order_info['order']['shipping_city'];?>
                                    <?php echo $order_info['order']['shipping_postcode'];?><br />
                                    <?php echo $order_info['order']['shipping_country'];?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="cart-dis mt-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="10%">Image</th>
                            <th width="50%">Item Description </th>
                            <th width="10%">Size </th>
                            <th width="10%" class="text-center">Qty</th>
                            <th width="10%" class="text-end">Unit SAR</th>
                            <th width="10%" class="text-end">Total SAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;
                            foreach($order_info['product'] as $product){
                            //$p_price = $product['real_price']; 
                            $p_price = ($product['discounted_price'] == 0) ? $product['real_price'] : $product['discounted_price'];
                            //$vat_initial = ($product['gst_rate'] / 100) * $p_price;
                            $initial_price = $product['order_price'] - $product['vat_price'];
                            $total_qty += $product['quantity'];
                            $total_vat += $product['vat_price'];
                            //$mrp += $product['real_price'] * $product['quantity'];
                            $amt_exl_vat += $product['order_price'] - $product['vat_price'];
                            $amt_incl_vat += $product['order_price'];
                        ?>
                        <tr>
                            <td>
                                <p><img src="<?php echo ($product['product_image'] == "" OR !file_exists($product['product_image'])) ? 'images/notfound.jpg':base_url($product['product_image']);?>" width="30px"></p>
                            </td>
                            <td>
                                <a href="<?php echo base_url('product/'.$product['id']); ?>"> <?php echo $product['product_name']; ?>
                                    <span><?php echo $product['arabic_name']; ?></span></a>
                                <p><?= $product['product_sku'];?> / </span> <span class="sku-divider"> <?= $product['barcode'];?></span></p>
                            </td>
                            <td align="left"><?php echo $product['size'];?></td>
                            <td align="center"><?php echo $product['quantity'];?></td>
                            <td align="right"><?= sprintf("%.3f",($initial_price/$product['quantity'])); ?> </td>
                            <td align="right"><?php echo sprintf("%.2f",$initial_price); ?></td>
                        </tr>
                        <?php } ?>
                        <tr class="basket-total">
                            <th colspan="3">Total Quantity: <span><?php echo $total_qty; ?></span></th>
                            <th colspan="2" class="text-end">Sub Total:</th>
                            <th class="price r text-end"> <span>SAR <?php echo sprintf("%.2f",$amt_exl_vat); ?></span></th>
                        </tr>
						<tr class="basket-total">
                            <th colspan="3"></th>
                            <th colspan="2" class="text-end">VAT (<?= $order_info['order']['vat_percent'];?>%):</th>
                            <th class="price r text-end"> <span> <?php echo sprintf("%.2f", ($order_info['order']['item_total_price'] - $order_info['order']['total_vat'])) .' SAR'; ?></span></th>
                        </tr>
                        <tr class="basket-total">
                            <th colspan="3"></th>
                            <th colspan="2" class="text-end">Shipping Charge:</th>
                            <th class="price r text-end"> <span>SAR <?php echo sprintf("%.2f",$order_info['order']['shipping_charge']); ?></span></th>
                        </tr>
                        <tr class="basket-total">
                            <th colspan="3"></th>
                            <th colspan="2" class="text-end">Grand Total:</th>
                            <th class="price r text-end"> <span>SAR <?php echo sprintf("%.2f",$order_info['order']['order_total']); ?></span></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
		<?php }else{ echo '<p>Unauthorized access</p>'; } ?>
    </div>
</section>
<?php $this->load->view("front/common/footer");?>
