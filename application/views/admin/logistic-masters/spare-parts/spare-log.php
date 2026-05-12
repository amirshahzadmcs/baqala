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
                        <tr class="h6" style="background-color: #f1d171!important;color: #000;"><td align="center">Inventory Logs (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark">
                        <tbody>
                            <tr class="thead-caption">
                                <td align="center" style="line-height:20px;"><b>Sr. No</b></td>
                                <td align="center" style="line-height:20px;"><b>Stock Type</b></td>
                                <td align="center" style="line-height:20px;"><b>Qunatity</b></td>
                                <td align="center" style="line-height:20px;"><b>Remarks</b></td>
                                <td align="center" style="line-height:20px; width:200px"><b>Created Date</b></td>
                            </tr>
                            <?php $count_i = 1; foreach($summary_list as $list){ ?>
                            <tr class="result-tr" id="tr_<?= $count_i;?>">
                                <td align="center"><?= $count_i++; ?></td>
                                <td align="center"><?= $list->in_out == 'in' ? '<span class="badge badge-pill badge-soft-success font-size-13">Stock In</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Stock Out</span>';?></td>
                                <td align="center"><?= $list->quantity;?></td>
                                <td align="center"><?= $list->remarks;?></td>
                                <td align="center" style="width: 125px;"><?= date('d-m-Y H:i:s', strtotime($list->created_at));?></td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->
