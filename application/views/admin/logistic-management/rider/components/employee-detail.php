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
<?php echo form_open("admin/logistic-management/rider/submit", array("id" => "riderProfileForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Fill Detail To Add Profile</div>
	<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail['id'];?>" required />
	<input type="hidden" id="vehicle_id" name="vehicle_id" value="<?php echo $vehicle_detail['id'];?>" required />
	<div class="row p-2">
		
		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="platform">Aggregator <span class="text-danger">*</span></label>
			<select name="platform" id="platform" class="form-select" required>
				<option value="">Select Aggregator</option>
				<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
					<option value="<?php echo $fdcompany->id; ?>"><?php echo $fdcompany->company_name; ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="id_number">Aggregator ID <span class="text-danger">*</span></label>
			<select name="id_number" id="id_number" class="form-select select2" required>
				<option value="">Select Aggregator ID</option>
				
			</select>
		</div>

		<div id="aggregator_detail" class="col-md-12 aggregator-detail"></div>

		<div class="col-md-6 col-sm-12 mb-2 form-group">
			<label for="rider_status">Status <span class="text-danger">*</span></label>
			<select name="rider_status" id="rider_status" class="form-select" required>
				<option value="">Select Status</option>
				<option value="active">Active</option>
				<option value="inactive">Inactive</option>
			</select>
		</div>
		
	</div>
</div>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header mb-2">Delivery Target & Commission</div>
	<div class="row p-2">
		<div class="col-md-12 col-sm-12 mb-2 form-group">
			<select name="incentive_id" id="incentive_id" class="form-select select2">
				<option value="">Select Target</option>
				<?php foreach(incentiveListHelper() as $incentive_list) { ?>
					<option value="<?php echo $incentive_list->id; ?>"><?php echo $incentive_list->incentive_name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
<script>
	$(document).ready(function() {

		$('#platform').change(function(e) {
			e.preventDefault();
			var platform = $(this).find('option:selected').val(); 
			$('#id_number').empty().append('<option value="">Select Aggregator ID</option>');

			if (platform !== "") {
				$.ajax({
					url: "<?php echo base_url('admin/logistic-management/rider/get-platform-ids'); ?>",
					type: "POST",
					data: { platform: platform },
					dataType: "json",
					success: function(data) {
						if (data.status === 'success') {
							var idNumberDropdown = $('#id_number');
							idNumberDropdown.empty();
							idNumberDropdown.append('<option value="">Select Aggregator ID</option>');

							// Check if data.output is valid and not empty
							if (data.output && data.output.length > 0) {
								$.each(data.output, function(index, item) {
									idNumberDropdown.append('<option value="' + item.id_number + '">' + item.id_number + ' (' + item.id_type + ')</option>');
								});

								// Reinitialize Select2 if used
								idNumberDropdown.select2();
								toastr.success('Aggregator IDs loaded successfully.');
							} else {
								toastr.warning('No Aggregator IDs found for this aggregator.');
							}
						} else {
							//idNumberDropdown.append('<option value="">Select Aggregator ID</option>');
							toastr.error(data.message);
						}
					},
					error: function(response) {
						console.log('Error Response:', response);
						idNumberDropdown.empty().append('<option value="">Select Aggregator ID</option>');
						toastr.error('An error occurred while fetching aggregator IDs.');
					}
				});
			} else {
				$('#id_number').empty().append('<option value="">Select Aggregator ID</option>');
				toastr.warning('Please select a platform.');
			}
		});

		$('#id_number').change(function(e) {
			e.preventDefault();

			var idNumber = $(this).find('option:selected').val(); 

			// Check if an ID number is selected
			if (idNumber !== "") {
				$.ajax({
					url: "<?php echo base_url('admin/logistic-management/rider/get-aggregator-id-detail'); ?>",
					type: "POST",
					data: {
						id_number: idNumber
					},
					dataType: "json",
					success: function(data) {
						if (data.status === 'success') {
							// Build the detail HTML
							var detailHtml = '<div class="size-inner-section p-3 my-2">';
							detailHtml += '<h5>Aggregator Details:</h5>';
							detailHtml += '<p class="mb-0"><strong>ID Type:</strong> ' + data.output.id_type + '</p>';
							detailHtml += '<p class="mb-0"><strong>Owner ID:</strong> ' + data.output.emp_no + '</p>';
							detailHtml += '<p class="mb-0"><strong>Owner Name:</strong> ' + data.output.full_name + '</p>';
							detailHtml += '<p class="mb-0"><strong>Request Date:</strong> ' + formatDate(data.output.request_date) + '</p>';
							detailHtml += '<p class="mb-0"><strong>Activation Date:</strong> ' + formatDate(data.output.activation_date) + '</p>';
							detailHtml += '</div>';
							// Add more fields as needed

							// Update the aggregator detail div
							$('#aggregator_detail').html(detailHtml);
						} else {
							$('#aggregator_detail').html('<p class="text-danger">' + data.message + '</p>');
						}
					},
					error: function() {
						$('#aggregator_detail').html('<p class="text-danger">An error occurred while fetching aggregator details.</p>');
					}
				});
			} else {
				// Clear the aggregator detail div if no ID number is selected
				$('#aggregator_detail').html('');
			}
		});

		$('#riderProfileForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/logistic-management/rider/submit');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					// Handle server response
					if (response.type === 'success') {
						toastr.success(response.message);
						// $('#searchResult').html('');
						// $('#searchResponse').html('');
						// $('#searchModalFooter').html('');
						// initializeDataTable();
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

	function formatDate(dateString) {
		const date = new Date(dateString);
		const day = String(date.getDate()).padStart(2, '0');
		const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based
		const year = date.getFullYear();
		return `${day}-${month}-${year}`;
	}
</script>
