<div class="row">
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-body pb-2">
                <div class="col-md-12 mb-5">
                    <a href="<?php echo base_url('admin/daily-delivery-summary/print-detail-summary'). '?company_id='. $other_info['company_id'] .'&rider_id='. $other_info['rider_id'] .'&start_filter='. $entry_date  .'&end_filter='. $exit_date ?>" target="_blank" class="btn btn-custom-white float-end">Print Summary</a>
                </div>
                <div class="col-12 table-responsive">
                    <table align="left" class="table table-bordered border-dark mb-2">
                        <tr><td colspan="2" align="center"><b>Summary Overview</b></td></tr>
                        <tr>
                            <td><b>Driver's ID</b> : <?= $other_info['driver_id'];?></td>
                            <td><b>Driver Name</b> : <?= $other_info['driver_name'];?></td>
                        </tr>
                        <tr>
                            <td><b>Company Name</b> : <?= $other_info['company_name'];?></td>
                            <td><b>Date</b> : <?= formatedDate($entry_date);?></td>
                        </tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark mb-0">
                        <?php
                            $count_orders = count($summary_list);
                        ?>
                        <tr class="text-white h6" style="background-color: #026902cc!important"><td align="center">Order List (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark">
                        <tbody>
                            <tr class="thead-caption">
                                <td align="center" style="line-height:20px;"><b>Sr. No</b></td>
                                <td align="center" style="line-height:20px;"><b>Ref. ID</b></td>
                                <td align="center" style="line-height:20px;"><b>Collection Amt.</b></td>
                                <td align="center" style="line-height:20px;"><b>Delivery Price</b></td>
                                <td align="center" style="line-height:20px;"><b>Free Order Count</b></td>
                                <td align="center" style="line-height:20px;"><b>Driver Credit</b></td>
                                <td align="center" style="line-height:20px;"><b>Driver Debit</b></td>
                                <td align="center" style="line-height:20px;"><b>Service Deduction</b></td>
                                <td align="center" style="line-height:20px;"><b>Driver Tips</b></td>
                                <td align="center" style="line-height:20px;"><b>Settled By</b></td>
                                <td align="center" style="line-height:20px;"><b>Settled Date</b></td>
                            </tr>
                            <?php 
                                $t_collection_amt = 0;
                                $t_delivery_price = 0;
                                $t_free_order_count = 0;
                                $t_driver_credit = 0;
                                $t_driver_debit = 0;
                                $t_service_deduction = 0;
                                $t_driver_tips = 0;
                                $count_i = 1; 
                                foreach($summary_list as $list){
                                
                                $t_collection_amt += $list->collection_amt;
                                $t_delivery_price += $list->delivery_price;
                                $t_free_order_count += $list->free_order_count;
                                $t_driver_credit += $list->driver_credit;
                                $t_driver_debit += $list->driver_debit;
                                $t_service_deduction += $list->service_deduction;
                                $t_driver_tips += $list->driver_tips;
                            ?>
                            <tr class="result-tr">
                                <td align="center"><?= $count_i++; ?></td>
                                <td align="center"><?= $list->ref_id;?></td>
                                <td align="center"><?= $list->collection_amt;?></td>
                                <td align="center"><?= $list->delivery_price;?></td>
                                <td align="center"><?= $list->free_order_count;?></td>
                                <td align="center"><?= $list->driver_credit;?></td>
                                <td align="center"><?= $list->driver_debit;?></td>
                                <td align="center"><?= $list->service_deduction;?></td>
                                <td align="center"><?= $list->driver_tips;?></td>
                                <td align="center"><?= $list->settled_by;?></td>
                                <td align="center" style="width: 125px;"><?= formatedDate($list->settled_date);?></td>
                            </tr>
                            <?php } ?> 
                            <tr class="thead-caption">
                                <td align="right" colspan="2"><b>Total</b></td>
                                <td align="center"><b><?= number_format($t_collection_amt,2);?></b></td>
                                <td align="center"><b><?= number_format($t_delivery_price,2);?></b></td>
                                <td align="center"><b><?= $t_free_order_count;?></b></td>
                                <td align="center"><b><?= number_format($t_driver_credit,2);?></b></td>
                                <td align="center"><b><?= number_format($t_driver_debit,2);?></b></td>
                                <td align="center"><b><?= number_format($t_service_deduction,2);?></b></td>
                                <td align="center"><b><?= number_format($t_driver_tips,2);?></b></td>
                                <td align="center"><b>-</b></td>
                                <td align="center" style="width: 125px;"><b>-</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->