<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Jahez Report</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/employed-rider/jahez/get-report'); ?>">Jahez</a></li>
						<li class="breadcrumb-item active">Report</li>
					</ol>
				</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			    <div class="col-sm-6">
				<?php if(!empty($reports)){ ?>
				<a type="button" href="<?php echo base_url();?>admin/employed-rider/jahez/print-report?keyword=<?php echo $this->input->get('keyword') ?>&rider_id=<?php echo $this->input->get('rider_id') ?>&start_date=<?php echo $this->input->get('start_date') ?>&end_date=<?php echo $this->input->get('end_date') ?>" class="btn btn-custom-white btn-sm float-end me-2" target="_blank"><i class="fa fa-print me-2"></i>Print Report</a>
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
						<form action="<?php echo base_url('admin/employed-rider/jahez/get-report'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name" value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>
								
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Driver Id</label>
										<input type="search" id="rider_id" name="rider_id" placeholder="Search Driver ID" value="<?php echo $this->input->get('rider_id') ? $this->input->get('rider_id') : ''; ?>" autocomplete="off" class="form-control">
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
									<a href="<?php echo base_url('admin/employed-rider/jahez/get-report'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
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
									<h6 style="padding-bottom: 0px; margin-bottom: 0px;"><strong>Report Of : </strong>Jahez</h6><br/>
								</td>
							</tr>
							
							<tr>
								<td colspan="3">
									<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr style="border-top: 2px solid;border-bottom: 2px solid;background: #ffe9a9;">
											<td valign="top" style="width: 7%;text-align:center;"><strong>Sr. No.</strong></td>
											<td valign="top" style="width: 10%;"><strong>Emp No.</strong></td>
											<td valign="top" style="width: 20%;"><strong>Emp Name</strong></td>
											<td valign="top" style="width: 10%;"><strong>Driver ID</strong></td>
											<td valign="top" style="width: 12%;text-align:right;"><strong>Total Delivery</strong></td>
											<td valign="top" style="width: 10%;text-align:right;"><strong>Traffic Fine</strong></td>
											<td valign="top" style="width: 10%;text-align:right;"><strong>ID Fine</strong></td>
											<td valign="top" style="width: 12%;text-align:right;"><strong>Online Hours</strong></td>
										</tr>
										<?php
											$sumTotalDelv = 0;
											$sumTotalTF = 0;
											$sumTotalIDF = 0;
											$sumTotalOH = 0;
										?>
										<?php $i=1;foreach($reports as $report){
											$sumTotalDelv += $report['total_deliveries'];
											$sumTotalTF += 0;
											$sumTotalIDF += $report['total_fine'];
											$sumTotalOH += 0;
										?>
										<tr class="item-list">
											<td valign="top" style="text-align:left;"><?php echo $i++;?></td>
											<td valign="top"><?php echo $report['emp_no'];?></td>
											<td valign="top"><?php echo $report['full_name'];?></td>
											<td valign="top"><?php echo $report['driver_id'];?></td>
											<td valign="top" style="text-align:right;"><?php echo $report['total_deliveries'];?></td>
											<td valign="top" style="text-align:right;">0</td>
											<td valign="top" style="text-align:right;"><?php echo number_format($report['total_fine'], 2);?></td>
											<td valign="top" style="text-align:right;">0</td>
										</tr>
										<?php } ?>
										<tr>
											<td colspan="4" valign="top" align="right">Total</td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo $sumTotalDelv;?></p></td>
											<td valign="top" style="text-align:right;"><p style="border-top: 2px solid;border-bottom: 2px solid;"><?php echo number_format($sumTotalTF, 2);?></p></td>
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


<?php $this->load->view('admin/home/footer');?>

</script>
