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
					<h4>Recharge Voucher Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/sim/vouchers'); ?>">Recharge Vouchers</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/sim/vouchers'); ?>"><i class="fa fa-reply"></i> Back</a>
				    <a class="btn btn-sm btn-custom-danger pull-right ms-2" title="Excel Export" href="<?php echo base_url('admin/sim/vouchers/excel-export?id='.$voucher_detail->id); ?>" target="_blank"><i class="fa fa-excel"></i> Export Excel</a>
				    <a class="btn btn-sm btn-custom-success pull-right ms-2" title="Excel PDF" href="<?php echo base_url('admin/sim/vouchers/print-detail?id='.$voucher_detail->id); ?>" target="_blank"><i class="fa fa-pdf"></i> Export PDF</a>

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
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12"><h5 class="text-dark">Voucher Details</h5><hr></div>
									<div class="col-md-6">
										<table>
											<tr>
												<td><strong>Date Of Purchase</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo date('d-m-Y', strtotime($voucher_detail->purchase_date));?></td>
											</tr>
											<tr>
												<td><strong>Service Provider</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $voucher_detail->network_name;?></td>
											</tr>
											<tr>
												<td><strong>Total Vouchers Purchased</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $voucher_detail->total_vouchers;?></td>
											</tr>
											<tr>
												<td><strong>Expiry Date</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo date('d-m-Y', strtotime($voucher_detail->expiry_date));?></td>
											</tr>
										</table>
									</div>
									<div class="col-md-6">
										<table>
											<tr>
												<td><strong>Voucher Price</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $voucher_detail->voucher_value;?></td>
											</tr>
											<tr>
												<td><strong>VAT</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $voucher_detail->voucher_vat;?></td>
											</tr>
											<tr>
												<td><strong>Voucher Price (inc Vat)</strong></td>
												<td width="20" align="center">:</td>
												<td><?php echo $voucher_detail->voucher_total;?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php if($voucher_list->num_rows() > 0){ ?>
						<div class="card">
							<div class="card-header">Vouchers Serial Numbers</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
											<thead>
												<tr>
													<td valign="top" bgcolor="#CCCCCC" style="width: 7%;"><strong>S. No.</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 19%;"><strong>Voucher Serial Number</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 12%;"><strong>Usage Date</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 12%;"><strong>Mobile Number</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 12%;"><strong>Vehicle Number</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>Employee ID</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 19%;"><strong>User Name</strong></td>
													<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>Status</strong></td>
												</tr>
											</thead>
											<tbody>
												<?php 
												$s_no = 1;foreach($voucher_list->result_array() as $v_array){
												?>
												<tr>
													<td valign="middle"><?php echo $s_no;?></td>
													<td valign="middle"><?php echo $v_array['serial_no'];?></td>
													<td valign="middle"><?php echo (isset($v_array['used_date'])) ? date('d-m-Y', strtotime($v_array['used_date'])) : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['mobile_no'])) ? $v_array['mobile_no'] : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['vehicle_no'])) ? $v_array['vehicle_no'] : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['emp_no'])) ? $v_array['emp_no'] : 'NA';?></td>
													<td valign="middle"><?php echo (isset($v_array['emp_full_name'])) ? $v_array['emp_full_name'] : 'NA';?></td>
													<td valign="middle">
														<?php 
															if($v_array['status'] == '0'){
																$status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
															}
															if($v_array['status'] == '1'){
																$status = '<span class="badge badge-pill badge-soft-success font-size-13">Used</span>';
															}
															if($v_array['status'] == '2'){
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
								No Vouchers added in this group
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
