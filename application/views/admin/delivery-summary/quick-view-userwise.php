<div class="row summary-detail-popup">
    <?php //echo '<pre>';print_r($result);?>
    <div class="col-12 mx-auto mb-5">
        <!-- <a href="<?php echo base_url('admin/daily-delivery-summary/print-detail-summary'). '?rider_id='. $rider_id .'&start_filter='. $start_date  .'&end_filter='. $end_date ?>" target="_blank" class="btn btn-custom-white float-end" style="position: absolute;right: 10px;">Print Summary</a> -->
        <div class="table-responsive">
            <table align="left" class="table table-bordered border-white mb-2">
                <tr>
                    <td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
                        <p></p>
                        <strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
                        <span>Riyadh, SA</span><br>
                        <span></span><br>
                        <span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
                    </td>
                    <td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
                        <p></p>
                        <strong style="font-size: 14px;">Delivery Summary of Period - <?php echo $start_date; ?> to <?php echo $end_date; ?></strong><br>
                        <span>Driver's ID: <?= $result['rider_detail']['driver_id'];?></span><br>
                        <span>Driver Name: <?= $result['rider_detail']['name'];?></span><br>
                    </td>
                </tr>
            </table>
            <table align="left" class="table table-bordered border-dark">
                <thead>
                    <tr class="thead-caption">
                        <td align="center"><b>S.No.</b></td>
                        <td align="left" style="width: 135px;"><b>Company Name</b></td>
                        <td colspan="10">
                            <table style="width: 100%;">
                                <tr>
                                    <td align="center"><b>Order Summary/Delivery Detail</b></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php $c_count = 1;foreach($result['order_info'] as $company_list){ ?>
                    <tr>
                        <td align="center" style="vertical-align: top;"><?= $c_count++; ?></td>
                        <td style="vertical-align: top;"><?php echo $company_list['company_detail']['company_name']; ?></td>
                        <td style="padding: 0px 2px;vertical-align: top;">
                            <?php $o_count = 1;foreach($company_list['orders'] as $order_list){ ?>
                            <table class="table inner-table-1 table-bordered">
                                <tr class="sub-heading" align="center" style="border-right: 1px solid #d6d6d6;"><td colspan="13"><b>ORDER OF DATE: <?= formatedDate($order_list['order_info']['delivery_date']); ?></b> <a href="<?php echo base_url('admin/daily-delivery-summary/edit-detail-summary?fdc='.$order_list['order_info']['id']); ?>" class="me-3 text-danger" data-bs-container="#tooltip-container1" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit" target="_blank"><i class="mdi mdi-pencil font-size-18"></i></a></td></tr>
                                <tr>
                                    <td>Total Deliveries</td>
                                    <td>Total Earnings</td>
                                    <td>Traffic Fine</td>
                                    <td>ID Fine</td>
                                    <td>Wallet Recv.</td>
                                    <td>Cash Recv</td>
                                    <td>POS Recv</td>
                                    <td>STCPay</td>
                                    <td>STCPayM</td>
                                    <td>Gasoline</td>
                                    <td>Hunger Topup</td>
                                    <td>Online Hours</td>
                                    <td style="width: 100px;">Delv. Date</td>
                                </tr>
                                <tr>
                                    <td align="right"><?= $order_list['order_info']['orders']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['total_earning']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['traffic_fine']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['id_fine']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['wallet_received']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['cash_received']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['pos_received']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['stcpay']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['stcpaym']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['fuel_topup']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['hunger_topup']; ?></td>
                                    <td align="right"><?= $order_list['order_info']['online_hrs']; ?></td>
                                    <td align="right"><?= formatedDate($order_list['order_info']['delivery_date']); ?></td>
                                </tr>
                            </table>
                            <table class="table inner-table-2 table-bordered">
                                <tr class="sub-heading-inner">
                                    <td align="center" style="line-height:20px;width:100px;">Ref. ID</td>
                                    <td align="center" style="line-height:20px;width:100px;">Collection Amt.</td>
                                    <td align="center" style="line-height:20px;width:100px;">Delivery Price</td>
                                    <td align="center" style="line-height:20px;width:125px;">Free Order Count</td>
                                    <td align="center" style="line-height:20px;width:100px;">Driver Credit</td>
                                    <td align="center" style="line-height:20px;width:100px;">Driver Debit</td>
                                    <td align="center" style="line-height:20px;width:100px;">Service Deduction</td>
                                    <td align="center" style="line-height:20px;width:100px;">Driver Tips</td>
                                    <td align="center" style="line-height:20px;width:100px;">Settled By</td>
                                    <td align="center" style="line-height:20px;width:130px;">Settled Date</td>
                                </tr>
                                <?php if(count($order_list['order_detail']) > 0){ ?>
                                    <?php foreach($order_list['order_detail'] as $detail){ ?>
                                    <tr>
                                        <td><?php echo $detail['ref_id'];?></td>
                                        <td align="right"><?php echo $detail['collection_amt'];?></td>
                                        <td align="right"><?php echo $detail['delivery_price'];?></td>
                                        <td align="right"><?php echo $detail['free_order_count'];?></td>
                                        <td align="right"><?php echo $detail['driver_credit'];?></td>
                                        <td align="right"><?php echo $detail['driver_debit'];?></td>
                                        <td align="right"><?php echo $detail['service_deduction'];?></td>
                                        <td align="right"><?php echo $detail['driver_tips'];?></td>
                                        <td align="right"><?php echo $detail['settled_by'];?></td>
                                        <td align="right"><?php echo formatedDate($detail['settled_date']);?></td>
                                    </tr>
                                    <?php } ?>
                                <?php }else{ ?>
                                    <tr><td colspan="10" align="center" style="line-height:20px;">No Detail Found</td></tr>
                                <?php } ?>
                            </table>
                            <?php } ?>
                        </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->
