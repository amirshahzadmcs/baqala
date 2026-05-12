<style> 
.modal-body {
    padding: 0.4rem;
}
</style>
<div>
	<?php echo form_open("admin/master-vehicle/save-allotment", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="vehicle_id" value="<?php echo $alloted_vehicle_detail['id'];?>" required>
        <input type="hidden" name="type" value="unalloted" required>
        <input type="hidden" name="allotment_status" value="unalloted" required>
        <input type="hidden" name="alloted_user" value="<?php echo $alloted_vehicle_detail['alloted_user'];?>" required>
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
                            <td>Mobile Number</td>
                            <td> : </td>
                            <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                        </tr>
                        <tr>
                            <td>DL Number</td>
                            <td> : </td>
                            <td><?php if(!empty($emp_detail->driving_license_number)){ echo $emp_detail->driving_license_number;}else{ echo 'NA';}?></td>
                        </tr>
                        <tr>
                            <td>GPS Tracking</td>
                            <td> : </td>
                            <td><?php echo (!empty($alloted_vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
		<div class="size-inner-section px-1 py-1 mx-1">
            <div class="card-header"> Alloted Vehicle Detail</div>
            <div class="d-flex align-items-center vehicle-detail">
                <div class="p-3 w-100">
                    <table>
                        <tr>
                            <td>Vehicle No.</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php echo $alloted_vehicle_detail['vehicle_no'];?> - <?php echo ucfirst($alloted_vehicle_detail['vehicle_type']);?></td>
                        </tr>
                        <tr>
                            <td>Vehicle Model</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php echo $alloted_vehicle_detail['vehicle_model'];?> / <?php echo $alloted_vehicle_detail['make_name'];?> / <?php echo ucfirst($alloted_vehicle_detail['color_name']);?></td>
                        </tr>
                        <tr>
                            <td>Chassis Number</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php echo (!empty($alloted_vehicle_detail['chassis_no'])) ? $alloted_vehicle_detail['chassis_no'] : 'NA';?></td>
                        </tr>
                        <tr>
                            <td>Sequel No</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php echo $alloted_vehicle_detail['sequel_no'];?></td>
                        </tr>
                        <tr>
                            <td>Vehicle Ownership</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php if(!empty($alloted_vehicle_detail['vehicle_ownership'])){ echo $alloted_vehicle_detail['vehicle_ownership'];}else{ echo 'NA';}?></td>
                        </tr>
                        <tr>
                            <td>Owner Name</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php if(!empty($alloted_vehicle_detail['owner_name_select'])){ echo $alloted_vehicle_detail['owner_name_select'];}else{ echo 'NA';}?></td>
                        </tr>
                        <tr>
                            <td>Gasoline Chip</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php if(($alloted_vehicle_detail['gasoline_chip_status'] == 'on')){ echo 'Yes'; }else{ echo 'No'; }?></td>
                        </tr>
                        <tr>
                            <td>GPS Tracking</td>
                            <td>&nbsp; : &nbsp;</td>
                            <td><?php echo (!empty($alloted_vehicle_detail['gps_device_serial'])) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row tab-inner-section m-2 py-2">
            <h4 class="header-title">Fill Unallotment Detail</h4><hr>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="status_date">Date of Unallotment<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="status_date" name="status_date" max="<?php echo date('Y-m-d'); ?>" required />
            </div>
            <div class="col-md-6 col-sm-12 mb-3 form-group">
                <label for="meter_reading">Meter Reading<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="meter_reading" name="meter_reading" required />
                <input type="hidden" id="previous_meter" value="<?= $last_meter_reading['meter_reading'] ?? 0 ?>">
            </div>
            <div class="col-md-12 col-sm-12 form-group mb-3">
                <label for="tamm_attachment">Tamm Cancelled Authorization</label>
                <input type="file" name="tamm_attachment" id="tamm_attachment" class="dropify"
                    accept=".png, .jpeg, .jpg, .gif, .svg, .webp, .pdf, .doc, .docx, .xls, .xlsx"
                    data-max-file-size="2M" data-height="100">
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="remarks">Remarks (If any)</label>
                <input type="text" class="form-control" id="remarks" name="remarks" />
            </div>
        </div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	
	$(document).ready(function () {
        $('#requestModalFullscreenLabel').html('Vehicle Unallotment Request');
        $('.dropify').dropify();
        $('.select2').select2({
            width: '100%'
        });

        $(document).on('blur', '#meter_reading', function () {
            let previous = parseFloat($('#previous_meter').val());
            let current = parseFloat($(this).val());

            if (current < previous) {
                toastr.error('Meter reading must be greater than or equal to the previous meter reading.');
            }
        });

		$("#request_form").on("submit", function (e) {
            e.preventDefault();

            var $submitBtn = $("#submitBtn");
            var originalBtnHtml = $submitBtn.html();

            // Disable button and show loader
            $submitBtn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

            var formData = new FormData(this); 
            $.ajax({
                url: "<?php echo base_url('admin/master-vehicle/save-allotment'); ?>",
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
                        }, 1500);
                    } else if (response.type === "error") {
                        toastr.error(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText, status, error);
                    toastr.error('An unexpected error occurred. Please try again.');
                },
                complete: function () {
                    // Restore button
                    $submitBtn.prop("disabled", false).html(originalBtnHtml);
                }
            });
        });
	});
</script>
