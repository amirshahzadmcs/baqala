<style> 
.modal-body {
    padding: 0.4rem;
}
.modal-footer{
	display: none;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-vehicle-allotment-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" id="allotment_employee_id" value="<?php echo $emp_detail->id;?>" required />
		<input type="hidden" name="request_type" value="VehicleAllotmentRequest" required />
		<!-- Tab panes -->
		<div id="ajaxRes"></div>
        <div class="tab-inner-section px-1 py-1 mx-1">
            <div class="card-header">Rider Detail</div>
            <div class="d-flex align-items-center employee-detail">
                <div class="image">
                    <?php if(!empty($emp_detail->employee_pic) && $emp_detail->employee_pic !== ''){ ?>
                        <img src="<?php echo $emp_detail->employee_pic;?>" class="rounded" width="140">
                    <?php }else{ ?>
                        <img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
                    <?php } ?>
                </div>
                <div class="p-3 w-100">
                    <h6 class="mb-0 mt-0"> <?php echo $emp_detail->full_name;?> / <?php echo $emp_detail->employee_arabic_name;?> </h6>
                    <span><?php echo $emp_detail->designation_name;?> | <?php echo $emp_detail->department_name;?></span>
                    <hr class="my-1">
                    <table>
                        <tr>
                            <td>Emp No.</td>
                            <td> : </td>
                            <td><?php echo $emp_detail->emp_no;?></td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td> : </td>
                            <td><?php echo $emp_detail->nationality_name;?></td>
                        </tr>
                        <tr>
                            <td>Flex Number</td>
                            <td> : </td>
                            <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                        </tr>
                        <tr>
                            <td>Mobile No</td>
                            <td> : </td>
                            <td><?php echo $emp_detail->mobile;?></td>
                        </tr>
                        <tr>
                            <td>DL Number</td>
                            <td> : </td>
                            <td><?php if(!empty($emp_detail->driving_license_number)){ echo $emp_detail->driving_license_number;}else{ echo 'NA';}?></td>
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
        <?php if(isset($existing_employee_request) && $existing_employee_request){ ?>
            <div class="row tab-inner-section m-1 py-2">
                <div class="col-md-12 col-sm-12 mb-2 form-group px-2">
                    <div class="alert alert-warning mb-0" role="alert">
                        <strong>Warning!</strong> There is already an existing Vehicle Allotment Request pending for this employee. You cannot submit another request until the existing one is resolved.
                    </div>
                </div>
            </div>
            <?php 
                $requestDetails = $existing_employee_request['request_detail'];
                $requestDetailArray = json_decode($requestDetails);
                $vehicle_id = isset($requestDetailArray->vehicle_id) ? $requestDetailArray->vehicle_id : '';
            ?>
            <?php if (!empty($vehicle_id)) : ?>
			<?php $vehicleInfo = vehicleDetailHelper($vehicle_id); ?>
            <?php if (!empty($vehicleInfo)) : ?>
            <div class="size-inner-section px-1 py-1 mx-1">
                <div class="card-header"> Requested Vehicle Detail</div>
                <div class="d-flex align-items-center vehicle-detail">
                    <div class="p-3 w-100">
                        <table>
                            <tr>
                                <td>Vehicle No.</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo $vehicleInfo->vehicle_no;?> - <?php echo ucfirst($vehicleInfo->vehicle_type);?></td>
                            </tr>
                            <tr>
                                <td>Vehicle Model</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo $vehicleInfo->vehicle_model;?> / <?php echo $vehicleInfo->make_name;?></td>
                            </tr>
                            <tr>
                                <td>Chassis Number</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo (!empty($vehicleInfo->chassis_no)) ? $vehicleInfo->chassis_no : 'NA';?></td>
                            </tr>
                            <tr>
                                <td>Sequel No</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo $vehicleInfo->sequel_no;?></td>
                            </tr>
                            <tr>
                                <td>Vehicle Ownership</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php if(!empty($vehicleInfo->vehicle_ownership)){ echo $vehicleInfo->vehicle_ownership;}else{ echo 'NA';}?></td>
                            </tr>
                            <tr>
                                <td>Owner Name</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php if(!empty($vehicleInfo->owner_name_select)){ echo $vehicleInfo->owner_name_select;}else{ echo 'NA';}?></td>
                            </tr>
                            <tr>
                                <td>Gasoline Chip</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php if(($vehicleInfo->gasoline_chip_status == 'on')){ echo 'Yes'; }else{ echo 'No'; }?></td>
                            </tr>
                            <tr>
                                <td>GPS Tracking</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo (!empty($vehicleInfo->gps_device_serial)) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                            </tr>
                            <tr>
                                <td>Meter Reading</td>
                                <td>&nbsp; : &nbsp;</td>
                                <td><?php echo (!empty($requestDetailArray->meter_reading)) ? $requestDetailArray->meter_reading : 'NA';?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
			<?php endif; ?>
        <?php }else{ ?>
		<div class="row tab-inner-section m-1 py-2">
            <div class="col-md-12 col-sm-12 mb-2 form-group px-2">
				<label for="vehicle_id">Select Vehicle</label>
				<select class="form-control select2" data-parsley-allselected="true" name="vehicle_id" id="vehicle_id" required>
					<option value="">Select Vehicle</option>
                    <?php foreach($unalloted_vehicles as $vehicle){ ?>
                        <option value="<?php echo $vehicle['id']; ?>"><?php echo $vehicle['vehicle_no']; ?> (<?php echo $vehicle['vehicle_model']; ?> / <?php echo $vehicle['make_name']; ?> / <?php echo ($vehicle['vehicle_type'] == 'bike') ? 'Bike' : 'Car'; ?>)</option>
					<?php } ?>
				</select>
			</div>
		</div>
        <div id="searchResult" class="mt-2">

        </div>
        <?php } ?>
        <div id="searchResponse" class="mt-2">

        </div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	
	$(document).ready(function () {
        $('.dropify').dropify();
        $('.select2').select2({
            width: '100%'
        });

        // Trigger on dropdown change
		$('#vehicle_id').on('change', function () {
			$('#searchResponse').html('');
			let vehicle_id = $(this).val();

			$.ajax({
				url: "<?php echo base_url('admin/hr-module/employees/Employee/get_vehicle_detail');?>",
				type: 'POST',
				data: { vehicle_id: vehicle_id },
				dataType: 'json',
				success: function(response) {
					if (response.type === 'success') {
						$('#searchResponse').html('<div><p class="text-success mb-0 mt-2">' + response.message + '</p></div>');
						$('#searchResult').html(response.output_html);
					} else {
						$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">' + response.message + '</p></div>');
						$('#searchResult').html('');
					}
				},
				error: function() {
					$('#searchResponse').html('<div><p class="text-danger mb-0 mt-2">An error occurred. Please try again.</p></div>');
				}
			});
		});

		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-vehicle-allotment-request'); ?>",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (response) {
					if (response.type === "success") {
						toastr.success(response.message);
						setTimeout(function () {
							location.reload();
						}, 2000);
					} else if (response.type === "error") {
						toastr.error(response.message);
					}
				},
				error: function (xhr, status, error) {
					console.error("AJAX Error:", xhr.responseText, status, error);
					toastr.error('An unexpected error occurred. Please try again.');
				},
			});
		});
	});
</script>
