<style>
tr.thead-caption {
    background-color: khaki;
    color: #000;
}
</style>
<div class="row">
    <div class="col-12 mx-auto">
        <div class="card">
            <div class="card-body p-0 pb-2">
                <div class="col-12 table-responsive">
					<table align="left" class="table table-bordered border-dark mb-2">
                        <tr>
                            <td><b>Vehicle Number</b> : <?= $vehicle_info['vehicle_no'];?>  (<?= ucfirst($vehicle_info['vehicle_type']);?>)</td>
                            <td><b>Vehicle Make</b> : <?= $vehicle_info['make_name'];?></td>
                            <td><b>Vehicle Model</b> : <?= $vehicle_info['vehicle_model'];?></td>
                            <td><b>Sequel No.</b> : <?= $vehicle_info['sequel_no'];?></td>
                        </tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark mb-0">
                        <?php
                            $count_orders = count($logs);
                        ?>
                        <tr class="h6" style="background-color: #f1d171!important;color: #000;"><td align="center">Vehicle Logs (Total : <?= $count_orders; ?>)</td></tr>
                    </table>
                    <table align="left" class="table table-bordered border-dark">
                        <tbody>
                            <tr class="thead-caption text-center">
                                <th>#</th>
								<th>Vehicle No</th>
								<th>Meter Reading</th>
								<th>Rider Name</th>
								<th>Date</th>
								<th>Status</th>
								<th>Location</th>
								<th>Remarks</th>
                                <th>Tamm Auth./Cancl.</th>
								<th>Created On</th>
                            </tr>
                            <?php if(count($logs) > 0){ $count_i = 1; foreach($logs as $list){ ?>
                            <tr class="result-tr">
                                <td align="center"><?= $count_i++; ?></td>
                                <td align="center"><?= $list['vehicle_no'];?></td>
                                <td align="center"><?= $list['meter_reading'];?></td>
                                <td align="left"><?= $list['full_name'];?></td>
                                <td align="left"><?= date('d-m-Y',strtotime($list['status_date']));?></td>
								<?php
								if($list['log_status'] == 'alloted'){
									$status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
								}elseif ($list['log_status'] == 'unalloted') {
									$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Unalloted</span>';
								}elseif ($list['log_status'] == 'return') {
									$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Return</span>';
								}else{
									$status = '<span class="badge badge-pill badge-soft-default font-size-13">NA</span>';
								}
								?>
                                <td align="center"><?= $status;?></td>
                                <td align="center"><?= $list['parking_name'];?></td>
                                <td align="center"><?= $list['remarks'];?></td>
                                <td align="center"><?= !empty($list['tamm_attachment']) ? '<a href="' . base_url($list['tamm_attachment']) . '" target="_blank"><i class="fa fa-paperclip font-size-20"></i></a>': 'NA';?></td>
                                <td align="center" style="width: 125px;"><?= date('d-m-Y H:i:s', strtotime($list['created_at']));?></td>
                            </tr>
                            <?php }}else{ ?>  
							<tr>
								<td colspan="9" align="center">No Data Found</td>
							</tr>
							<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    

</div> <!-- end row -->
