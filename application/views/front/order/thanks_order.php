<?php $this->load->view("front/common/header");?>
<section class="order-pg  mb-5">
    <div class="container">
        <hr />
        <div class="file-actions text-end">
            <ul>
                <li> <a href="#">Export to CSV </a></li>
                <li> <a href="#">Copy To Basket </a></li>
            </ul>
        </div>
        <h4>Thank you, your order has been placed!
        </h4>
        <div class="order-pg-sec table-responsive">
            <div class="row">
                <div class="col-lg-6">
                    <table>
                        <tbody>
                            <tr>
                                <th>Status</th>
                                <td>
									<?php
										if($order_info['order']['quotation_status'] == 'pending'){
											$status = '<span class="text-secondary"> Pending</span>';
										}
										elseif($order_info['order']['quotation_status'] == 'review'){
											$status = '<span class="text-info"> In Review</span>';
										}elseif($order_info['order']['quotation_status'] == 'reject'){
											$status = '<span class="text-danger">Rejected</span>';
										}elseif($order_info['order']['quotation_status'] == 'approved'){
											$status = '<span class="badge badge-pill bg-success">Approved</span>';
										}elseif($order_info['order']['quotation_status'] == 'accept'){
											$status = '<span class="text-primary">Accepted</span>';
										}elseif($order_info['order']['quotation_status'] == 'pending' && $current_date > $exp_date){
											$status = '<span class="text-warning">Expired</span>';
										}elseif($order_info['order']['quotation_status'] == 'converted'){
											$status = '<span class="text-success">Converted</span>';
										}
									?>
									<?= $status;?>
								</td>
                            </tr>
                            <tr>
                                <th>Ordered On</th>
                                <td><b><?php $qdate=$order_info['order']['date_added']; echo date('d-m-Y h:i:s', strtotime($qdate)); ?></b>
                                </td>
                            </tr>
                            <tr>
                                <th>Customer Ref</th>
                                <td><b>#<?php echo $order_info['order']['invoice_prefix'] .'-'. $order_info['order']['quotation_no'];?></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table-borderless">
                        <thead>
                            <tr>
                                <th>Deliver To</th>
                                <th>Invoice To</th>
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
                                    <?php echo $order_info['order']['s_person_name'];?><br />
                                    <?php echo $order_info['order']['c_company'];?><br />
                                    <?php echo $order_info['order']['s_mobile'];?>,
                                    <?php echo $order_info['order']['s_phone'];?><br />
                                    <?php echo $order_info['order']['s_email'];?><br />
                                    <?php echo $order_info['order']['s_address_type'];?>-<?php echo $order_info['order']['s_building_villa_no'];?>,
                                    <?php echo $order_info['order']['s_street'];?><br />
                                    <?php echo $order_info['order']['s_city'];?>
                                    <?php echo $order_info['order']['s_postal'];?><br />
                                    <?php echo $order_info['order']['s_country'];?>
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
                            <th width="10%">Qty</th>
                            <th width="10%">Unit SAR</th>
                            <th width="10%">Total SAR</th>
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
                            <td><?php echo $product['quantity'];?></td>
                            <td>0.00 </td>
                            <td>0.00 </td>
                        </tr>
                        <?php } ?>
                        <tr class="basket-total">
                            <th colspan="3"></th>
                            <th>Total Quantity: <span><?php echo $total_qty; ?></span></th>
                            <th class="price r"> <span>SAR O. 00</span></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view("front/common/footer");?>
