<div class="card-header">Rider Detail</div>
<div class="d-flex align-items-center employee-detail">
    <div class="image">
        <?php if (!empty($profile->employee_pic) && $profile->employee_pic != '') { ?>
            <img src="<?php echo $profile->employee_pic; ?>" class="rounded" width="140">
        <?php } else { ?>
            <img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="140">
        <?php } ?>
    </div>
    <div class="p-3 w-100">
        <h5 class="mb-0 mt-0"> <?php echo $profile->full_name; ?> / <?php echo $profile->employee_arabic_name; ?> </h5>
        <span><?php echo $profile->job_title; ?> | <?php echo $profile->department_name; ?></span>
        <hr class="my-1">
        <table>
            <tr>
                <td>Emp No.</td>
                <td> : </td>
                <td><?php echo $profile->emp_no; ?></td>
            </tr>
            <tr>
                <td>Nationality</td>
                <td> : </td>
                <td><?php echo $profile->nationality_name; ?></td>
            </tr>
            <!-- <tr>
                    <td>Flex Number</td>
                    <td> : </td>
                    <td><?php //echo (!empty($sim_detail->mobile)) ? $sim_detail->mobile : 'NA'; 
                        ?></td>
                </tr> -->
            <tr>
                <td>Mobile No</td>
                <td> : </td>
                <td><?php echo $profile->mobile; ?></td>
            </tr>
            <tr>
                <td>DL Number</td>
                <td> : </td>
                <td><?php if (!empty($profile->driving_license_number)) {
                        echo $profile->driving_license_number;
                    } else {
                        echo 'NA';
                    } ?></td>
            </tr>
            <tr>
                <td>Vehicle No</td>
                <td> : </td>
                <td><?php if (!empty($profile->vehicle_no)) {
                        echo $profile->vehicle_no; ?> / <?php echo $profile->vehicle_model; ?> / <?php echo $profile->make_name; ?> <?php echo ($profile->vehicle_type == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';
                                                                                                                                } else {
                                                                                                                                    echo 'NA';
                                                                                                                                } ?></td>
            </tr>
            <tr>
                <td>GPS Tracking</td>
                <td> : </td>
                <td><?php echo (!empty($profile->gps_device_serial)) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>'; ?></td>
            </tr>
        </table>
    </div>
</div>

<div id="shiftAllotment">
    <div class="card-header">Fill Details to Schedule Shift</div>
    <?php echo form_open("admin/logistic-management/hunger/rider-shift-change", array("id" => "changeShiftForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
    <input type="hidden" name="shiftId" id="shiftId" value="<?php echo $edit->id; ?>">
    <input type="hidden" name="rider_id" id="riderId" value="<?php echo $profile->emp_id; ?>">
    <div id="shiftRows">
        <div class="row p-2 shift_row">
            <div class="col-md-3 col-sm-12 mb-2 px-1 form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control shiftDate" name="shift_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+15 days')); ?>" value="<?php echo $edit->date; ?>" required>
            </div>
            <div class="col-md-3 col-sm-12 mb-2 px-1 form-group">
                <label for="teamName">Shift:<span class="text-danger">*</span></label>
                <select name="shift_id" class="form-control shiftId" required>
                    <option value="">Choose...</option>
                    <?php foreach ($shifts as $shift) : ?>
                        <option value="<?php echo $shift->id; ?>" <?php echo $edit->shift_id == $shift->id ? 'selected' : '' ?>><?php echo $shift->name; ?> (<?php echo $shift->ar_name; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-12 mb-2 px-1 form-group">
                <label for="startTime">Start Time:</label>
                <input type="time" class="form-control startTime" name="start_time" value="<?php echo $edit->start_time; ?>" required>
            </div>
            <div class="col-md-2 col-sm-12 mb-2 px-1 form-group">
                <label for="endTime">End Time:</label>
                <input type="time" class="form-control endTime" name="end_time" value="<?php echo $edit->end_time; ?>" required>
            </div>
            <div class="col-md-2 col-sm-12 mb-2 px-1 form-group">
                <label for="endTime">Area:</label>
                <select name="area_id" class="form-control areaId" required>
                    <option value="">Choose...</option>
                    <?php foreach ($areas as $area) : ?>
                        <option value="<?php echo $area->id; ?>" <?php echo $edit->area_id == $area->id ? 'selected' : '' ?>><?php echo $area->name; ?> (<?php echo $area->ar_name; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script>
    $('#changeShiftForm').on('submit', function(event) {
        event.preventDefault();
        const $form = $(this);
        var modalBody = $form.closest('.modal').find('.modal-body');
        var selector = modalBody.find('.alert_box');
        const url = "<?php echo base_url('admin/logistic-management/hunger/rider-shift-assign'); ?>";
        removeBlankShiftRows();
        if ($form.parsley().isValid()) {
            $.ajax({
                type: "POST",
                url: url,
                data: $form.serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        $form.closest('.modal').modal('hide');
                        initializeShiftTable();
                        alertSuccess(response.message);
                        resetChangeShiftModal();
                    } else {
                        modalBody.animate({
                            scrollTop: 0
                        }, 'slow');
                        alertErrorModal(response.message, selector);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                    alertErrorModal("An error occurred while assigning the shift. Please try again.", selector);
                }
            });
        } else {
            $form.parsley().validate();
        }
    });
</script>