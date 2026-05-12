<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
    <tbody>
        <tr class="thead-caption">
            <td align="center" style="line-height:20px;width:5%;"><b>Sr. No</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Ref. ID</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Collection Amt.</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Delivery Price</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Free Order Count</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Driver Credit</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Driver Debit</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Service Deduction</b></td>
            <td align="center" style="line-height:20px;width:7%;"><b>Driver Tips</b></td>
            <td align="center" style="line-height:20px;width:8%;"><b>Settled By</b></td>
            <td align="center" style="line-height:20px;width:10%;"><b>Settled Date</b></td>
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
            foreach($results['summary_list'] as $list){
            
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
            <td align="center"><?= formatedDate($list->settled_date);?></td>
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
            <td align="center"><b>-</b></td>
        </tr>
    </tbody>
</table>