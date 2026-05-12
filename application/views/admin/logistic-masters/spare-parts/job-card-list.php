<div class="row">
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-body pb-2">
                <div class="col-12 table-responsive">
                    <table align="left" class="table table-bordered border-dark mb-2">
                        <tr>
                            <td><b>Item Code</b> : <?= $prod_info['item_code'];?></td>
                            <td><b>Item Name</b> : <?= $prod_info['part_name_en'];?></td>
                        </tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark mb-0">
                        <?php
                            $count_orders = count($summary_list);
                        ?>
                        <tr class="h6" style="background-color: #f1d171!important;color: #000;"><td align="center">Spare Stock Out (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark">
                        <tbody>
                            <tr class="thead-caption">
                                <td align="center" style="line-height:20px;"><b>Sr. No</b></td>
                                <td align="center" style="line-height:20px;"><b>Job Card No.</b></td>
                                <td align="center" style="line-height:20px;"><b>Job Type</b></td>
                                <td align="center" style="line-height:20px; width:200px"><b>Job Date</b></td>
                                <td align="center" style="line-height:20px;"><b>Quantity</b></td>
                            </tr>
                            <?php $count_j = 1; foreach($summary_list as $list){ ?>
                            <tr class="result-tr" id="jc_<?= $count_j;?>">
                                <td align="center"><?= $count_j++; ?></td>
                                <td align="center"><a class="text-decoration-underline" href="admin/job-card/detail?id=<?php echo $list['jobcard_id'];?>" target="_blank"><?= 'JC-'. invoiceNmFormat($list['jobcard_id']);?></a></td>
                                <td align="center"><?= $list['job_type'];?></td>
                                <td align="center"><?= date('d-m-Y', strtotime($list['job_date']));?></td>
                                <td align="center"><?= $list['qty'];?></td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->
