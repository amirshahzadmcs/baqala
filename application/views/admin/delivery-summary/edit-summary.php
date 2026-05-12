<?php $this->load->view('admin/home/header'); ?>
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
	.result-tr .cash-td{
		background-color: #cfffd5;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Edit Daily Delivery Summary</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/daily-delivery-summary/list'); ?>">Daily Delivery Summary</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/daily-delivery-summary/list') ?>"><i class="fa fa-reply me-2"></i>Back</a>
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
			<div class="card">
				<div class="card-body px-0 pb-2">
					<div class="col-12 table-responsive">
						<table align="left" class="table table-bordered border-dark mb-2">
							<tr><td colspan="2" align="center"><b>Summary Overview</b></td></tr>
							<tr>
								<td><b>Driver's ID</b> : <?= $result['summary_info']['driver_id'];?></td>
								<td><b>Driver Name</b> : <?= $result['summary_info']['driver_name'];?></td>
							</tr>
							<tr>
								<td><b>Company Name</b> : <?= $result['summary_info']['company_name'];?></td>
								<td><b>Date</b> : <?= formatedDate($result['summary_info']['delivery_date']);?></td>
							</tr>
						</table>
						<table align="left" class="table table-bordered border-dark mb-0">
							<tr class="text-white h6" style="background-color: #026902cc!important"><td align="center">Order Summary</td></tr>
						</table>
						<form action="<?php echo base_url('admin/daily-delivery-summary/update-summary') ?>" method="POST">
							<input type="hidden" name="id" value="<?= $result['summary_info']['id'];?>" required>
							<table align="left" class="table table-bordered border-dark mb-0">
								<tr>
									<td>
										<div class="row">
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="orders">Total Delivery <span class="text-danger">*</span></label>
												<input type="number" min="1" max="100" class="form-control" name="orders" placeholder="Total Today's Delivery" autocomplete="off" value="<?= $result['summary_info']['orders'];?>" disabled>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="total_earning">Total Earning <span class="text-danger">*</span></label>
												<input id="total_earning" name="total_earning" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['total_earning'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="traffic_fine">Traffic Fine <span class="text-danger">*</span></label>
												<input id="traffic_fine" name="traffic_fine" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['traffic_fine'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="id_fine">ID Fine <span class="text-danger">*</span></label>
												<input id="id_fine" name="id_fine" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['id_fine'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="cash_received">Cash <span class="text-danger">*</span></label>
												<input id="cash_received" name="cash_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['cash_received'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="wallet_received">Wallet <span class="text-danger">*</span></label>
												<input id="wallet_received" name="wallet_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['wallet_received'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="stcpay">STCPay P <span class="text-danger">*</span></label>
												<input id="stcpay" name="stcpay" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['stcpay'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="stcpaym">STCPay M <span class="text-danger">*</span></label>
												<input id="stcpaym" name="stcpaym" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['stcpaym'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="pos_received">POS <span class="text-danger">*</span></label>
												<input id="pos_received" name="pos_received" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['pos_received'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="fuel_topup">Fuel <span class="text-danger">*</span></label>
												<input id="fuel_topup" name="fuel_topup" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['fuel_topup'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="hunger_topup">Hunger Topup <span class="text-danger">*</span></label>
												<input id="hunger_topup" name="hunger_topup" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" value="<?= $result['summary_info']['hunger_topup'];?>" required>
											</div>
											<div class="form-group col-lg-3 col-md-4 col-12 mb-3">
												<label for="online_hrs">Online Hours <span class="text-danger">* (Hrs and Min)</span></label>
												<div class="input-group">
													<input type="number" name="online_hrs" min="0" max="23" aria-label="Hours" placeholder="Hours" value="<?php echo date('H', strtotime($result['summary_info']['online_hrs']));?>" class="form-control" required>
													<input type="number" name="online_min" min="0" max="59" aria-label="Minutes" placeholder="Minutes" value="<?php echo date('i', strtotime($result['summary_info']['online_hrs']));?>" class="form-control" required>
												</div>
											</div>
											<div class="form-group col-lg-12 col-md-12 col-12 mb-3">
												<label for="button"></label>
												<input type="submit" id="submit" value="Update Summary" class="btn btn-custom-success float-end" />
											</div>
										</div>
									</td>
								</tr>
							</table>
						</form>

						<table align="left" class="table table-bordered border-dark mb-0 mt-2">
							<?php
								$count_orders = $result['summary_info']['orders'];
							?>
							<tr class="text-white h6" style="background-color: #026902cc!important"><td align="center">Order List (Total : <?= $count_orders; ?>)</td></tr>
						</table>
						<table align="left" class="table table-bordered border-dark">
							<tbody>
								<tr class="thead-caption">
									<td align="center" style="line-height:20px;"><b>Sr. No</b></td>
									<td align="center" style="line-height:20px;"><b>Ref. ID</b></td>
									<td align="center" style="line-height:20px;"><b>Collection Amt.</b></td>
									<td align="center" style="line-height:20px;"><b>Delivery Price</b></td>
									<td align="center" style="line-height:20px;"><b>Free Order Count</b></td>
									<td align="center" style="line-height:20px;"><b>Driver Credit</b></td>
									<td align="center" style="line-height:20px;"><b>Driver Debit</b></td>
									<td align="center" style="line-height:20px;"><b>Service Deduction</b></td>
									<td align="center" style="line-height:20px;"><b>Driver Tips</b></td>
									<td align="center" style="line-height:20px;"><b>Settled By</b></td>
									<td align="center" style="line-height:20px;"><b>Tool</b></td>
								</tr>
								
								<?php 
									$t_collection_amt = 0;
									$t_delivery_price = 0;
									$t_free_order_count = 0;
									$t_driver_credit = 0;
									$t_driver_debit = 0;
									$t_service_deduction = 0;
									$t_driver_tips = 0;
									$count_i = 1; 
									foreach($result['summary_list'] as $list){
									
									$t_collection_amt += $list['collection_amt'];
									$t_delivery_price += $list['delivery_price'];
									$t_free_order_count += $list['free_order_count'];
									$t_driver_credit += $list['driver_credit'];
									$t_driver_debit += $list['driver_debit'];
									$t_service_deduction += $list['service_deduction'];
									$t_driver_tips += $list['driver_tips'];
								?>
								
								<tr class="result-tr">
									<form id="detail_form<?= $count_i; ?>" action="<?php echo base_url('admin/daily-delivery-summary/update-detail-summary') ?>" method="POST"></form>
									<td align="center"><input type="hidden" name="fdc_id" value="<?= $result['summary_info']['id'];?>" form="detail_form<?= $count_i; ?>" required><input type="hidden" class="form-control" name="id" value="<?= $list['id'];?>" form="detail_form<?= $count_i; ?>" required><?= $count_i; ?></td>
									<td align="center"><input type="text" class="form-control" value="<?= $list['ref_id'];?>" name="ref_id" form="detail_form<?= $count_i; ?>" required style="width: 120px;"></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="collection_amt" value="<?= $list['collection_amt'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="delivery_price" value="<?= $list['delivery_price'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center"><input type="number" min="0" max="99" class="form-control" name="free_order_count" value="<?= $list['free_order_count'];?>" required form="detail_form<?= $count_i; ?>" style="width: 80px;"></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_credit" value="<?= $list['driver_credit'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_debit" value="<?= $list['driver_debit'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="service_deduction" value="<?= $list['service_deduction'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center"><input class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" name="driver_tips" value="<?= $list['driver_tips'];?>" form="detail_form<?= $count_i; ?>" required></td>
									<td align="center" style="width: 100px;">
										<select name="settled_by" class="form-select" data-placeholder="Choose Method..." required form="detail_form<?= $count_i; ?>" style="width: 110px;">
											<option value="">Select</option>
											<option value="cash" <?php echo ($list['settled_by'] == 'cash') ? " selected":"" ?>>Cash</option>
											<option value="wallet" <?php echo ($list['settled_by'] == 'wallet') ? " selected":"" ?>>Wallet</option>
											<option value="stcpay_p" <?php echo ($list['settled_by'] == 'stcpay_p') ? " selected":"" ?>>STCPayP</option>
											<option value="stcpay_m" <?php echo ($list['settled_by'] == 'stcpay_m') ? " selected":"" ?>>STCPayM</option>
											<option value="pos" <?php echo ($list['settled_by'] == 'pos') ? " selected":"" ?>>POS</option>
										</select>
									</td>
									<td><button type="submit" form="detail_form<?= $count_i; ?>" class="btn btn-custom-success btn-sm waves-effect float-end" title="Update"><i class="fa fa-check"></i></button></td>
								</tr>
								<?php $count_i++;} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>
