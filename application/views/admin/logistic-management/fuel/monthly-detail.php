<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	td {
		white-space: nowrap;
	}

	.mark_bold { font-weight:bold; }
    .grey-background { background:#eee; }
    .duplicate-vehicle {
        background-color: #ffe6e6 !important;
        font-weight: bold;
    }
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<?php
                        $date = DateTime::createFromFormat('Y-m', $search_month);
                        $fuelMonth = $date ? $date->format('F Y') : 'Invalid Month';
                    ?>
					<h4><b><?= $fuelMonth ?> Fuel Consumption</b></h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/fuel/list'); ?>">Fuel Consumption</a></li>
						<li class="breadcrumb-item active">Monthly</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/logistic-management/fuel/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<!-- <button type="button" class="btn btn-custom-white btn-sm pull-right me-2" title="Export"><i class="fas fa-file-excel me-2"></i>Export</button> -->
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
						<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>

					<?php } else { ?>
						<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data; ?></strong>
						</div>
				<?php }
				}
				$this->admin->removeInfo();  ?>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->


<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body" style="overflow: scroll;">
                        <?php
                        if ($search_month) {
                            $date = DateTime::createFromFormat('Y-m', $search_month);
                            $num_days = (int) $date->format('t'); // number of days in month
                        }
                        ?>
						<table class="table table-bordered" style="width:100%">
							<tr>
                                <td align="center" class="mark_bold" rowspan="2" style="width:25px;background-color:#ebebeb;">#</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:55px;background-color:#ebebeb;">Vehicle No</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:50px;background-color:#ebebeb;">Vehicle Type</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:50px;background-color:#ebebeb;">Allotment Status</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:50px;background-color:#ebebeb;">Emp No</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:250px;background-color:#ebebeb;">Employee Name</td>
								<td align="center" class="mark_bold" rowspan="2" style="width:50px;background-color:#ebebeb;">Team</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:60px;background-color:#ebebeb;">Fuel Consumption</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:60px;background-color:#ebebeb;">Order Completed</td>
                                <td align="center" class="mark_bold" rowspan="2" style="width:60px;background-color:#ebebeb;">Avg. Per Rider</td>
                                
                                <!-- <td align="center" class="mark_bold" rowspan="2" style="width:150px;background-color:#ebebeb;">Team Leader</td> -->
                                <?php for ($day = 1; $day <= $num_days; $day++): ?>
                                <td align="center" colspan="2" style="width:65px;background-color:#99CC66;"><?= $day .' '. date('M', strtotime($search_month . '-01')) ?></td>
                                <?php endfor; ?>
                            </tr>
                            <tr>
                                <?php for ($day = 1; $day <= $num_days; $day++): ?>
                                    <td align="center" class="mark_bold" style="background-color:#66CCCC;">Fuel</td>
                                    <td align="center" class="mark_bold" style="background-color:#FFCC33;">Orders</td>
                                <?php endfor; ?>
                            </tr>
                            <?php if (!empty($employees)): ?>
                                <?php 
                                $grand_total_cost = 0;
                                $grand_total_orders = 0;
                                $daily_totals = [];
                                $i = 1;

                                // Step 1: Count vehicles
                                $vehicleCounts = array_count_values(array_column($employees, 'vehicle_no'));
                                ?>
                                <?php foreach ($employees as $emp): ?>
                                    <?php 
                                    $total_cost = 0;
                                    $total_orders = 0;
                                    $isDuplicate = isset($vehicleCounts[$emp['vehicle_no']]) && $vehicleCounts[$emp['vehicle_no']] > 1;
                                    ?>
                                    <tr>
                                        <td align="center"><?= $i++; ?></td>
                                        <!-- Step 2: Add class if duplicate -->
                                        <td align="center" class="<?= $isDuplicate ? 'duplicate-vehicle' : '' ?>">
                                            <?= $emp['vehicle_no'] ?? '-' ?>
                                        </td>

                                        <td align="center"><?= ucfirst($emp['vehicle_type']) ?? '-' ?></td>
                                        <td align="center"><?= ucfirst($emp['allotment_status']) ?? '-' ?></td>

                                        <td align="center"><?= $emp['emp_no'] ?? '-' ?></td>
                                        <td style="text-align:left;"><?= $emp['full_name'] ?? '-' ?></td>
                                        
                                        <td align="center"><?= ucfirst($emp['team_name']) ?? '-' ?></td>
                                        
                                        <?php 
                                        $total_cost   = array_sum(array_column($emp['days'], 'cost'));
                                        $total_orders = array_sum(array_column($emp['days'], 'orders'));
                                        $avg_per_order = ($total_orders > 0) ? $total_cost / $total_orders : 0;
                                        ?>
                                        <td align="center" class="mark_bold"><?= number_format($total_cost, 2) ?></td>
                                        <td align="center" class="mark_bold"><?= $total_orders ?></td>
                                        <td align="center" class="mark_bold"><?= $total_orders > 0 ? number_format($avg_per_order, 2) : '-' ?></td>

                                        <?php for ($day = 1; $day <= $num_days; $day++): ?>
                                            <?php 
                                            $cost   = $emp['days'][$day]['cost'] ?? 0;
                                            $orders = $emp['days'][$day]['orders'] ?? 0;

                                            if (!isset($daily_totals[$day])) {
                                                $daily_totals[$day] = ['cost' => 0, 'orders' => 0];
                                            }
                                            $daily_totals[$day]['cost']   += $cost;
                                            $daily_totals[$day]['orders'] += $orders;

                                            $weekday = date('N', strtotime($search_month . '-' . sprintf('%02d',$day)));
                                            $isWeekend = ($weekday >= 5);
                                            ?>
                                            <td align="center" class="<?= $isWeekend ? 'grey-background' : '' ?>"><?= $cost > 0 ? number_format($cost, 2) : '-' ?></td>
                                            <td align="center" class="<?= $isWeekend ? 'grey-background' : '' ?>"><?= $orders > 0 ? $orders : '-' ?></td>
                                            <?php 
                                            $total_cost   += $cost;
                                            $total_orders += $orders;
                                            ?>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php 
                                    $grand_total_cost += $total_cost;
                                    $grand_total_orders += $total_orders;
                                    ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= ($num_days * 2) + 7 ?>" align="center">
                                        No fuel consumption data available
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php if (!empty($employees)): ?>
                            <tfoot>
                                <tr style="background-color:#f3ffdf; font-weight:bold;">
                                    <td colspan="7" align="right">Grand Total</td>
                                    <?php 
                                    $grand_avg = ($grand_total_orders > 0) ? $grand_total_cost / $grand_total_orders : 0;
                                    ?>
                                    <td align="center"><?= number_format($grand_total_cost, 2) ?></td>
                                    <td align="center"><?= $grand_total_orders ?></td>
                                    <td align="center"><?= $grand_total_orders > 0 ? number_format($grand_avg, 2) : '-' ?></td>
                                    <?php for ($day = 1; $day <= $num_days; $day++): ?>
                                        <td align="center"><?= number_format($daily_totals[$day]['cost'], 2) ?></td>
                                        <td align="center"><?= $daily_totals[$day]['orders'] ?></td>
                                    <?php endfor; ?>
                                </tr>
                            </tfoot>
                            <?php endif; ?>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>