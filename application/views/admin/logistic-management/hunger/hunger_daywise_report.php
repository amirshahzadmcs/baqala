<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
.table>:not(caption)>*>* {
    padding: 0.75rem 0.5rem !important;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Hunger Station Daywise Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/employed-rider/hunger/get-report'); ?>">Hunger Station</a></li>
						<li class="breadcrumb-item active">Daywise Report</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if(!empty($reports)){ ?>
					<!-- <div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-file-export"></i> Export Reports <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="<?php echo base_url();?>admin/employed-rider/hunger/print-report?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fa fa-print me-2"></i>Export PDF Report</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url();?>admin/employed-rider/hunger/export-excel?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fas fa-file-excel me-2"></i>Export Excel Report</a>
						</div>
					</div> -->
				<?php } ?>
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
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
						<form action="<?php echo base_url('admin/employed-rider/hunger/get-daywise-report'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12 mb-3">
									<label for="date_range">Date Range: <span class="text-danger">*</span></label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: 30px;">
									<button type="submit" class="btn btn-success btn-md ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/employed-rider/hunger/get-daywise-report'); ?>" class="btn btn-danger btn-md">Reset Filter</a>
								</div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php if(!empty($reports)){ ?>
						<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top">
									<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Maha Alfala Trading Est.</strong></h6>
									<h6 style="padding-bottom: 0px; margin-top: 0px;"><strong>Riyadh</strong></h6>
									<p style="padding-bottom: 0px; margin-bottom: 0px;">VAT No: <?php echo COMPANY_VAT_NO ?></p>
								</td>
								<td align="left" valign="top">
									<p style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Delivery Summary of Period:</strong> &nbsp;<?php echo !empty($search_start_date) ? date("d M Y", strtotime($search_start_date)) : 'NA';?> &nbsp;&nbsp;<strong>To:</strong> &nbsp;<?php echo !empty($search_end_date) ? date("d M Y", strtotime($search_end_date)) : 'NA';?></p>
									<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Report Of : </strong>Hunger Station</h6><br/>
								</td>
							</tr>
							
							<tr>
								<td colspan="3">
									<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr style="border-top: 2px solid;border-bottom: 2px solid;background: #ffe9a9;">
											<td valign="top" style="width: 7%;text-align:center;"><strong>Sr. No.</strong></td>
											<td valign="top" style="width: 12%;text-align:center;"><strong>Date</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Notified Delivery</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Completed Delivery</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Cancelled Deliveries</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Declined Deliveries</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Accepted Deliveries</strong></td>
											<td valign="top" style="width: 10%;text-align:right;"><strong>Not Accepted Deliveries</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Unattended Deliveries</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>ID Fine</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Online Hours</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Online Riders</strong></td>
										</tr>
										<?php
											$sumTotalNotifiedDelv = 0;
											$sumTotalCompleteDelv = 0;
											$sumTotalCancelledDelv = 0;
											$sumTotalDeclinedDelv = 0;
											$sumTotalAcceptDelv = 0;
											$sumTotalAcceptRate = 0;
											$sumTotalNotAcceptDelv = 0;
											$sumTotalIDF = 0;
											$sumTotalOH = 0;
											$sumTotalRiders = 0;
										?>
										<?php $i=1;foreach($reports as $report){
											$sumTotalNotifiedDelv += $report['total_notified_deliveries'];
											$sumTotalCompleteDelv += $report['total_completed_deliveries'];
											$sumTotalCancelledDelv += $report['total_cancelled_deliveries'];
											$sumTotalDeclinedDelv += $report['total_declined_deliveries'];
											$sumTotalNotAcceptDelv += $report['total_not_accepted_deliveries'];
											$sumTotalAcceptDelv += $report['total_accepted_deliveries'];
											$sumTotalIDF += $report['total_fine'];
											$sumTotalOH += $report['total_working_hours'];
											$sumTotalRiders += $report['total_riders'];
										?>
										<tr class="item-list">
											<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
											<td valign="top" style="text-align:center;"><?php echo date('d-m-Y', strtotime($report['date_local']));?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_notified_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_completed_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_cancelled_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_declined_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_accepted_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_not_accepted_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo ($report['total_cancelled_deliveries'] + $report['total_declined_deliveries'] + $report['total_not_accepted_deliveries']);?></td>
											<td valign="top" style="text-align:right;"><?php echo number_format($report['total_fine'], 2);?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_working_hours'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_riders'];?></td>
										</tr>
										<?php } ?>
										<tr>
											<td colspan="2" valign="top" style="text-align:right;"></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalNotifiedDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalCompleteDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalCancelledDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalDeclinedDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalAcceptDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalNotAcceptDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo ($sumTotalCancelledDelv + $sumTotalDeclinedDelv + $sumTotalNotAcceptDelv);?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalIDF, 2);?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalOH, 2);?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalRiders;?></p></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						<?php }else{ ?>
						<div class="card-body">
							<h4><center>No Data Found</center></h4>
						</div>
						<?php } ?>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
 </div>
 <!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>

</script>
