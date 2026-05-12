<div class="modal-header">
    <h5 class="modal-title px-3" id="editAttendanceModalLabel">Edit Attendance - <?php echo date('d F, Y', strtotime($attendance_detail['date_of_attend'])); ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?php echo base_url('admin/hr/attendance/update'); ?>" method="post" id="updateAttendanceForm">
        <input type="hidden" name="attendance_id" value="<?php echo $attendance_detail['id']; ?>">
        <div class="accordion mb-3 rounded-3" id="attendanceAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header m-2 rounded" id="attendanceHeading">
                <button class="accordion-button p-2 border-0 rounded" type="button" data-bs-toggle="collapse" data-bs-target="#attendanceCollapse" aria-expanded="true" aria-controls="attendanceCollapse">
                    Employee Information
                </button>
                </h2>
                <div id="attendanceCollapse" class="accordion-collapse border-0 collapse show" aria-labelledby="attendanceHeading" data-bs-parent="#attendanceAccordion">
                    <div class="accordion-body p-1">
                        <div class="d-flex align-items-center employee-detail">
                            <div class="image">
                                <?php if(!empty($attendance_detail['employee_pic']) && $attendance_detail['employee_pic'] !== ''){ ?>
                                    <img src="<?php echo $attendance_detail['employee_pic'];?>" class="rounded" width="120">
                                <?php }else{ ?>
                                    <img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="120">
                                <?php } ?>
                            </div>
                            <div class="p-2 w-100">
                                <h6 class="mb-0 mt-0"> <?php echo $attendance_detail['emp_full_name'];?> / <?php echo $attendance_detail['employee_arabic_name'];?> </h6>
                                <hr class="my-1">
                                <table>
                                    <tr>
                                        <td>Emp No.</td>
                                        <td> : </td>
                                        <td><?php echo $attendance_detail['emp_no'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Iqama No.</td>
                                        <td> : </td>
                                        <td><?php echo $attendance_detail['iqama_no'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Aggregator</td>
                                        <td> : </td>
                                        <td><?php echo $attendance_detail['aggregator_id'];?> - <?php echo $attendance_detail['aggregator_name'];?></td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle No</td>
                                        <td> : </td>
                                        <td><?php if(!empty($attendance_detail['vehicle_no'])){ echo $attendance_detail['vehicle_no'];?> <?php echo ($attendance_detail['vehicle_type'] == 'bike') ? '<i class="fas fa-motorcycle"></i>' : '<i class="mdi mdi-car"></i>';}else{ echo 'NA';}?></td>
                                    </tr>
                                    <tr>
                                        <td>Team</td>
                                        <td> : </td>
                                        <td><?php echo (!empty($attendance_detail['team_name'])) ? $attendance_detail['team_name'] : 'NA';?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Attendance Type</label>
                    <select name="attendance_type" id="attendance_type" class="form-control select2">
                        <option value="">[Select Type]</option>
                        <option value="A" <?php echo ($attendance_detail['attend_type'] == 'A') ? 'selected' : ''; ?>>A - Absent</option>
                        <option value="L" <?php echo ($attendance_detail['attend_type'] == 'L') ? 'selected' : ''; ?>>L - Leave</option>
                        <option value="P" <?php echo ($attendance_detail['attend_type'] == 'P') ? 'selected' : ''; ?>>P - Present</option>
                        <option value="AC" <?php echo ($attendance_detail['attend_type'] == 'AC') ? 'selected' : ''; ?>>AC - Accident</option>
                        <option value="AL" <?php echo ($attendance_detail['attend_type'] == 'AL') ? 'selected' : ''; ?>>AL - Annual Leave</option>
                        <option value="BT" <?php echo ($attendance_detail['attend_type'] == 'BT') ? 'selected' : ''; ?>>BT - Business Trip</option>
                        <option value="CL" <?php echo ($attendance_detail['attend_type'] == 'CL') ? 'selected' : ''; ?>>CL - Casual Leave</option>
                        <option value="COL" <?php echo ($attendance_detail['attend_type'] == 'COL') ? 'selected' : ''; ?>>COL - Compassionate Leave</option>
                        <option value="HI" <?php echo ($attendance_detail['attend_type'] == 'HI') ? 'selected' : ''; ?>>HI - Health Issue</option>
                        <option value="ID" <?php echo ($attendance_detail['attend_type'] == 'ID') ? 'selected' : ''; ?>>ID - ID Issue</option>
                        <option value="IQ" <?php echo ($attendance_detail['attend_type'] == 'IQ') ? 'selected' : ''; ?>>IQ - Iqama Issue</option>
                        <option value="MAR" <?php echo ($attendance_detail['attend_type'] == 'MAR') ? 'selected' : ''; ?>>MAR - Marriage Leave</option>
                        <option value="MI" <?php echo ($attendance_detail['attend_type'] == 'MI') ? 'selected' : ''; ?>>MI - Mobile Issue</option>
                        <option value="ML" <?php echo ($attendance_detail['attend_type'] == 'ML') ? 'selected' : ''; ?>>ML - Maternity Leave</option>
                        <option value="PL" <?php echo ($attendance_detail['attend_type'] == 'PL') ? 'selected' : ''; ?>>PL - Paternity Leave</option>
                        <option value="SI" <?php echo ($attendance_detail['attend_type'] == 'SI') ? 'selected' : ''; ?>>SI - Sponsorship Issue</option>
                        <option value="SL" <?php echo ($attendance_detail['attend_type'] == 'SL') ? 'selected' : ''; ?>>SL - Sick Leave</option>
                        <option value="UL" <?php echo ($attendance_detail['attend_type'] == 'UL') ? 'selected' : ''; ?>>UL - Unpaid Leave</option>
                        <option value="WL" <?php echo ($attendance_detail['attend_type'] == 'WL') ? 'selected' : ''; ?>>WL - Widow Leave</option>
                        <option value="WO" <?php echo ($attendance_detail['attend_type'] == 'WO') ? 'selected' : ''; ?>>WO - Week Off</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group mb-2">
                    <label>Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="3"><?php echo $attendance_detail['remarks']; ?></textarea>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a href="<?php echo base_url('admin/hr/attendance/detail/'.date('Y-m', strtotime($attendance_detail['date_of_attend']))); ?>" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
    <button type="submit" form="updateAttendanceForm" class="btn btn-custom-success">Update</button>
</div>

<script>
    $(document).on('submit', '#updateAttendanceForm', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        // Show loader (optional)
        $('#updateAttendanceForm button[type="submit"]').prop('disabled', true).text('Updating...');

        $.ajax({
            url: "<?php echo base_url('admin/hr/attendance/update'); ?>",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                $('#updateAttendanceForm button[type="submit"]').prop('disabled', false).text('Save');

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#editAttendanceModal').modal('hide');

                    // Reload DataTable
                    $('#attendanceTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                $('#updateAttendanceForm button[type="submit"]').prop('disabled', false).text('Save');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
            }
        });
    });

</script>