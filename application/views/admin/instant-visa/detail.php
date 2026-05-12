<?php $this->load->view('admin/home/header');?>
<style>
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Instant Work Visa</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/talent-aquisition/visa'); ?>">Instant Work Visa</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/talent-aquisition/visa'); ?>"><i class="fa fa-reply"></i> Back</a>
					<!--
				    <a class="btn btn-sm btn-custom-danger pull-right ms-2" title="Excel Export" href="<?php echo base_url('admin/sim/vouchers/excel-export?id='.$visa_detail->id); ?>" target="_blank"><i class="fa fa-excel"></i> Export Excel</a>
				    <a class="btn btn-sm btn-custom-success pull-right ms-2" title="Excel PDF" href="<?php echo base_url('admin/sim/vouchers/print-detail?id='.$visa_detail->id); ?>" target="_blank"><i class="fa fa-pdf"></i> Export PDF</a>
					-->
				</div>
				<?php if ($this->admin->getInfo()) {
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
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
						<div class="card p-3">
							<div class="row">
								<div class="col-md-12"><h5 class="text-dark">Visa Details</h5><hr></div>
								<div class="col-md-4">
									<table>
										<tr>
											<td><strong>Date Of Issue</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo date('d-m-Y', strtotime($visa_detail->visa_issue_date));?></td>
										</tr>
										<tr>
											<td><strong>Unified No</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->unified_no;?></td>
										</tr>
										<tr>
											<td><strong>Establishment Name (AR)</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->establishment_name;?></td>
										</tr>
										<tr>
											<td><strong>Sponsor Name (EN)</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->sponsor_name;?></td>
										</tr>
										<tr>
											<td><strong>Agency</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->agency_name;?></td>
										</tr>
									</table>
								</div>
								<div class="col-md-4">
									<table>
										<tr>
											<td><strong>Establishment Number</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->establishment_no;?></td>
										</tr>
										<tr>
											<td><strong>Visa Issue No.</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->visa_issue_no;?></td>
										</tr>
										<tr>
											<td><strong>No. Of Visa</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->used_border_entries;?>/<?php echo $visa_detail->no_of_visa;?></td>
										</tr>
										<tr>
											<td><strong>Request No</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->request_no;?></td>
										</tr>
										<tr>
											<td><strong>Nationality</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->nationality_name;?></td>
										</tr>
										<tr>
											<td><strong>Status</strong></td>
											<td width="20" align="center">:</td>
											<td>
												<?php
													if($visa_detail->vstatus == '0'){
														$visa_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
													}elseif($visa_detail->vstatus == '1'){
														$visa_status = '<span class="badge badge-pill badge-soft-success font-size-13">Wakala Issued</span>';
													}elseif($visa_detail->vstatus == '2'){
														$visa_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
													}else{
														$visa_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
													}
												?>
												<?php echo $visa_status;?>
											</td>
										</tr>
									</table>
								</div>
								<div class="col-md-4">
									<table>
										<tr>
											<td><strong>Occupation</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->profession_name;?></td>
										</tr>
										<tr>
											<td><strong>Embassy</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->embassy;?></td>
										</tr>
										<tr>
											<td><strong>Gender</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo ucfirst($visa_detail->gender);?></td>
										</tr>
										<tr>
											<td><strong>Religion</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->religion;?></td>
										</tr>
										<tr>
											<td><strong>CR Number</strong></td>
											<td width="20" align="center">:</td>
											<td><?php echo $visa_detail->cr_no;?></td>
										</tr>
										<tr>
											<td><strong>Attachment</strong></td>
											<td width="20" align="center">:</td>
											<td><?php if($visa_detail->attachment){ ?><a href="<?php echo $visa_detail->attachment;?>" target="_blank">View File</a><?php }else{ echo 'NA';} ?></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<?php if($visa_list->num_rows() > 0){ ?>
						<div class="card">
							<div class="card-header">Visa Numbers</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 6%;"><strong>S. No.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Border Number</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Nationality</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Occupation</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Embassy Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Gender</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Religion</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Passport No</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 19%;"><strong>Candidate Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Visa Status</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php 
												$s_no = 1;foreach($visa_list->result_array() as $v_array){
												?>
												<tr>
													<td valign="middle"><?php echo $s_no;?></td>
													<td valign="middle"><?php echo $v_array['border_nos'];?></td>
													<td valign="middle"><?php echo (isset($visa_detail->nationality_name)) ? $visa_detail->nationality_name : 'NA';?></td>
													<td valign="middle"><?php echo (isset($visa_detail->profession_name)) ? $visa_detail->profession_name : 'NA';?></td>
													<td valign="middle"><?php echo (isset($visa_detail->embassy)) ? $visa_detail->embassy : 'NA';?></td>
													<td valign="middle"><?php echo (isset($visa_detail->gender)) ? ucfirst($visa_detail->gender) : 'NA';?></td>
													<td valign="middle"><?php echo (isset($visa_detail->religion)) ? $visa_detail->religion : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['passport_no'])) ? $v_array['passport_no'] : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['full_name'])) ? $v_array['full_name'] : 'NA';?></td>
													<td valign="middle">
														<?php 
															if($v_array['visa_status'] == '0'){
																$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Pending</span>';
															}
															if($v_array['visa_status'] == '1'){
																$status = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
															}
															if($v_array['visa_status'] == '2'){
																$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>';
															}
														?>
														<?php echo $status;?>
													</td>
												</tr>
												<?php $s_no++;} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php }else{ ?>
						<div class="card">
							<div class="card-body">
								<h5 class="text-center">No border numbers added in this group</h5>
							</div>
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
