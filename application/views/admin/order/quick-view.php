<tr class="clone-tr" id="trclone_<?= $result['order']['id']; ?>" style="background: #f9f9f9;">
    <td colspan="12">
        <div class="row">
            <div class="col-md-6">
                <h6>Picker</h6>
                <ul class="ps-0">
                    <li class="d-block">Name: </li>
                    <li class="d-block">Mobile: </li>
                    <li class="d-block">Email ID: </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Rider</h6>
                <ul class="ps-0">
                    <li class="d-block">Name: <span id="dboyName"><?= $result['order']['db_name']; ?></span></li>
                    <li class="d-block">Mobile: <span id="dboyMob"><?= $result['order']['db_mob']; ?></span></li>
                    <li class="d-block">Email ID: <span id="dboyEmail"><?= $result['order']['db_email']; ?></span></li>
                </ul>
            </div>
        </div>
        <h6>Payment</h6>
        <table class="table w-100 border border-secondary">
            <thead>
                <tr class="bg-info">
                    <td class="text-start">Original Amount</td>
                    <td class="text-start">Confirmed Amount</td>
                    <td class="text-start">Total to be collected</td>
                    <td class="text-start">Price Difference</td>
                    <td class="text-start">Fees</td>
                    <td class="text-start">Discount</td>
                    <td class="text-start">Wallet</td>
                    <td class="text-start">Currency</td>
                    <td colspan="2" class="text-start">Payment Method</td>
                    <?php if (check_action_permission(get_user_role(), 'order', 'print_invoice')): ?>
                        <td class="text-start">Receipt Image</td>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <?php $net_amt = $result['order']['order_total'];
                        echo sprintf("%.2f", $net_amt); ?>
                    </td>
                    <td class="text-center">
                        <?php echo sprintf("%.2f", $net_amt); ?>
                    </td>
                    <td class="text-center">
                        <?php $net_payble_amt = $result['order']['net_payble_amt'];
                        echo sprintf("%.2f", $net_payble_amt); ?>
                    </td>
                    <td class="text-center">
                        <?php echo sprintf("%.2f", $net_amt - $net_payble_amt); ?>
                    </td>
                    <td class="text-center"><?php echo $result['order']['shipping_charge']; ?></td>
                    <td class="text-center">N/A</td>
                    <td class="text-center"><?php $wallet_applied = $result['order']['wallet_applied'];
                                            echo sprintf("%.2f", $wallet_applied); ?></td>
                    <td class="text-center">SAR</td>
                    <td colspan="2" class="text-center"><?php echo $result['order']['payment_method']; ?></td>
                    <?php if (check_action_permission(get_user_role(), 'order', 'print_invoice')): ?>
                        <td class="text-center">
                            <a href="<?php echo base_url(); ?>admin/order_process/print_invoice?id=<?php echo $result['order']['id']; ?>" class="text-danger font-size-14" data-toggle="tooltip" title="Print Invoice" target="_blank">Invoice <i class="mdi mdi-download ml-2"></i></a>
                        </td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>
        <h6>Products (Total No : <?= count($result['product']); ?>)</h6>
        <table class="table w-100 border border-secondary">
            <thead>
                <tr class="bg-success">
                    <td class="text-start">Image</td>
                    <td class="text-start">Child SKU</td>
                    <td class="text-start">Barcode</td>
                    <td class="text-start">Product Description</td>
                    <td class="text-start">Qty</td>
                    <td class="text-start">Status</td>
                    <td class="text-start">Original Price</td>
                    <td class="text-start">Final Price</td>
                    <td colspan="2" class="text-start">Comments</td>
                    <td class="text-start">Issue</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_qty = 0;
                $i = 1;
                $amt_exl_vat = 0;
                $amt_incl_vat = 0;
                $total_vat = 0;
                $saving = 0;
                $ptotal = 0;
                foreach ($result['product'] as $product) {
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
                        <td class="text-center"><img src="<?php echo ($product['product_image'] == "" or !file_exists($product['product_image'])) ? 'images/notfound.jpg' : $product['product_image']; ?>" width="50px"></td>
                        <td class="text-start"><?php echo $product['product_sku']; ?></td>
                        <td class="text-start"><?php echo $product['barcode']; ?></td>
                        <td class="text-start">
                            <?php echo $product['product_name']; ?><br />
                            <span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
                        </td>
                        <td class="text-center"><?php echo $product['quantity']; ?></td>
                        <td class="text-start">N/A</td>
                        <td class="text-start"><?php echo sprintf("%.2f", $p_price); ?></td>
                        <td class="text-end"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
                        <td colspan="2" class="text-start">N/A</td>
                        <td class="text-start">N/A</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php if (check_action_permission(get_user_role(), 'order', 'process')): ?>
            <form class="row mt-3" action="<?php echo base_url('admin/order_process/process'); ?>" method="POST">
                <input type="hidden" name="id" value="<?= $result['order']['id']; ?>" />
                <input type="hidden" name="email" value="<?= $result['order']['email']; ?>" />
                <div class="col-md-12">
                    <hr />
                    <h6>Update Status</h6>
                    <hr />
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label class="d-block">Select Status </label>
                        <select style="height:410px;" name="status" class="form-control select2 w-100">
                            <option value="">Select Status</option>
                            <option value="0" <?php echo ($result['order']['order_status_id'] == 0) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] > 0) ? 'disabled' : ''; ?>>Pending</option>
                            <option value="1" <?php echo ($result['order']['order_status_id'] == 1) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 0) ? '' : 'disabled'; ?>>Recieved</option>
                            <option value="2" <?php echo ($result['order']['order_status_id'] == 2) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 1) ? '' : 'disabled'; ?>>Accepted</option>
                            <option value="4" <?php echo ($result['order']['order_status_id'] == 4) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 2) ? '' : 'disabled'; ?>>Van Assigned</option>
                            <option value="5" <?php echo ($result['order']['order_status_id'] == 5) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 4) ? '' : 'disabled'; ?>>Dispatched</option>
                            <option value="6" <?php echo ($result['order']['order_status_id'] == 6) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 5) ? '' : 'disabled'; ?>>Delivered</option>
                            <option value="7" <?php echo ($result['order']['order_status_id'] == 7) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 5) ? '' : 'disabled'; ?>>Cancel On Delivery</option>
                            <option value="3" <?php echo ($result['order']['order_status_id'] == 3) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] < 6) ? '' : 'disabled'; ?>>Cancel By Admin</option>
                            <option value="8" <?php echo ($result['order']['order_status_id'] == 8) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] == 3 || $result['order']['order_status_id'] == 5 || $result['order']['order_status_id'] == 9) ? '' : 'disabled'; ?>>Refund</option>
                            <option value="9" <?php echo ($result['order']['order_status_id'] == 9) ? 'selected' : ''; ?> <?php echo ($result['order']['order_status_id'] < 6) ? '' : 'disabled'; ?>>Cancel By Customer</option>
                        </select>
                    </div>
                </div>
                <?php if ($result['order']['order_status_id'] == 2) { ?>
                    <!--
            <div class="col-md-4">
                <div class="form-group mb-2">
                    <label class="d-block">Crate No. (if any) </label>
                    <input type="text" id="track" class="form-control" name="tracking_id" />
                </div>
            </div>
           -->
                    <input type="hidden" name="tracking_id" value="<?= $result['order']['tracking']; ?>" />
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="d-block">Total Packets (if any) </label>
                            <input type="number" name="packets_no" min="1" max="50" minlength="1" maxlength="2" class="form-control" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="d-block">Select Delivery Person </label>
                            <select name="delivery_boy" class="form-control show-tick select2 w-100" id="selectDeliveryBoy" required>
                                <option value="">--- Select Delivery Person ---</option>
                                <?php foreach (deliveryBoyList() as $dboy) { ?>
                                    <option value="<?php echo $dboy->id; ?>" data-name="<?php echo $dboy->full_name; ?>" data-mobile="<?php echo $dboy->mobile; ?>" data-email="<?php echo $dboy->email; ?>"><?php echo $dboy->emp_no; ?> - <?php echo $dboy->full_name; ?> (<?php echo $dboy->designation_name; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" name="tracking_id" value="<?= $result['order']['tracking']; ?>" />
                    <input type="hidden" min="1" max="50" minlength="1" maxlength="2" name="packets_no" value="<?= $result['order']['packets']; ?>" required />
                    <input type="hidden" name="delivery_boy" value="<?= $result['order']['delivery_boy']; ?>" />
                <?php } ?>
                <div class="col-md-8">
                    <div class="form-group mb-2">
                        <label class="d-block">Remarks (if any) </label>
                        <input type="text" class="form-control" id="remarks" name="remarks" maxlength="250" value="" />
                    </div>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-sm btn-custom-success float-end">Update Status</button>
                </div>
            </form>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="history-tl-container">
                    <ul class="tl">

                        <li class="tl-item">
                            <div class="timestamp">
                                <?= date("d M Y", strtotime($result['order']['date_added'])); ?><br />
                                <?= date("h:i A", strtotime($result['order']['date_added'])); ?>
                            </div>
                            <div class="item-title">Placed</div>
                            <div class="item-detail">Order Placed</div>
                        </li>
                        <?php foreach ($result['logs'] as $log) { ?>
                            <li class="tl-item">
                                <div class="timestamp">
                                    <?= date("d M Y", strtotime($log['created_at'])); ?><br />
                                    <?= date("h:i A", strtotime($log['created_at'])); ?>
                                </div>
                                <div class="item-title"><?= $log['status_type']; ?></div>
                                <div class="item-detail"><?= $log['description']; ?></div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </div>
    </td>
    <script>
        $('.select2').select2({
            placeholder: 'Select an option'
        });

        $('#selectDeliveryBoy').change(function() {
            var sel_name = $(this).find('option:selected').data('name');
            var sel_mobile = $(this).find('option:selected').data('mobile');
            var sel_email = $(this).find('option:selected').data('email');

            $('#dboyName').html(sel_name);
            $('#dboyMob').html(sel_mobile);
            $('#dboyEmail').html(sel_email);
        });
    </script>
</tr>