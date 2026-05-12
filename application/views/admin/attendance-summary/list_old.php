<?php //echo '<pre>';print_r($attend_results);exit();
$this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.roundCircle {
		/* background-color: rgba(35,197,143,.25)!important; */
		border-radius: 50%;
		width: 50px;
		height: 50px;
		padding: 12px 14px;
	}
	.input-group-text {
        padding: 0 0.75rem;
    }
	.table .thead-caption {
		font-weight: 300;
		color: #000000;
		background: #fdce43ad;
	}
	.table .thead-caption td{
		padding: 0.2rem 0.5rem;
		vertical-align: middle;
		font-weight: 400;
		color: #764444;
	}
	.result-tr td{
		line-height: 15px;
		color: #000000;
	}
	.result-tr .present{
		background-color: #70dc70;
	}
	.result-tr .absent{
		background-color: #f03838;
	}
	.tpre{
		color: green !important;
    	font-weight: 700;
	}
	.tabs{
		color: red !important;
    	font-weight: 700;
	}
	.table.border-gray {
		border-color: #989898!important;
	}
	.custom-scroll::-webkit-scrollbar {
		height: 5px;
	}
	.custom-scroll::-webkit-scrollbar-thumb {
		background: #cacaca;
		border-radius: 25px;
	}
	.td-fridged{
		position: absolute;
		width: 50px;
		border: none;
		background: #fff;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Delivery Attendance Summary</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/list'); ?>">Attendance</a></li>
						<li class="breadcrumb-item active">Summary</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/list') ?>"><i class="fa fa-reply me-2"></i>Back</a>
					<?php if(check_action_permission(get_user_role(),'attendance_summary','add')):?>
						<a class="btn btn-sm btn-custom-success pull-right" title="Add" href="<?php echo base_url('admin/attendance/add') ?>"><i class="fa fa-plus me-2"></i>Add Attendance</a>.
						<?php endif;?>

					<?php if($this->admin->getInfo()){
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if($info_type == 2){
					?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
					<?php } else{?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data;?></strong>
						</div>
					<?php } ?> <?php } $this->admin->removeInfo();?>
				</div>
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
					<div class="card-body">
						<form action="<?php echo base_url('admin/attendance/old-list') ?>" method="get">
							<div class="row">
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="dboy">Riders/Drivers:</label>
									<select name="rider_filter" id="dboy" class="form-control select2 w-100" data-placeholder="Choose Delivery Boy...">
										<option value="">ALL</option>
										<?php foreach(inhouseDeliveryBoy() as $list) { ?>
											<option value="<?php echo $list->id;?>" <?php echo ($list->id == $this->input->get('rider_filter')) ? 'selected' : ''; ?>><?php echo $list->name; ?></option>
										<?php } ?>
									</select>
								</div>
								
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="month_of">Select Month: <span class="text-danger">*</span></label>
									<div class="position-relative" id="datepicker4">
										<input type="text" class="form-control" data-date-container='#datepicker4' data-provide="datepicker"
										data-date-format="MM yyyy" data-date-min-view-mode="1" name="month_of" id="month_of" autocomplete="off" value="<?php echo $this->input->get('month_of');?>" required>
									</div>
								</div>
								
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<input type="submit" value="Show Summary" class="form-control btn btn-custom-success mt-2" />
								</div>
								<div class="form-group col-lg-2 col-md-4 col-12 mb-3">
									<label for="button"></label>
									<a href="<?php echo base_url('admin/attendance/list'); ?>"class="form-control btn btn-custom-danger mt-2">Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-2">
						<?php if(!empty($attend_results) && count($attend_results) > 0){ ?>
						<div class="col-md-12 mb-5">
							<!--<a href="<?php echo base_url('admin/attendance/print-summary'). '?rider_filter='. $this->input->get('rider_filter') .'&start_filter='. $this->input->get('start_filter')  .'&end_filter='. $this->input->get('end_filter') ?>" target="_blank" class="btn btn-custom-white float-end">Print</a>-->
						</div>
						<div class="col-12 table-responsive custom-scroll">
							<table align="left" class="table table-bordered border-gray">
								<?php
									$pass_date = strtotime($attendance_month);
									$total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
									//echo '<pre>';print_r($total_days);exit();
								?>
								<thead>
									<tr class="text-white h6" style="background-color: #026902cc!important">
										<td colspan="<?php echo (3 + ($total_days) + 2);?>" align="center" style="padding: 18px;">
											<table style="position: absolute;width: 100%;text-align: center;">
												<tr><td style="line-height: 0px;">Attendance of <?php echo $attendance_month;?></td></tr>
											</table>
										</td>
									</tr>
								</thead>
								<tbody>
									<tr class="thead-caption">
										<td rowspan="2" align="center" style="line-height:20px;"><b>Sr.No</b></td>
										<td rowspan="2" align="center" style="line-height:20px;"><b>EMP_ID</b></td>
										<td rowspan="2" align="center" style="line-height:20px;padding-right:170px;"><b>Employee_Name</b></td>
									</tr>
									<tr class="thead-caption">
									<?php for ($i=0; $i < $total_days; $i++) { ?>
										<?php
											$attend_date = date('d-M', strtotime($attendance_month .' + '. $i .' days'));
											$attend_day = date('D', strtotime($attend_date));
										?>
										<td align="center" style="line-height:20px;"><b><?= $attend_day; ?></b><br/><b><?= date('d', strtotime($attend_date)); ?></b><br/><b><?= date('M', strtotime($attend_date)); ?></b></td>
									<?php } ?>
										<td align="center"><b>Total Present</b></td>
										<td align="center"><b>Total Absent</b></td>
									</tr>
									<?php if(!empty($attend_results) && count($attend_results) > 0){ ?>
										<?php 
											$result_count = 1;
											$sumPresent = 0;
											$sumAbsent = 0;
											foreach($attend_results as $summary) { 
											
											$total_present[$result_count] = 0;
											$total_absent[$result_count] = 0;
											?>
											<tr class="result-tr">
												<td align="center"><?= $result_count;?></td>
												<td align="left"><?= $summary['emp_id'];?></td>
												<td align="left"><?= $summary['rider_name'];?></td>
												<?php if(count($summary['order_info']) > 0){ foreach($summary['order_info'] as $att_info){ ?>
												<?php
													$ddiff = dateDiffHelper($att_info['date']);
													if($ddiff > 0){
												?>
												<td align="center">-</td>
												<?php }else{ 
												?>
												<td align="center" class="<?= ($att_info['total_orders']) ? 'present' : 'absent';?>"><?= ($att_info['total_orders']) ? 'P' : 'A';?></td>
												<?php ($att_info['total_orders']) ? $total_present[$result_count]++ : $total_absent[$result_count]++;?>
												<?php }}} ?>
												<td align="center" class="tpre"><?php $sumPresent += $total_present[$result_count]; echo $total_present[$result_count];?></td>
												<td align="center" class="tabs"><?php $sumAbsent += $total_absent[$result_count]; echo $total_absent[$result_count];?></td>
											</tr>
										<?php $result_count++;} ?>
										<tr>
											<td colspan="3" align="right"><b>Daily Employee Strength</b></td>
											
											<?php foreach($attend_results[0]['sum_total'] as $summ) { ?>
											<td><b><?= $summ->aval_rider; ?></b></td>
											<?php } ?>
											<td align="center"><b><?= $sumPresent; ?></b></td>
											<td align="center"><b><?= $sumAbsent; ?></b></td>
										</tr>
										<?php }else{ ?>
											<tr class="text-dark h6" style="background-color: #efefefcc!important">
												<td colspan="<?php echo (3 + ($total_days));?>" align="center">No data found</td>
											</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } else{ ?>
							<div class="col-12 text-center">No data found, try other date!</div>
						<?php } ?>
					</div>
				</div>
			</div> <!-- end col -->
			

		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>
