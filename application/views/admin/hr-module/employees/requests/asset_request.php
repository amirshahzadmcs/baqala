<style> 
span.textbox.combo {
    width: 100% !important;
}
#request_form .textbox{
	border: 1px solid #cbcbcb;
}
input#_easyui_textbox_input1 {
    width: 100% !important;
}
</style>
<div>
	<?php echo form_open("admin/hr/employees/save-asset-request", array("id" => "request_form", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
		<input type="hidden" name="emp_id" value="<?php echo $emp_detail->id;?>" required />
		<!-- Tab panes -->
		<div class="row tab-inner-section py-2 mx-1">
			<h4 class="header-title">Asset Details</h4><hr>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<label for="request_type">Type</label>
				<select class="form-control form-select" data-parsley-allselected="true" name="request_type" id="request_type" required>
					<option value="">Select Request Type</option>
					<option value="AssetRequest">Asset request</option>
					<option value="AssetClearRequest">Asset clear request</option>
				</select>
			</div>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<label for="asset_category">Asset Items</label>
				<div class="input-group mb-3">
					<input name="category[]" type="text" class="form-control easyui-combotree w-100" data-options="url:'<?php echo base_url("admin/asset/get-category"); ?>',method:'get',labelPosition:'top',collapsible:true,multiple:true" />
				</div>
			</div>
		</div>
		<div class="row tab-inner-section py-2 mx-1">
			<h4 class="header-title">Reason</h4><hr>
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<input type="text" class="form-control" id="reason" name="reason" />
			</div>
			
			<div class="col-md-12 col-sm-12 mb-3 form-group">
				<input type="file" name="attachment[]" id="attachment" class="dropify"
					accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
					data-max-file-size="2M" data-height="100">
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
	$('.dropify').dropify();
	initializeComboTree();
	$(document).ready(function () {
		$("#request_form").on("submit", function (e) {
			e.preventDefault();
			var formData = new FormData(this); 
			$.ajax({
				url: "<?php echo site_url('admin/hr/employees/save-asset-request'); ?>",
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
					// Handle AJAX error
					console.error("AJAX Error:", status, error);
					toastr.error('An unexpected error occurred. Please try again.');
				},
			});
		});
	});
</script>
