<div class="modal-header">
	<h5 class="modal-title mt-0" id="dlModalFullscreenLabel">Update Salary</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="size-inner-section p-2">
		<div class="card-header px-2 mb-3">Fill Driving License Details</div>
		<?php echo form_open("admin/hr/employees/add-secondary-dl", array("id" => "dlForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
			<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
			<!-- Tab panes -->
			<div class="row">
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="driving_license_number">Driving License Number</label>
					<input type="text" class="form-control" id="driving_license_number" name="driving_license_number" maxlength="15" />
				</div>

				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="driving_license_type">Driving License Type</label>
                    <select class="form-select select2" data-parsley-allselected="true" name="driving_license_type" id="driving_license_type">
                        <option value="">Select Driving License Type</option>
                        <?php foreach(licenceTypeHelper() as $insType) { ?>
                            <option value="<?php echo $insType->licence_type; ?>" <?php echo ($insType->licence_type == $emp_info->driving_license_type) ? ' selected' : '' ?>><?php echo $insType->licence_type; ?></option>
                        <?php } ?>
                    </select>
				</div>

				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="dl_issue_country">Driving License Issue Country</label>
                    <select class="form-select" name="driving_license_issue_country" id="dl_issue_country">
                        <option value="">Select Country</option>
                        <?php foreach(masterCountries() as $country) { ?>
                        <option value="<?php echo $country->id; ?>" data-id="<?php echo $country->id; ?>" <?php echo ($country->id == $emp_info->driving_license_issue_country) ? 'selected' : '' ?>><?php echo $country->name; ?></option>
                        <?php } ?>
                    </select>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="dl_issue_city">Driving License Issue City</label>
                    <select class="form-select select2" data-parsley-allselected="true" name="driving_license_issue_city" id="dl_issue_city">
                        <option value="">Select Driving License Issue City</option>
                    </select>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="driving_license_issue_date">Driving License Issue Date</label>
					<input type="date" class="form-control" id="driving_license_issue_date" name="driving_license_issue_date" />
				</div>
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="driving_license_exp_date">Driving License Expiry Date</label>
					<input type="date" class="form-control" id="driving_license_exp_date" name="driving_license_exp_date" />
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div class="modal-footer">
	<div class="row">
		<div class="col-md-12">
			<button form="dlForm" type="submit" class="btn btn-success btn-md">Save Detail</button>
			<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
        $('#dl_issue_country').change(function() {
            var country_id = $(this).find('option:selected').val();
            $.ajax({
                url: "<?php echo base_url(); ?>admin/hr-module/employees/Employee/getCities",
                data: {
                    country_id: country_id
                },
                dataType: "json",
                type: "POST",
                success: function(data) {
                    //console.log(data);
                    var html = '<option value="">Select Driving License Issue City</option>';
                    if (Object.keys(data).length > 0) {
                        $.each(data, function(index, item) {
                            html += '<option value="' + item.id + '" data-id="' + item.id + '">' + item.city_name + '</option>';
                        });
                    } else {
                        var html = '<option value="">No city found</option>';
                    }
                    $('#dl_issue_city').html(html);
                }
            });
        });
        
		$('#dlForm').submit(function(e) {
            e.preventDefault();

            var $btn = $('button[form="dlForm"]');
            var originalText = $btn.html(); // Store original button text

            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...');

            var formData = new FormData(this);

            $.ajax({
                url: '<?php echo base_url('admin/hr/employees/add-secondary-dl');?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.type === 'success') {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                        $btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function() {
                    toastr.error("An unexpected error occurred.");
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });

	});

</script>
