<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Sim Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="p-3 w-100">
            <table>
                <tr>
                    <td>Owner Type</td>
                    <td> : </td>
                    <td><?php echo ucfirst($sim_detail->ownership_type);?></td>
                </tr>
                <tr>
                    <td>Owner ID</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->owner_id;?></td>
                </tr>
                <tr>
                    <td>Owner Name</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->owner_name;?></td>
                </tr>
                <tr>
                    <td>Mobile No / Type</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->mobile;?> / <?php echo $sim_detail->sim_type;?></td>
                </tr>
                <tr>
                    <td>Sim Card No / Provider</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->sim_no;?> / <?php echo ucfirst($sim_detail->network_name);?></td>
                </tr>
                <tr>
                    <td>Active Plan</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->plan_name;?></td>
                </tr>
                <tr>
                    <td>Date of purchase</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->date_of_purchase;?></td>
                </tr>
                <tr>
                    <td>Current User</td>
                    <td> : </td>
                    <td><?php echo $sim_detail->emp_full_name;?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Fill Sim Replacement Detail</div>
    <?php echo form_open("admin/sim/replace-save", array("id" => "simReplaceForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
        <input type="hidden" id="id" name="id" value="<?php echo $sim_detail->id;?>" required />
        <div class="row p-2">
			<div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="sim_no">New Sim No. <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sim_no" name="sim_no" minlength="<?php echo SIM_LENGTH; ?>" maxlength="<?php echo SIM_LENGTH; ?>" required />
            </div>

            <div class="col-md-6 col-sm-12 mb-2 form-group">
                <label for="replacement_date">Replacement Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="replacement_date" name="replacement_date" max="<?php echo date("Y-m-d"); ?>" required />
            </div>

            <div class="col-md-12 col-sm-12 mb-2 form-group">
                <label for="reason">Reason <span class="text-danger">*</span></label>
                <select name="reason" id="reason" class="form-select" required>
                    <option value="">Choose Reason</option>
                    <option value="Lost">Lost</option>
                    <option value="Damage">Damage</option>
                </select>
            </div>
            <div class="col-md-12 col-sm-12 mb-3 form-group">
                <label for="message">Message</label>
                <textarea class="form-control" rows="2" id="message" name="message"></textarea>
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
<script>
$(document).ready(function() {
	$('.dropify').dropify();
});

$(document).ready(function() {
	$('#simReplaceForm').submit(function(e) {
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: '<?php echo base_url('admin/sim/replace-save');?>',
			type: 'POST',
			data: formData,
			dataType: 'json',
			processData: false,
			contentType: false,
			success: function(response) {
				// Handle server response
				if (response.type === 'success') {
					$('#responseContainer2').html('<div class="alert alert-success">' + response.message + '</div>');
					$('#searchResult2').html('');
					$('#searchResponse2').html('');
					$('#searchModalFooter2').html('');
					location.reload();
				} else {
					$('#responseContainer2').html('<div class="alert alert-danger">' + response.message + '</div>');
				}
			},
			error: function() {
				$('#responseContainer2').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
			}
		});
	});
});

</script>
