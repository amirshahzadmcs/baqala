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
					<h4>Hunger Station Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/employed-rider/hunger/get-report'); ?>">Hunger Station</a></li>
						<li class="breadcrumb-item active">Report</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<?php if(!empty($reports)){ ?>
					<div class="btn-group ms-2 float-end">
						<button class="btn btn-custom-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-file-export"></i> Export Reports <i class="mdi mdi-chevron-down"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="<?php echo base_url();?>admin/employed-rider/hunger/print-report?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fa fa-print me-2"></i>Export PDF Report</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo base_url();?>admin/employed-rider/hunger/export-excel?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fas fa-file-excel me-2"></i>Export Excel Report</a>
						</div>
					</div>
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
						<form action="<?php echo base_url('admin/employed-rider/hunger/get-report'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Rider Id</label>
										<input type="search" id="rider_id" name="rider_id" placeholder="Search Rider ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="date_range">Date Range: <span class="text-danger">*</span></label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
										<input type="text" class="form-control" name="start_date" placeholder="Start Date" value="<?php echo $this->input->get('start_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
										<input type="text" class="form-control" name="end_date" placeholder="End Date" value="<?php echo $this->input->get('end_date'); ?>" autocomplete="off">
										<span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/employed-rider/hunger/get-report'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
											<td valign="top" style="width: 9%;"><strong>Emp No.</strong></td>
											<td valign="top" style="width: 20%;"><strong>Emp Name</strong></td>
											<td valign="top" style="width: 8%;"><strong>Rider ID</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Notified Delivery</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Completed Delivery</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Unattended Deliveries</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>ID Fine</strong></td>
											<td valign="top" style="width: 8%;text-align:right;"><strong>Online Hours</strong></td>
										</tr>
										<?php
											$sumTotalNotifiedDelv = 0;
											$sumTotalCompleteDelv = 0;
											$sumTotalCancelledDelv = 0;
											$sumTotalDeclinedDelv = 0;
											$sumTotalNotAcceptDelv = 0;
											$sumTotalIDF = 0;
											$sumTotalOH = 0;
										?>
										<?php $i=1;foreach($reports as $report){
											$sumTotalNotifiedDelv += $report['total_notified_deliveries'];
											$sumTotalCompleteDelv += $report['total_completed_deliveries'];
											$sumTotalCancelledDelv += $report['total_cancelled_deliveries'];
											$sumTotalDeclinedDelv += $report['total_declined_deliveries'];
											$sumTotalNotAcceptDelv += $report['total_not_accepted_deliveries'];
											$sumTotalIDF += $report['total_fine'];
											$sumTotalOH += $report['total_working_hours'];
										?>
										<tr class="item-list">
											<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
											<td valign="top"><?php echo $report['emp_no'];?></td>
											<td valign="top"><?php echo $report['full_name'];?></td>
											<td valign="top"><button class="btn btn-link view-summary" data-riderid="<?php echo $report['rider_id'];?>"><?php echo $report['rider_id'];?></button></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_notified_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_completed_deliveries'];?></td>
											<td valign="top" style="text-align:right;"><?php echo ($report['total_cancelled_deliveries'] + $report['total_declined_deliveries'] + $report['total_not_accepted_deliveries']);?></td>
											<td valign="top" style="text-align:right;"><?php echo number_format($report['total_fine'], 2);?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_working_hours'];?></td>
										</tr>
										<?php } ?>
										<tr>
											<td colspan="4" valign="top" align="right">Total</td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalNotifiedDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalCompleteDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo ($sumTotalCancelledDelv + $sumTotalDeclinedDelv + $sumTotalNotAcceptDelv);?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalIDF, 2);?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalOH, 2);?></p></td>
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

<div class="modal fade log-detail-modal" role="dialog" aria-labelledby="ModalFullscreenLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title mt-0" id="summaryModalFullscreenLabel">User Summary Report</h6>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="summary_body_modal">
                
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $this->load->view('admin/home/footer');?>

<script>
	$("body table").on("click",".view-summary",function(){
		var rider_id = $(this).attr("data-riderid");
		var from_date = '<?php echo $this->input->get('start_date'); ?>';
		var to_date = '<?php echo $this->input->get('end_date'); ?>';
		if(rider_id !== '' || rider_id == undefined){
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/employed-rider/hunger/get-userwise-report');?>",
				data: {'rider_id': rider_id,'start_date':from_date,'end_date':to_date},
				//dataType: "json",
				success: function (response) {
					console.log(response);
					$('.log-detail-modal').modal('show');
					$('#summary_body_modal').html(response);
				},
				error: function (request, error) {
					console.log(" Can't do because: " + JSON.stringify(request));
					$('#summary_body_modal').after(JSON.stringify(request));
				},
			});
		}else{
			alert('Invalid request id!');
		}
	});
</script>
