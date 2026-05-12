<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Edit Cash Collection</h5>
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
	<?php echo form_open("admin/logistic-management/cash-collection/update", array("id" => "cashCollectionForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
	<div class="size-inner-section px-1 py-1 mx-1">
		<div class="card-header">Update Detail - <?php echo $transaction['transaction_id'];?></div>
		<input type="hidden" id="id" name="id" value="<?php echo $transaction['id'];?>" required />
		<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
		<input type="hidden" name="due_amount" value="<?php echo $transaction['due_amount'];?>" required />
		<input type="hidden" id="attachment_old" name="attachment_old" value="<?php echo $transaction['attachment'];?>" />
		<div class="row p-2">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="transaction_date">Date <span class="text-danger">*</span></label>
				<input type="date" class="form-control" id="transaction_date" name="transaction_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['transaction_date'];?>" disabled />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="transaction_id">Jahez ID <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="jahez_id" name="jahez_id" value="<?php echo $transaction['driver_id'];?>" disabled />
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="due_amount">COD Amount <span class="text-danger">*</span></label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="due_amount" name="due_amount" value="<?php echo $transaction['due_amount'];?>" disabled />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="paid_amount">Amount Collected <span class="text-danger">*</span></label>
				<input type="text" class="form-control input-mask text-left amount_collected" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="paid_amount" name="paid_amount" value="<?php echo $transaction['paid_amount'];?>" data-cod="<?php echo $transaction['due_amount'];?>" required />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="balance_amount">Outstanding Amount <span class="text-danger">*</span></label>
				<input type="text" class="form-control input-mask text-left outstanding_amount" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="balance_amount" name="balance_amount" value="<?php echo $transaction['balance_amount'];?>" readonly required />
			</div>
			<!--
			<div class="col-md-12 col-sm-12 mb-2 form-group">
				<label for="receipt_reason">Receipt Reason <span class="text-danger">*</span></label>
				<select name="receipt_reason" id="receipt_reason" class="form-select" required>
					<option value="">Select Reason</option>
					<?php 
						if(!empty(cashReasonsHelper())){ 
						foreach(cashReasonsHelper() as $master_reason){ 
					?>
					<option value="<?php echo $master_reason->reason_title_en;?>" <?php echo ($master_reason->reason_title_en == $transaction['receipt_reason']) ? ' selected ' : '';?>><?php echo $master_reason->reason_title_en;?></option>
					<?php }}else{ ?>
						<option value="" disabled>No reason found, add first!</option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<label for="description">Description</label>
				<input type="text" class="form-control" id="description" name="description" value="<?php echo $transaction['description'];?>" maxlength="255" />
			</div>

			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<input type="file" name="attachment" id="attachment" class="dropify"
					accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
					data-max-file-size="2M" data-height="100">
			</div>
			-->
			<?php if($transaction['attachment'] !== '' || $transaction['attachment'] !== NULL){ ?>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<img src="<?php echo $transaction['attachment'];?>" height="100px" style="border: 1px dashed #6c6c6c;padding: 3px;" />
			</div>
			<?php } ?>
		</div>
	</div>
	<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="cashCollectionForm" class="btn btn-custom-success">Update</button>
</div>

<script>
	$(document).ready(function(){
		$(".input-mask").inputmask();
		$('.dropify').dropify();
		$(document).on("input", ".amount_collected", function () {
			let $this = $(this);
			let collected = parseFloat($this.val()) || 0;
			let cod = parseFloat($this.data("cod")) || 0;
			let outstanding = cod - collected;

			// Remove old warning if exists
			$this.siblings(".warning-text").remove();

			let $form = $this.closest("form"); // <-- form is the correct parent
			let $outstanding = $form.find(".outstanding_amount");

			if (collected > cod) {
				$this.after('<small class="text-danger warning-text">Collected amount cannot be greater than COD (' + cod.toFixed(2) + ')</small>');
				$outstanding.val('0.00');
			} else if (collected > 0 && collected <= cod) {
				$outstanding.val(outstanding.toFixed(2));
			} else {
				$outstanding.val(cod.toFixed(2));
			}
		});

	});

	$(document).ready(function() {
		$('#cashCollectionForm').submit(function(e) {
			e.preventDefault();
			let $form = $(this);
			let formData = new FormData(this);

			// Find the submit button inside this form
			let $submitBtn = $form.find("button[type='submit']");

			// Disable button and show 'Saving...'
			$submitBtn.prop("disabled", true).text("Saving...");

			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/cash-collection/update');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.type === 'success') {
						initializeDataTable();
						$('#responseContainer').html(
							'<div class="alert alert-success alert-dismissible fade show" role="alert">' +
							'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
							response.message +
							'</div>'
						);

						// Close modal after 1 sec
						setTimeout(function() {
							$('#cashCollectionForm').closest('.modal').modal('hide');
						}, 1000);

					} else {
						$('#responseContainer').html(
							'<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
							'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
							response.message +
							'</div>'
						);
						// Re-enable button if failed
						$submitBtn.prop("disabled", false).text("Submit");
					}
				},
				error: function() {
					$('#responseContainer').html(
						'<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
						'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
						'An error occurred. Please try again.' +
						'</div>'
					);
					// Re-enable button on error
					$submitBtn.prop("disabled", false).text("Submit");
				}
			});
		});
	});

</script>
