<div class="modal-header">
	<h5 class="modal-title mt-0" id="addRiderModalLabel">Swap Platform ID</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="mt-2">
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="row">
				<div class="col">
					<div class="d-flex align-items-center employee-detail">
						<div class="p-2 w-100">
							<h6 class="mb-0 mt-0">#<?php echo $emp_detail['emp_no'];?></h6>
							<h6 class="mb-0 mt-0"><u> <?php echo $emp_detail['full_name'];?> </u></h6>
							<span><?php echo $emp_detail['designation_name'];?><br>ID Number : <?php echo $profile['id_number'];?></span>
						</div>
					</div>
				</div>
				<div class="col-md-1"><i class="fas fa-long-arrow-alt-right font-size-24" style="line-height: 72px;"></i></div>
				<div class="col">
					<div class="d-flex align-items-center employee-detail">
						<div class="p-2 w-100">
							<h6 class="mb-0 mt-0" id="swapIdNo"></h6>
							<h6 class="mb-0 mt-0" id="swapIdName"><span style="line-height: 52px;">N/A</span></h6>
							<span id="swapIdInfo"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Fill Swap Information</div>
			<?php echo form_open("admin/logistic-management/rider/save-swap", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
				<input type="hidden" id="id" name="id" value="<?php echo $profile['id'];?>" required />
				<div class="row p-2">
					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="swap_rider">Select Rider To Swap ID</label>
						<select name="swap_rider" id="swap_rider" class="form-control select2" required>
							<option value="">Select Rider</option>
							<?php foreach($rider_list as $driders) { ?>
								<option value="<?php echo $driders['id']; ?>" data-emp_no ="<?php echo $driders['emp_no']; ?>" data-full_name="<?php echo $driders['full_name']; ?>" data-designation="<?php echo $driders['designation_name']; ?>" data-id_number="<?php echo $driders['id_number']; ?>"><?php echo $driders['emp_no']; ?> - <?php echo $driders['full_name']; ?> - <?php echo $driders['designation_name']; ?> (<?php echo $driders['id_number']; ?>)</option>
							<?php } ?>
						</select>
					</div>
					<div id="rider_msg" class="text-info"></div>
					<div class="col-md-12 col-sm-12 mb-2 form-group">
						<label for="reason">Swap Reason <span class="text-danger">*</span></label>
						<select name="reason" id="reason" class="form-select" required>
							<option value="">Select Reason</option>
							<?php foreach (masterReasons('suspend_reason') as $mreason) { ?>
								<option value="<?php echo $mreason->reason_title_en;?>"><?php echo $mreason->reason_title_en;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
	<button type="submit" form="riderProfileForm" class="btn btn-custom-success">Swap</button>
</div>

<script>
	$(document).ready(function() {

		$('#swap_rider').on('change', function() {
			// Get the selected option's data attributes
			$('#rider_msg').html('');
			var selectedRiderId = $(this).val();
			var selectedOption = $(this).find('option:selected');
			
			var empNo = selectedOption.data('emp_no');
			var fullName = selectedOption.data('full_name');
			var designation = selectedOption.data('designation');
			var idNumber = selectedOption.data('id_number');
			
			// Update the corresponding fields with the selected rider's details
			$('#swapIdNo').text(empNo ? '#' + empNo : 'N/A');
			$('#swapIdName').text(fullName ? fullName : 'N/A');
			$('#swapIdInfo').html(designation ? designation + '<br>ID Number: ' + idNumber : 'N/A');
			if (selectedRiderId) {
				$.ajax({
					url: '<?php echo base_url("admin/logistic-management/rider/check-id-allotment"); ?>',
					type: 'POST',
					data: { rider_id: selectedRiderId },
					dataType: 'json',
					success: function(response) {
						if (response.status === 'error') {
							//toastr.warning(response.message);
							$('#rider_msg').html(response.message);
						}
					},
					error: function() {
						toastr.error('An error occurred while checking the ID number.');
					}
				});
			}
		});

		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/rider/save-swap');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						//initializeDataTable();
						toastr.success(response.message);
						//$('#addRiderModal').modal('hide');
						setTimeout(function() {
							location.reload();
						}, 800);
					} else {
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
	});
</script>
