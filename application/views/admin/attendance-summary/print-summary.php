<table class="table" width="94%" border="1" cellspacing="0" cellpadding="5">
    <?php
        $count_company = count(fdCompanyHelper());
    ?>
    
    <tbody>
        <tr class="thead-caption">
            <td rowspan="2" align="center" style="line-height:20px;width:5%;"><b>Sr.No</b></td>
            <td rowspan="2" align="center" style="line-height:20px;width:7%;"><b>EMP_ID</b></td>
            <td rowspan="2" align="center" style="line-height:20px;width:28%;"><b>Name</b></td>
            <td rowspan="2" align="center" style="line-height:20px;width:5%;"><b>Del.</b></td>
            <td rowspan="2" align="center" style="line-height:20px;width:7%;"><b>Earnings</b></td>
            <?php foreach(fdCompanyHelper() as $company){ ?>
            <td colspan="6" align="center" style="line-height:20px;"><b><?= $company->company_name;?></b></td>
            <?php } ?>
        </tr>
        <tr class="thead-caption">
        <?php for ($i=0; $i < $count_company; $i++) { ?>
            <td align="center" style="line-height:20px;">Delivery</td>
            <td align="center" style="line-height:20px;">Cash</td>
            <td align="center" style="line-height:20px;">Wallet</td>
            <td align="center" style="line-height:20px;">STC_P</td>
            <td align="center" style="line-height:20px;">STC_M</td>
            <td align="center" style="line-height:20px;">POS</td>
        <?php } ?>
        </tr>
        <?php 
        if(count($results) > 0){ 
            $total_main_del = 0;
            $total_main_amt = 0;
            $total_summary = 0;
            for ($ci=0; $ci < ($count_company); $ci++) { 
                $child['total_orders'][$ci] = 0;
                $child['total_cash'][$ci] = 0;
                $child['total_wallet'][$ci] = 0;
                $child['total_stc'][$ci] = 0;
                $child['total_stcpaym'][$ci] = 0;
                $child['total_pos'][$ci] = 0;
            }
        ?>
            <?php $result_count = 1;foreach($results as $summary) { ?>
                <?php
                    $total_main_del += $summary['total_orders'];
                    $total_main_amt += $summary['total_earnings'];
                    $total_summary = count($summary['order_info']);
                ?>
                <tr class="result-tr">
                    <td align="center"><?= $result_count++;?></td>
                    <td align="left"><?= $summary['emp_id'];?></td>
                    <td align="left"><?= $summary['rider_name'];?></td>
                    <td align="right"><?= $summary['total_orders'];?></td>
                    <td align="right"><?= $summary['total_earnings'];?></td>
                    <?php $o_count = 0;foreach($summary['order_info'] as $o_info){ ?>
                    <?php 
                        $child['total_orders'][$o_count] += $o_info['total_orders'];
                        $child['total_cash'][$o_count] += $o_info['total_cash'];
                        $child['total_wallet'][$o_count] += $o_info['total_wallet'];
                        $child['total_stc'][$o_count] += $o_info['total_stc'];
                        $child['total_stcpaym'][$o_count] += $o_info['total_stcpaym'];
                        $child['total_pos'][$o_count] += $o_info['total_pos'];
                    ?>
                    <td align="right"><button type="link" class="btn btn-link quick-modal-btn" onclick="quickView('<?= $o_info['id'];?>')"><?= ($o_info['total_orders'] > 0) ? $o_info['total_orders'] : '0';?></button></td>
                    <td align="right" class="cash-td"><?= ($o_info['total_cash'] !== '') ? $o_info['total_cash'] : '-';?></td>
                    <td align="right" class="cash-td"><?= ($o_info['total_wallet'] !== '') ? $o_info['total_wallet'] : '-';?></td>
                    <td align="right" class="cash-td"><?= ($o_info['total_stc'] !== '') ? $o_info['total_stc'] : '-';?></td>
                    <td align="right" class="cash-td"><?= ($o_info['total_stcpaym'] !== '') ? $o_info['total_stcpaym'] : '-';?></td>
                    <td align="right" class="cash-td"><?= ($o_info['total_pos'] !== '') ? $o_info['total_pos'] : '-';?></td>
                    <?php $o_count++;} ?>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="right"><b><?= $total_main_del; ?></b></td>
                <td align="right"><b><?= $total_main_amt; ?></b></td>
                <?php for ($i=0; $i < $total_summary; $i++) { 
                    echo '<td align="right"><b>'. number_format($child['total_orders'][$i], 2) .'</b></td>';
                    echo '<td align="right"><b>'. number_format($child['total_cash'][$i], 2) .'</b></td>';
                    echo '<td align="right"><b>'. number_format($child['total_wallet'][$i], 2) .'</b></td>';
                    echo '<td align="right"><b>'. number_format($child['total_stc'][$i], 2) .'</b></td>';
                    echo '<td align="right"><b>'. number_format($child['total_stcpaym'][$i], 2) .'</b></td>';
                    echo '<td align="right"><b>'. number_format($child['total_pos'][$i], 2) .'</b></td>';
                } ?>
            </tr>
            <?php }else{ ?>
                <tr class="text-dark h6" style="background-color: #efefefcc!important">
                    <td colspan="<?php echo (5 + ($count_company*6));?>" align="center">No data found</td>
                </tr>
        <?php } ?>
    </tbody>
</table>