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
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
				    <a class="btn btn-sm btn-custom-white pull-right ms-2" title="Back" href="<?php echo base_url('admin/sim/vouchers'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right ms-2" title="Save"><i class="fa fa-save"></i> Save</button>

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
												<td><?php echo date('d-m-Y', strtotime($voucher_detail->purchase_date));?></td>
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
							<div class="card-header">Update Vouchers Serial Numbers</div>
							<div class="card-body">
								<?php echo form_open("admin/sim/vouchers/update-vouchers", array("id" => "demo-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
									<input type="hidden" name="group_id" value="<?php echo $voucher_detail->id;?>" required />
									<?php 
										function get_results($val, $qt){
											$division = intdiv($val, $qt); // PHP <7: $division = ($val - ($val % $qt)) / $qt;
											$ret = array_fill(0, $qt, $division); // fill array with $qt equal values
											if($division != $val / $qt){ // if not whole division, add remaning to lsat element
												$ret[count($ret)-1] = $ret[0] + ($val % $qt);
											}
											return $ret;
										}
										$total = $voucher_list->num_rows();
										$voucher_array = get_results($total, 2);
										$vouchers_in_group = $voucher_list->result_array();
									?>
									<div class="row">
										<?php $s_no = 0;foreach($voucher_array as $v_array){ ?>
										<div class="col-md-6">
											<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
												<thead>
													<tr>
														<td valign="top" bgcolor="#CCCCCC" style="width: 18%;"><strong>S. No.</strong></td>
														<td valign="top" bgcolor="#CCCCCC" style="width: 82%;"><strong>Voucher Serial Number</strong></td>
													</tr>
												</thead>
												<tbody>
													<?php 
													for($i=1;$i <= $v_array; $i++){ 
													?>
													<tr>
														<td valign="top"><?php echo $s_no+1;?><input type="hidden" name="id[]" value="<?php echo $vouchers_in_group[$s_no]['id'];?>" required /></td>
														<td valign="top"><input type="text" name="serial_no[]" value="<?php echo $vouchers_in_group[$s_no]['serial_no'];?>" class="form-control" required="required" /></td>
													</tr>
													<?php $s_no = $s_no+1;} ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
									</div>
								<?php echo form_close(); ?>
							</div>
						</div>
						<?php }else{ ?>
						<div class="card">
							<div class="card-header">Add Vouchers Serial Numbers</div>
							<div class="card-body">
								<?php echo form_open("admin/sim/vouchers/save-vouchers", array("id" => "demo-form2", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
									<input type="hidden" name="group_id" value="<?php echo $voucher_detail->id;?>" required />
									<?php 
										function get_results($val, $qt){
											$division = intdiv($val, $qt); // PHP <7: $division = ($val - ($val % $qt)) / $qt;
											$ret = array_fill(0, $qt, $division); // fill array with $qt equal values
											if($division != $val / $qt){ // if not whole division, add remaning to lsat element
												$ret[count($ret)-1] = $ret[0] + ($val % $qt);
											}
											return $ret;
										}
										$total = $voucher_detail->total_vouchers;
										$voucher_array = get_results($total, 2);
									?>
									<div class="row">
										<?php $s_no = 1;foreach($voucher_array as $v_array){ ?>
										<div class="col-md-6">
											<table class="table table-striped jambo_table table-bordered mb-0" id="item_table" width="100%" border="1" cellspacing="0" cellpadding="5">
												<thead>
													<tr>
														<td valign="top" bgcolor="#CCCCCC" style="width: 18%;"><strong>S. No.</strong></td>
														<td valign="top" bgcolor="#CCCCCC" style="width: 82%;"><strong>Voucher Serial Number</strong></td>
													</tr>
												</thead>
												<tbody>
													<?php
													for($i=1;$i <= $v_array; $i++){ 
													?>
													<tr>
														<td valign="top"><?php echo $s_no;?></td>
														<td valign="top"><input type="text" name="serial_no[]" value="" class="form-control" required="required" /></td>
													</tr>
													<?php $s_no = $s_no+1;} ?>
												</tbody>
											</table>
										</div>
										<?php } ?>
									</div>
								<?php echo form_close(); ?>
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

<script type="text/javascript">
	function checkDuplicateMob() {
		var mobile = $("#mobile").val();
		var id = $("#id").val();
		if (mobile !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/sim/check-duplicate-mob",
				type: "GET",
				data: {
					mobile: mobile,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$("#mobile").removeClass('parsley-error');
						$(".res-msg").html(data.msg);
					}else{
						$("#mobile").val('');
						$("#mobile").addClass('parsley-error');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#mobile").val('');
					$("#mobile").addClass('parsley-error');
					$(".res-msg").html('<span class="text-danger">Some error occured, refresh page.</span>');
					return false;
				},
			});
		} else {
			$("#mobile").addClass('parsley-error');
			$(".res-msg").html('<span class="text-danger">Enter mobile number.</span>');
		}
	}

</script>
