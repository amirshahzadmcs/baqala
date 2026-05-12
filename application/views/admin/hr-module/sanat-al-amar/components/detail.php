<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Sanat Al Amar Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div id="responseContainer"></div>
	<div class="mt-2">
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Rider Detail</div>
			<div class="d-flex align-items-center employee-detail">
				<div class="image">
					<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
						<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="140">
					<?php }else{ ?>
						<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
					<?php } ?>
				</div>
				<div class="p-3 w-100">
					<h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
					<span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
					<hr class="my-1">
					<table>
						<tr>
							<td>Emp No.</td>
							<td> : </td>
							<td><?php echo $emp_detail['emp_no'];?></td>
						</tr>
						<tr>
							<td>Nationality</td>
							<td> : </td>
							<td><?php echo $emp_detail['nationality_name'];?></td>
						</tr>
						<tr>
							<td>Flex Number</td>
							<td> : </td>
							<td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
						</tr>
						<tr>
							<td>Mobile No</td>
							<td> : </td>
							<td><?php echo $emp_detail['mobile'];?></td>
						</tr>
						<tr>
							<td>DL Number</td>
							<td> : </td>
							<td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>Vehicle No</td>
							<td> : </td>
							<td><?php if(!empty($vehicle_detail['vehicle_no'])){ echo $vehicle_detail['vehicle_no'];?> / <?php echo $vehicle_detail['vehicle_model'];?> / <?php echo $vehicle_detail['make_name'];?> <?php echo ($vehicle_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>GPS Tracking</td>
							<td> : </td>
							<td><?php echo (!empty($vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Detail</div>
			<div class="row p-2">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="sanat_date">Sanat Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="sanat_date" name="sanat_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['sanat_date'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-3 form-group">
					<label for="sanat_no">Sanat No <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="sanat_no" name="sanat_no" maxlength="55" value="<?php echo $transaction['sanat_no'];?>" readonly />
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="sanat_amount">Sanat Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="sanat_amount" name="sanat_amount" value="<?php echo $transaction['sanat_amount'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="sanat_owner">Sanat Owner <span class="text-danger">*</span></label>
					<select name="sanat_owner" id="sanat_owner" class="form-select" disabled>
						<option value="">Select Owner</option>
						<option value="Abdulaziz Al Dhoheyan" <?php echo ($transaction['sanat_owner'] == 'Abdulaziz Al Dhoheyan') ? ' selected ' : '';?>>Abdulaziz Al Dhoheyan</option>
						<option value="Itlubha International Company" <?php echo ($transaction['sanat_owner'] == 'Itlubha International Company') ? ' selected ' : '';?>>Itlubha International Company</option>
					</select>
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="sanat_status">Status <span class="text-danger">*</span></label>
					<select name="status" id="sanat_status" class="form-select" disabled>
						<option value="">Select Status</option>
						<option value="open" <?php echo ($transaction['status'] == 'open') ? ' selected ' : '';?>>Open</option>
						<option value="activated" <?php echo ($transaction['status'] == 'activated') ? ' selected ' : '';?>>Activated</option>
						<option value="cancelled" <?php echo ($transaction['status'] == 'cancelled') ? ' selected ' : '';?>>Cancelled</option>
					</select>
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group sanat_date_container">
					<?php if($transaction['status'] == 'activated'){ ?>
						<label id="date_label"></label>
						<label for="activation_date">Activation Date</label>
						<input type="date" class="form-control" id="activation_date" name="activation_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['activation_date'];?>" disabled />
					<?php }elseif ($transaction['status'] == 'cancelled') { ?>
						<label for="cancellation_date">Cancellation Date</label>
						<input type="date" class="form-control" id="cancellation_date" name="cancellation_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['cancellation_date'];?>" disabled />
					<?php } ?>
				</div>
				
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="description">Description</label>
					<input type="text" class="form-control" id="description" name="description" value="<?php echo $transaction['description'];?>" maxlength="255" style="pointer-events: none;" readonly />
				</div>

				<?php
				if (!empty($transaction['attachment'])) {
					$attachment = $transaction['attachment'];
					$file_extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
					$is_image = in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
					$is_pdf = $file_extension === 'pdf';
					?>

					<div class="col-md-12 col-sm-12 mb-3 form-group d-flex align-items-center gap-3">
						<?php if ($is_image) { ?>
							<img src="<?php echo $attachment; ?>" height="100px" style="border: 1px dashed #6c6c6c; padding: 3px;" />
						<?php } elseif ($is_pdf) { ?>
							<a href="<?php echo $attachment; ?>" target="_blank">
								<img src="<?= base_url('admin_assets/icons/pdf.png'); ?>" height="100px" alt="PDF File" />
							</a>
						<?php } else { ?>
							<a href="<?php echo $attachment; ?>" target="_blank">
								<img src="<?= base_url('admin_assets/icons/docs.png'); ?>" height="100px" alt="Document File" />
							</a>
						<?php } ?>

						<!-- Download Button -->
						<a href="<?php echo $attachment; ?>" download class="btn btn-md btn-secondary" style="margin-left: 10px;">
							<i class="mdi mdi-download-outline"></i>Download
						</a>
					</div>

				<?php } ?>
			</div>
		</div>
	</div>
</div>
