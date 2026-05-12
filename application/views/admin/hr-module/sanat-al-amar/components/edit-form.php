<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Edit Sanat Al Amar</h5>
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
	<?php echo form_open("admin/hr-module/sanat-al-amar/update", array("id" => "sanatForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
	<div class="size-inner-section px-1 py-1 mx-1">
		<div class="card-header">Fill Detail</div>
		<input type="hidden" id="id" name="id" value="<?php echo $transaction['id'];?>" required />
		<input type="hidden" id="attachment_old" name="attachment_old" value="<?php echo $transaction['attachment'];?>" />
		<div class="row p-2">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="sanat_date">Sanat Date <span class="text-danger">*</span></label>
				<input type="date" class="form-control" id="sanat_date" name="sanat_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $transaction['sanat_date'];?>" required />
			</div>

			<div class="col-md-6 col-sm-12 mb-3 form-group">
				<label for="sanat_no">Sanat No <span class="text-danger">*</span></label>
				<input type="text" class="form-control" id="sanat_no" name="sanat_no" minlength="16" maxlength="16" value="<?php echo $transaction['sanat_no'];?>" required />
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="sanat_amount">Sanat Amount <span class="text-danger">*</span></label>
				<input type="text" class="form-control input-mask text-left" data-inputmask="'alias': 'numeric', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" autocomplete="off" id="sanat_amount" name="sanat_amount" value="<?php echo $transaction['sanat_amount'];?>" required />
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="sanat_owner">Sanat Owner <span class="text-danger">*</span></label>
				<select name="sanat_owner" id="sanat_owner" class="form-select" required>
					<option value="">Select Owner</option>
					<option value="Abdulaziz Al Dhoheyan" <?php echo ($transaction['sanat_owner'] == 'Abdulaziz Al Dhoheyan') ? ' selected ' : '';?>>Abdulaziz Al Dhoheyan</option>
					<option value="Itlubha International Company" <?php echo ($transaction['sanat_owner'] == 'Itlubha International Company') ? ' selected ' : '';?>>Itlubha International Company</option>
				</select>
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="sanat_status">Status <span class="text-danger">*</span></label>
				<select name="status" id="sanat_status" class="form-select" required>
					<option value="">Select Status</option>
					<option value="open" <?php echo ($transaction['status'] == 'open') ? ' selected ' : '';?>>Open</option>
					<option value="activated" <?php echo ($transaction['status'] == 'activated') ? ' selected ' : '';?>>Activated</option>
					<option value="cancelled" <?php echo ($transaction['status'] == 'cancelled') ? ' selected ' : '';?>>Cancelled</option>
				</select>
			</div>

			<div class="col-md-6 col-sm-12 mb-2 form-group sanat_date_container" style="display: none;">
				<label id="date_label"></label>
				<input type="date" class="form-control" id="date_input" name="" max="<?php echo date('Y-m-d');?>" />
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
			<?php
			if (!empty($transaction['attachment'])) {
				$attachment = $transaction['attachment'];
				$file_extension = strtolower(pathinfo($attachment, PATHINFO_EXTENSION));
				$is_image = in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
				$is_pdf = $file_extension === 'pdf';
				?>

				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<?php if ($is_image) { ?>
						<img src="<?php echo $attachment; ?>" height="100px" style="border: 1px dashed #6c6c6c; padding: 3px;" />
					<?php } elseif ($is_pdf) { ?>
						<a href="<?php echo $attachment; ?>" target="_blank">
							<img src="<?= base_url('admin_assets/icons/pdf.png');?>" height="100px" alt="PDF File" />
						</a>
					<?php } else { ?>
						<a href="<?php echo $attachment; ?>" target="_blank">
							<img src="<?= base_url('admin_assets/icons/docs.png');?>" height="100px" alt="Document File" />
						</a>
					<?php } ?>
				</div>

			<?php } ?>
		</div>
	</div>
	<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="sanatForm" class="btn btn-custom-success">Update</button>
</div>

<script>
	$(document).ready(function(){
		$(".input-mask").inputmask();
		$('.dropify').dropify();
	});

	$(document).ready(function() {
		$('#sanatForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/sanat-al-amar/update');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						initializeDataTable();
						toastr.success(response.message);
						$('#addCashModal').modal('hide');
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error(response.message);
				}
			});
		});
	});

	$(document).ready(function () {
        // Function to handle the dropdown options based on the current status
        function updateStatusOptions() {
            var currentStatus = "<?php echo $transaction['status']; ?>"; // Current status from the backend
            
            $('#sanat_status option').each(function () {
                if ($(this).val() !== "" && $(this).val() !== currentStatus) {
                    // Hide or disable previous statuses based on the current status
                    if (
                        (currentStatus === 'activated' && $(this).val() === 'open') ||
                        (currentStatus === 'cancelled' && $(this).val() === 'open') ||
                        (currentStatus === 'cancelled' && $(this).val() === 'activated')
                    ) {
                        $(this).hide(); // Hide the option
                    } else {
                        $(this).show(); // Ensure valid options remain visible
                    }
                }
            });
        }

        // Function to handle date fields based on the selected status
        function handleStatusChange() {
            var selectedStatus = $('#sanat_status').val();
            var dateContainer = $('.sanat_date_container');
            var dateLabel = $('#date_label');
            var dateInput = $('#date_input');

            // Hide the container by default
            dateContainer.hide();
            dateInput.val(''); // Clear the input value
            dateInput.attr('name', ''); // Clear the name attribute

            // Show specific date field based on the selected status
            if (selectedStatus === 'activated') {
                dateLabel.text('Activation Date');
                dateInput.attr('name', 'activation_date');
                dateContainer.show();
            } else if (selectedStatus === 'cancelled') {
                dateLabel.text('Cancellation Date');
                dateInput.attr('name', 'cancellation_date');
                dateContainer.show();
            }
        }

        // Initialize dropdown options and date fields
        updateStatusOptions();
        handleStatusChange();

        // Trigger status change function on dropdown change
        $('#sanat_status').on('change', handleStatusChange);
    });
</script>
