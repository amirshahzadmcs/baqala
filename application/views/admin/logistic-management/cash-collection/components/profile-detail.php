<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Cash Collection Detail</h5>
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
			<div class="card-header">Cash Collection Detail</div>
			<input type="hidden" id="id" name="id" value="<?php echo $transaction['id'];?>" required />
			<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
			<input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicle_detail['id'];?>" required />
			<input type="hidden" id="attachment_old" name="attachment_old" value="<?php echo $transaction['attachment'];?>" />
			<div class="row p-2">
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="transaction_id">Transaction ID <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="transaction_id" name="transaction_id" value="<?php echo $transaction['transaction_id'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="transaction_id">Jahez ID <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="jahez_id" name="jahez_id" value="<?php echo $transaction['driver_id'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="transaction_date">COD Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="transaction_date" name="transaction_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['transaction_date'];?>" readonly />
				</div>
				
				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="due_amount">COD Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="due_amount" name="due_amount" value="<?php echo $transaction['due_amount'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="paid_amount">Amount Collected <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="paid_amount" name="paid_amount" value="<?php echo $transaction['paid_amount'];?>" readonly />
				</div>

				<div class="col-md-6 col-sm-12 mb-2 form-group">
					<label for="balance_amount">Outstanding Amount <span class="text-danger">*</span></label>
					<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="balance_amount" name="balance_amount" value="<?php echo $transaction['balance_amount'];?>" readonly />
				</div>

				<?php if($transaction['attachment'] !== '' || $transaction['attachment'] !== NULL){ ?>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<img src="<?php echo $transaction['attachment'];?>" height="100px" style="border: 1px dashed #6c6c6c;padding: 3px;" />
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
