<div class="row">
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-body pb-2">
                <div class="col-12 table-responsive">
                    <table align="left" class="table table-bordered border-dark mb-2">
                        <tbody>
                            <tr class="thead-caption">
                                <td><b>Asset Code</b></td>
                                <td><b>Asset Name</b></td>
                                <td><b>Prod. sr. no</b></td>
                                <td><b>Model no	</b></td>
                                <td><b>Allotment</b></td>
                            </tr>
                            <tr>
                                <td><?= $assets_detail['fa_code'];?></td>
                                <td><?= $assets_detail['description'];?></td>
                                <td><?= $assets_detail['prod_sr_no'];?></td>
                                <td><?= $assets_detail['model_no'];?></td>
                                <td><?php echo ($assets_detail['is_alloted'] == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';?></td>
                            </tr>
                        </tbody>
                    </table>
                    <table align="left" class="table table-bordered border-dark mb-0">
                        <?php
                            $count_orders = count($assets_log);
                        ?>
                        <tr class="h6" style="background-color: #f1d171!important;color: #000;"><td align="center">Inventory Logs (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark">
                        <tbody>
                            <tr class="thead-caption">
                                <td align="center" style="line-height:20px;"><b>Sr. No</b></td>
                                <td align="center" style="line-height:20px;"><b>Allot Type</b></td>
                                <td align="center" style="line-height:20px;"><b>Employee Name</b></td>
                                <td align="center" style="line-height:20px;"><b>Designation</b></td>
                                <td align="center" style="line-height:20px;"><b>Remarks</b></td>
                                <td align="center" style="line-height:20px; width:200px"><b>Created Date</b></td>
                            </tr>
                            <?php $count_i = 1; foreach($assets_log as $list){ ?>
                            <tr class="result-tr">
                                <td align="center"><?= $count_i++; ?></td>
                                <td align="center"><?= $list['status'] == 'allot' ? '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';?></td>
                                <td align="center"><?= $list['emp_name'];?></td>
                                <td align="center"><?= $list['desig_location'];?></td>
                                <td align="center"><?= $list['remarks'];?></td>
                                <td align="center" style="width: 125px;"><?= date('d-m-Y H:i:s', strtotime($list['created_at']));?></td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->