<div class="modal-header">
	<h5 class="modal-title mt-0" id="manageEmployeeModalLabel">Update Iqama Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div id="responseContainer"></div>
	<div class="mt-2">
		<div class="size-inner-section px-1 py-1 mx-1">
			<div class="card-header">Basic Detail</div>
			<div class="d-flex align-items-center employee-detail">
				<div class="image">
					<?php if(!empty($emp_detail->employee_pic) && $emp_detail->employee_pic !== ''){ ?>
						<img src="<?php echo $emp_detail->employee_pic;?>" class="rounded" width="140">
					<?php }else{ ?>
						<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
					<?php } ?>
				</div>
				<div class="p-3 w-100">
					<h5 class="mb-0 mt-0"> <?php echo $emp_detail->full_name;?> / <?php echo $emp_detail->employee_arabic_name;?> </h5>
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
			<div class="card-header">Update Iqama Detail</div>
			<?php echo form_open("admin/hr/employees/update-iqama-detail", array("id" => "iqamaUpdateForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
				<input type="hidden" id="emp_id" name="employee_id" value="<?php echo $emp_detail->id;?>" required />
				<div class="row p-2">
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_no">ID/Iqama Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="iqama_no" name="iqama_no" minlength="<?= ICAMA_LENGTH; ?>" maxlength="<?= ICAMA_LENGTH; ?>" value="<?php echo $emp_detail->iqama_no; ?>" required />
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_name_en">Name as per Iqama (EN)</label>
                        <input type="text" class="form-control" onKeyPress="return Alpha(event);" id="iqama_name_en" name="iqama_name_en" maxlength="150" value="<?php echo $emp_detail->iqama_name_en; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_name_ar">Name as per Iqama (AR)</label>
                        <input type="text" class="form-control rtl-input" onKeyPress="return Alpha(event);" id="iqama_name_ar" name="iqama_name_ar" maxlength="150" value="<?php echo $emp_detail->iqama_name_ar; ?>" />
                    </div>
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_profession">Profession in Iqama</label>
                        <select class="form-select select2" name="iqama_profession" id="iqama_profession">
                            <option value="">Select Profession</option>
                            <?php foreach (professionList() as $profession) { ?>
                                <option value="<?php echo $profession->id; ?>" data-id="<?php echo $profession->id; ?>" <?php echo ($profession->id == $emp_detail->iqama_profession) ? ' selected ' : '' ?>><?php echo $profession->profession_name; ?> <?php echo (isset($profession->arabic_name)) ? '/ ' . $profession->arabic_name : ''; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_issue_date">ID/Iqama Issue Date</label>
                        <input type="date" class="form-control" id="iqama_issue_date" name="iqama_issue_date" value="<?php echo $emp_detail->iqama_issue_date; ?>" />
                    </div>

                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_expiry_date">ID/Iqama Expiry Date</label>
                        <input type="date" class="form-control" id="iqama_expiry_date" name="iqama_expiry_date" value="<?php echo $emp_detail->iqama_expiry_date; ?>" />
                    </div>

                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_issue_city">ID/Iqama Issue City</label>
                        <select class="form-select select2" name="iqama_issue_city" id="iqama_issue_city">
                            <option value="">Select City</option>
                            <?php foreach (selectedCitiesHelp(6) as $cities) { ?>
                                <option value="<?php echo $cities->id; ?>" data-id="<?php echo $cities->id; ?>" <?php echo ($cities->id == $emp_detail->iqama_issue_city) ? ' selected ' : '' ?>><?php echo $cities->city_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <?php
                        // Assuming you have fetched the iqama expiry date from the database
                        $iqama_expiry_date = $emp_detail->iqama_expiry_date;

                        // Convert the expiry date to a DateTime object
                        $expiry_date = new DateTime($iqama_expiry_date);
                        $current_date = new DateTime();

                        $status_message = '';
                        $status_class = '';

                        if ($expiry_date < $current_date) {
                            $status_message = 'Expired.';
                            $status_class = 'alert-danger';
                        } elseif ($expiry_date == $current_date) {
                            $status_message = 'Expires Today.';
                            $status_class = 'alert-warning';
                        } else {
                            $status_message = 'Active';
                            $status_class = 'alert-success';
                        }
                        ?>
                    <div class="col-md-6 col-sm-12 mb-2 form-group">
                        <label for="iqama_status">ID/ Iqama Status</label>
                        <div id="iqama_status" class="py-2 alert <?php echo $status_class; ?>" style="display: block;">
                            <?php echo $status_message; ?>
                        </div>
                    </div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div class="modal-footer" id="searchModalFooter">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
	<button type="submit" form="iqamaUpdateForm" class="btn btn-custom-success">Update</button>
</div>

<script>
$(document).ready(function () {

    $("#iqamaUpdateForm").on("submit", function (e) {
        e.preventDefault();

        let issueDate  = $("#iqama_issue_date").val();
        let expiryDate = $("#iqama_expiry_date").val();

        // Date validation
        if (issueDate && expiryDate) {
            if (new Date(expiryDate) <= new Date(issueDate)) {
                toastr.error("Iqama Expiry Date must be greater than Iqama Issue Date.");
                return false;
            }
        }

        let form = $(this);
        let submitBtn = form.find("button[type=submit]");

        // Disable button + change text
        submitBtn.prop("disabled", true).html("Updating...");

        let formData = new FormData(this);

        $.ajax({
            url: "<?php echo base_url('admin/hr/employees/update-iqama-detail'); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (response) {
                let data = JSON.parse(response);

                if (data.type === "success") {
                    toastr.success(data.message);

                    // Close modal
                    setTimeout(function () {
                        window.location.reload();
                    }, 800);

                    // Reload table
                    if (typeof employeeTable !== "undefined") {
                        employeeTable.ajax.reload(null, false);
                    }
                } else {
                    toastr.error(data.message);
                }

                // Re-enable button
                submitBtn.prop("disabled", false).html("Update");
            },

            error: function () {
                toastr.error("Something went wrong.");
                submitBtn.prop("disabled", false).html("Update");
            }
        });
    });
});
</script>


